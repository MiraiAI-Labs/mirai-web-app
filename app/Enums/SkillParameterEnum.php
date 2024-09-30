<?php

namespace App\Enums;

enum SkillParameterEnum: string
{
    case INTERPERSONAL = 'Interpersonal';
    case EQ = 'EQ';
    case CREATIVITY = 'Creativity';
    case ADAPTABILITY = 'Adaptability';
    case MOTIVATION = 'Motivation';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
