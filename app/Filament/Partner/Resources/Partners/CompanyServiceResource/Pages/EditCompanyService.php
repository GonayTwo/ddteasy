<?php

namespace App\Filament\Partner\Resources\Partners\CompanyServiceResource\Pages;

use App\Filament\Partner\Resources\Partners\CompanyServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyService extends EditRecord
{
    protected static string $resource = CompanyServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
