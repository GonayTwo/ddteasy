<?php

namespace App\Services\Pagarme\Entities\Orders;

use App\Models\Partners\CompanyService;

class Item
{
    public ?string $id;

    public int $amount;

    public string $description;

    public int $quantity;

    public string $code;

    public ?string $category;

    public ?string $status;

    public ?string $created_at;

    public ?string $updated_at;

    public ?string $datetime;

    public function __construct(array $data)
    {
        $this->id = data_get($data, 'id');
        $this->amount = data_get($data, 'amount');
        $this->description = data_get($data, 'description');
        $this->quantity = data_get($data, 'quantity');
        $this->code = data_get($data, 'code');
        $this->category = data_get($data, 'category');
        $this->status = data_get($data, 'status');
        $this->created_at = data_get($data, 'created_at');
        $this->updated_at = data_get($data, 'updated_at');
        $this->datetime = data_get($data, 'datetime');
    }

    public static function make(string $code, int $amount, string $description, int $quantity): self
    {
        return new self(['code' => $code, 'amount' => $amount, 'description' => $description, 'quantity' => $quantity]);
    }

    public static function fromCompanyService(CompanyService $company_service): self
    {
        return new self(['code' => $company_service->id, 'amount' => $company_service->daily_price, 'description' => $company_service->service->name, 'quantity' => 1]);
    }
}
