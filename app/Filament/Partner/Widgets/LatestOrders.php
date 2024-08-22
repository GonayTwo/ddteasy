<?php

namespace App\Filament\Partner\Widgets;

use App\Enums\HouseRanges;
use App\Enums\PropertyTypes;
use App\Enums\ServicePeriods;
use App\Filament\Partner\Resources\Orders\OrderResource;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Tables\Columns\Orders\TotalColumn;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Últimos Agendamentos';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(filament()->getTenant()->orders()->getQuery())
            ->paginated(false)
            ->modifyQueryUsing(fn (Builder $query) => $query->orderByDesc('created_at')->limit(5))
            ->defaultSort('date', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->badge(),
                Tables\Columns\TextColumn::make('customer.user.full_name')
                    ->label('Cliente')
                    ->limit(20),
                Tables\Columns\TextColumn::make('items.0.service_id')
                    ->label('Serviço')
                    ->formatStateUsing(fn ($state) => Service::find($state)->name)
                    ->limit(20),
                Tables\Columns\TextColumn::make('period.value')
                    ->label('Período')
                    ->badge()
                    ->color('secondary')
                    ->formatStateUsing(fn (?string $state) => ServicePeriods::tryFrom($state) ? ServicePeriods::from($state)->getLabel() : str($state)->substr(0, 5)),
                Tables\Columns\TextColumn::make('property')
                    ->label('Tipo do Imóvel')
                    ->formatStateUsing(fn (?string $state): string => static::getOrderPropertyLabel($state)),
                Tables\Columns\TextColumn::make('address.street')
                    ->label('Endereço')
                    ->limit(15),
                TotalColumn::make('items')
                    ->jsonField('daily_price')
                    ->label('Valor'),
                Tables\Columns\TextColumn::make('latest_status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter(),
                Columns\TextColumn::make('created_at')
                    ->label('Feito em:')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record])),
            ])
            ->headerActions([
                Tables\Actions\Action::make('all')
                    ->label('Ver Mais')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(OrderResource::getUrl('index')),
            ]);
    }

    private function getOrderPropertyLabel(string $data): string
    {
        $data = explode(', ', $data);

        $type = PropertyTypes::tryFrom($data[0]);
        $size = $data[1];

        $label = $type->getLabel() . ' - ' . match ($type) {
            PropertyTypes::Apartament => "$size Quarto(s)",
            PropertyTypes::House => HouseRanges::tryFrom($size)?->getLabel()
        };

        return $label;
    }
}
