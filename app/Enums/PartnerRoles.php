<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PartnerRoles: string implements HasLabel
{
    case Responsible = 'responsible';

    case Supervisor = 'supervisor';

    case Employee = 'employee';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Responsible => 'Responsável',
            self::Supervisor => 'Supervisor',
            self::Employee => 'Funcionário',
        };
    }
}
