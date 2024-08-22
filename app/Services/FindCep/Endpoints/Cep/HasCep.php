<?php

namespace App\Services\FindCep\Endpoints\Cep;

trait HasCep
{
    public static function cep()
    {
        return new Cep();
    }
}
