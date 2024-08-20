<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Helpers;

use Livewire\Wireable;

class Card implements Wireable
{
    public ?string $id;

    public ?string $number;

    public ?string $first_six_digits;

    public ?string $last_four_digits;

    public ?string $holder_name;

    public ?string $holder_document;

    public ?int $exp_month;

    public ?int $exp_year;

    public ?string $cvv;

    public ?string $brand;

    public ?string $label;

    public ?string $billing_address_id;

    public ?BillingAddress $billing_address;

    public function __construct(mixed $data)
    {
        $this->id = data_get($data, 'id');
        $this->number = data_get($data, 'number');
        $this->first_six_digits = data_get($data, 'first_six_digits');
        $this->last_four_digits = data_get($data, 'last_four_digits');
        $this->holder_name = data_get($data, 'holder_name');
        $this->holder_document = data_get($data, 'holder_document');
        $this->exp_month = data_get($data, 'exp_month');
        $this->exp_year = data_get($data, 'exp_year');
        $this->cvv = data_get($data, 'cvv');
        $this->brand = data_get($data, 'brand');
        $this->label = data_get($data, 'label');
        $this->billing_address_id = data_get($data, 'billing_address_id');
        $this->billing_address = (data_get($data, 'billing_address')) ? new BillingAddress(data_get($data, 'billing_address')) : null;
    }

    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'first_six_digits' => $this->first_six_digits,
            'last_four_digits' => $this->last_four_digits,
            'holder_name' => $this->holder_name,
            'holder_document' => $this->holder_document,
            'exp_month' => $this->exp_month,
            'exp_year' => $this->exp_year,
            'cvv' => $this->cvv,
            'brand' => $this->brand,
            'label' => $this->label,
            'billing_address_id' => $this->billing_address_id,
            'billing_address' => $this->billing_address,
        ];
    }

    public static function fromLivewire($data)
    {
        $id = $data['id'];
        $number = $data['number'];
        $first_six_digits = $data['first_six_digits'];
        $last_four_digits = $data['last_four_digits'];
        $holder_name = $data['holder_name'];
        $holder_document = $data['holder_document'];
        $exp_month = $data['exp_month'];
        $exp_year = $data['exp_year'];
        $cvv = $data['cvv'];
        $brand = $data['brand'];
        $label = $data['label'];
        $billing_address_id = $data['billing_address_id'];
        $billing_address = $data['billing_address'];

        return new static($id, $number, $first_six_digits, $last_four_digits, $holder_name, $holder_document, $exp_month, $exp_year, $cvv, $brand, $label, $billing_address_id, $billing_address);
    }
}
