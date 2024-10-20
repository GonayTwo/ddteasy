<?php

namespace App\Services\Pagarme;

use App\Services\Pagarme\Endpoints\Customers\HasCustomers;
use App\Services\Pagarme\Endpoints\Orders\HasOrders;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Pagar.me API Service
 *
 * @link https://docs.pagar.me/reference
 */
class PagarmeService
{
    use HasCustomers;
    use HasOrders;

    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::baseUrl(env('PAGARME_BASEURL'))
            ->withHeaders(['Accept' => 'application/json'])
            ->withBasicAuth(env('PAGARME_SECRET'), '');
    }

    public function testConnection()
    {
        try {
            $response = $this->api->get('/customers'); // Um endpoint simples de teste

            if ($response->successful()) {
                return $response->json();
            } else {
                return 'Erro: ' . $response->status() . ' - ' . $response->body();
            }
        } catch (\Exception $e) {
            return 'Erro ao conectar: ' . $e->getMessage();
        }
    }
}
