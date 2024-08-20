<?php

namespace App\Filament\Partner\Resources\Partners\CalendarResource\Pages;

use App\Filament\Partner\Resources\Partners\CalendarResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCalendar extends ViewRecord
{
    protected static string $resource = CalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
