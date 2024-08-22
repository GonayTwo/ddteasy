<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCompanyRegister extends Notification
{
    use Queueable;

    private $mail;

    private $company;

    /**
     * Create a new notification instance.
     */
    public function __construct($mail, $company)
    {
        $this->mail = $mail;
        $this->company = $company ?? '';
    }

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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Empresa acabou de finalizar o cadastro.')
            ->greeting("A empresa '$this->company' acabou de finalizar o cadastro.")
            ->markdown('vendor.notifications.newcompanyregister');
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
