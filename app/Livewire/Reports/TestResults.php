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
        // Build query
        $query = TestAttempt::with(['user', 'test.subject', 'user.groups'])
            ->where('status', 'submitted')
            ->whereNotNull('score');

        // Apply filters
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterSubject) {
            $query->whereHas('test', function ($q) {
                $q->where('subject_id', $this->filterSubject);
            });
        }

        if ($this->filterTest) {
            $query->where('test_id', $this->filterTest);
        }

        if ($this->filterGroup) {
            $query->whereHas('user.groups', function ($q) {
                $q->where('groups.id', $this->filterGroup);
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
            ? Test::where('subject_id', $this->filterSubject)->orderBy('name')->get()
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
}
