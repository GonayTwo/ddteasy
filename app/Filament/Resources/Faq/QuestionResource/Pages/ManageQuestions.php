<?php

namespace App\Filament\Resources\Faq\QuestionResource\Pages;

use App\Filament\Resources\Faq\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageQuestions extends ManageRecords
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
