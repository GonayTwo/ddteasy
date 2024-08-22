<?php

namespace App\Services\Pagarme\Endpoints\Customers;

use App\Services\Pagarme\Endpoints\BaseEndpoint;
use App\Services\Pagarme\Entities\Customers\Customer;
use Illuminate\Support\Collection;

/**
 * Pagar.me API Service - Customers
 *
 * @link https://docs.pagar.me/reference/clientes-1
 */
class CustomersEndpoint extends BaseEndpoint
{
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = '/customers';
    }

    /**
     * Create an customer to Pagar.me customer wallet
     *
     * @link https://docs.pagar.me/reference/criar-cliente-1
     */
    public function create(mixed $data): Customer
    {
        return new Customer($this->service->api->post($this->endpoint, $data)->json());
    }

    /**
     * Obtain the customer by the Pagar.me customer_id
     *
     * @param  string  $customer_id  Pagar.me customer_id
     *
     * @link https://docs.pagar.me/reference/obter-cliente-1
     */
    public function get(string $customer_id): Customer
    {
        return new Customer($this->service->api->get("{$this->endpoint}/{$customer_id}")->json());
    }

    /**
     * Update an existing Pagar.me customer
     *
     * @param  string  $customer_id  Pagar.me customer_id
     * @param  Customer  $customer_data  Instance of Customer with the data to be updated
     *
     * @link https://docs.pagar.me/reference/editar-cliente-1
     */
    public function update(string $customer_id, Customer $customer_data): mixed
    {
        return $this->service->api->put("{$this->endpoint}/{$customer_id}", (array) $customer_data)->json();
    }

    /**
     * Return all the customers according to search parameters
     *
     * The search params can be:
     * * `name` (string): Customer name
     * * `document` (string): CPF or CNPJ of the customer. Max 16 characters
     * * `email` (string): Customer email
     * * `gender` (string): Customer gender. Possible values: 'male' ou 'female'
     * * `page` (int32): Current page
     * * `size` (int32): Number of items per page
     * * `code` (string): Customer code in the merchant's system
     *
     * @param  array  $search_params  The search params of the search
     *
     * @link https://docs.pagar.me/reference/listar-clientes-1
     */
    public function all(mixed $search_params = []): Collection
    {
        $query_params['name'] = data_get($search_params, 'name');
        $query_params['document'] = data_get($search_params, 'document');
        $query_params['email'] = data_get($search_params, 'email');
        $query_params['gender'] = data_get($search_params, 'gender');
        $query_params['page'] = data_get($search_params, 'page', 1);
        $query_params['size'] = data_get($search_params, 'size', 10);
        $query_params['code'] = data_get($search_params, 'code');

        return $this->transform(data_get($this->service->api->get($this->endpoint, $query_params)->json(), 'data'), Customer::class);
    }
}
