<?php

namespace App\Services\FindCep\Endpoints\Cep;

use App\Services\FindCep\Endpoints\BaseEndpoint;
use App\Services\FindCep\Entities\Address;
use Exception;

class Cep extends BaseEndpoint
{
    public function get(string $cep): Address
    {
        try {
            return new Address($this->service->api->get("/cep/{$cep}.json")->json());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
