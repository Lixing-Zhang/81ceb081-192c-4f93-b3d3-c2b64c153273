<?php

namespace App\Enums;

enum Report: int
{
    case Diagnostic = 1;
    case Progress = 2;
    case Feedback = 3;

    public static function toArray(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
