<?php

namespace App\Livewire\Web\Partners;

use App\Livewire\Forms\Web\Partners\FinishRegistrationForm;
use App\Models\Partners\PreRegistration;
use App\Services\FindCep\FindCepService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Finalizar Cadastro')]
class FinishRegistration extends Component
{
    use WithFileUploads;

    public FinishRegistrationForm $form;

    public PreRegistration $pre_registration;

    public ?string $city;

    public ?string $state;

    public ?string $district;

    public ?string $street;

    public function boot()
    {
        $this->withValidator(function ($validator) {
            $validator->after(function ($validator) {

                $cnpj_validator = Validator::make(
                    ['form' => ['cnpj' => preg_replace('/[^0-9]/', '', $this->form->cnpj)]],
                    ['form.cnpj' => 'unique:companies,cnpj']
                );

                if ($cnpj_validator->fails()) {
                    $validator->errors()->add('form.cnpj', 'O CPNJ informado já está sendo utilizado.');
                }

                $password_validation = Validator::make(['password' => $this->form->password], ['password' => Password::defaults()]);

                if ($password_validation->fails()) {
                    $validator->errors()->add('form.password', data_get($password_validation->errors()->toArray(), 'password.0'));
                }
            });
        });
    }

    public function mount(PreRegistration $pre_registration)
    {
        if ($pre_registration->finished) {
            abort(404);
        }

        $this->pre_registration = $pre_registration;

        $name_parts = explode(' ', $pre_registration->name, 2);
        $this->form->fantasy_name = $pre_registration->company;
        $this->form->first_name = data_get($name_parts, 0);
        $this->form->last_name = data_get($name_parts, 1);
        $this->form->email = $pre_registration->email;
        $this->form->phone = $pre_registration->phone;
        $this->form->contact_methods = $pre_registration->contact_methods;
    }

    public function save()
    {
        $this->validate();

        $this->form->store($this->pre_registration);

        $route = route('filament.partner.auth.login');
        $this->js("
            Swal.fire({
                title: 'Sucesso!',
                text: 'Cadastro realizado com sucesso! Você será redirecionado para a tela de login em instantes.',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: false,
            }).then((result) => window.location.href = '$route')
        ");
    }

    #[On('cep-filled')]
    public function searchCep()
    {
        try {
            $clean_cep = str_replace('-', '', $this->form->cep);
            if (strlen($clean_cep) == 8) {
                $address = FindCepService::cep()->get($clean_cep);
                $this->street = $address?->street;
                $this->district = $address?->district;
                $this->city = $address?->city;
                $this->state = $address?->state;
                $this->resetValidation(['street', 'district', 'city', 'state']);
            }
        } catch (\Exception) {
            $this->js("modal('Erro', 'Ops! Não foi possível encontrar o endereço', 'warning')");
        }
    }

    #[On('cep-cleaned')]
    public function cleanAddress()
    {
        collect(['street', 'district', 'city', 'state'])->each(fn ($property) => $this->$property = '');
    }
}
