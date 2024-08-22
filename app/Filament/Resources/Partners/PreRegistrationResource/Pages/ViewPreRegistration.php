<?php

namespace App\Filament\Resources\Partners\PreRegistrationResource\Pages;

use App\Filament\Resources\Partners\PreRegistrationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPreRegistration extends ViewRecord
{
    protected static string $resource = PreRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
