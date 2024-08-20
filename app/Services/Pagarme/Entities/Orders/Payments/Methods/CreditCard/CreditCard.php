<?php

namespace App\Services\Pagarme\Entities\Orders\Payments\Methods\CreditCard;

use App\Services\Pagarme\Entities\Orders\Payments\Helpers\Card;

class CreditCard
{
    public string $operation_type;

    public int $installments;

    public string $statement_descriptor;

    public ?Card $card;

    public ?string $card_id;

    public ?string $card_token;

    public ?string $recurrence_cycle;

    public function __construct(mixed $data = [])
    {
        $this->operation_type = data_get($data, 'operation_type', 'auth_and_capture');
        $this->installments = data_get($data, 'installments');
        $this->statement_descriptor = data_get($data, 'statement_descriptor', 'DDTEASY');
        $this->card = (data_get($data, 'card')) ? new Card(data_get($data, 'card')) : null;
        $this->card_id = data_get($data, 'card_id');
        $this->card_token = data_get($data, 'card_token');
        $this->recurrence_cycle = data_get($data, 'recurrence_cycle');
    }

    public static function makeByCardId(string $card_id, int $installments = 1): CreditCard
    {
        return new self(['card_id' => $card_id, 'installments' => $installments]);
    }
}
