<?php

namespace App\Livewire\Web\Components;

use App\Enums\ContactForms;
use App\Livewire\Forms\Web\Components\ContactForm;
use App\Models\Contacts\Recipient;
use App\Notifications\ContactCreated;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Contact extends Component
{
    public ?string $title;

    public ContactForm $form;

    public function mount(string $title)
    {
        $this->title = $title;
    }

    public function save()
    {
        $contact = $this->form->store();
        $recipients = Recipient::all()->filter(fn ($recipient) => in_array(ContactForms::Contact->value, $recipient->forms));

        try {
            Notification::sendNow($recipients, (new ContactCreated($contact)));
        } catch (\Exception) {
            $this->js("modal('Sucesso!', 'Contato realizado com sucesso! Em breve entraremos em contato com você!', 'success')");
        }

        $this->js("modal('Sucesso!', 'Contato realizado com sucesso! Em breve entraremos em contato com você!', 'success')");
        $this->form->reset();
    }
}
