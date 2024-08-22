<?php

namespace App\Services\Pagarme\Endpoints;

use App\Services\Pagarme\PagarmeService;
use Illuminate\Support\Collection;

abstract class BaseEndpoint
{
    protected PagarmeService $service;

    protected string $endpoint;

    public function __construct()
    {
        $this->service = new PagarmeService();
    }

    protected function transform(mixed $json, string $entity): Collection
    {
        return collect($json)->map(fn ($item) => new $entity($item));
    }
}
