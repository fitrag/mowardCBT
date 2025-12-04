<?php

namespace App\Livewire;

use App\Models\Test;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class StudentDashboard extends Component
{
    public $activeTests = [];
    public $upcomingTests = [];
    public $completedTests = [];

    public function mount()
    {
        $this->loadTests();
    }

    public function loadTests()
    {
        $user = auth()->user();
        
        // Get all tests assigned to user's group
        $allTests = Test::whereHas('groups', function ($query) use ($user) {
            $query->where('groups.id', $user->group_id);
        })->with(['subjects', 'attempts' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        // Helper to check if test is completed
        $isCompleted = function ($test) use ($user) {
            return $test->attempts->where('user_id', $user->id)
                ->whereIn('status', ['submitted', 'graded', 'cheating_detected'])
                ->isNotEmpty();
        };

        // Categorize tests
        $this->activeTests = $allTests->filter(fn($test) => $test->isActive() && !$isCompleted($test))->values();
        $this->upcomingTests = $allTests->filter(fn($test) => $test->isUpcoming() && !$isCompleted($test))->values();
        
        // Get completed tests (tests that user has attempted and submitted)
        $this->completedTests = $allTests->filter(function ($test) use ($isCompleted) {
            return $isCompleted($test);
        })->values();
    }

    public function getUserAttempt($test)
    {
        return $test->attempts->where('user_id', auth()->id())->first();
    }

    public function getTotalQuestions($test)
    {
        return $test->subjects->sum(function ($subject) {
            return $subject->pivot->question_count;
        });
    }

    public function render()
    {
        return view('livewire.student-dashboard');
    }
}
