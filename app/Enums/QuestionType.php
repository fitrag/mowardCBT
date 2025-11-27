<?php

namespace App\Enums;

enum QuestionType: int
{
    case MULTIPLE_CHOICE = 1;
    case ESSAY = 2;
    case SHORT_ANSWER = 3;

    public function label(): string
    {
        return match($this) {
            self::MULTIPLE_CHOICE => 'Multiple Choice',
            self::ESSAY => 'Essay',
            self::SHORT_ANSWER => 'Short Answer',
        };
    }
}
