<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Helpers;

use Livewire\Wireable;

class BillingAddress implements Wireable
{
    public ?string $line_1;

    public ?string $line_2;

    public ?string $zip_code;

    public ?string $city;

    public ?string $state;

    public ?string $country;

    public function __construct(mixed $data)
    {
        $this->line_1 = data_get($data, 'line_1');
        $this->line_2 = data_get($data, 'line_2');
        $this->zip_code = data_get($data, 'zip_code');
        $this->city = data_get($data, 'city');
        $this->state = data_get($data, 'state');
        $this->country = data_get($data, 'country');
    }

    public function toLivewire()
    {
        return [
            'line_1' => $this->line_1,
            'line_2' => $this->line_2,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }

    public static function fromLivewire($data)
    {
        $line_1 = $data['line_1'];
        $line_2 = $data['line_2'];
        $zip_code = $data['zip_code'];
        $city = $data['city'];
        $state = $data['state'];
        $country = $data['country'];

        return new static($line_1, $line_2, $zip_code, $city, $state, $country);
    }
}
