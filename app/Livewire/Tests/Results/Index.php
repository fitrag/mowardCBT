<?php

namespace App\Livewire\Tests\Results;

use App\Models\Test;
use App\Models\TestAttempt;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public Test $test;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $statusFilter = '';
    
    #[Url(history: true)]
    public $viewMode = 'modern'; // modern or classic

    public $perPage = 10;
    
    public $selectedAttempt = null;

    public function mount(Test $test)
    {
        $this->test = $test;
    }
    
    public function viewAttemptDetail($attemptId)
    {
        $this->selectedAttempt = TestAttempt::with('user')->findOrFail($attemptId);
    }
    
    public function closeModal()
    {
        $this->selectedAttempt = null;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function getStatsProperty()
    {
        $attempts = TestAttempt::where('test_id', $this->test->id)
            ->whereIn('status', ['submitted', 'graded'])
            ->get();

        return [
            'total_participants' => TestAttempt::where('test_id', $this->test->id)->distinct('user_id')->count('user_id'),
            'completed' => $attempts->count(),
            'in_progress' => TestAttempt::where('test_id', $this->test->id)->where('status', 'in_progress')->count(),
            'average_score' => $attempts->avg('score') ?? 0,
            'highest_score' => $attempts->max('score') ?? 0,
            'lowest_score' => $attempts->where('score', '>', 0)->min('score') ?? 0,
        ];
    }

    public function deleteAttempt($attemptId)
    {
        $attempt = TestAttempt::findOrFail($attemptId);
        
        // Check if attempt belongs to this test
        if ($attempt->test_id !== $this->test->id) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Invalid attempt.']);
            return;
        }

        $studentName = $attempt->user->name;
        $attempt->delete();

        $this->dispatch('toast', ['type' => 'success', 'message' => "Attempt for {$studentName} has been deleted successfully."]);
    }

    public function render()
    {
        $query = TestAttempt::where('test_id', $this->test->id)
            ->with('user')
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->latest('submitted_at')
            ->latest('started_at');

        return view('livewire.tests.results.index', [
            'attempts' => $query->paginate($this->perPage),
        ]);
    }
}
