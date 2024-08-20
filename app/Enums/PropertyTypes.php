<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PropertyTypes: string implements HasIcon, HasLabel
{
    case Apartament = 'apartament';
    case House = 'house';

    public function getLabel(): ?string
    {
        return __($this->value);
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Apartament => 'heroicon-m-building-office',
            self::House => 'heroicon-m-home'
        };
    }
}
