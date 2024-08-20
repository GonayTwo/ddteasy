<?php

namespace App\Services\Pagarme\Entities\Orders\Customers;

use App\Services\Pagarme\Entities\Customers\Customer;

trait HasCustomer
{
    public Customer $customer;

    public string $customer_id;

    public function customer()
    {
        return $this;
    }

    public function byCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function byId(string $customer_id)
    {
        $this->customer_id = $customer_id;
    }
}
