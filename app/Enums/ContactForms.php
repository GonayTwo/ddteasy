<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContactForms: string implements HasLabel
{
    case Contact = 'contact';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Contact => 'Contato'
        };
    }
}
