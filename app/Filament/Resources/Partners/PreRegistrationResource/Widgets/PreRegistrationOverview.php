<?php

namespace App\Filament\Resources\Partners\PreRegistrationResource\Widgets;

use App\Filament\Resources\Partners\PreRegistrationResource\Pages\ListPreRegistrations;
use App\Models\Partners\PreRegistration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PreRegistrationOverview extends BaseWidget
{
    protected function getTablePage(): string
    {
        return ListPreRegistrations::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Pré Cadastros', PreRegistration::count()),
            Stat::make('Empresas Inativas', PreRegistration::where('finished', false)->withTrashed()->count()),
            Stat::make('Ativas & Inativas', PreRegistration::withTrashed()->count()),
        ];
    }
}
