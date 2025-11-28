<?php

namespace App\Livewire;

use App\Models\Test;
use App\Models\TestAttempt;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TestResult extends Component
{
    public Test $test;
    public TestAttempt $attempt;
    public $questions = [];

    public function mount(Test $test)
    {
        $this->test = $test;
        $user = auth()->user();

        // Get the user's attempt for this test
        $this->attempt = TestAttempt::where('user_id', $user->id)
            ->where('test_id', $this->test->id)
            ->where('status', '!=', 'in_progress')
            ->latest()
            ->firstOrFail();

        // Verify user owns this attempt
        if ($this->attempt->user_id !== $user->id) {
            abort(403, 'Unauthorized access to test results.');
        }

        // Load questions if show_result_details is enabled
        if ($this->test->show_result_details) {
            $this->questions = $this->attempt->questions ?? [];
        }
    }

    public function getScorePercentage()
    {
        if ($this->test->max_score == 0) {
            return 0;
        }
        return round(($this->attempt->score / $this->test->max_score) * 100, 2);
    }

    public function getCorrectCount()
    {
        $correct = 0;
        foreach ($this->questions as $question) {
            $userAnswer = $this->attempt->answers[$question['id']] ?? null;
            if ($userAnswer && $userAnswer == $question['correct_answer']) {
                $correct++;
            }
        }
        return $correct;
    }

    public function getWrongCount()
    {
        $wrong = 0;
        foreach ($this->questions as $question) {
            $userAnswer = $this->attempt->answers[$question['id']] ?? null;
            if ($userAnswer && $userAnswer != $question['correct_answer']) {
                $wrong++;
            }
        }
        return $wrong;
    }

    public function getUnansweredCount()
    {
        $unanswered = 0;
        foreach ($this->questions as $question) {
            $userAnswer = $this->attempt->answers[$question['id']] ?? null;
            if (!$userAnswer) {
                $unanswered++;
            }
        }
        return $unanswered;
    }

    public function getUserAnswer($questionId)
    {
        return $this->attempt->answers[$questionId] ?? null;
    }

    public function isCorrect($questionId, $correctAnswer)
    {
        $userAnswer = $this->getUserAnswer($questionId);
        return $userAnswer && $userAnswer == $correctAnswer;
    }

    public function render()
    {
        return view('livewire.test-result');
    }
}
