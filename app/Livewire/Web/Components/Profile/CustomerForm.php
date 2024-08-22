<?php

namespace App\Livewire\Web\Components\Profile;

use App\Livewire\Forms\Web\Components\Profile\UpdateCustomer;
use Livewire\Component;

class CustomerForm extends Component
{
    public UpdateCustomer $form;

    public function mount()
    {
        $customer = auth()->user()->userable;

        $this->form->cpf = $customer->cpf;
        $this->form->birth_date = $customer->birth_date;
        $this->form->phone = $customer->phone;
        $this->form->contact_methods = $customer->contact_methods->toArray();
        $this->form->consent = $customer->consent;
        $this->form->newsletter = $customer->newsletter;
    }

    public function update()
    {
        $this->form->update();
        $this->js("modal('Sucesso!', 'Informações atualizadas com sucesso!', 'success')");
    }
}
