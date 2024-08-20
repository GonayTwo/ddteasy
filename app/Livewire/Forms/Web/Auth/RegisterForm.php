<?php

namespace App\Livewire\Forms\Web\Auth;

use App\Models\Address;
use App\Models\Customers\Customer;
use App\Services\FindCep\FindCepService;
use App\Services\Pagarme\PagarmeService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Validate(['required', 'string', 'min:3', 'max:255'], as: 'nome')]
    public ?string $first_name;

    #[Validate(['required', 'string', 'min:3', 'max:255'], as: 'sobrenome')]
    public ?string $last_name;

    #[Validate(['required', 'email', 'max:255', 'unique:users,email'])]
    public ?string $email;

    #[Validate(['required', 'min:8', 'max:255'], as: 'senha')]
    public ?string $password = '';

    #[Validate(['required', 'same:password', 'min:8', 'max:255'], as: 'confirmar senha')]
    public ?string $password_confirmation;

    #[Validate(['required', 'cpf'], as: 'CPF')]
    public ?string $cpf = '';

    #[Validate(['array', 'filled'], as: 'métodos de contato', message: ['form.contact_methods.*' => 'Selecione ao menos uma preferência de contato.'])]
    public ?array $contact_methods = [];

    #[Validate(['required', 'celular_com_ddd'], as: 'telefone')]
    public ?string $phone = '';

    #[Validate(['required', 'date', 'before:18 years ago'], as: 'data de nascimento', message: ['form.birth_date.before' => 'Você deve ter mais de 18 anos.'])]
    public ?string $birth_date;

    #[Validate(['required', 'formato_cep', 'max:9'], as: 'CEP')]
    public ?string $cep = '';

    #[Validate(['required', 'max:255'], as: 'número')]
    public ?string $number;

    #[Validate(['nullable', 'string', 'max:255'], as: 'complemento')]
    public ?string $complement;

    #[Validate(['accepted'], message: ['form.consent.accepted' => 'Você deve aceitar os Termos de Uso e Política de Privacidade.'])]
    public ?bool $consent;

    #[Validate(['nullable'])]
    public ?bool $newsletter = true;

    public ?array $address;

    public function store(): string
    {
        $this->validate();
        DB::transaction(function () {
            $customer = Customer::create([
                'birth_date' => $this->birth_date,
                'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
                'phone' => preg_replace('/[^0-9]/', '', $this->phone),
                'contact_methods' => $this->contact_methods,
                'consent' => $this->consent,
                'newsletter' => $this->newsletter,
            ]);

            $customer->user()->create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);

            $address = Address::factory()->make($this->address);
            $address->number = $this->number;
            $address->complement = $this->complement ?? null;
            $customer->address()->save($address);

            try {
                $pagarme_service = new PagarmeService();
                $pagarme_customer = $pagarme_service->customers()->create([
                    'name' => "{$customer->user->first_name} {$customer->user->last_name}",
                    'email' => $customer->user->email,
                    'document' => $customer->cpf,
                    'document_type' => 'CPF',
                    'type' => 'individual',
                    'code' => $customer->id,
                    'birthdate' => $customer->birth_date,
                    'phones' => [
                        'mobile_phone' => [
                            'country_code' => '55',
                            'area_code' => substr($customer->phone, 0, 2),
                            'number' => substr($customer->phone, 2),
                        ],
                    ],
                ]);

                $customer->pagarme_id = $pagarme_customer->id;
                $customer->save();
            } catch (\Exception $e) {
                throw new \Exception('user cannot be created', 409);
            }
            $this->reset();

            $intended_route = session()->get('url.intended');
            auth()->login($customer->user);
            session()->put('url.intended', $intended_route);
        });

        return session()->pull('url.intended') ?? route('site.home');
    }

    public function findAddress()
    {
        $address = (array) FindCepService::cep()->get(str_replace('-', '', $this->cep));
        unset($address['id'], $address['status']);
        $this->address = $address;

        $geolocation = FindCepService::geolocation()->get(str_replace('-', '', $this->cep));
        $this->address = array_merge($this->address, (array) $geolocation->location);
    }
}
