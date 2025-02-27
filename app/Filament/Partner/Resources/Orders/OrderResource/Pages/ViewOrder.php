<?php

namespace App\Filament\Partner\Resources\Orders\OrderResource\Pages;

use App\Filament\Partner\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
