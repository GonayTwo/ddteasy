<?php

namespace App\Services\Pagarme\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderPaymentStatus: string implements HasIcon, HasLabel
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Canceled = 'canceled';
    case Failed = 'failed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Paid => 'Pago',
            self::Canceled => 'Cancelado',
            self::Failed => 'Falhou'
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Pending => 'heroicon-m-clock',
            self::Paid => 'heroicon-m-check-circle',
            self::Canceled => 'heroicon-m-x-circle',
            self::Failed => 'heroicon-m-exclamation-triangle'
        };
    }
}
