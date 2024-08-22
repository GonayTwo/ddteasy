<?php

namespace App\Livewire\Web\Auth;

use App\Livewire\Forms\Web\Auth\ForgotPasswordForm;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Esqueci Minha Senha')]
class ForgotPassword extends Component
{
    public ForgotPasswordForm $form;

    public function save()
    {
        $this->form->store();
        $this->js("modal('Sucesso!', 'Se o email informado estiver correto, você receberá uma mensagem de recuperação de senha nele.', 'success')");
    }
}
