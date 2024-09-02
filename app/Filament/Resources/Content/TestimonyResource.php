<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\TestimonyResource\Pages;
use App\Models\Content\Testimony;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonyResource extends Resource
{
    protected static ?string $model = Testimony::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $modelLabel = 'depoimento';

    protected static ?string $navigationGroup = 'Institucional';

    protected static ?string $slug = 'depoimentos';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('testimony')
                        ->label('Depoimento')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('image')
                        ->label('Imagem')
                        ->image()
                        ->imageEditor()
                        ->imageEditorMode(1)
                        ->imageCropAspectRatio('1:1')
                        ->default(0),
                    Forms\Components\TextInput::make('sort')
                        ->label('Ordem')
                        ->numeric()
                        ->minValue(0),
                ]),
                Forms\Components\Section::make()
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
                    ])
                    ->columns(3)
                    ->hidden(fn (?Testimony $record) => $record === null),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->paginatedWhileReordering()
            ->reorderRecordsTriggerAction(fn (Action $action) => $action->button())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('testimony')
                    ->label('Depoimento')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagem')
                    ->disk('public')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('sort')
                    ->label('Ordem')
                    ->alignCenter()
                    ->badge()
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTestimonies::route('/'),
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
