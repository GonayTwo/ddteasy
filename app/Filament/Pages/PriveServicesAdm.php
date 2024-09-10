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
        return CompanyService::query()->with('company'); // Carrega a relação 'company'
    }

    // Colunas da tabela
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('company.fantasy_name') // Coluna para o prestador de serviço
                ->label('Prestador de Serviço')
                ->sortable()
                ->searchable(),
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
            Tables\Columns\TextColumn::make('daily_price') // Coluna de valor formatado
                ->label('Valor')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn($state) => $this->formatMoneyToBRL($state)),
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
    // protected function getTableActions(): array
    // {
    //     return [
    //         Tables\Actions\ViewAction::make(),
    //         Tables\Actions\EditAction::make(),
    //     ];
    // }

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

    // Função para formatar o dinheiro em Real Brasileiro
    protected function formatMoneyToBRL($value): string
    {
        return 'R$ ' . number_format($value / 100, 2, ',', '.'); // Divide por 100 para centavos
    }
}
