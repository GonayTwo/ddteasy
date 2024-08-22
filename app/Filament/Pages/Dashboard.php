<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\ActionSize;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Filtros')
                    ->description('Filtre aqui os resultados das estatísticas abaixo.')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('startDate')
                            ->label('Desde:')
                            ->maxDate(fn (Forms\Get $get) => $get('endDate') ?: now())
                            ->default(now()->startOfYear()),
                        Forms\Components\DatePicker::make('endDate')
                            ->label('Até:')
                            ->minDate(fn (Forms\Get $get) => $get('startDate') ?: now())
                            ->maxDate(now())
                            ->default(now()),
                    ])
                    ->headerActions($this->getFiltersFormHeaderActions()),
            ]);
    }

    private function getFiltersFormHeaderActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('clearFilters')
                ->label('Limpar Filtros')
                ->icon('heroicon-m-x-circle')
                ->size(ActionSize::ExtraSmall)
                ->hidden(fn (Forms\Get $get) => ($get('startDate') == null) && ($get('endDate') == null))
                ->action(function (Forms\Set $set) {
                    $set('startDate', null);
                    $set('endDate', null);

                    Notification::make()
                        ->title('Filtros limpos!')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getColumns(): int|string|array
    {
        return 3;
    }
}
