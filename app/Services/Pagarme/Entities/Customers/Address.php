<?php

namespace App\Services\Pagarme\Entities\Customers;

class Address
{
    public ?string $id;

    public ?string $line_1;

    public ?string $line_2;

    public ?int $zip_code;

    public ?string $city;

    public ?string $state;

    public ?string $country;

    public ?string $status;

    public ?string $created_at;

    public ?string $updated_at;

    public ?string $deleted_at;

    public ?Customer $customer;

    public function __construct(mixed $data)
    {
        $this->id = data_get($data, 'id');
        $this->line_1 = data_get($data, 'line_1');
        $this->line_2 = data_get($data, 'line_2');
        $this->zip_code = data_get($data, 'zip_code');
        $this->city = data_get($data, 'city');
        $this->state = data_get($data, 'state');
        $this->country = data_get($data, 'country');
        $this->status = data_get($data, 'status');
        $this->created_at = data_get($data, 'created_at');
        $this->updated_at = data_get($data, 'updated_at');
        $this->deleted_at = data_get($data, 'deleted_at');
        $this->customer = (data_get($data, 'customer')) ? new Customer(data_get($data, 'customer')) : null;
    }
}
