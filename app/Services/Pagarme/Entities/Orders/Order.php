<?php

namespace App\Services\Pagarme\Entities\Orders;

use App\Services\Pagarme\Entities\Orders\Customers\HasCustomer;
use App\Services\Pagarme\Entities\Orders\Payments\HasPayments;
use Illuminate\Support\Collection;

class Order
{
    use HasCustomer;
    use HasPayments;

    public ?string $id;

    public ?string $currency;

    public ?string $status;

    public ?string $code;

    public ?Collection $items;

    public ?bool $closed;

    public ?bool $antifraud_enabled;

    public ?string $created_at;

    public ?string $updated_at;

    public ?string $recurrence_cycle;

    public function __construct(mixed $data = [])
    {
        $this->id = data_get($data, 'id');
        $this->currency = data_get($data, 'currency', 'BRL');
        $this->status = data_get($data, 'status');
        $this->code = data_get($data, 'code');
        $this->items = collect(data_get($data, 'items'));
        $this->closed = data_get($data, 'closed');
        $this->antifraud_enabled = data_get($data, 'antifraud_enabled');
        $this->created_at = data_get($data, 'created_at');
        $this->updated_at = data_get($data, 'updated_at');
        $this->recurrence_cycle = data_get($data, 'recurrence_cycle');
    }
}
