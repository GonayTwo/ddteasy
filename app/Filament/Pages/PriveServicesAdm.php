<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable; // Trait para tabelas
use App\Models\Partners\CompanyService;
use App\Enums\PropertyTypes;
use App\Enums\ApartmentRooms;
use App\Enums\HouseRanges;

class PriveServicesAdm extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable; // Usando o trait para tabelas

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.prive-services-adm';
    protected static ?string $navigationLabel = 'Serviços';

    // Query para buscar os serviços
    protected function getTableQuery()
    {
        // Aqui você pode ajustar a query para trazer apenas os serviços de uma empresa específica
        return CompanyService::query();
    }

    // Colunas da tabela
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('service.name')
                ->label('Serviço')
                ->searchable(),
            Tables\Columns\TextColumn::make('property_type')
                ->label('Tipo do imóvel')
                ->searchable(),
            Tables\Columns\TextColumn::make('property_size')
                ->label('Tamanho do imóvel')
                ->formatStateUsing(fn($record, $state) => $this->getPropertySizeLabel($record, $state))
                ->searchable(),
            Tables\Columns\TextColumn::make('daily_price')
                ->label('Valor')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime('d/m/Y H:i:s')
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Atualizado em')
                ->dateTime('d/m/Y H:i:s')
                ->sortable(),
        ];
    }

    // Ações da tabela
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ];
    }

    // Filtros da tabela
    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('property_type')
                ->label('Tipo do Imóvel')
                ->options(PropertyTypes::class),
        ];
    }

    // Formatação do tamanho do imóvel
    protected function getPropertySizeLabel($record, $state)
    {
        return ($record->property_type == PropertyTypes::House ? HouseRanges::tryFrom($state) : ApartmentRooms::tryFrom($state))->getLabel();
    }
}
