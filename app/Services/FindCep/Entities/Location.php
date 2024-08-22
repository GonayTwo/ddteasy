<?php

namespace App\Services\FindCep\Entities;

class Location
{
    public float $lat;

    public float $lon;

    public function __construct(array $data)
    {
        $this->lat = data_get($data, 'lat');
        $this->lon = data_get($data, 'lon');
    }
}
