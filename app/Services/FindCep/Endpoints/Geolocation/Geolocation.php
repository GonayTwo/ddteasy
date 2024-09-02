<?php

namespace App\Services\FindCep\Endpoints\Geolocation;

use App\Services\FindCep\Endpoints\BaseEndpoint;
use App\Services\FindCep\Entities\Coordinates;
use App\Services\FindCep\Entities\Address;
use Illuminate\Support\Facades\Log;
use Exception;

class Geolocation extends BaseEndpoint
{
    public function get(string $cep): Coordinates
    {
        try {
            return new Coordinates($this->service->api->get("/geolocation/cep/{$cep}")->json());
        } catch (Exception $e) {
            return new Address([]);
        }
    }
}
