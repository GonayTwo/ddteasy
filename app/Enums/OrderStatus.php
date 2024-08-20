<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{
    case Open = 'open';
    case Finished = 'finished';
    case Refused = 'refused';
    case Reschedule = 'reschedule';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Open => 'Aberto',
            self::Finished => 'Finalizado',
            self::Refused => 'Recusado',
            self::Reschedule => 'Reagendar',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Open => Color::Sky,
            self::Finished => Color::Lime,
            self::Refused => Color::Rose,
            self::Reschedule => Color::Orange,
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Open => 'heroicon-m-information-circle',
            self::Finished => 'heroicon-m-check-circle',
            self::Refused => 'heroicon-m-x-circle',
            self::Reschedule => 'heroicon-m-clock',
        };
    }
}
