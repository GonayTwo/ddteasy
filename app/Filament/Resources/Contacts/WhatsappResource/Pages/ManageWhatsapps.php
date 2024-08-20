<?php

namespace App\Filament\Resources\Contacts\WhatsappResource\Pages;

use App\Filament\Resources\Contacts\WhatsappResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWhatsapps extends ManageRecords
{
    protected static string $resource = WhatsappResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
