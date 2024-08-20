<?php

namespace App\Livewire\Forms\Web\Customers;

use Livewire\Attributes\Rule;
use Livewire\Form;

class CardsForm extends Form
{
    public ?string $card_id;

    #[Rule(['required', 'digits_between:13,19'], as: 'número')]
    public ?string $number;

    #[Rule(['required', 'alpha', 'max:64', 'uppercase'], as: 'nome')]
    public ?string $holder_name;

    #[Rule(['required', 'numeric', 'min:1', 'max:12'], as: 'mês de expiração')]
    public ?int $exp_month;

    #[Rule(['required', 'numeric', 'digits:4'], as: 'ano de expiração')]
    public ?int $exp_year;

    #[Rule(['required', 'numeric', 'digits_between:3,4'], as: 'CVV')]
    public ?int $cvv;
}
