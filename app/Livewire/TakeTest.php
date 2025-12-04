<?php

namespace App\Livewire;

use App\Models\Question;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TakeTest extends Component
{
    public Test $test;
    public TestAttempt $attempt;
    public $questions = [];
    public $answers = [];
    public $currentQuestionIndex = 0;
    public $timeRemaining;
    public $question_start_times = []; // Track when each question was first viewed
    public $locked_questions = []; // Track which questions are locked due to timer expiry
    
    // Cache for subject configurations to avoid repeated access
    protected $subjectConfigsCache = null;
    
    // Pending database updates to batch at end of request
    protected $pendingUpdates = [];

    public function mount(Test $test)
    {
        // Eager load test with all necessary relationships to prevent N+1 queries
        $this->test = $test->load(['subjects' => function ($query) {
            $query->withPivot([
                'question_count',
                'question_type',
                'difficulty_level',
                'options_count',
                'randomize_questions',
                'randomize_answers'
            ]);
        }]);
        
        $user = auth()->user();

        // Get or validate attempt with minimal fields for performance
        $this->attempt = TestAttempt::select([
            'id', 'user_id', 'test_id', 'status', 'started_at', 'paused_at',
            'remaining_seconds', 'questions', 'answers', 'question_start_times', 
            'locked_questions'
        ])
            ->where('user_id', $user->id)
            ->where('test_id', $this->test->id)
            ->where('status', 'in_progress')
            ->firstOrFail();

        // Check if test is paused
        $this->checkPauseStatus();

        // Load questions - use saved order if exists, otherwise generate new
        if ($this->attempt->questions && !empty($this->attempt->questions)) {
            // Load existing question order
            $this->questions = $this->attempt->questions;
            
            // Check if we need to process options (first time loading or settings changed)
            $needsProcessing = false;
            foreach ($this->questions as $question) {
                if ($question['question_type'] == 1) {
                    // Check if shuffled_options or limited_options is missing
                    if (!isset($question['shuffled_options']) && !isset($question['limited_options'])) {
                        $needsProcessing = true;
                        break;
                    }
                }
            }
            
            // Process options if needed and save back to database
            if ($needsProcessing) {
                $this->processQuestionOptions();
                // Save updated questions with shuffled/limited options
                $this->attempt->update([
                    'questions' => $this->questions,
                ]);
            }
        } else {
            // Generate new question order
            $this->loadQuestions();
            // Save question order to attempt
            $this->attempt->update([
                'questions' => $this->questions,
            ]);
        }

        // Load existing answers
        $this->answers = $this->attempt->answers ?? [];

        // Load question start times and locked questions from attempt
        $this->question_start_times = $this->attempt->question_start_times ?? [];
        $this->locked_questions = $this->attempt->locked_questions ?? [];

        // Initialize start time for first question if not already set
        if (!empty($this->questions)) {
            $firstQuestionId = $this->questions[0]['id'] ?? null;
            if ($firstQuestionId && !isset($this->question_start_times[$firstQuestionId])) {
                $this->question_start_times[$firstQuestionId] = now()->timestamp;
                $this->saveTimerState();
            }
        }

        // Initialize timeRemaining to 0 first
        $this->timeRemaining = 0;
        
        // Initialize remaining_seconds if null (first time)
        if ($this->attempt->remaining_seconds === null) {
            $totalAllowedSeconds = (int) $this->test->duration * 60;
            $this->attempt->update([
                'remaining_seconds' => $totalAllowedSeconds,
            ]);
            $this->attempt->refresh();
        }
        
        // Calculate time remaining
        $this->calculateTimeRemaining();
    }
    
    /**
     * Check if test is paused by admin
     * Uses cache to reduce database queries
     */
    public function checkPauseStatus()
    {
        // Use cache to avoid hitting database every 5 seconds
        $cacheKey = "test_attempt_status_{$this->attempt->id}";
        
        $status = cache()->remember($cacheKey, 5, function () {
            return TestAttempt::where('id', $this->attempt->id)->value('status');
        });
        
        if ($status === 'paused') {
            // Clear cache and refresh to get latest data
            cache()->forget($cacheKey);
            $this->attempt->refresh();
            
            // Dispatch event to frontend to handle redirect
            $this->dispatch('test-paused');
            return false;
        }
        
        return true;
    }
    
    /**
     * Update remaining time to database (called periodically from frontend)
     * Only updates if there's a significant change to reduce database writes
     */
    public function updateElapsedTime()
    {
        // Only update if changed by at least 5 seconds to reduce DB writes
        $currentSaved = $this->attempt->remaining_seconds;
        $difference = abs($currentSaved - $this->timeRemaining);
        
        if ($difference >= 5) {
            $this->attempt->remaining_seconds = $this->timeRemaining;
            $this->attempt->save(['timestamps' => false]); // Skip updating updated_at
        }
    }
    
    /**
     * Get cached subject configurations
     */
    protected function getSubjectConfigs()
    {
        if ($this->subjectConfigsCache === null) {
            $this->subjectConfigsCache = $this->test->subjects->keyBy('id');
        }
        return $this->subjectConfigsCache;
    }

    public function processQuestionOptions()
    {
        // Use cached subject configurations to avoid N+1 queries
        $subjectConfigs = $this->getSubjectConfigs();
        
        // Re-apply options_count and randomization to loaded questions
        foreach ($this->questions as $index => $question) {
            // Find the subject configuration for this question
            $subject = $subjectConfigs->get($question['subject_id']);
            
            if (!$subject || $question['question_type'] != 1) {
                continue;
            }

            $options = collect($question['options'] ?? []);
            
            // Apply options_count limit if set
            if ($subject->pivot->options_count && $subject->pivot->options_count > 0) {
                $options = $options->take($subject->pivot->options_count);
            }
            
            // Apply randomization if enabled
            if ($subject->pivot->randomize_answers) {
                // Check if already shuffled (has shuffled_options key)
                if (!isset($question['shuffled_options'])) {
                    // Use multiple shuffles with random sorting for better randomization
                    $options = $options->shuffle();
                    
                    // Additional randomization: sort by random values
                    $options = $options->sortBy(function() {
                        return random_int(0, 999999);
                    })->values(); // values() resets array keys
                    
                    $this->questions[$index]['shuffled_options'] = $options->toArray();
                }
            } else {
                // Use limited options without shuffle
                if (!isset($question['limited_options'])) {
                    $this->questions[$index]['limited_options'] = $options->toArray();
                }
            }
        }
    }

    public function loadQuestions()
    {
        $questions = collect();
        
        // Pre-load all subject IDs and their configurations
        $subjectConfigs = $this->getSubjectConfigs();
        $subjectIds = $subjectConfigs->keys()->toArray();
        
        // Single optimized query to get all questions at once
        $allQuestions = Question::with('options')
            ->whereIn('subject_id', $subjectIds)
            ->where('status', 1)
            ->get()
            ->groupBy('subject_id');
        
        // Process questions per subject
        foreach ($subjectConfigs as $subjectId => $subject) {
            $subjectQuestions = $allQuestions->get($subjectId, collect());
            
            // Apply filters from pivot
            if ($subject->pivot->question_type) {
                $subjectQuestions = $subjectQuestions->where('question_type', $subject->pivot->question_type)->values();
            }
            
            if ($subject->pivot->difficulty_level) {
                $subjectQuestions = $subjectQuestions->where('difficulty_level', $subject->pivot->difficulty_level)->values();
            }
            
            // Randomize and limit to question_count
            $subjectQuestions = $subjectQuestions->shuffle()
                ->take($subject->pivot->question_count);

            // Randomize questions if enabled
            if ($subject->pivot->randomize_questions) {
                $subjectQuestions = $subjectQuestions->shuffle();
            }

            // Process each question for this subject
            $subjectQuestions = $subjectQuestions->map(function ($question) use ($subject) {
                if ($question->question_type == 1) { // Multiple choice
                    $options = collect($question->options);
                    
                    // Apply options_count limit if set
                    if ($subject->pivot->options_count && $subject->pivot->options_count > 0) {
                        $options = $options->take($subject->pivot->options_count);
                    }
                    
                    // Randomize answers if enabled
                    if ($subject->pivot->randomize_answers) {
                        // Use multiple shuffles with random sorting for better randomization
                        $options = $options->shuffle();
                        
                        // Additional randomization: sort by random values
                        $options = $options->sortBy(function() {
                            return random_int(0, 999999);
                        })->values(); // values() resets array keys
                        
                        $question->shuffled_options = $options->toArray();
                    } else {
                        // Keep original order but still apply limit
                        $question->limited_options = $options->toArray();
                    }
                }
                return $question;
            });

            $questions = $questions->merge($subjectQuestions);
        }

        // Convert to array with all attributes
        $this->questions = $questions->map(function ($question) {
            $questionArray = $question->toArray();
            
            // Explicitly include timer field
            $questionArray['timer'] = $question->timer;
            
            // Get correct answer from options
            $correctOption = $question->options->where('is_correct', true)->first();
            $questionArray['correct_answer'] = $correctOption ? $correctOption->option_text : null;
            
            // Ensure shuffled_options is preserved if it exists
            if (isset($question->shuffled_options)) {
                $questionArray['shuffled_options'] = $question->shuffled_options->toArray();
            } elseif (isset($question->limited_options)) {
                // Use limited options if no shuffle
                $questionArray['limited_options'] = $question->limited_options->toArray();
            }
            
            return $questionArray;
        })->toArray();
    }

    public function calculateTimeRemaining()
    {
        // Always use remaining_seconds as source of truth
        $this->timeRemaining = (int) $this->attempt->remaining_seconds;

        // Auto-submit if time is up
        if ($this->timeRemaining <= 0) {
            $this->submitTest();
        }
    }

    public function saveAnswer($questionId, $answer)
    {
        // Check if test is paused
        $this->checkPauseStatus();
        
        // Check if question is locked
        if (in_array($questionId, $this->locked_questions)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'This question is locked due to timer expiry.']);
            return;
        }

        $this->answers[$questionId] = $answer;
        
        // Defer database update to dehydrate hook
        $this->pendingUpdates['answers'] = $this->answers;
    }

    public function saveTimerState()
    {
        // Defer database update to dehydrate hook
        $this->pendingUpdates['question_start_times'] = $this->question_start_times;
        $this->pendingUpdates['locked_questions'] = $this->locked_questions;
    }
    
    /**
     * Batch all pending updates when component dehydrates
     */
    public function dehydrate()
    {
        // Save all pending updates at once to reduce database calls
        if (!empty($this->pendingUpdates)) {
            $this->attempt->update($this->pendingUpdates);
            $this->pendingUpdates = [];
        }
    }

    public function goToQuestion($index)
    {
        $this->currentQuestionIndex = $index;
        
        // Track when this question was first viewed
        $questionId = $this->questions[$index]['id'] ?? null;
        if ($questionId && !isset($this->question_start_times[$questionId])) {
            $this->question_start_times[$questionId] = now()->timestamp;
            $this->saveTimerState();
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            
            // Track when this question was first viewed
            $questionId = $this->questions[$this->currentQuestionIndex]['id'] ?? null;
            if ($questionId && !isset($this->question_start_times[$questionId])) {
                $this->question_start_times[$questionId] = now()->timestamp;
                $this->saveTimerState();
            }
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            
            // Track when this question was first viewed
            $questionId = $this->questions[$this->currentQuestionIndex]['id'] ?? null;
            if ($questionId && !isset($this->question_start_times[$questionId])) {
                $this->question_start_times[$questionId] = now()->timestamp;
                $this->saveTimerState();
            }
        }
    }

    public function submitTest()
    {
        // Check if test is paused
        $this->checkPauseStatus();
        
        // Calculate score and statistics
        $stats = $this->calculateScore();

        // Calculate total duration
        $duration = (int) $this->test->duration;
        $totalAllowedSeconds = $duration * 60;
        
        // Duration = total allowed - remaining time
        $durationSeconds = $totalAllowedSeconds - $this->timeRemaining;

        // Update attempt
        $this->attempt->update([
            'submitted_at' => now(),
            'score' => $stats['score'],
            'correct_answers' => $stats['correct_answers'],
            'wrong_answers' => $stats['wrong_answers'],
            'status' => 'graded',
            'answers' => $this->answers,
            'duration_seconds' => $durationSeconds,
            'duration_minutes' => round($durationSeconds / 60),
        ]);

        // Redirect based on show_results setting
        if ($this->test->show_results) {
            session()->flash('success', 'Test submitted successfully!');
            return redirect()->route('student.test.result', $this->test);
        } else {
            session()->flash('success', 'Test submitted successfully!');
            return redirect()->route('student.dashboard');
        }
    }

    public function calculateScore()
    {
        $totalScore = 0;
        $correctAnswers = 0;
        $wrongAnswers = 0;
        $unanswered = 0;
        
        $totalQuestions = count($this->questions);

        foreach ($this->questions as $question) {
            $questionId = $question['id'];
            $userAnswer = $this->answers[$questionId] ?? null;

            if ($userAnswer === null) {
                $unanswered++;
                $totalScore += $this->test->unanswered_score;
            } elseif ($userAnswer == $question['correct_answer']) {
                $correctAnswers++;
                $totalScore += $this->test->correct_score;
            } else {
                $wrongAnswers++;
                $totalScore += $this->test->wrong_score;
            }
        }
        
        // Calculate maximum possible score based on all correct answers
        $maxPossibleScore = $totalQuestions * $this->test->correct_score;
        
        // Normalize to max_score (usually 100)
        // Formula: (raw_score / max_possible_score) * max_score
        if ($maxPossibleScore > 0) {
            $normalizedScore = ($totalScore / $maxPossibleScore) * $this->test->max_score;
        } else {
            $normalizedScore = 0;
        }
        
        // Ensure score is within bounds [0, max_score]
        $finalScore = max(0, min($normalizedScore, $this->test->max_score));
        
        // Return score and statistics
        return [
            'score' => $finalScore,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'unanswered' => $unanswered,
            'total_questions' => $totalQuestions,
        ];
    }

    public function getCurrentQuestion()
    {
        return $this->questions[$this->currentQuestionIndex] ?? null;
    }

    public function getAnsweredCount()
    {
        return count($this->answers);
    }

        public function handleCheating()
    {
        // Check if cheating detection is enabled globally
        if (!Setting::get('enable_cheating_detection', true)) {
            return; // Cheating detection disabled, ignore
        }
        
        // Calculate score and statistics
        $stats = $this->calculateScore();

        // Calculate duration in seconds
        $durationSeconds = $this->attempt->started_at->diffInSeconds(now());

        // Update attempt with cheating flag
        $this->attempt->update([
            'submitted_at' => now(),
            'score' => $stats['score'],
            'correct_answers' => $stats['correct_answers'],
            'wrong_answers' => $stats['wrong_answers'],
            'status' => 'cheating_detected',
            'answers' => $this->answers,
            'duration_seconds' => $durationSeconds,
            'duration_minutes' => round($durationSeconds / 60),
        ]);

        // Redirect to cheating notification page
        return redirect()->route('student.test.cheating', $this->test);
    }

    public function render()
    {
        return view('livewire.take-test');
    }
}
