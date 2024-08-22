<?php

namespace App\Services\FindCep\Entities;

class Coordinates
{
    public string $postal_code;

    public Location $location;

    public bool $status;

    public function __construct(array $data)
    {
        $this->postal_code = data_get($data, 'postal_code');
        $this->location = new Location(data_get($data, 'location'));
        $this->status = data_get($data, 'status');
    }
}
