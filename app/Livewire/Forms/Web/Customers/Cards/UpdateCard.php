<?php

namespace App\Livewire\Forms\Web\Customers\Cards;

use App\Services\Pagarme\Entities\Orders\Payments\Helpers\Card;
use App\Services\Pagarme\PagarmeService;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdateCard extends Form
{
    #[Rule(['required'])]
    public ?string $card_id;

    #[Rule(['required', 'string', 'max:64'], as: 'nome')]
    public ?string $holder_name;

    #[Rule(['required', 'numeric', 'min:1', 'max:12'], as: 'mês de expiração')]
    public ?int $exp_month;

    #[Rule(['required', 'numeric', 'digits:4'], as: 'ano de expiração')]
    public ?int $exp_year;

    public function store()
    {
        $this->validate();

        $pagarme = new PagarmeService();

        $pagarme->customers()->get(auth()->user()->userable->pagarme_id)->cards()->update($this->card_id, new Card($this->except('card_id')));
    }
}
