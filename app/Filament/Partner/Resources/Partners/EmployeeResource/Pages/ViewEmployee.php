<?php

namespace App\Filament\Partner\Resources\Partners\EmployeeResource\Pages;

use App\Filament\Partner\Resources\Partners\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
