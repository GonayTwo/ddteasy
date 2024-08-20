<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\AdminResource\Pages;
use App\Models\Admin\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Phpsa\FilamentPasswordReveal\Password;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $slug = 'configuracoes/admins';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações Pessoais')
                    ->icon('heroicon-m-user-circle')
                    ->relationship('user')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->imageEditor()
                            ->imageEditorMode(1)
                            ->imageCropAspectRatio('1:1')
                            ->disk('public')
                            ->directory('users/images')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('first_name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Sobrenome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        Forms\Components\Section::make('Segurança')
                            ->icon('heroicon-o-lock-closed')
                            ->collapsible(true)
                            ->collapsed(true)
                            ->schema([
                                Password::make('password')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
                                    ->password()
                                    ->rule(RulesPassword::default())
                                    ->autocomplete('new-password')
                                    ->dehydrated(fn ($state): bool => filled($state))
                                    ->dehydrateStateUsing(fn ($state): string => bcrypt($state))
                                    ->live(debounce: 500)
                                    ->same('passwordConfirmation')
                                    ->revealable()
                                    ->copyable()
                                    ->generatable(),
                                Forms\Components\TextInput::make('passwordConfirmation')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
                                    ->password()
                                    ->required()
                                    ->visible(fn (Get $get): bool => filled($get('password')))
                                    ->dehydrated(false),
                            ]),
                    ]),

                Forms\Components\Section::make('Telefone')
                    ->icon('heroicon-m-phone')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 99999-9999')
                            ->formatStateUsing(fn (?string $state): ?string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state))
                            ->dehydrateStateUsing(fn (?string $state): ?string => preg_replace('/[^0-9]/', '', $state))
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('user.avatar')
                    ->label('Avatar')
                    ->defaultImageUrl(fn ($record): string => "https://source.boringavatars.com/beam/120/{$record->user->full_name}?colors=f28a20,4a1d96")
                    ->circular()
                    ->alignCenter()
                    ->size(75),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state))
                    ->copyable(),
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
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
