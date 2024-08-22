<?php

namespace App\Filament\Resources\Orders;

use App\Enums\HouseRanges;
use App\Enums\OrderStatus;
use App\Enums\PropertyTypes;
use App\Enums\ServicePeriods;
use App\Filament\Resources\Orders\OrderResource\Pages;
use App\Filament\Resources\Partners\CompanyResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderStatusUpdate;
use App\Models\Services\Service;
use App\Services\Pagarme\Enums\OrderPaymentStatus;
use App\Tables\Columns\Orders\TotalColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $modelLabel = 'agendamento';

    protected static ?string $navigationGroup = 'Agendamentos';

    protected static ?string $slug = 'agendamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        Forms\Components\Fieldset::make('Valores')
                            ->columns(3)
                            ->schema([
                                Forms\Components\Placeholder::make('amount')
                                    ->label('Total:')
                                    ->content(fn (Order $record) => 'R$ ' . number_format($record->pagarme['amount'] / 100, 2, ',', '.')),

                                Forms\Components\Placeholder::make('itemsTotalPrice')
                                    ->label('Parte DDTeasy:')
                                    ->content(fn (Order $record): string => 'R$ ' . number_format(($record->itemsTotalPrice * config('ddteasy.charge')) / 100, 2, ',', '.')),

                                Forms\Components\Placeholder::make('itemsTotalPrice')
                                    ->label('Parte Parceiro:')
                                    ->content(fn (Order $record) => 'R$ ' . number_format(($record->itemsTotalPrice - ($record->itemsTotalPrice * config('ddteasy.charge'))) / 100, 2, ',', '.')),

                                Forms\Components\FileUpload::make('partner_payment_attachment')
                                    ->label('Comprovante de pagamento do parceiro')
                                    ->directory('orders')
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                    ])
                                    ->openable()
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Fieldset::make('Parceiro')
                            ->columns(5)
                            ->relationship('company')
                            ->schema([
                                Forms\Components\Placeholder::make('corporate_name')
                                    ->label('Empresa:')
                                    ->content(fn ($state) => $state)
                                    ->hintAction(
                                        Forms\Components\Actions\Action::make('see')
                                            ->label('Ver')
                                            ->icon('heroicon-o-arrow-top-right-on-square')
                                            ->iconPosition(IconPosition::After)
                                            ->url(fn ($record) => CompanyResource::getUrl('view', ['record' => $record]))
                                            ->openUrlInNewTab()
                                            ->badge()
                                    ),

                                Forms\Components\Placeholder::make('cnpj')
                                    ->label('CNPJ:')
                                    ->content(fn ($state): string => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $state)),

                                Forms\Components\Placeholder::make('bank')
                                    ->label('Banco:')
                                    ->content(fn ($state) => $state),

                                Forms\Components\Placeholder::make('agency')
                                    ->label('Agência:')
                                    ->content(fn ($state) => $state),

                                Forms\Components\Placeholder::make('checking_account')
                                    ->label('Conta Corrente:')
                                    ->content(fn ($state) => $state),
                            ]),

                        Forms\Components\Fieldset::make('Cliente')
                            ->columns(4)
                            ->schema([
                                Forms\Components\Placeholder::make('customer.user.full_name')
                                    ->label('Nome:')
                                    ->content(fn (?Order $record): ?string => $record->customer->user->full_name),
                                Forms\Components\Placeholder::make('customer.phone')
                                    ->label('Telefone:')
                                    ->content(fn (?Order $record): ?string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $record->customer->phone)),
                                Forms\Components\Placeholder::make('customer.user.email')
                                    ->label('Email:')
                                    ->content(fn (?Order $record): ?string => $record->customer->user->email),
                                Forms\Components\Placeholder::make('pagarme.status')
                                    ->label('Status do Pagamento:')
                                    ->content(fn (Order $record): ?OrderPaymentStatus => OrderPaymentStatus::from($record->pagarme['status'])),
                                Forms\Components\Placeholder::make('observation')
                                    ->label('Observações:')
                                    ->columnSpanFull()
                                    ->content(fn (?string $state): ?string => $state),
                            ]),
                    ]),

                Forms\Components\Section::make('Endereço')
                    ->icon('heroicon-m-map-pin')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('address.cep')
                                ->label('CEP')
                                ->content(fn (?Order $record): ?string => preg_replace('/(\d{5})(\d{3})/', '$1-$2', $record->address->cep)),
                            Forms\Components\Placeholder::make('address.street')
                                ->label('Endereço')
                                ->content(fn (?Order $record): ?string => $record->address->street),
                            Forms\Components\Placeholder::make('address.number')
                                ->label('Número')
                                ->content(fn (?Order $record): ?string => $record->address->number),
                            Forms\Components\Placeholder::make('address.complement')
                                ->label('Complemento')
                                ->content(fn (?Order $record): ?string => $record->address->complement),
                        ])->columns(4),
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('address.district')
                                ->label('Bairro')
                                ->content(fn (?Order $record): ?string => $record->address->district),
                            Forms\Components\Placeholder::make('address.city')
                                ->label('Cidade')
                                ->content(fn (?Order $record): ?string => $record->address->city),
                            Forms\Components\Placeholder::make('address.state')
                                ->label('Estado')
                                ->content(fn (?Order $record): ?string => $record->address->state),
                        ])->columns(4),
                    ]),

                Forms\Components\Section::make('Tipo do Imóvel')
                    ->icon('heroicon-m-home-modern')
                    ->columns(2)
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Placeholder::make('property.type')
                            ->label('Tipo')
                            ->content(fn (?string $state): ?string => PropertyTypes::tryFrom($state)->getLabel() ?? $state),
                        Forms\Components\Placeholder::make('property.value')
                            ->label('Tamanho')
                            ->content(fn (?string $state): ?string => HouseRanges::tryFrom($state) ? HouseRanges::from($state)->getLabel() : "$state Quarto(s)"),
                    ]),

                Forms\Components\Section::make('Data')
                    ->icon('heroicon-m-calendar-days')
                    ->columns(2)
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Placeholder::make('date')
                            ->label('Data')
                            ->content(fn (string $state): string => date('d/m/Y', strtotime($state))),
                        Forms\Components\Placeholder::make('period.value')
                            ->label('Período/Horário')
                            ->content(fn (?string $state): ?string => ServicePeriods::tryFrom($state) ? ServicePeriods::from($state)->getLabel() : $state),
                    ]),

                Forms\Components\Section::make('Items')
                    ->icon('heroicon-m-shopping-bag')
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label(false)
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false)
                            ->columns(2)
                            ->disabled()
                            ->schema([
                                Forms\Components\Placeholder::make('service_id')
                                    ->label('Item')
                                    ->content(fn (?string $state): ?string => Service::find($state)->name)
                                    ->disabled(),
                                Forms\Components\Placeholder::make('daily_price')
                                    ->label('Valor')
                                    ->content(fn (?int $state): string => 'R$ ' . number_format($state / 100, decimals: 2, decimal_separator: ',', thousands_separator: '.'))
                                    ->disabled(),
                            ]),
                    ]),

                Forms\Components\Section::make('Atualizações')
                    ->icon('heroicon-m-clipboard')
                    ->description('Anote aqui as atualizações sobre o agendamento.')
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('latest_status')
                            ->label(' ')
                            ->relationship('orderStatusUpdates')
                            ->orderColumn('created_at')
                            ->reorderable(false)
                            ->deletable(false)
                            ->addable(false)
                            ->columns(2)
                            ->schema([
                                Forms\Components\Placeholder::make('status')
                                    ->content(fn (?string $state) => OrderStatus::from($state)->getLabel()),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Data')
                                    ->content(fn (?OrderStatusUpdate $record): string => $record->created_at->format('d/m/Y H:i')),

                                Forms\Components\Placeholder::make('observation')
                                    ->label('Observações')
                                    ->content(fn (?string $state) => $state)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informações')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        Infolists\Components\Fieldset::make('Valores')
                            ->columns(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('pagarme.amount')
                                    ->prefix('R$ ')
                                    ->label('Total:')
                                    ->formatStateUsing(fn (?int $state) => number_format($state / 100, 2, ',', '.')),

                                Infolists\Components\TextEntry::make('itemsTotalPrice')
                                    ->prefix('R$ ')
                                    ->label('Parte DDTeasy:')
                                    ->formatStateUsing(fn ($state): string => number_format(($state * config('ddteasy.charge')) / 100, 2, ',', '.')),

                                Infolists\Components\TextEntry::make('itemsTotalPrice')
                                    ->prefix('R$ ')
                                    ->label('Parte Parceiro:')
                                    ->formatStateUsing(fn ($state) => number_format(($state - ($state * config('ddteasy.charge'))) / 100, 2, ',', '.')),

                                Infolists\Components\TextEntry::make('partner_payment_attachment')
                                    ->label('Cliente pago:')
                                    ->badge()
                                    ->placeholder('Não')
                                    ->formatStateUsing(fn (?string $state) => !is_null($state) ? 'Comprovante' : 'Não pago')
                                    ->icon('heroicon-o-paper-clip')
                                    ->iconPosition(IconPosition::After)
                                    ->color('secondary')
                                    ->url(fn (?string $state) => !is_null($state) ? asset('storage/' . $state) : null, shouldOpenInNewTab: true),
                            ]),

                        Infolists\Components\Fieldset::make('Parceiro')
                            ->columns(5)
                            ->schema([
                                Infolists\Components\TextEntry::make('company.corporate_name')
                                    ->label('Empresa:')
                                    ->hintAction(
                                        Infolists\Components\Actions\Action::make('see')
                                            ->label('Ver')
                                            ->icon('heroicon-o-arrow-top-right-on-square')
                                            ->iconPosition(IconPosition::After)
                                            ->url(fn ($record) => CompanyResource::getUrl('view', ['record' => $record->company]))
                                            ->openUrlInNewTab()
                                            ->badge()
                                    ),
                                Infolists\Components\TextEntry::make('company.cnpj')
                                    ->label('CNPJ:')
                                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $state)),
                                Infolists\Components\TextEntry::make('company.bank')
                                    ->label('Banco:'),
                                Infolists\Components\TextEntry::make('company.agency')
                                    ->label('Agência:'),
                                Infolists\Components\TextEntry::make('company.checking_account')
                                    ->label('Conta Corrente:'),
                            ]),

                        Infolists\Components\Fieldset::make('Cliente')
                            ->columns(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('customer.user.full_name')
                                    ->label('Nome:')
                                    ->formatStateUsing(fn (?Order $record): ?string => $record->customer->user->full_name),
                                Infolists\Components\TextEntry::make('customer.phone')
                                    ->label('Telefone:')
                                    ->formatStateUsing(fn (?Order $record): ?string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $record->customer->phone)),
                                Infolists\Components\TextEntry::make('customer.user.email')
                                    ->label('Email:')
                                    ->formatStateUsing(fn (?Order $record): ?string => $record->customer->user->email),
                                Infolists\Components\TextEntry::make('pagarme.status')
                                    ->label('Status do Pagamento:')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): ?OrderPaymentStatus => OrderPaymentStatus::from($state))
                                    ->icon(fn (?string $state): ?string => OrderPaymentStatus::from($state)->getIcon()),
                                Infolists\Components\TextEntry::make('observation')
                                    ->label('Observações:')
                                    ->columnSpanFull()
                                    ->placeholder('Nenhuma observação'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Endereço')
                    ->icon('heroicon-m-map-pin')
                    ->collapsible()
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('address.cep')
                            ->label('CEP:')
                            ->formatStateUsing(fn (?string $state): ?string => preg_replace('/(\d{5})(\d{3})/', '$1-$2', $state)),
                        Infolists\Components\TextEntry::make('address.street')
                            ->label('Endereço:'),
                        Infolists\Components\TextEntry::make('address.number')
                            ->label('Número:'),
                        Infolists\Components\TextEntry::make('address.complement')
                            ->label('Complemento:'),
                        Infolists\Components\TextEntry::make('address.district')
                            ->label('Bairro:'),
                        Infolists\Components\TextEntry::make('address.city')
                            ->label('Cidade:'),
                        Infolists\Components\TextEntry::make('address.state')
                            ->label('Estado:'),
                    ]),

                Infolists\Components\Section::make('Tipo do Imóvel')
                    ->icon('heroicon-m-home-modern')
                    ->columns(2)
                    ->columnSpan(1)
                    ->schema([
                        Infolists\Components\TextEntry::make('property.type')
                            ->label('Tipo:')
                            ->badge()
                            ->icon(fn (?string $state): ?string => PropertyTypes::tryFrom($state)->getIcon())
                            ->formatStateUsing(fn (?string $state): ?string => PropertyTypes::tryFrom($state)->getLabel() ?? $state),
                        Infolists\Components\TextEntry::make('property.value')
                            ->label('Tamanho:')
                            ->badge()
                            ->color('secondary')
                            ->formatStateUsing(fn (?string $state): ?string => HouseRanges::tryFrom($state) ? HouseRanges::from($state)->getLabel() : "$state Quarto(s)"),
                    ]),

                Infolists\Components\Section::make('Período')
                    ->icon('heroicon-m-sun')
                    ->columns(2)
                    ->columnSpan(1)
                    ->schema([
                        Infolists\Components\TextEntry::make('date')
                            ->label('Data:')
                            ->date('d/m/Y')
                            ->badge(),
                        Infolists\Components\TextEntry::make('period.value')
                            ->label('Período/Horário:')
                            ->badge()
                            ->color('secondary')
                            ->formatStateUsing(fn (?string $state): ?string => ServicePeriods::tryFrom($state) ? ServicePeriods::from($state)->getLabel() : $state),
                    ]),

                Infolists\Components\Section::make('Items')
                    ->icon('heroicon-m-shopping-bag')
                    ->columnSpanFull()
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('items')
                            ->label(false)
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('service_id')
                                    ->label('Item:')
                                    ->formatStateUsing(fn (?string $state): ?string => Service::find($state)->name),
                                Infolists\Components\TextEntry::make('daily_price')
                                    ->prefix('R$ ')
                                    ->label('Valor:')
                                    ->formatStateUsing(fn (?int $state) => number_format($state / 100, 2, ',', '.')),
                            ]),
                    ]),

                Infolists\Components\Section::make('Atualizações')
                    ->icon('heroicon-m-clipboard')
                    ->description('Atualizações sobre o agendamento.')
                    ->columnSpanFull()
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('orderStatusUpdates')
                            ->label(' ')
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->badge(),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Data')
                                    ->dateTime('d/m/Y H:i'),

                                Infolists\Components\TextEntry::make('observation')
                                    ->label('Observações')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->badge(),
                Tables\Columns\TextColumn::make('customer.user.full_name')
                    ->label('Cliente')
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.corporate_name')
                    ->label('Parceiro')
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('items.0.service_id')
                    ->label('Serviço')
                    ->formatStateUsing(fn ($state) => Service::find($state)->name)
                    ->limit(20),
                Tables\Columns\TextColumn::make('period.value')
                    ->label('Período')
                    ->badge()
                    ->color('secondary')
                    ->formatStateUsing(fn (?string $state) => ServicePeriods::tryFrom($state) ? ServicePeriods::from($state)->getLabel() : str($state)->substr(0, 5)),
                Tables\Columns\TextColumn::make('address.street')
                    ->label('Endereço')
                    ->limit(10),
                TotalColumn::make('items')
                    ->jsonField('daily_price')
                    ->label('Valor'),
                Tables\Columns\TextColumn::make('latest_status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('partner_payment_attachment')
                    ->label('Parceiro pago')
                    ->alignCenter()
                    ->icon(fn ($state) => !is_null($state) ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->placeholder('Não'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')->label('De:'),
                        Forms\Components\DatePicker::make('date_until')->label('Até'),
                    ])
                    ->query(
                        fn (Builder $query, array $data): Builder => $query
                            ->when($data['date_from'], fn (Builder $query, string $date): Builder => $query->whereDate('date', '>=', $date))
                            ->when($data['date_until'], fn (Builder $query, string $date): Builder => $query->whereDate('date', '<=', $date))
                    ),

                Tables\Filters\Filter::make('status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status:')
                            ->native(false)
                            ->options(OrderStatus::class),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['status']) {
                            $query->whereHas(
                                'orderStatusUpdates',
                                fn ($query) => $query
                                    ->where('created_at', DB::Raw('(select max(`created_at`) from `order_status_updates` where `orders`.`id` = `order_status_updates`.`order_id`)'))
                                    ->where('status', $data['status'])
                            );

                            if ($data['status'] == OrderStatus::Open->value) {
                                $query->orWhereDoesntHave('orderStatusUpdates');
                            }
                        }

                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(' '),
            ])
            ->bulkActions([])
            ->emptyStateActions([])
            ->groups([
                Tables\Grouping\Group::make('date')
                    ->label('Data')
                    ->getTitleFromRecordUsing(fn (?Order $record): ?string => date('d/m/Y', strtotime($record->date)))
                    ->collapsible(),
            ])
            ->defaultGroup('date');
    }

    private static function getOrderPropertyLabel(string $data): string
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/editar'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
