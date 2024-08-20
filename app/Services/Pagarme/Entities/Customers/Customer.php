<?php

namespace App\Services\Pagarme\Entities\Customers;

use App\Services\Pagarme\Endpoints\Cards\HasCards;
use App\Services\Pagarme\Entities\Phones\Phones;

class Customer
{
    use HasCards;

    public ?string $id;

    public ?string $name;

    public ?string $email;

    public Phones $phones;

    public ?string $document;

    public ?string $document_type;

    public ?string $type;

    public ?string $gender;

    public Address $address;

    public ?string $delinquent;

    public ?string $code;

    public ?string $created_at;

    public ?string $updated_at;

    public ?string $birthdate;

    public function __construct(mixed $data)
    {
        $this->id = data_get($data, 'id');
        $this->name = data_get($data, 'name');
        $this->email = data_get($data, 'email');
        $this->phones = new Phones(data_get($data, 'phones'));
        $this->document = data_get($data, 'document');
        $this->document_type = data_get($data, 'document_type');
        $this->type = data_get($data, 'type');
        $this->gender = data_get($data, 'gender');
        $this->address = new Address(data_get($data, 'address'));
        $this->delinquent = data_get($data, 'delinquent');
        $this->code = data_get($data, 'code');
        $this->created_at = data_get($data, 'created_at');
        $this->updated_at = data_get($data, 'updated_at');
        $this->birthdate = data_get($data, 'birthdate');
    }
}
