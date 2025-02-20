<?php

namespace App\Filament\Partner\Pages\Tenancy;

use App\Enums\CompanyStatus;
use App\Services\FindCep\FindCepService;
use Filament\Forms\Components;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\EditTenantProfile;
use Leandrocfe\FilamentPtbrFormFields\Document;

class EditCompanyProfile extends EditTenantProfile
{
    protected static string $view = 'filament.partner.pages.tenancy.edit-company-profile';

    public static function getLabel(): string
    {
        return 'Perfil da Empresa';
    }

    public static function getDescription(): string
    {
        return 'Gerencie as informações de sua empresa por aqui';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Empresa')
                    ->description('Informações da empresa')
                    ->icon('heroicon-o-building-office-2')
                    ->aside()
                    ->columns(4)
                    ->schema([
                        Components\Group::make([
                            Components\FileUpload::make('logo')
                                ->label('Logo')
                                ->image()
                                ->imageEditor()
                                ->imageEditorMode(1)
                                ->imageCropAspectRatio('1:1')
                                ->disk('public')
                                ->directory('companies/images'),
                        ])->columnSpan(1),

                        Components\Group::make([
                            Components\TextInput::make('fantasy_name')
                                ->label('Nome Fantasia')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignorable: fn ($record) => $record)
                                ->lazy()
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', str($state)->slug())),
                            Components\TextInput::make('corporate_name')
                                ->label('Razão Social')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignorable: fn ($record) => $record),
                            Document::make('cnpj')
                                ->label('CNPJ')
                                ->cnpj()
                                ->required()
                                ->dehydrateStateUsing(fn (?string $state): ?string => str($state)->replace(['.', '-', '/'], ''))
                                ->unique(ignorable: fn ($record) => $record),
                            Components\TextInput::make('slug')
                                ->label('Url')
                                ->required()
                                ->maxLength(255)
                                ->readOnly()
                                ->required()
                                ->unique(ignorable: fn ($record) => $record),
                        ])->columns(2)->columnSpan(3),
                    ]),

                Components\Section::make('Documentos')
                    ->description('Documentação da empresa')
                    ->icon('heroicon-o-paper-clip')
                    ->aside()
                    ->columns(2)
                    ->schema([
                        // Components\FileUpload::make('social_contract')
                        //     ->label('Contrato Social')
                        //     ->required()
                        //     ->openable()
                        //     ->disk('public')
                        //     ->directory('companies/documents')
                        //     ->acceptedFileTypes(['application/pdf']),
                        Components\FileUpload::make('sanitary_license')
                            ->label('Licença Sanitária')
                            ->required()
                            ->openable()
                            ->disk('public')
                            ->directory('companies/documents')
                            ->acceptedFileTypes(['application/pdf']),
                    ]),

                Components\Section::make('Endereço')
                    ->icon('heroicon-o-map-pin')
                    ->description('Endereço da empresa')
                    ->aside()
                    ->relationship('address')
                    ->columns([
                        'sm' => 1,
                        'md' => 4,
                    ])
                    ->schema([
                        Components\TextInput::make('cep')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->required()
                            ->dehydrateStateUsing(fn (string $state): string => str($state)->remove(['.', '-']))
                            ->suffixAction(
                                fn ($state, Set $set) => Action::make('search-action')
                                    ->icon('heroicon-o-magnifying-glass')
                                    ->action(function () use ($state, $set) {
                                        $state = str($state)->remove(['.', '-']);
                                        if (blank($state)) {
                                            Notification::make()
                                                ->warning()
                                                ->title('Ops!')
                                                ->body('Digite o CEP para buscar o endereço.')
                                                ->color('warning')
                                                ->send();

                                            return;
                                        }

                                        try {
                                            $addressData = FindCepService::cep()->get($state);
                                        } catch (\Exception) {
                                            Notification::make()
                                                ->danger()
                                                ->title('Erro!')
                                                ->body('Erro ao buscar pelo endereço.')
                                                ->color('danger')
                                                ->send();

                                            return;
                                        }

                                        $set('street', $addressData->street);
                                        $set('district', $addressData->district);
                                        $set('city', $addressData->city);
                                        $set('state', $addressData->state);
                                    })
                            ),
                        Components\TextInput::make('street')
                            ->label('Endereço')
                            ->disabled()
                            ->columnSpan([
                                'sm' => 'full',
                                'md' => 2,
                            ]),
                        Components\TextInput::make('number')
                            ->label('Número')
                            ->required()->columnSpan([
                                'sm' => 'full',
                                'md' => 1,
                            ]),
                        Components\TextInput::make('complement')
                            ->label('Complemento'),
                        Components\TextInput::make('district')
                            ->label('Bairro')
                            ->disabled(),
                        Components\TextInput::make('city')
                            ->label('Cidade')
                            ->disabled(),
                        Components\TextInput::make('state')
                            ->label('Estado')
                            ->disabled(),
                    ]),

                Components\Section::make('Informações Gerais')
                    ->description('Informações gerais da empresa')
                    ->icon('heroicon-o-information-circle')
                    ->aside()
                    ->columns(3)
                    ->schema([
                        Components\Placeholder::make('created_at')
                            ->label('Criado em')
                            ->content(fn ($record): string => $record?->created_at ? $record->created_at->format('d/m/Y H:i:s') : '-'),
                        Components\Placeholder::make('updated_at')
                            ->label('Atualizado em')
                            ->content(fn ($record): string => $record?->updated_at ? $record->updated_at->format('d/m/Y H:i:s') : '-'),
                        Components\Placeholder::make('status')
                            ->label('Status')
                            ->content(fn (string $state) => CompanyStatus::from($state)->getLabel()),
                    ]),

                Components\Section::make('Dias de funcionamento')
                    ->description('Dias de atuação da empresa')
                    ->icon('heroicon-o-calendar')
                    ->aside()
                    ->columns(1)
                    ->schema([
                        Components\ToggleButtons::make('work_days')
                            ->label('Dias da Semana')
                            ->multiple()
                            ->options([
                                1 => 'Segunda',
                                2 => 'Terça',
                                3 => 'Quarta',
                                4 => 'Quinta',
                                5 => 'Sexta',
                                6 => 'Sábado',
                                7 => 'Domingo',
                            ])
                            ->inline()
                            ->required(),
                    ]),
                Components\Section::make('Informações Bancárias')
                    ->description('Informações Bancárias para que possamos realizar os pagamentos')
                    ->icon('heroicon-o-credit-card')
                    ->aside()
                    ->columns(3)
                    ->schema([
                        Components\TextInput::make('bank')
                            ->label('Banco')
                            ->required(),
                        Components\TextInput::make('agency')
                            ->label('Agência')
                            ->required(),
                        Components\TextInput::make('checking_account')
                            ->label('Conta Corrente')
                            ->required(),
                    ]),
            ]);
    }
}
