<?php

namespace App\Filament\Partner\Resources\Orders\OrderResource\Pages;

use App\Filament\Partner\Resources\Orders\OrderResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'newest' => Tab::make()
                ->label('Novos')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date', '>=', now()->toDateTime())),
            'oldest' => Tab::make()
                ->label('Antigos')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('date', '<', now()->toDateTime())),
            'all' => Tab::make()
                ->label('Todos'),
        ];
    }
}
