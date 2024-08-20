<?php

namespace App\Filament\Resources\Admin\AdminResource\Pages;

use App\Filament\Resources\Admin\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
