<?php

namespace App\Filament\Resources\Contacts;

use App\Enums\ContactStatus;
use App\Filament\Resources\Contacts\ContactResource\Pages;
use App\Models\Contacts\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $modelLabel = 'contato';

    protected static ?string $navigationGroup = 'Contatos';

    protected static ?string $slug = 'contatos';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 3,
                'lg' => null,
            ])
            ->schema([
                Forms\Components\Group::make()
                    ->columnSpan(['lg' => fn (?Contact $record) => $record === null ? 3 : 2])
                    ->schema([
                        Forms\Components\Section::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\Placeholder::make('name')
                                    ->label('Nome:')
                                    ->content(fn (Contact $record): string => $record->name),
                                Forms\Components\Placeholder::make('email')
                                    ->label('Email:')
                                    ->content(fn (Contact $record): string => $record->email),
                                Forms\Components\Placeholder::make('phone')
                                    ->label('Telefone:')
                                    ->content(fn (Contact $record): string => $record->phone),
                                Forms\Components\Select::make('status')
                                    ->label('Status:')
                                    ->native(false)
                                    ->options(ContactStatus::class),
                                Forms\Components\Placeholder::make('message')
                                    ->label('Mensagem:')
                                    ->content(fn (Contact $record): string => $record->message),
                            ]),
                    ]),

                Forms\Components\Section::make()
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Contact $record) => $record === null)
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Criado em:')
                            ->content(fn ($record): string => $record?->created_at ? $record->created_at->format('d/m/Y H:i:s') : 'Nunca'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Atualizado em:')
                            ->content(fn ($record): string => $record?->updated_at ? $record->updated_at->format('d/m/Y H:i:s') : 'Nunca'),
                        Forms\Components\Placeholder::make('deleted_at')
                            ->label('Excluído em:')
                            ->content(fn ($record): string => $record?->deleted_at ? $record->deleted_at->format('d/m/Y H:i:s') : 'Nunca'),
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
                    ->columnSpan(['lg' => fn (?Contact $record) => $record === null ? 3 : 2])
                    ->schema([
                        Infolists\Components\Section::make()
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nome:'),
                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email:')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Telefone:')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status:')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('message')
                                    ->label('Mensagem:'),
                            ]),
                    ]),

                Infolists\Components\Section::make()
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Contact $record) => $record === null)
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Criado em:')
                            ->formatStateUsing(fn (Contact $record): string => $record?->created_at->format('d/m/Y H:i:s'))
                            ->placeholder('Nunca'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Atualizado em:')
                            ->formatStateUsing(fn (Contact $record): string => $record?->updated_at->format('d/m/Y H:i:s'))
                            ->placeholder('Nunca'),
                        Infolists\Components\TextEntry::make('deleted_at')
                            ->label('Excluído em:')
                            ->formatStateUsing(fn (Contact $record): string => $record?->deleted_at->format('d/m/Y H:i:s'))
                            ->placeholder('Nunca'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderByDesc('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Mensagem')
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
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
