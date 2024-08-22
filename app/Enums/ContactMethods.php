<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContactMethods: string implements HasLabel
{
    case Email = 'email';
    case Sms = 'sms';
    case WhatsApp = 'whatsapp';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Email => 'Email',
            self::Sms => 'SMS',
            self::WhatsApp => 'WhatsApp',
        };
    }
}
