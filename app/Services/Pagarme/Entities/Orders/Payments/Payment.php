<?php

namespace App\Services\Pagarme\Entities\Orders\Payments;

class Payment
{
    public string $payment_method;

    public int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function __set($attribute, $value)
    {
        $this->{$attribute} = $value;
    }

    public function __get($attribute)
    {
        return $this->{$attribute};
    }
}
