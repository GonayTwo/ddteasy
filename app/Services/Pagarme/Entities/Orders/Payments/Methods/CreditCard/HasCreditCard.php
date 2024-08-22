<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Methods\CreditCard;

use App\Services\Pagarme\Entities\Orders\Payments\Payment;

trait HasCreditCard
{
    public ?CreditCard $credit_card;

    public function credit_card(string $card_id): void
    {
        $payment = new Payment($this->items->sum('amount'));
        $payment->payment_method = 'credit_card';
        $payment->credit_card = CreditCard::makeByCardId($card_id);
        $this->payments[] = $payment;
    }
}
