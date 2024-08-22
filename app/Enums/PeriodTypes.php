<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PeriodTypes: string implements HasLabel
{
    case Period = 'period';
    case Hour = 'hour';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Period => 'Período',
            self::Hour => 'Hora Marcada',
        };
    }
}
