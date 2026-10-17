<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Program: string implements HasLabel
{
    case Engineering = 'engineering';
    case Law = 'law';
    case Medicine = 'medicine';
    case Economics = 'economics';
    case Architecture = 'architecture';

    public function getLabel(): string
    {
        return match ($this) {
            self::Engineering => 'Engineering',
            self::Law => 'Law',
            self::Medicine => 'Medicine',
            self::Economics => 'Economics',
            self::Architecture => 'Architecture',
        };
    }
}
