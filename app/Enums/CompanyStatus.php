<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CompanyStatus: string implements HasColor, HasIcon, HasLabel
{
    case Analysis = 'analysis';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Suspended = 'suspended';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Analysis => 'Análise',
            self::Approved => 'Aprovado',
            self::Rejected => 'Rejeitado',
            self::Suspended => 'Suspenso',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Analysis => Color::Sky,
            self::Approved => Color::Lime,
            self::Rejected => Color::Rose,
            self::Suspended => Color::Orange,
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Analysis => 'heroicon-m-magnifying-glass-circle',
            self::Approved => 'heroicon-m-check-circle',
            self::Rejected => 'heroicon-m-x-circle',
            self::Suspended => 'heroicon-m-exclamation-circle',
        };
    }
}
