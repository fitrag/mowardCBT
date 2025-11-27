<?php

namespace App\Livewire\Groups;

use App\Models\Group;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Url;

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

    public $groupId;
    public $isEdit = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function toggleSelectAll()
    {
        if (count($this->selected) === Group::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->limit($this->perPage)
                ->count()) {
            $this->selected = [];
        } else {
            $this->selected = Group::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->limit($this->perPage)
                ->pluck('id')
                ->toArray();
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No groups selected.']);
            return;
        }

        Group::whereIn('id', $this->selected)->delete();
        $count = count($this->selected);
        $this->selected = [];
        $this->dispatch('toast', ['type' => 'success', 'message' => $count . ' groups deleted successfully.']);
    }

    public function create()
    {
        $this->reset(['name', 'description', 'groupId']);
        $this->isEdit = false;
        $this->dispatch('open-modal', 'group-modal');
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $this->groupId = $id;
        $this->name = $group->name;
        $this->description = $group->description;
        $this->isEdit = true;
        $this->dispatch('open-modal', 'group-modal');
    }

    public function store()
    {
        $this->validate();

        Group::updateOrCreate(
            ['id' => $this->groupId],
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        $this->dispatch('close-modal', 'group-modal');
        $this->reset(['name', 'description', 'groupId']);
        $this->dispatch('toast', ['type' => 'success', 'message' => $this->groupId ? 'Group updated successfully.' : 'Group created successfully.']);
    }

    public function delete($id)
    {
        Group::find($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Group deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.groups.index', [
            'groups' => Group::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate($this->perPage),
        ]);
    }
}
