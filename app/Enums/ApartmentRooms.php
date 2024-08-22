<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ApartmentRooms: string implements HasLabel
{
    case One = '1';
    case Two = '2';
    case Three = '3';
    case Four = '4';
    case Five = '5';
    case Six = '6';
    case Seven = '7';
    case Eight = '8';
    case Nine = '9';
    case Ten = '10';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::One => '1 Quarto',
            self::Two => '2 Quartos',
            self::Three => '3 Quartos',
            self::Four => '4 Quartos',
            self::Five => '5 Quartos',
            self::Six => '6 Quartos',
            self::Seven => '7 Quartos',
            self::Eight => '8 Quartos',
            self::Nine => '9 Quartos',
            self::Ten => '10 Quartos',
        };
    }
}
