<?php

namespace App\Livewire\Forms\Web\Components\Profile;

use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdateUser extends Form
{
    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'nome')]
    public ?string $first_name;

    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'sobrenome')]
    public ?string $last_name;

    #[Rule(['required', 'email', 'max:255', 'unique:users'])]
    public ?string $email;

    public function update()
    {
        $this->validate();
        auth()->user()->update($this->all());
    }
}
