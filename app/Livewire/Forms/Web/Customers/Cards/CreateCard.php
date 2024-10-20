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

        $card_data = [
            'number' => str_replace(' ', '', $this->number),
            'holder_name' => $this->holder_name,
            'exp_month' => $this->exp_month,
            'exp_year' => $this->exp_year,
            'cvv' => $this->cvv
        ];

        try {
            // Fazendo a requisição para criar o cartão no Pagar.me
            $response = $pagarme->customers()->get(auth()->user()->userable->pagarme_id)->cards()->create($card_data);

            return $response; // Retorna a resposta da API para ser tratada em outro lugar
        } catch (\Exception $e) {
            // Retorna a exceção para ser tratada no método save()
            return null;
        }
    }
}
