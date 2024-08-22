<?php

namespace App\Services\FindCep\Entities;

class Address
{
    public ?string $complement;

    public ?string $district;

    public ?string $cep;

    public ?string $street;

    public ?string $state;

    public ?string $status;

    public ?string $city;

    public ?string $country = 'BR';

    public function __construct(array $data)
    {
        $this->complement = data_get($data, 'complemento');
        $this->district = data_get($data, 'bairro');
        $this->cep = data_get($data, 'cep');
        $this->street = data_get($data, 'logradouro');
        $this->state = data_get($data, 'uf');
        $this->status = data_get($data, 'status');
        $this->city = data_get($data, 'cidade');
    }
}
