<?php

namespace App\Livewire\Forms\Web\Components\Profile;

use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdatePassword extends Form
{
    #[Rule(['required', 'max:255'], as: 'senha')]
    public ?string $password;

    #[Rule(['required', 'same:form.password', 'max:255'], as: 'confirmar senha')]
    public ?string $password_confirmation;

    public function update()
    {
        $this->validate();
        auth()->user()->update(['password' => bcrypt($this->password)]);
    }
}
