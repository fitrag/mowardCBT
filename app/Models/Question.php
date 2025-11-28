<?php

namespace App\Models;

use App\Enums\DifficultyLevel;
use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'question',
        'image',
        'question_type',
        'difficulty_level',
        'status',
        'audio_file',
        'timer',
    ];

    protected $casts = [
        'question_type' => QuestionType::class,
        'difficulty_level' => DifficultyLevel::class,
        'status' => 'boolean',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
