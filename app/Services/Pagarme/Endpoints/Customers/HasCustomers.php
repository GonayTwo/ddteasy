<?php

namespace App\Services\Pagarme\Endpoints\Customers;

trait HasCustomers
{
    public function customers()
    {
        return new CustomersEndpoint();
    }
}
