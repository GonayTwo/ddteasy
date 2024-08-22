<?php

namespace App\Services\Pagarme\Endpoints\Cards;

use App\Services\Pagarme\Endpoints\BaseEndpoint;
use App\Services\Pagarme\Entities\Orders\Payments\Helpers\Card;
use Illuminate\Support\Collection;

/**
 * Pagar.me API Service - Cards
 *
 * @link https://docs.pagar.me/reference/cartões-1
 */
class CardsEndpoint extends BaseEndpoint
{
    public function __construct(string $customer_id)
    {
        parent::__construct();
        $this->endpoint = "/customers/{$customer_id}/cards";
    }

    /**
     * This resource creates a card associated with the customer through
     * the entered customer_id. This resource creates a card associated
     * with the customer through the entered customer_id.
     *
     * @link https://docs.pagar.me/reference/criar-cartão
     */
    public function create(mixed $data): Card
    {
        return new Card($this->service->api->post($this->endpoint, $data)->json());
    }

    /**
     * Allows the recovery of a card through the identifiers of the
     * card (card_id) and the associated customer (customer_id),
     * informed by parameter.
     *
     * @return \App\Services\Pagarme\Entities\Orders\Payments\Helpers\Card
     *
     * @link https://docs.pagar.me/reference/obter-cartão
     */
    public function get(string $card_id)
    {
        return new Card($this->service->api->get("{$this->endpoint}/{$card_id}")->json());
    }

    /**
     * With the HTTP PUT verb, through the card identifier (card_id)
     * and the identifier of the customer to which it is associated
     * (customer_id), it is possible to change data of the informed card.
     *
     * @link https://docs.pagar.me/reference/editar-cartão
     */
    public function update(string $card_id, Card $card_data): mixed
    {
        return $this->service->api->put("{$this->endpoint}/{$card_id}", (array) $card_data)->json();
    }

    /**
     * With the HTTP DELETE verb, through the card identifier (card_id) and
     * the customer identifier (customer_id) to which the card is associated,
     * it is possible to remove the card from the customer's Wallet.
     */
    public function delete(string $card_id): mixed
    {
        return $this->service->api->delete("{$this->endpoint}/{$card_id}")->json();
    }

    /**
     * Return all the cards of the customer
     */
    public function all(): Collection
    {
        return $this->transform(data_get($this->service->api->get($this->endpoint)->json(), 'data'), Card::class);
    }
}
