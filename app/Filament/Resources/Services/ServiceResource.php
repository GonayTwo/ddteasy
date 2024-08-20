<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\ServiceResource\Pages;
use App\Filament\Resources\Services\ServiceResource\RelationManagers;
use App\Models\Services\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $modelLabel = 'serviço';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Serviços';

    protected static ?string $slug = 'servicos';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 3,
                'lg' => null,
            ])
            ->schema([
                Forms\Components\Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->lazy()
                                    ->required()
                                    ->maxLength(255)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->readOnly(),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Descrição')
                                    ->required()
                                    ->maxLength(65535)
                                    ->columnSpanFull()
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'codeBlock',
                                        'link',
                                    ]),
                                Forms\Components\RichEditor::make('observations')
                                    ->label('Observações')
                                    ->maxLength(65535)
                                    ->columnSpanFull()
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'codeBlock',
                                        'link',
                                    ]),
                                Forms\Components\Repeater::make('benefits')
                                    ->label('Benefícios')
                                    ->required()
                                    ->columnSpanFull()
                                    ->simple(
                                        Forms\Components\TextInput::make('benefit')
                                            ->label('Benefício')
                                            ->required()
                                    ),
                            ])->columns(2),
                    ]),

                Forms\Components\Group::make()
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('plagues')
                                    ->label('Pragas')
                                    ->multiple()
                                    ->relationship(name: 'plagues', titleAttribute: 'name')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nome')
                                            ->lazy()
                                            ->required()
                                            ->maxLength(255)
                                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->readOnly(),
                                    ]),
                            ]),

                        Forms\Components\Section::make()
                            ->hidden(fn (?Service $record) => $record === null)
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Criado em')
                                    ->content(fn ($record): string => $record?->created_at ? $record->created_at->format('d/m/Y H:i:s') : '-'),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Atualizado em')
                                    ->content(fn ($record): string => $record?->updated_at ? $record->updated_at->format('d/m/Y H:i:s') : '-'),
                                Forms\Components\Placeholder::make('deleted_at')
                                    ->label('Excluído em')
                                    ->content(fn ($record): string => $record?->deleted_at ? $record->deleted_at->format('d/m/Y H:i:s') : '-'),
                            ]),
                    ]),

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns([
                'sm' => 3,
                'lg' => null,
            ])
            ->schema([
                Infolists\Components\Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nome'),
                                Infolists\Components\TextEntry::make('description')
                                    ->label('Descrição')
                                    ->placeholder('N/A'),
                                Infolists\Components\TextEntry::make('observations')
                                    ->label('Observações')
                                    ->placeholder('N/A')
                                    ->html(),
                                Infolists\Components\TextEntry::make('benefits')
                                    ->label('Benefícios')
                                    ->bulleted(),
                            ]),
                    ]),

                Infolists\Components\Group::make()
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('plagues.name')
                                    ->label('Pragas')
                                    ->badge(),
                            ]),

                        Infolists\Components\Section::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Criado em')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->placeholder('Nunca'),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Atualizado em')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->placeholder('Nunca'),
                                Infolists\Components\TextEntry::make('deleted_at')
                                    ->label('Excluído em')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->placeholder('Nunca'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Serviço')
                    ->searchable()
                    ->limit(50)
                    ->description(fn (Service $record): string => substr(strip_tags($record->description), 0, 50) . '...'),
                Tables\Columns\TextColumn::make('plagues.name')
                    ->label('Pragas')
                    ->badge()
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
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PriceRangesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
