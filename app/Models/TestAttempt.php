<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'started_at',
        'submitted_at',
        'score',
        'correct_answers',
        'wrong_answers',
        'answers',
        'questions',
        'status',
        'duration_minutes',
        'duration_seconds',
        'remaining_seconds',
        'paused_at',
        'question_start_times',
        'locked_questions',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'paused_at' => 'datetime',
        'score' => 'decimal:2',
        'answers' => 'array',
        'questions' => 'array',
        'question_start_times' => 'array',
        'locked_questions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isSubmitted()
    {
        return in_array($this->status, ['submitted', 'graded', 'cheating_detected']);
    }

    public function isGraded()
    {
        return $this->status === 'graded';
    }

    public function isCheating()
    {
        return $this->status === 'cheating_detected';
    }

    public function getTimeElapsed()
    {
        if ($this->submitted_at) {
            return $this->started_at->diffInMinutes($this->submitted_at);
        }
        return $this->started_at->diffInMinutes(now());
    }
}
