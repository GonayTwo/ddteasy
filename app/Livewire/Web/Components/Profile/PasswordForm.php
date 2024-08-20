<?php

namespace App\Livewire\Web\Components\Profile;

use App\Livewire\Forms\Web\Components\Profile\UpdatePassword;
use Livewire\Component;

class PasswordForm extends Component
{
    public UpdatePassword $form;

    public function update()
    {
        $this->form->update();
        $this->js("modal('Sucesso!', 'Informações atualizadas com sucesso!', 'success')");
    }
}
