<?php

namespace App\Notifications;

use DateTime;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmationOrderCustomer extends Notification
{
    /**
     * Create a new notification instance.
     */
    private $product;

    private $period;

    private $date;

    private $payment;

    public function __construct($order, $period, $date, $payment)
    {
        $this->product = $order['items'][0];
        $this->date = $date;

        $Data = new DateTime($date);
        $this->date = $Data->format('d/m/Y');

        if ($payment == 'credit_card') {
            $this->payment = 'Cartão de credito';
        } else {
            $this->payment = 'Pix';
        }

        switch ($period) {
            case 'afternoon':
                $this->period = 'Tarde';
                break;
            case 'night':
                $this->period = 'Noite';
                break;
            default:
                $this->period = 'Manhã';
                break;
        }
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
            ->subject('Serviço Agendado')
            ->line('Confira abaixo as informações do pedido:')
            ->markdown('vendor.notifications.orderconfirmed', ['descripton' => $this->product['description'], 'amount' => number_format(($this->product['amount'] / 100), 2, ',', '.'), 'date' => $this->date, 'period' => $this->period, 'payment' => $this->payment]);
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
