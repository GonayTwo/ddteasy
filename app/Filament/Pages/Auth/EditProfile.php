<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Phpsa\FilamentPasswordReveal\Password;

class EditProfile extends BaseEditProfile
{
    protected static string $layout = 'filament-panels::components.layout.index';

    protected static string $view = 'filament.pages.auth.edit-profile';

    public static function getSlug(): string
    {
        return static::$slug ?? 'perfil';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Informações Pessoais')
                    ->description('Seus dados de usuário')
                    ->icon('heroicon-o-user-circle')
                    ->aside()
                    ->schema([
                        Components\Group::make([
                            Components\FileUpload::make('avatar')
                                ->image()
                                ->imageEditor()
                                ->imageEditorMode(1)
                                ->imageCropAspectRatio('1:1')
                                ->disk('public')
                                ->directory('users/images')
                                ->columnSpanFull(),
                        ])->columnSpan(1),
                        Components\Group::make([
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
                                        ->required(),
                                ]),
                        ])->columns(2)->columnSpan(3),
                    ])->columns(4),
                Components\Section::make('Segurança')
                    ->description('Seus dados de segurança')
                    ->icon('heroicon-o-lock-closed')
                    ->aside()
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

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Voltar')
            ->icon('heroicon-o-arrow-left');
    }

    public function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction();
    }
}
