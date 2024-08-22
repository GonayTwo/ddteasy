<?php

namespace App\Filament\Partner\Widgets;

use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Agendamentos';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Agendamentos',
                    'data' => [],
                    'fill' => true,
                ],
            ],
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
