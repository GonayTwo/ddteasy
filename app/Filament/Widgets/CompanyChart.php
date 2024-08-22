<?php

namespace App\Filament\Widgets;

use App\Models\Partners\Company;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CompanyChart extends ChartWidget
{
    protected static ?string $heading = 'Cadastro de empresas por mês';

    protected static ?string $description = 'Quantidade de empresas cadastradas na plataforma durante os meses';

    protected static string $color = 'secondary';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $data = Trend::model(Company::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Empresas',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
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
