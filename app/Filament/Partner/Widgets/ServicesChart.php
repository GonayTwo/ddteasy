<?php

namespace App\Filament\Partner\Widgets;

use Filament\Widgets\ChartWidget;

class ServicesChart extends ChartWidget
{
    protected static ?string $heading = 'Serviços';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
