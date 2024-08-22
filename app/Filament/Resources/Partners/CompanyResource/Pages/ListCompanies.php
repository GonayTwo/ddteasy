<?php

namespace App\Filament\Resources\Partners\CompanyResource\Pages;

use App\Enums\CompanyStatus;
use App\Filament\Resources\Partners\CompanyResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make()
                ->label('Todas'),
        ];

        foreach (CompanyStatus::cases() as $case) {
            $tabs[$case->value] = Tab::make()
                ->label($case->getLabel())
                ->icon($case->getIcon())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $case));
        }

        return $tabs;
    }
}
