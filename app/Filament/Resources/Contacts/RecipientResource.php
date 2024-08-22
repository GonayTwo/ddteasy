<?php

namespace App\Filament\Resources\Contacts;

use App\Filament\Resources\Contacts\RecipientResource\Pages;
use App\Models\Contacts\Recipient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RecipientResource extends Resource
{
    protected static ?string $model = Recipient::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?string $recordTitleAttribute = 'email';

    protected static ?string $modelLabel = 'destinatário';

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $slug = 'configuracoes/destinatarios';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\CheckboxList::make('forms')
                    ->label('Formulários')
                    ->required()
                    ->options(\App\Enums\ContactForms::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->badge()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->badge()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRecipients::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
