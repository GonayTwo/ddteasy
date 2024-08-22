<?php

namespace App\Filament\Partner\Resources\Partners\CompanyServiceResource\Pages;

use App\Filament\Partner\Resources\Partners\CompanyServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyServices extends ListRecords
{
    protected static string $resource = CompanyServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
