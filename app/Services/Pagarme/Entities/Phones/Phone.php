<?php

namespace App\Services\Pagarme\Entities\Phones;

class Phone
{
    public ?string $country_code;

    public ?string $area_code;

    public ?string $number;

    public function __construct(mixed $data)
    {
        $this->country_code = data_get($data, 'country_code');
        $this->area_code = data_get($data, 'area_code');
        $this->number = data_get($data, 'number');

    }
}
