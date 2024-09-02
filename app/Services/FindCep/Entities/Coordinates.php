<?php

namespace App\Services\FindCep\Entities;

use Illuminate\Support\Facades\Log;

class Coordinates
{
    public string $postal_code;

    public Location $location;

    public bool $status;

    public function __construct(array $data)
    {
        Log::info("Criando entidade de coordenadas");
        Log::info(print_r($data, true));
        $this->postal_code = data_get($data, 'postal_code');
        $this->location = new Location(data_get($data, 'location'));
        $this->status = data_get($data, 'status');
    }
}
