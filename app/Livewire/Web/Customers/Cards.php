<?php

namespace App\Livewire\Web\Customers;

use App\Livewire\Forms\Web\Customers\CardsForm;
use App\Services\Pagarme\PagarmeService;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cartões')]
class Cards extends Component
{
    public ?string $pagarme_id;

    public ?CardsForm $form;

    public ?Collection $cards;

    public function mount()
    {
        $pagarme = new PagarmeService();

        $this->pagarme_id = auth()->user()->userable->pagarme_id;
        $this->cards = $pagarme->customers()->get($this->pagarme_id)->cards()->all();
    }
}
