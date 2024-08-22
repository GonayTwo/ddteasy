<?php

namespace App\Filament\Resources\Contacts\RecipientResource\Pages;

use App\Filament\Resources\Contacts\RecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRecipients extends ManageRecords
{
    protected static string $resource = RecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
