<?php

namespace App\Livewire\Subjects;

use App\Models\Module;
use App\Models\Subject;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public $perPage = 10;
    public $selected = [];
    public $filterModule = '';

    #[Rule('required|min:3')]
    public $name = '';

    #[Rule('nullable')]
    public $description = '';

    #[Rule('required|exists:modules,id')]
    public $module_id = '';

    public $subjectId;
    public $isEdit = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterModule()
    {
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        $query = Subject::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterModule) {
            $query->where('module_id', $this->filterModule);
        }

        if (count($this->selected) === $query->limit($this->perPage)->count()) {
            $this->selected = [];
        } else {
            $this->selected = $query->limit($this->perPage)->pluck('id')->toArray();
        }
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No subjects selected.']);
            return;
        }

        Subject::whereIn('id', $this->selected)->delete();
        $count = count($this->selected);
        $this->selected = [];
        $this->dispatch('toast', ['type' => 'success', 'message' => $count . ' subjects deleted successfully.']);
    }

    public function create()
    {
        $this->reset(['name', 'description', 'module_id', 'subjectId']);
        $this->isEdit = false;
        $this->dispatch('open-modal', 'subject-modal');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $this->subjectId = $id;
        $this->name = $subject->name;
        $this->description = $subject->description;
        $this->module_id = $subject->module_id;
        $this->isEdit = true;
        $this->dispatch('open-modal', 'subject-modal');
    }

    public function store()
    {
        $this->validate();

        Subject::updateOrCreate(
            ['id' => $this->subjectId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'module_id' => $this->module_id,
            ]
        );

        $this->dispatch('close-modal', 'subject-modal');
        $this->reset(['name', 'description', 'module_id', 'subjectId']);
        $this->dispatch('toast', ['type' => 'success', 'message' => $this->subjectId ? 'Subject updated successfully.' : 'Subject created successfully.']);
    }

    public function delete($id)
    {
        Subject::find($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Subject deleted successfully.']);
    }

    public function render()
    {
        $query = Subject::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply module filter
        if ($this->filterModule) {
            $query->where('module_id', $this->filterModule);
        }

        return view('livewire.subjects.index', [
            'subjects' => $query->with('module')->latest()->paginate($this->perPage),
            'modules' => Module::all(),
        ]);
    }
}
