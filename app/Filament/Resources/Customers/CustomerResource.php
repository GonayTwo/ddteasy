<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\CustomerResource\Pages;
use App\Models\Customers\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'cliente';

    protected static ?string $navigationGroup = 'Clientes';

    protected static ?string $slug = 'clientes';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\TextInput::make('pagarme_id')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\TextInput::make('cpf')
                    ->required()
                    ->maxLength(11),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(14),
                Forms\Components\Textarea::make('contact_methods')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('consent')
                    ->required(),
                Forms\Components\Toggle::make('newsletter'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Usuário')
                    ->icon('heroicon-m-identification')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('user.full_name')
                            ->label('Nome'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email'),
                        Infolists\Components\TextEntry::make('cpf')
                            ->label('CPF')
                            ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", '$1.$2.$3-$4', $state)),
                        Infolists\Components\TextEntry::make('birth_date')
                            ->label('Data de Nascimento')
                            ->date('d/m/Y'),
                    ]),
                Infolists\Components\Section::make('Contato')
                    ->icon('heroicon-m-phone')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('pagarme_id')
                            ->label('ID Pagar.me'),
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Telefone')
                            ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                        Infolists\Components\TextEntry::make('consent')
                            ->label('Termos de uso e Política de Privacidade')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Concorda' : 'Discorda')
                            ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->badge(),
                        Infolists\Components\TextEntry::make('newsletter')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Concorda' : 'Discorda')
                            ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->badge(),
                        Infolists\Components\TextEntry::make('contact_methods')
                            ->label('Métodos de Contato'),
                    ]),

                Infolists\Components\Section::make('Endereço')
                    ->icon('heroicon-m-map-pin')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('address.cep')
                            ->label('CEP')
                            ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{5})(\d{3})/", '$1-$2', $state)),
                        Infolists\Components\TextEntry::make('address.street')
                            ->label('Endereço'),
                        Infolists\Components\TextEntry::make('address.number')
                            ->label('Número'),
                        Infolists\Components\TextEntry::make('address.complement')
                            ->label('Complemento'),
                        Infolists\Components\TextEntry::make('address.district')
                            ->label('Bairro'),
                        Infolists\Components\TextEntry::make('address.city')
                            ->label('Cidade'),
                        Infolists\Components\TextEntry::make('address.state')
                            ->label('Estado'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('address.city')
                    ->label('Cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address.state')
                    ->label('UF')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable()
                    ->copyable()
                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                Tables\Columns\IconColumn::make('consent')
                    ->label('Consentimento')
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\IconColumn::make('newsletter')
                    ->label('Newsletter')
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('last_service_date')
                    ->label('Data Último Serviço')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Nunca')
                    ->alignCenter()
                    ->badge()
                    ->color('secondary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(' '),
            ]);
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
            'index' => Pages\ListCustomers::route('/'),
            'view' => Pages\ViewCustomer::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
