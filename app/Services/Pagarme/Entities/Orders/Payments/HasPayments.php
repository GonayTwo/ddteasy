<?php

namespace App\Services\Pagarme\Entities\Orders\Payments;

use App\Services\Pagarme\Entities\Orders\Payments\Methods\CreditCard\HasCreditCard;
use App\Services\Pagarme\Entities\Orders\Payments\Methods\Pix\HasPix;

trait HasPayments
{
    use HasCreditCard;
    use HasPix;

    public array $payments;

    public function payments()
    {
        return $this;
    }
}
