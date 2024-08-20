<?php

namespace App\Filament\Resources\Services\ServiceResource\RelationManagers;

use App\Enums\ApartmentRooms;
use App\Enums\HouseRanges;
use App\Enums\PropertyTypes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Money;

class PriceRangesRelationManager extends RelationManager
{
    protected static string $relationship = 'priceRanges';

    protected static ?string $title = 'Preços';

    protected static ?string $modelLabel = 'range de preço';

    protected static ?string $pluralModelLabel = 'ranges de preços';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('property_type')
                    ->label('Tipo do Imóvel')
                    ->required()
                    ->live()
                    ->native(false)
                    ->options(PropertyTypes::class),

                Forms\Components\ToggleButtons::make('property_size')
                    ->label('Tamanho do Imóvel')
                    ->required()
                    ->inline()
                    ->hidden(fn (Get $get) => !$get('property_type'))
                    ->options(fn (Get $get) => $get('property_type') === PropertyTypes::House->value ? HouseRanges::class : ApartmentRooms::class)
                    ->disableOptionWhen(
                        fn (RelationManager $livewire, Get $get, string $value) => $livewire->getOwnerRecord()
                            ->priceRanges()
                            ->where('property_type', $get('property_type'))
                            ->where('property_size', $value)
                            ->first() != null
                    ),

                Forms\Components\Split::make([
                    Money::make('min_price')
                        ->label('Preço Mínimo')
                        ->required()
                        ->formatStateUsing(fn (?int $state) => number_format($state / 100, 2, ',', '.'))
                        ->dehydrateStateUsing(fn (?string $state): ?int => str($state)->replace(['.', ','], '')->toInteger()),
                    Money::make('max_price')
                        ->label('Preço Máximo')
                        ->required()
                        ->formatStateUsing(fn (?int $state) => number_format($state / 100, 2, ',', '.'))
                        ->dehydrateStateUsing(fn (?string $state): ?int => str($state)->replace(['.', ','], '')->toInteger()),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('property_type')
            ->columns([
                Tables\Columns\TextColumn::make('property_type')
                    ->label('Tipo do imóvel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_size')
                    ->label('Tamanho do imóvel')
                    ->formatStateUsing(fn ($record, $state) => $this->getPropertySizeLabel($record, $state))
                    ->searchable(),
                \App\Tables\Columns\MoneyColumn::make('min_price')
                    ->label('Preço mínimo')
                    ->sortable()
                    ->searchable(),
                \App\Tables\Columns\MoneyColumn::make('max_price')
                    ->label('Preço máximo')
                    ->sortable()
                    ->searchable(),
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
                Tables\Filters\SelectFilter::make('property_type')
                    ->label('Tipo do Imóvel')
                    ->options(PropertyTypes::class)
                    ->native(false),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getPropertySizeLabel($record, $state)
    {
        return ($record->property_type == PropertyTypes::House ? HouseRanges::tryFrom($state) : ApartmentRooms::tryFrom($state))->getLabel();
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->priceRanges()->count();
    }
}
