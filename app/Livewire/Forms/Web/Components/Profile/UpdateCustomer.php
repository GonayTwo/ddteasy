<?php

namespace App\Livewire\Forms\Web\Components\Profile;

use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdateCustomer extends Form
{
    #[Rule(['required', 'cpf'], as: 'CPF')]
    public ?string $cpf;

    #[Rule(['required', 'date', 'before:18 years ago'], as: 'data de nascimento', message: ['*' => 'Você deve ter mais de 18 anos.'])]
    public ?string $birth_date;

    #[Rule(['required', 'celular_com_ddd'], as: 'telefone')]
    public ?string $phone;

    #[Rule(['array', 'filled'], as: 'métodos de contato', message: ['*' => 'Selecione ao menos uma preferência de contato.'])]
    public ?array $contact_methods = [];

    #[Rule(['accepted'], message: ['*' => 'Você deve aceitar os Termos de Uso e Política de Privacidade.'])]
    public ?bool $consent;

    #[Rule(['nullable'])]
    public ?bool $newsletter = true;

    public function update()
    {
        $this->validate();

        $customer_data = $this->all();
        $customer_data['cpf'] = preg_replace('/[^0-9]/', '', $this->cpf);
        $customer_data['phone'] = preg_replace('/[^0-9]/', '', $this->phone);

        auth()->user()->userable->update($customer_data);
    }
}
