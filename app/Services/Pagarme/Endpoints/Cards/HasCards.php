<?php

namespace App\Services\Pagarme\Endpoints\Cards;

trait HasCards
{
    public function cards()
    {
        return new CardsEndpoint($this->id);
    }
}
