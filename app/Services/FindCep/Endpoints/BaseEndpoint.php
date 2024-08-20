<?php

namespace App\Services\FindCep\Endpoints;

use App\Services\FindCep\FindCepService;

abstract class BaseEndpoint
{
    protected FindCepService $service;

    public function __construct()
    {
        $this->service = new FindCepService();
    }
}
