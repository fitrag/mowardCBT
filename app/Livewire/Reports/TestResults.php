<?php

namespace App\Livewire\Reports;

use App\Models\TestAttempt;
use App\Models\Test;
use App\Models\Subject;
use App\Models\Group;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class TestResults extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $filterSubject = '';

    #[Url(history: true)]
    public $filterTest = '';

    #[Url(history: true)]
    public $filterGroup = '';

    #[Url(history: true)]
    public $filterDateFrom = '';

    #[Url(history: true)]
    public $filterDateTo = '';

    public $perPage = 20;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterSubject()
    {
        $this->filterTest = ''; // Reset test filter when subject changes
        $this->resetPage();
    }

    public function updatedFilterTest()
    {
        $this->resetPage();
    }

    public function updatedFilterGroup()
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterDateTo()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterSubject', 'filterTest', 'filterGroup', 'filterDateFrom', 'filterDateTo']);
        $this->resetPage();
    }

    public function render()
    {
        // Build query - show all tests (completed, in progress, paused, cheating detected)
        $query = TestAttempt::with(['user.group', 'test.subjects'])
            ->whereIn('status', ['graded', 'in_progress', 'paused', 'cheating_detected']);

        // Apply filters
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterSubject) {
            $query->whereHas('test', function ($q) {
                $q->whereHas('subjects', function ($subQ) {
                    $subQ->where('subjects.id', $this->filterSubject);
                });
            });
        }

        if ($this->filterTest) {
            $query->where('test_id', $this->filterTest);
        }

        if ($this->filterGroup) {
            $query->whereHas('user', function ($q) {
                $q->where('group_id', $this->filterGroup);
            });
        }

        if ($this->filterDateFrom) {
            $query->whereDate('submitted_at', '>=', $this->filterDateFrom);
        }

        if ($this->filterDateTo) {
            $query->whereDate('submitted_at', '<=', $this->filterDateTo);
        }

        // Get results
        $results = $query->latest('submitted_at')->paginate($this->perPage);

        // Calculate statistics
        $stats = $this->calculateStatistics($query);

        // Get filter options
        $subjects = Subject::orderBy('name')->get();
        $tests = $this->filterSubject 
            ? Test::whereHas('subjects', function($q) {
                $q->where('subjects.id', $this->filterSubject);
              })->orderBy('name')->get()
            : Test::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();

        return view('livewire.reports.test-results', [
            'results' => $results,
            'subjects' => $subjects,
            'tests' => $tests,
            'groups' => $groups,
            'stats' => $stats,
        ]);
    }

    private function calculateStatistics($query)
    {
        $clonedQuery = clone $query;
        $attempts = $clonedQuery->get();

        if ($attempts->isEmpty()) {
            return [
                'total' => 0,
                'avgScore' => 0,
                'avgPercentage' => 0,
                'highestScore' => 0,
                'lowestScore' => 0,
                'passRate' => 0,
            ];
        }

        $total = $attempts->count();
        $avgScore = $attempts->avg('score');
        
        // Calculate average percentage
        $percentages = $attempts->map(function ($attempt) {
            return ($attempt->score / $attempt->test->max_score) * 100;
        });
        $avgPercentage = $percentages->avg();

        // Calculate pass rate (assuming 60% is passing)
        $passed = $percentages->filter(function ($percentage) {
            return $percentage >= 60;
        })->count();
        $passRate = ($passed / $total) * 100;

        return [
            'total' => $total,
            'avgScore' => round($avgScore, 1),
            'avgPercentage' => round($avgPercentage, 1),
            'highestScore' => round($attempts->max('score'), 1),
            'lowestScore' => round($attempts->min('score'), 1),
            'passRate' => round($passRate, 1),
        ];
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\TestResultsExport(),
            'test-results-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function pauseTest($attemptId)
    {
        $attempt = TestAttempt::findOrFail($attemptId);
        
        // Only pause if in progress
        if ($attempt->status === 'in_progress') {
            // Use existing remaining_seconds (from last auto-save)
            // Only calculate if remaining_seconds is null (test just started, no auto-save yet)
            if ($attempt->remaining_seconds === null) {
                $test = $attempt->test;
                $totalAllowedSeconds = $test->duration * 60;
                $elapsedSeconds = now()->diffInSeconds($attempt->started_at);
                $remainingSeconds = max(0, $totalAllowedSeconds - $elapsedSeconds);
                
                $attempt->update([
                    'status' => 'paused',
                    'remaining_seconds' => $remainingSeconds,
                    'paused_at' => now(),
                ]);
            } else {
                // Just update status, keep existing remaining_seconds
                $attempt->update([
                    'status' => 'paused',
                    'paused_at' => now(),
                ]);
            }
            
            $this->dispatch('toast', [
                'type' => 'success', 
                'message' => 'Test paused successfully. Student cannot continue until resumed.'
            ]);
            
            // Clear cache to ensure status update is immediate
            cache()->forget("test_attempt_status_{$attemptId}");
        } else {
            $this->dispatch('toast', [
                'type' => 'error', 
                'message' => 'Can only pause tests that are in progress.'
            ]);
        }
    }

    public function resumeTest($attemptId)
    {
        $attempt = TestAttempt::findOrFail($attemptId);
        
        // Only resume if paused
        if ($attempt->status === 'paused') {
            // Just change status back to in_progress
            // remaining_seconds already saved during pause
            $attempt->update([
                'status' => 'in_progress',
                'paused_at' => null,
            ]);
            
            $this->dispatch('toast', [
                'type' => 'success', 
                'message' => 'Test resumed successfully. Student can continue now.'
            ]);
            
            // Clear cache to ensure status update is immediate
            cache()->forget("test_attempt_status_{$attemptId}");
        } else {
            $this->dispatch('toast', [
                'type' => 'error', 
                'message' => 'Can only resume tests that are paused.'
            ]);
        }
    }
    
    public function addExtraTime($attemptId, $extraMinutes)
    {
        $attempt = TestAttempt::findOrFail($attemptId);
        
        // Only add time if test is in progress
        if ($attempt->status === 'in_progress') {
            // Convert minutes to seconds and add to remaining_seconds
            $extraSeconds = $extraMinutes * 60;
            $newRemaining = $attempt->remaining_seconds + $extraSeconds;
            
            $attempt->update([
                'remaining_seconds' => $newRemaining,
            ]);
            
            $this->dispatch('toast', [
                'type' => 'success', 
                'message' => "Added {$extraMinutes} minutes to student's test time."
            ]);
            
            // Clear cache to ensure time update is immediate
            cache()->forget("test_attempt_status_{$attemptId}");
        } else {
            $this->dispatch('toast', [
                'type' => 'error', 
                'message' => 'Can only add time to tests that are in progress.'
            ]);
        }
    }
}
