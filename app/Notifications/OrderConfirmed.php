<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $pedidoN;

    private $pedidoId;

    private $slug;

    public function __construct($pedidoN, $pedidoId, $slug)
    {
        $this->pedidoN = $pedidoN;
        $this->pedidoId = $pedidoId;
        $this->slug = $slug;
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
            ->subject('Pedido Confirmado')
            ->line("O pedido Nº $this->pedidoN está em garantia.")
            ->markdown('vendor.notifications.companyorder', ['slug' => $this->slug, 'pedidoId' => $this->pedidoId]);
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
