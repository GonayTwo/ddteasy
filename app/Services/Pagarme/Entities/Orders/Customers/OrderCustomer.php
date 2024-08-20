<?php

namespace App\Services\Pagarme\Entities\Orders\Customers;

class OrderCustomer
{
    public function __set($attribute, $value)
    {
        $this->{$attribute} = $value;
    }

    public function __get($attribute)
    {
        return $this->{$attribute};
    }
}
