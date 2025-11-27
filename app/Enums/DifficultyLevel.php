<?php

namespace App\Enums;

enum DifficultyLevel: int
{
    case EASY = 1;
    case MEDIUM = 2;
    case HARD = 3;

    public function label(): string
    {
        return match($this) {
            self::EASY => 'Easy',
            self::MEDIUM => 'Medium',
            self::HARD => 'Hard',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EASY => 'green',
            self::MEDIUM => 'yellow',
            self::HARD => 'red',
        };
    }
}
