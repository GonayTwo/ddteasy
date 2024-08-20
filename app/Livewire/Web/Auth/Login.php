<?php

namespace App\Livewire\Web\Auth;

use App\Livewire\Forms\Web\Auth\LoginForm;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    public LoginForm $form;

    public function save()
    {
        $this->form->store();
    }
}
