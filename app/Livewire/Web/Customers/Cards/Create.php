<?php

namespace App\Livewire\Web\Customers\Cards;

use App\Livewire\Forms\Web\Customers\Cards\CreateCard;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Adicionar Cartão')]
class Create extends Component
{
    public CreateCard $form;

    public function mount()
    {
        $this->form->number = '';
        $this->form->holder_name = '';
        $this->form->exp_month = (int) date('m');
        $this->form->exp_year = (int) date('Y');
        $this->form->cvv = null;
    }

    public function save()
    {
        $this->form->store();
        $this->js("modal('Sucesso!', 'Cartão cadastrado com sucesso! Você será redirecionado em instantes', 'success')");

        return session()->get('scheduling') ? redirect()->route('site.scheduling.checkout') : redirect()->route('site.profile.cards.index');
    }
}
