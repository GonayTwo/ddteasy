<?php

namespace App\Livewire\Forms\Web\Partners;

use App\Enums\PartnerRoles;
use App\Models\Address;
use App\Models\Partners\Company;
use App\Models\Partners\Partner;
use App\Models\Partners\PreRegistration;
use App\Models\User;
use App\Notifications\NewCompanyRegister;
use App\Services\FindCep\FindCepService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FinishRegistrationForm extends Form
{
    /* Company */
    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'razão social')]
    public ?string $corporate_name;

    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'nome fantasia')]
    public ?string $fantasy_name;

    #[Rule(['required', 'cnpj'], as: 'CNPJ')]
    public ?string $cnpj = '';

    #[Rule(['required', 'string', 'formato_cep'], as: 'CEP')]
    public ?string $cep = '';

    #[Rule(['required', 'numeric'], as: 'número')]
    public ?string $number;

    #[Rule(['nullable', 'string', 'max:255'], as: 'complemento')]
    public ?string $complement = null;

    #[Rule(['required', 'file', 'mimetypes:application/pdf', 'max:2048'], as: 'contrato social')]
    public $social_contract;

    #[Rule(['required', 'file', 'mimetypes:application/pdf', 'max:2048'], as: 'licença sanitária')]
    public $sanitary_license;

    /* Responsible */
    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'nome')]
    public ?string $first_name;

    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'sobrenome')]
    public ?string $last_name;

    #[Rule(['required', 'email', 'max:255', 'unique:users,email'])]
    public ?string $email;

    #[Rule(['required', 'cpf'], as: 'CPF')]
    public ?string $cpf = '';

    #[Rule(['required', 'celular_com_ddd'], as: 'telefone')]
    public ?string $phone = '';

    #[Rule(['required', 'min:8', 'max:255'], as: 'senha')]
    public ?string $password = '';

    #[Rule(['required', 'same:password', 'min:8', 'max:255'], as: 'confirmar senha')]
    public ?string $password_confirmation;

    #[Rule(['array', 'filled'], as: 'métodos de contato', message: ['contact_methods.*' => 'Selecione ao menos uma preferência de contato.'])]
    public ?array $contact_methods = [];

    #[Rule(['accepted'], message: ['consent.*' => 'Você deve aceitar os Termos de Uso e Política de Privacidade.'])]
    public ?bool $consent;

    public function store(PreRegistration $pre_registration)
    {
        $this->validate();

        DB::transaction(function () use ($pre_registration) {
            $partner = $this->storePartner();

            $company = $this->storeCompany($partner, $this->makeAddress());

            $pre_registration->update(['finished' => true]);
        });

        $this->reset();
    }

    private function makeAddress(): Address
    {
        $cep = str_replace('-', '', $this->cep);
        $address_data = array_merge(
            (array) FindCepService::cep()->get($cep),
            (array) FindCepService::geolocation()->get($cep)->location,
            ['number' => $this->number, 'complement' => $this->complement]
        );
        unset($address_data['status']);

        return Address::factory()->make($address_data);
    }

    private function storePartner(): Partner
    {
        $partner = Partner::make([
            'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            'phone' => preg_replace('/[^0-9]/', '', $this->phone),
            'consent' => $this->consent,
            'role' => PartnerRoles::Responsible,
            'contact_methods' => $this->contact_methods,
        ]);

        $user = User::make([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $partner->save();
        $partner->user()->save($user);

        return $partner;
    }

    private function storeCompany(Partner $partner, Address $address): Company
    {
        $company_data = [
            'corporate_name' => $this->corporate_name,
            'fantasy_name' => $this->fantasy_name,
            'slug' => str()->slug($this->fantasy_name),
            'cnpj' => preg_replace('/[^0-9]/', '', $this->cnpj),
            'social_contract' => $this->social_contract,
            'sanitary_license' => $this->sanitary_license,
        ];
        $company = Company::make($company_data);

        $company->social_contract = $company->social_contract->store('/companies/documents', 'public');
        $company->sanitary_license = $company->sanitary_license->store('/companies/documents', 'public');
        $company->save();

        $company->partners()->save($partner);
        $company->address()->save($address);

        $adms = User::all()->where('userable_type', 'App\Models\Admin\Admin');
        foreach ($adms as $adm) {
            $adm->notify(new NewCompanyRegister($adm->email, $this->fantasy_name));
        }

        return $company;
    }
}
