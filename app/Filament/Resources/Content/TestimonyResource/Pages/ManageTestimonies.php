<?php

namespace App\Filament\Resources\Content\TestimonyResource\Pages;

use App\Filament\Resources\Content\TestimonyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTestimonies extends ManageRecords
{
    protected static string $resource = TestimonyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
