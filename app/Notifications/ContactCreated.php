<?php

namespace App\Notifications;

use App\Filament\Resources\Contacts\ContactResource;
use App\Models\Contacts\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Contact $contact) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->replyTo($this->contact->email, $this->contact->name)
            ->subject('Novo Contato - ' . $this->contact->name)
            ->line('Você tem um novo contato no site.')
            ->line('Nome: ' . $this->contact->name)
            ->line('Email: ' . $this->contact->email)
            ->line('Telefone: ' . $this->contact->phone)
            ->line('Mensagem: ' . $this->contact->message)
            ->action('Ver no sistema', ContactResource::getUrl('view', ['record' => $this->contact]))
            ->salutation(' ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
