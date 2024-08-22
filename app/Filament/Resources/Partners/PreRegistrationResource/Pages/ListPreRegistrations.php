<?php

namespace App\Filament\Resources\Partners\PreRegistrationResource\Pages;

use App\Filament\Resources\Partners\PreRegistrationResource;
use App\Filament\Resources\Partners\PreRegistrationResource\Widgets;
use Filament\Resources\Pages\ListRecords;

class ListPreRegistrations extends ListRecords
{
    protected static string $resource = PreRegistrationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\PreRegistrationOverview::class,
        ];
    }
}
