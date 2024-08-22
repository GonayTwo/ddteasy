<?php

namespace App\Filament\Partner\Resources\Partners;

use App\Filament\Partner\Resources\Partners\CalendarResource\Pages;
use App\Models\Partners\Calendar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalendarResource extends Resource
{
    protected static ?string $model = Calendar::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $modelLabel = 'dias não operacionais';

    protected static ?string $slug = 'calendario';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->label('Cor')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_at')
                    ->label('Data')
                    ->minDate(now())
                    ->native(false)
                    ->seconds(false)
                    ->required()
                    ->columnSpanFull(),
                // Forms\Components\DateTimePicker::make('end_at')
                //     ->label('Termina em')
                //     ->minDate(now())
                //     ->native(false)
                //     ->seconds(false)
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Cor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->label('Começa em')
                    ->dateTime('d/m/Y')
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('end_at')
                //     ->label('Termina em')
                //     ->dateTime('d/m/Y H:i')
                //     ->badge()
                //     ->alignCenter()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->badge()
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->badge()
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime('d/m/Y H:i')
                    ->badge()
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListCalendars::route('/'),
            'create' => Pages\CreateCalendar::route('/create'),
            'view' => Pages\ViewCalendar::route('/{record}'),
            'edit' => Pages\EditCalendar::route('/{record}/edit'),
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
        return static::getModel()::where('company_id', filament()->getTenant()->id)->count();
    }
}
