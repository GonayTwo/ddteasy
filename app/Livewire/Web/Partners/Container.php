<?php

namespace App\Livewire\Web\Partners;

use App\Livewire\Forms\Web\Partners\PreRegistrationForm;
use App\Models\Partners\PreRegistration;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Seja um Parceiro')]
class Container extends Component
{
    public PreRegistrationForm $form;

    public function boot()
    {
        $this->withValidator(fn ($validator) => $validator->after(
            fn ($validator) => Validator::make(
                ['phone' => preg_replace('/[^0-9]/', '', $this->form->phone)],
                ['phone' => ['unique:customers', 'unique:partners']]
            )->passes() ?: $validator->errors()->add('form.phone', 'O telefone informado já está sendo utilizado.')
        ));
    }

    public function save()
    {
        $this->form->validate();

        $existing_pre_registration = PreRegistration::select('id')->where('email', $this->form->email)->first();
        if ($existing_pre_registration) {
            $route = route('site.partners.finish', ['pre_registration' => $existing_pre_registration]);
            $this->js("
                Swal.fire({
                    title: 'Ops!',
                    text: 'Já existe um pré cadastro com esse email. Você será redirecionado em instantes para finalizar seu cadastro.',
                    icon: 'info',
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => window.location.href = '$route')
            ");

            return;
        }

        $pre_registration = $this->form->store();
        $route = route('site.partners.finish', ['pre_registration' => $pre_registration]);
        $this->js("
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Seu pré cadastro foi realizado com sucesso! Você será redirecionado em instantes para finalizar seu cadastro.',
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                }).then((result) => window.location.href = '$route')
                ");

    }
}
