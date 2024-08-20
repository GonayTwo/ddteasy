<?php

namespace App\Services\Pagarme\Endpoints\Orders;

trait HasOrders
{
    public function orders()
    {
        return new OrdersEndpoint();
    }
}
