<?php

namespace App\Filament\Resources\Contacts\ContactResource\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use App\Models\Contacts\Contact;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('sendEmail')
                ->label('Responder')
                ->icon('heroicon-m-paper-airplane')
                ->url(fn (Contact $record): string => "mailto:{$record->email}")
                ->openUrlInNewTab(),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
