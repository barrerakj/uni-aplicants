<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ApplicantStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case Interviewed = 'interviewed';
    case Admitted = 'admitted';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Interviewed => 'Interviewed',
            self::Admitted => 'Admitted',
            self::Rejected => 'Rejected',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Interviewed => 'info',
            self::Admitted => 'success',
            self::Rejected => 'danger',
        };
    }
}
