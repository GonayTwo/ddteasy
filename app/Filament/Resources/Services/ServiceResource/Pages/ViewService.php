<?php

namespace App\Filament\Resources\Services\ServiceResource\Pages;

use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewService extends ViewRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
