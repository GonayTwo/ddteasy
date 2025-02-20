<?php

namespace App\Filament\Partner\Pages\Tenancy;

use App\Models\Address;
use App\Models\Partners\Company;
use App\Services\FindCep\FindCepService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Leandrocfe\FilamentPtbrFormFields\Document;

class RegisterCompany extends RegisterTenant
{
    protected static string $view = 'filament.partner.pages.tenancy.register-company';

    protected static string $layout = 'filament.partner.layouts.tenancy.register-company-layout';

    public static function getLabel(): string
    {
        return 'Cadastrar nova empresa';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Empresa')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Forms\Components\TextInput::make('fantasy_name')
                            ->label('Nome Fantasia')
                            ->required()
                            ->unique()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('corporate_name')
                            ->label('Razão Social')
                            ->unique()
                            ->required()
                            ->maxLength(255),
                        Document::make('cnpj')
                            ->label('CNPJ')
                            ->cnpj()
                            ->required()
                            ->unique()
                            ->dehydrateStateUsing(fn (?string $state): ?string => str($state)->replace(['.', '-', '/'], '')),
                        Forms\Components\Group::make([
                            // Forms\Components\FileUpload::make('social_contract')
                            //     ->label('Contrato Social')
                            //     ->required()
                            //     ->disk('public')
                            //     ->directory('companies/documents')
                            //     ->acceptedFileTypes(['application/pdf']),
                            Forms\Components\FileUpload::make('sanitary_license')
                                ->label('Licença Sanitária')
                                ->required()
                                ->disk('public')
                                ->directory('companies/documents')
                                ->acceptedFileTypes(['application/pdf']),

                        ])->columns(2)->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Endereço')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\Group::make([
                            Forms\Components\TextInput::make('address.cep')
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

                                            $set('address.street', $addressData->street);
                                            $set('address.district', $addressData->district);
                                            $set('address.city', $addressData->city);
                                            $set('address.state', $addressData->state);
                                        })
                                ),
                            Forms\Components\TextInput::make('address.street')
                                ->label('Endereço')
                                ->disabled()
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('address.number')
                                ->label('Número')
                                ->required(),
                            Forms\Components\TextInput::make('address.complement')
                                ->label('Complemento'),
                        ])->columns(5),
                        Forms\Components\Group::make([
                            Forms\Components\TextInput::make('address.district')
                                ->label('Bairro')
                                ->disabled(),
                            Forms\Components\TextInput::make('address.city')
                                ->label('Cidade')
                                ->disabled(),
                            Forms\Components\TextInput::make('address.state')
                                ->label('Estado')
                                ->disabled(),
                        ])->columns(3),
                    ]),
            ]);
    }

    protected function handleRegistration(array $data): Company
    {
        $data = collect($data);
        $companyData = $data->except('address');
        $companyData['slug'] = str($companyData['fantasy_name'])->slug();

        try {
            $addressData = collect($data->only('address')->first());

            $cep = $addressData['cep'];
            $addressData = $addressData->union((array) FindCepService::cep()->get($cep));
            $addressData = $addressData->merge((array) FindCepService::geolocation()->get($cep)->location);

            $address = Address::factory()->make($addressData->except('status')->toArray());
        } catch (\Exception) {
            Notification::make()->title('Erro!')->body('Erro ao cadastrar a empresa.')->color('danger')->danger()->send();
        }

        $company = Company::create($companyData->toArray());

        $company->partners()->attach(auth()->user()->userable);
        $company->address()->save($address);

        return $company;
    }

    public function backAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('back')
            ->link()
            ->label(ucfirst(__('filament-panels::pages/auth/edit-profile.actions.cancel.label')))
            ->icon(match (__('filament-panels::layout.direction')) {
                'rtl' => 'heroicon-m-arrow-right',
                default => 'heroicon-m-arrow-left',
            })
            ->url(filament()->getUrl());
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function getRegisterFormAction(): \Filament\Actions\Action
    {
        return parent::getRegisterFormAction()
            ->label('Cadastrar');
    }
}
