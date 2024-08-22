<?php

namespace App\Livewire\Web\Customers\Services;

use App\Enums\HouseRanges;
use App\Enums\PropertyTypes;
use App\Enums\ServicePeriods;
use App\Models\Address;
use App\Models\Orders\Order;
use App\Tables\Columns\Orders\TotalColumn;
use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Últimos Serviços')]
class Table extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->query(Order::where('customer_id', auth()->user()->userable->id))
            ->defaultPaginationPageOption(5)
            ->columns([
                Columns\TextColumn::make('pagarme_id')
                    ->label('ID'),
                Columns\TextColumn::make('company.fantasy_name')
                    ->label('Empresa'),
                Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y'),
                Columns\TextColumn::make('period.value')
                    ->label('Período')
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => ServicePeriods::tryFrom($state) ? ServicePeriods::from($state)->getLabel() : str($state)->substr(0, 5)),
                Columns\TextColumn::make('property')
                    ->label('Propriedade')
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => $this->getOrderPropertyLabel($state)),
                Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->searchable()
                    ->formatStateUsing(fn (?Address $state): string => $this->getOrderAddressLabel($state))
                    ->limit(50),
                TotalColumn::make('items')
                    ->jsonField('daily_price')
                    ->label('Valor'),
                Columns\TextColumn::make('latest_status')
                    ->label('Status')
                    ->alignCenter(),
                Columns\TextColumn::make('payment_status')
                    ->label('Pagamento')
                    ->alignCenter(),
                Columns\TextColumn::make('payment_method')
                    ->label('Método de Pagamento')
                    ->alignCenter(),
                Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->toggleable(),
                Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                Filter::make('date')
                    ->form([
                        Components\DatePicker::make('date_from')
                            ->label('De:'),
                        Components\DatePicker::make('date_until')
                            ->label('Até:'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['date_from'], fn (Builder $query, string $date): Builder => $query->whereDate('date', '>=', $date))
                            ->when($data['date_until'], fn (Builder $query, string $date): Builder => $query->whereDate('date', '<=', $date));
                    }),
            ])
            ->groups([
                Group::make('date')
                    ->label('Data')
                    ->getTitleFromRecordUsing(fn (?Order $record): ?string => date('d/m/Y', strtotime($record->date)))
                    ->collapsible(),
            ])
            ->defaultGroup('date')
            ->actions([
                Action::make('see')
                    ->label('Visualizar')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Order $record): string => route('site.profile.services.see', ['order' => $record->id])),
            ])
            ->bulkActions([]);
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

    private function getOrderAddressLabel(Address $address): string
    {
        $address_label = $address->street . ', ' . $address->number;
        $address_label .= $address->complement ? ', ' . $address->complement : '';

        return $address_label;
    }
}
