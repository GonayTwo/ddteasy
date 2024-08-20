<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\PreRegistrationResource\Pages;
use App\Models\Partners\PreRegistration;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PreRegistrationResource extends Resource
{
    protected static ?string $model = PreRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $modelLabel = 'Pré-Cadastro';

    protected static ?string $navigationGroup = 'Parceiros';

    protected static ?string $slug = 'pre-cadastros';

    protected static ?int $navigationSort = 0;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make('Informações')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nome:'),
                                Infolists\Components\TextEntry::make('company')
                                    ->label('Empresa:'),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Telefone:')
                                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email:'),
                                Infolists\Components\TextEntry::make('contact_methods')
                                    ->label('Formas de Contato:')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('finished')
                                    ->label('Finalizado:')
                                    ->badge()
                                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                            ])->columns(2),
                    ])->columnSpan(2),

                Infolists\Components\Section::make('Datas e horas')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Criado em:')
                            ->dateTime('d/m/Y H:i:s')
                            ->placeholder('Nunca'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Atualizado em:')
                            ->dateTime('d/m/Y H:i:s')
                            ->placeholder('Nunca'),
                        Infolists\Components\TextEntry::make('deleted_at')
                            ->label('Excluído em:')
                            ->dateTime('d/m/Y H:i:s')
                            ->placeholder('Nunca'),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')->label('Empresa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copiado')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Telefone copiado')
                    ->copyMessageDuration(1500)
                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state)),
                Tables\Columns\TextColumn::make('contact_methods')->label('Contato')
                    ->badge(),
                Tables\Columns\IconColumn::make('finished')
                    ->label('Finalizado')
                    ->alignCenter()
                    ->icon(fn (bool $state): string => ($state) ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn (bool $state): string => ($state) ? 'success' : 'danger'),
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->icon('heroicon-o-arrow-down-tray')
                        ->label('Exportar'),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPreRegistrations::route('/'),
            'view' => Pages\ViewPreRegistration::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
