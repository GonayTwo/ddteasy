<?php

namespace App\Filament\Resources\Services\PlagueResource\Pages;

use App\Filament\Resources\Services\PlagueResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePlagues extends ManageRecords
{
    protected static string $resource = PlagueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
