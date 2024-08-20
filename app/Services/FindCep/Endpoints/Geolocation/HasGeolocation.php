<?php

namespace App\Services\FindCep\Endpoints\Geolocation;

trait HasGeolocation
{
    public static function geolocation()
    {
        return new Geolocation();
    }
}
