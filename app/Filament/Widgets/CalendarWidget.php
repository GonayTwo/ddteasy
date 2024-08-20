<?php

namespace App\Filament\Widgets;

use App\Models\Partners\Calendar;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Calendar::class;

    protected function headerActions(): array
    {
        return [
            CreateAction::make()->label('Adicionar data')
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'start_at' => $arguments['start'] ?? null,
                        ]);
                    }
                )->mutateFormDataUsing(function (array $data): array {
                    $company = auth()->user()->userable->companies->first();

                    return [
                        ...$data,
                        'company_id' => $company->id,
                    ];
                }),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $company = auth()->user()->userable->companies->first();

        return Calendar::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('company_id', $company->id)
            // ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Calendar $event) => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'color' => $event->color,
                    'start' => $event->start_at,
                    'end' => $event->end_at,
                ]
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(255),
                    ColorPicker::make('color')
                        ->label('Cor')
                        ->required(),
                ]),
            DateTimePicker::make('start_at')
                ->label('Data')
                ->minDate(now())
                ->native(false)
                ->seconds(false)
                ->required()
                ->columnSpanFull(),
        ];
    }
}
