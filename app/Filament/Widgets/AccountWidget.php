<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseWidget;

class AccountWidget extends BaseWidget
{
    protected static string $view = 'filament.partner.widgets.account-widget';

    protected int|string|array $columnSpan = 'full';
}
