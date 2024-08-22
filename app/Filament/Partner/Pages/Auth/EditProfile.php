<?php

namespace App\Filament\Partner\Pages\Auth;

use App\Enums\ContactMethods;
use Filament\Actions\Action;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Phpsa\FilamentPasswordReveal\Password;

class EditProfile extends \Filament\Pages\Auth\EditProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.partner.pages.auth.edit-profile';

    protected static string $layout = 'filament.partner.layouts.auth.edit-profile';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Perfil')
                    ->icon('heroicon-m-user-circle')
                    ->schema([
                        Components\FileUpload::make('avatar')
                            ->image()
                            ->imageEditor()
                            ->imageEditorMode(1)
                            ->imageCropAspectRatio('1:1')
                            ->disk('public')
                            ->directory('users/images'),
                        Components\TextInput::make('first_name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Components\TextInput::make('last_name')
                            ->label('Sobrenome')
                            ->required()
                            ->maxLength(255),
                        $this->getEmailFormComponent(),
                        Components\Group::make()
                            ->relationship('userable')
                            ->schema([
                                Components\TextInput::make('phone')
                                    ->label('Telefone')
                                    ->formatStateUsing(fn (string $state): string => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state))
                                    ->dehydrateStateUsing(fn (?string $state): ?string => preg_replace('/[^0-9]/', '', $state))
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                                Components\TextInput::make('cpf')
                                    ->label('CPF')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->formatStateUsing(fn (string $state): string => preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", '$1.$2.$3-$4', $state)),
                                Components\Toggle::make('consent')
                                    ->label('Concordo com os termos de uso'),
                                Components\CheckboxList::make('contact_methods')
                                    ->label('Métodos de contato')
                                    ->options(ContactMethods::class)
                                    ->columns(3),
                            ])->columns(2)->columnSpanFull(),
                    ])->columns(2),

                Components\Section::make('Segurança')
                    ->icon('heroicon-m-lock-closed')
                    ->collapsible()
                    ->collapsed()
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
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
            ]);
    }

    public static function getSlug(): string
    {
        return static::$slug ?? 'perfil';
    }

    public function getDescription()
    {
        return 'Gerencie as suas inforações pessoais.';
    }

    public function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Voltar')
            ->icon('heroicon-o-arrow-left');
    }
}
