<?php

namespace App\Services\Pagarme\Endpoints\Orders;

use App\Services\Pagarme\Endpoints\BaseEndpoint;
use App\Services\Pagarme\Entities\Orders\Order;

class OrdersEndpoint extends BaseEndpoint
{
    public function __construct()
    {
        parent::__construct();
        $this->endpoint = '/orders';
    }

    /**
     * Return all the orders according to search parameters
     *
     * The search parameters can be:
     * * `code` (string): Order code in the merchant's system
     * * `status` (string): Order status. Possible values: pending, paid, canceled or failed
     * * `customer_id` (string): Customer code
     * * `created_since` (date): Start date of the creation period to be listed
     * * `created_until` (date): End date of the creation period to be listed
     * * `page` (int32): Current page
     * * `size` (int32): Number of items per page
     */
    public function all(array $search_params = [])
    {
        $query_params['code'] = data_get($search_params, 'code');
        $query_params['status'] = data_get($search_params, 'status');
        $query_params['customer_id'] = data_get($search_params, 'customer_id');
        $query_params['created_since'] = data_get($search_params, 'created_since');
        $query_params['created_until'] = data_get($search_params, 'created_until');
        $query_params['page'] = data_get($search_params, 'page', 1);
        $query_params['size'] = data_get($search_params, 'size', 10);

        return $this->transform(data_get($this->service->api->get($this->endpoint, $query_params)->json(), 'data'), Order::class);
    }

    public function get(?string $order_id = null)
    {
        return $this->service->api->get("{$this->endpoint}/{$order_id}")->json();
    }

    public function create(Order $order)
    {
        return $this->service->api->post($this->endpoint, (array) $order)->json();
    }
}
