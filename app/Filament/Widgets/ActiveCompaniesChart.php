<?php

namespace App\Filament\Widgets;

use App\Enums\CompanyStatus;
use App\Models\Partners\Company;
use Filament\Widgets\ChartWidget;

class ActiveCompaniesChart extends ChartWidget
{
    protected static ?string $heading = 'Atividade das empresas';

    protected static ?string $description = 'Quantidade total de empresas ativas e inativas';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = [];
        $backgroundColors = collect([]);
        $labels = [];

        foreach (CompanyStatus::cases() as $status) {
            $data[] = Company::where('status', $status)->count();
            $backgroundColors->push(str($status->getColor()[500])->explode(',')->toArray());
            $labels[] = $status->getLabel();
        }

        $backgroundColors = $backgroundColors->map(fn (array $rgb) => sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]))->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Empresas',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
