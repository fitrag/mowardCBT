<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'duration',
        'show_results',
        'show_result_details',
        'show_score_to_students',
        'enable_safe_browser',
        'correct_score',
        'wrong_score',
        'unanswered_score',
        'max_score',
        'use_token',
        'token',
        'token_expires_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'show_results' => 'boolean',
        'show_result_details' => 'boolean',
        'show_score_to_students' => 'boolean',
        'enable_safe_browser' => 'boolean',
        'use_token' => 'boolean',
        'token_expires_at' => 'datetime',
        'correct_score' => 'decimal:2',
        'wrong_score' => 'decimal:2',
        'unanswered_score' => 'decimal:2',
        'max_score' => 'decimal:2',
    ];

    public function isTokenValid($token)
    {
        if (!$this->use_token) {
            return true;
        }

        if ($this->token !== $token) {
            return false;
        }

        if ($this->token_expires_at && $this->token_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'test_groups');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'test_subjects')
            ->withPivot([
                'question_type',
                'difficulty_level',
                'question_count',
                'options_count',
                'randomize_questions',
                'randomize_answers',
            ])
            ->withTimestamps();
    }

    public function attempts()
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function isActive()
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    public function isUpcoming()
    {
        return $this->start_date > now();
    }

    public function isExpired()
    {
        return $this->end_date < now();
    }

    public function getSubjectAttribute()
    {
        return $this->subjects->first();
    }

    public function getStatusAttribute()
    {
        if ($this->isActive()) {
            return 'active';
        } elseif ($this->isUpcoming()) {
            return 'upcoming';
        } else {
            return 'expired';
        }
    }
}
