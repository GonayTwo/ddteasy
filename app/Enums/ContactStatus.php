<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ContactStatus: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';
    case Answered = 'answered';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => 'Novo',
            self::Answered => 'Respondido',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-clock',
            self::Answered => 'heroicon-m-check-circle',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => 'warning',
            self::Answered => 'success',
        };
    }
}
