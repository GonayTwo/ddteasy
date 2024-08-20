<?php

namespace App\Livewire\Web\Components\Profile;

use App\Livewire\Forms\Web\Components\Profile\UpdateUser;
use Livewire\Component;

class UserForm extends Component
{
    public UpdateUser $form;

    public function mount()
    {
        $user = auth()->user();
        $this->form->first_name = $user->first_name;
        $this->form->last_name = $user->last_name;
        $this->form->email = $user->email;
    }

    public function update()
    {
        $this->form->update();
        $this->js("modal('Sucesso!', 'Informações atualizadas com sucesso!', 'success')");
    }
}
