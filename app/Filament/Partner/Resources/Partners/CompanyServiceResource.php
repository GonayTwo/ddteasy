<?php

namespace App\Filament\Partner\Resources\Partners;

use App\Enums\ApartmentRooms;
use App\Enums\HouseRanges;
use App\Enums\PropertyTypes;
use App\Filament\Partner\Resources\Partners\CompanyServiceResource\Pages;
use App\Models\Partners\CompanyService;
use App\Models\Services\Service;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;

class CompanyServiceResource extends Resource
{
    protected static ?string $model = CompanyService::class;

    protected static ?string $navigationIcon = 'heroicon-o-bug-ant';

    public static ?string $modelLabel = 'serviço';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->label('Serviço')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('property_type')
                            ->label('Tipo do Imóvel')
                            ->required()
                            ->live()
                            ->native(false)
                            ->live()
                            ->options(PropertyTypes::class),

                        Forms\Components\ToggleButtons::make('property_size')
                            ->label('Tamanho do Imóvel')
                            ->required()
                            ->inline()
                            ->live()
                            ->hidden(fn(Forms\Get $get) => !$get('property_type'))
                            ->options(fn(Forms\Get $get) => $get('property_type') === PropertyTypes::House->value ? HouseRanges::class : ApartmentRooms::class)
                            ->disableOptionWhen(function (Forms\Get $get, string $value) {
                                return filament()
                                    ->getTenant()
                                    ->companyServices()
                                    ->where('service_id', $get('service_id'))
                                    ->where('property_type', $get('property_type'))
                                    ->where('property_size', $value)
                                    ->first() != null
                                    ||
                                    Service::find($get('service_id'))?->priceRanges()
                                    ->where('property_type', $get('property_type'))
                                    ->where('property_size', $value)
                                    ->first() === null;
                            }),
                        Money::make('daily_price')
                            ->label(fn(Forms\Get $get): string => static::getPriceLabel(Service::find($get('service_id')), $get('property_type'), $get('property_size')))
                            ->required()
                            ->formatStateUsing(fn(?int $state) => number_format($state / 100, 2, ',', '.'))
                            ->dehydrateStateUsing(fn(?string $state): ?int => str($state)->replace(['.', ','], '')->toInteger())
                            ->disabled(
                                fn(Forms\Get $get): bool => Service::find($get('service_id'))?->priceRanges()
                                    ->where('property_type', $get('property_type'))
                                    ->where('property_size', $get('property_size'))
                                    ->first() === null
                            )
                            ->rules([
                                fn(Forms\Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    $service = Service::find($get('service_id'));

                                    $priceRange = $service->priceRanges()
                                        ->where('property_type', $get('property_type'))
                                        ->where('property_size', $get('property_size'))
                                        ->first();

                                    if (is_null($priceRange)) {
                                        $fail('O valor mínimo e máximo desse serviço ainda não está disponível');

                                        return;
                                    }

                                    $minPrice = $priceRange->min_price;

                                    $maxPrice = $priceRange->max_price;

                                    $formatedMinPrice = number_format($minPrice / 100, 2, ',', '.');
                                    $formatedMaxPrice = number_format($maxPrice / 100, 2, ',', '.');
                                    $dehydratedValue = str($value)->replace(['.', ','], '')->toInteger();
                                    if ($dehydratedValue < $minPrice || $dehydratedValue > $maxPrice) {
                                        $fail("Valor mínimo: R$ {$formatedMinPrice}. Valor máximo: R$ {$formatedMaxPrice}");
                                    }
                                },
                            ]),
                    ]),
            ]);
    }

    private static function getPriceLabel(?Service $service, $propertyType, $propertySize): string
    {
        $priceRange = $service?->priceRanges()
            ->where('property_type', $propertyType)
            ->where('property_size', $propertySize)
            ->first();

        $minPrice = $priceRange?->min_price;

        $maxPrice = $priceRange?->max_price;

        $label = 'Preço';

        if ($priceRange) {
            $minPrice = number_format($minPrice / 100, 2, ',', '.');
            $maxPrice = number_format($maxPrice / 100, 2, ',', '.');

            $label = "Preço: Mín: R$ {$minPrice}. Max: R$ {$maxPrice}";
        }

        return $label;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Serviço')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_type')
                    ->label('Tipo do imóvel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_size')
                    ->label('Tamanho do imóvel')
                    ->formatStateUsing(fn($record, $state) => self::getPropertySizeLabel($record, $state))
                    ->searchable(),
                \App\Tables\Columns\MoneyColumn::make('daily_price')
                    ->label('Valor')
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPropertySizeLabel($record, $state)
    {
        return ($record->property_type == PropertyTypes::House ? HouseRanges::tryFrom($state) : ApartmentRooms::tryFrom($state))->getLabel();
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
            'index' => Pages\ListCompanyServices::route('/'),
            'create' => Pages\CreateCompanyService::route('/create'),
            'view' => Pages\ViewCompanyService::route('/{record}'),
            'edit' => Pages\EditCompanyService::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return filament()->getTenant()->companyServices()->count();
    }
}
