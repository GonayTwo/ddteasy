<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HouseRanges: string implements HasLabel
{
    case MinorThan100 = 'minor-than100';
    case From100To200 = 'from100-to200';
    case From200To300 = 'from200-to300';
    case From300To400 = 'from300-to400';
    case From400To500 = 'from400-to500';
    case From500To600 = 'from500-to600';
    case GreaterThan600 = 'greater-than600';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MinorThan100 => 'Abaixo de 100 m²',
            self::From100To200 => '100m² a 200m²',
            self::From200To300 => '200m² a 300m²',
            self::From300To400 => '300m² a 400m²',
            self::From400To500 => '400m² a 500m²',
            self::From500To600 => '500m² a 600m²',
            self::GreaterThan600 => 'Acima de 600m²',
        };
    }
}
