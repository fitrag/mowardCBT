<?php

namespace App\Livewire\Tests;

use App\Models\Test;
use Livewire\Attributes\Layout;
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Test::find($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Test deleted successfully.']);
    }

    public function render()
    {
        $query = Test::where('name', 'like', '%' . $this->search . '%');

        return view('livewire.tests.index', [
            'tests' => $query->with('groups', 'subjects')->latest()->paginate($this->perPage),
        ]);
    }
}
