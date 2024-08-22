<?php

namespace App\Services\Pagarme\Entities\Phones;

class Phones
{
    public ?Phone $home_phone;

    public ?Phone $mobile_phone;

    public function __construct(mixed $data)
    {
        $this->home_phone = (data_get($data, 'home_phone')) ? new Phone(data_get($data, 'home_phone')) : null;
        $this->mobile_phone = (data_get($data, 'mobile_phone')) ? new Phone(data_get($data, 'mobile_phone')) : null;
    }
}
