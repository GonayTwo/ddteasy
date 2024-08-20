<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Methods\Pix;

use App\Services\Pagarme\Entities\Orders\Payments\Helpers\AdditionalInformation;
use App\Services\Pagarme\Entities\Orders\Payments\Methods\BasePaymentMethod;

class Pix extends BasePaymentMethod
{
    public int $expires_in;

    public ?string $expires_at;

    public ?AdditionalInformation $additional_information;

    public function __construct(mixed $data)
    {
        $this->expires_in = data_get($data, 'expires_in');
        $this->expires_at = data_get($data, 'expires_at');
        $this->additional_information = data_get($data, 'additional_information');
    }
}
