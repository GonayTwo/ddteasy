<?php

namespace App\Livewire\Web\Customers;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Endereço')]
class Address extends Component
{
    public function render()
    {
        return view('livewire.web.customers.address');
    }
}
