<?php

namespace App\Livewire\Web\Customers\Services;

use App\Models\Orders\Order;
use App\Models\Partners\CompanyService;
use Illuminate\Support\Collection;
use Livewire\Component;

class See extends Component
{
    public Order $order;

    public Collection $order_items;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->order_items = collect($order->items)->map(fn ($item) => CompanyService::find($item['id']));
    }

    public function render()
    {
        return view('livewire.web.customers.services.see')->title($this->order->pagarme['code']);
    }
}
