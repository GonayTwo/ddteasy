<?php

namespace App\Filament\Partner\Resources\Orders\OrderResource\Pages;

use App\Filament\Partner\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}