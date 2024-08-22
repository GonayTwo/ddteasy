<?php

namespace App\Livewire\Forms\Web\Partners;

use App\Models\Partners\PreRegistration;
use Livewire\Attributes\Rule;
use Livewire\Form;

class PreRegistrationForm extends Form
{
    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'nome')]
    public ?string $name;

    #[Rule(['required', 'email', 'max:255', 'unique:users,email'], as: 'email')]
    public ?string $email;

    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'empresa')]
    public ?string $company;

    #[Rule(['required', 'string', 'celular_com_ddd'], as: 'telefone')]
    public ?string $phone = '';

    #[Rule(['required', 'filled'], as: 'métodos de contato', message: ['filled' => 'Selecione ao menos um dos :attribute'])]
    public ?array $contact_methods = [];

    public function store(): PreRegistration
    {
        $this->validate();

        $data = $this->all();
        $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);

        return PreRegistration::create($data);
    }
}
