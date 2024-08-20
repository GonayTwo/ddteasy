<?php

namespace App\Livewire\Web\Auth;

use App\Livewire\Forms\Web\Auth\RegisterForm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cadastro')]
class Register extends Component
{
    public ?RegisterForm $form;

    public ?string $address_preview;

    public function boot()
    {
        $this->withValidator(function ($validator) {
            $validator->after(function ($validator) {

                $cpf_validator = Validator::make(
                    ['form' => ['cpf' => preg_replace('/[^0-9]/', '', $this->form->cpf)]],
                    ['form.cpf' => 'unique:customers,cpf|unique:partners,cpf']
                );

                if ($cpf_validator->fails()) {
                    $validator->errors()->add('form.cpf', 'O CPF informado já está sendo utilizado.');
                }

                $phone_validator = Validator::make(
                    ['phone' => preg_replace('/[^0-9]/', '', $this->form->phone)],
                    ['phone' => [Rule::unique('customers', 'phone'), Rule::unique('partners', 'phone')]]
                );

                if ($phone_validator->fails()) {
                    $validator->errors()->add('form.phone', 'O telefone informado já está sendo utilizado.');
                }

                $password_validation = Validator::make(['password' => $this->form->password], ['password' => Password::defaults()]);

                if ($password_validation->fails()) {
                    $validator->errors()->add('form.password', data_get($password_validation->errors()->toArray(), 'password.0'));
                }
            });
        });
    }

    public function save()
    {
        $this->validate();

        $route = $this->form->store();

        $this->address_preview = null;

        $this->js("
            Swal.fire({
                title: 'Sucesso!',
                text: 'Conta criada com sucesso! Você será redirecionado em instantes!',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: false,
            }).then((result) => window.location.href = '$route');");
    }

    #[On('cep-filled')]
    public function searchCep()
    {
        try {
            $this->form->findAddress();
            $this->address_preview = "{$this->form->address['street']}, {$this->form->address['district']}, {$this->form->address['city']} - {$this->form->address['state']}";
        } catch (\Exception $e) {
            $this->js("modal('Erro', 'Ops! Não foi possível encontrar o endereço', 'warning')");
        }
    }
}
