<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Methods\Pix;

use App\Services\Pagarme\Entities\Orders\Payments\Payment;

trait HasPix
{
    public ?Pix $pix;

    /**
     * Set pix to the orders payment
     *
     * @param  int  $expires_in  Pix expiration date in seconds. Default: 30 minutes
     * @param  string|null  $expires_at  Pix expiration date. (Optional | Mandatory if expires_in is not sent) [Format: YYYY-MM-DDThh:mm:ss] UTC
     */
    public function pix(int $expires_in = 1800, ?string $expires_at = null): void
    {
        $payment = new Payment($this->items->sum('amount'));
        $payment->payment_method = 'pix';
        $payment->pix = new Pix(['expires_in' => $expires_in, 'expires_at' => $expires_at]);
        $this->payments[] = $payment;
    }
}
