<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServicePeriods: string implements HasLabel
{
    case Morning = 'morning';
    case Afternoon = 'afternoon';
    case Night = 'night';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Morning => 'Manhã',
            self::Afternoon => 'Tarde',
            self::Night => 'Noite',
        };
    }
}
