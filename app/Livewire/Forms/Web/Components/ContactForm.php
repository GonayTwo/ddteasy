<?php

namespace App\Livewire\Forms\Web\Components;

use App\Models\Contacts\Contact;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ContactForm extends Form
{
    #[Rule(['required', 'string', 'min:3', 'max:255'], as: 'nome')]
    public ?string $name;

    #[Rule(['required', 'email', 'max:255'], as: 'email')]
    public ?string $email;

    #[Rule(['required', 'string', 'celular_com_ddd'], as: 'telefone')]
    public ?string $phone;

    #[Rule(['required', 'string', 'max:255'], as: 'mensagem')]
    public ?string $message;

    public function store()
    {
        $this->validate();

        $contact = Contact::create($this->all());

        return $contact;
    }
}
