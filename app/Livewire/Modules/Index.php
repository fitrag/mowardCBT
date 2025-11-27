<?php

namespace App\Livewire\Modules;

use App\Models\Module;
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

    #[Rule('required|min:3')]
    public $name = '';

    #[Rule('nullable')]
    public $description = '';

    public $moduleId;
    public $isEdit = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        if (count($this->selected) === Module::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->limit($this->perPage)
                ->count()) {
            $this->selected = [];
        } else {
            $this->selected = Module::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->limit($this->perPage)
                ->pluck('id')
                ->toArray();
        }
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No modules selected.']);
            return;
        }

        Module::whereIn('id', $this->selected)->delete();
        $count = count($this->selected);
        $this->selected = [];
        $this->dispatch('toast', ['type' => 'success', 'message' => $count . ' modules deleted successfully.']);
    }

    public function create()
    {
        $this->reset(['name', 'description', 'moduleId']);
        $this->isEdit = false;
        $this->dispatch('open-modal', 'module-modal');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $this->moduleId = $id;
        $this->name = $module->name;
        $this->description = $module->description;
        $this->isEdit = true;
        $this->dispatch('open-modal', 'module-modal');
    }

    public function store()
    {
        $this->validate();

        Module::updateOrCreate(
            ['id' => $this->moduleId],
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        $this->dispatch('close-modal', 'module-modal');
        $this->reset(['name', 'description', 'moduleId']);
        $this->dispatch('toast', ['type' => 'success', 'message' => $this->moduleId ? 'Module updated successfully.' : 'Module created successfully.']);
    }

    public function delete($id)
    {
        Module::find($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Module deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.modules.index', [
            'modules' => Module::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->withCount('subjects')
                ->latest()
                ->paginate($this->perPage),
        ]);
    }
}
