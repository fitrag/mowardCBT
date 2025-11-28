<?php

namespace App\Livewire;

use App\Models\Test;
use App\Models\TestAttempt;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TestDetail extends Component
{
    public Test $test;
    public $accessToken = '';
    public $showConfirmation = false;

    public function mount(Test $test)
    {
        $this->test = $test;

        // Check if user has access to this test
        $user = auth()->user();
        $hasAccess = $this->test->groups->contains('id', $user->group_id);

        if (!$hasAccess) {
            abort(403, 'You do not have access to this test.');
        }

        // Check if test is active
        if (!$this->test->isActive()) {
            session()->flash('error', 'This test is not currently available.');
            return redirect()->route('student.dashboard');
        }

        // Check if user already has a submitted attempt
        $existingAttempt = TestAttempt::where('user_id', $user->id)
            ->where('test_id', $this->test->id)
            ->whereIn('status', ['submitted', 'graded'])
            ->first();

        if ($existingAttempt) {
            session()->flash('error', 'You have already completed this test.');
            return redirect()->route('student.dashboard');
        }
    }

    public function startTest()
    {
        // Validate token if required
        if ($this->test->use_token) {
            $this->validate([
                'accessToken' => 'required|string',
            ]);

            if (!$this->test->isTokenValid($this->accessToken)) {
                $errorMsg = 'Invalid access token.';
                if ($this->test->token_expires_at && $this->test->token_expires_at->isPast()) {
                    $errorMsg = 'The access token has expired.';
                }
                $this->dispatch('toast', ['type' => 'error', 'message' => $errorMsg]);
                return;
            }
        }

        $user = auth()->user();

        // Check for existing in-progress attempt
        $existingAttempt = TestAttempt::where('user_id', $user->id)
            ->where('test_id', $this->test->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            // Continue existing attempt
            $this->dispatch('toast', ['type' => 'info', 'message' => 'Continuing your previous attempt...']);
            return redirect()->route('student.test.take', $this->test);
        }

        // Token is valid, show confirmation dialog
        $this->showConfirmation = true;
    }

    public function confirmStartTest()
    {
        $user = auth()->user();

        // Create new attempt
        $attempt = TestAttempt::create([
            'user_id' => $user->id,
            'test_id' => $this->test->id,
            'started_at' => now(),
            'status' => 'in_progress',
        ]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Test started! Good luck!']);
        return redirect()->route('student.test.take', $this->test);
    }

    public function getTotalQuestions()
    {
        return $this->test->subjects->sum(function ($subject) {
            return $subject->pivot->question_count;
        });
    }

    public function render()
    {
        return view('livewire.test-detail');
    }
}
