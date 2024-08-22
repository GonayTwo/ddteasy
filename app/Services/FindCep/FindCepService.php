<?php

namespace App\Services\FindCep;

use App\Services\FindCep\Endpoints\Cep\HasCep;
use App\Services\FindCep\Endpoints\Geolocation\HasGeolocation;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * FindCEP API Service
 *
 * @link https://www.findcep.com/docs/index.html#/
 */
class FindCepService
{
    use HasCep;
    use HasGeolocation;

    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::baseUrl(env('FINDCEP_BASEURL'))->withHeaders(['Referer' => env('FINDCEP_REFERER')]);
    }
}
