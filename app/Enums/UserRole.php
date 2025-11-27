<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case OPERATOR = 'operator';
    case PESERTA = 'peserta';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::OPERATOR => 'Operator',
            self::PESERTA => 'Peserta',
        };
    }
}
