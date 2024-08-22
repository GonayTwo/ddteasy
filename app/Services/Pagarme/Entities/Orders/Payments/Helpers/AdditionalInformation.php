<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Helpers;

class AdditionalInformation
{
    public string $name;

    public string $value;

    public function __construct(mixed $data)
    {
        $this->name = data_get($data, 'name');
        $this->value = data_get($data, 'value');
    }
}
