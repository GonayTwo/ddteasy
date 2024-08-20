<?php

namespace App\Filament\Resources\Partners\PreRegistrationResource\Pages;

use App\Filament\Resources\Partners\PreRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreRegistration extends EditRecord
{
    protected static string $resource = PreRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
