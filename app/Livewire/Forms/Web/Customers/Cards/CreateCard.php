<?php

namespace App\Livewire\Forms\Web\Customers\Cards;

use App\Services\Pagarme\PagarmeService;
use Livewire\Attributes\Rule;
use Livewire\Form;

class CreateCard extends Form
{
    #[Rule(['required', 'min:13', 'max:19'], as: 'número')]
    public ?string $number;

    #[Rule(['required', 'string', 'max:64'], as: 'nome')]
    public ?string $holder_name;

    #[Rule(['required', 'numeric', 'min:1', 'max:12'], as: 'mês de expiração')]
    public ?int $exp_month;

    #[Rule(['required', 'numeric', 'digits:4'], as: 'ano de expiração')]
    public ?int $exp_year;

    #[Rule(['required', 'numeric', 'digits_between:3,4'], as: 'CVV')]
    public ?string $cvv;

    public function store()
    {
        $this->validate();
        $pagarme = new PagarmeService();
        $card_data = $this->all();
        $card_data['number'] = str_replace(' ', '', $card_data['number']);
        $pagarme->customers()->get(auth()->user()->userable->pagarme_id)->cards()->create($card_data);
    }
}
