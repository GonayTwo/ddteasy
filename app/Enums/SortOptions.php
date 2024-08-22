<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SortOptions: string implements HasLabel
{
    case Recommendation = 'recommendation';
    case Closest = 'closest';
    case Cheapest = 'cheapest';
    case Costiest = 'costiest';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Recommendation => 'Recomendação',
            self::Closest => 'Mais próximos',
            self::Cheapest => 'Menor preço',
            self::Costiest => 'Maior preço',
        };
    }
}
