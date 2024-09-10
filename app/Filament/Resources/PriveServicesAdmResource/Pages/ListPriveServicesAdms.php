<?php

namespace App\Filament\Resources\PriveServicesAdmResource\Pages;

use App\Filament\Resources\PriveServicesAdmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPriveServicesAdms extends ListRecords
{
    protected static string $resource = PriveServicesAdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
