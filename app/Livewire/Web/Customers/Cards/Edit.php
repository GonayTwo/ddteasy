<?php

namespace App\Livewire\Web\Customers\Cards;

use App\Livewire\Forms\Web\Customers\Cards\UpdateCard;
use App\Services\Pagarme\Entities\Orders\Payments\Helpers\Card;
use App\Services\Pagarme\PagarmeService;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Atualizar Cartão')]
class Edit extends Component
{
    public UpdateCard $form;

    public ?Card $card;

    public string $last_four_digits;

    public function mount(string $card_id)
    {
        $card = auth()->user()->userable->cards->where('id', $card_id)->first();

        if (!$card) {
            abort(404);
        }

        $this->card = $card;
        $this->last_four_digits = $card->last_four_digits;

        $this->form->card_id = $this->card->id;
        $this->form->holder_name = $this->card->holder_name;
        $this->form->exp_month = $this->card->exp_month;
        $this->form->exp_year = $this->card->exp_year;
    }

    public function save()
    {
        $this->form->store();
        $this->js("modal('Sucesso!', 'Cartão atualizado com sucesso! Você será redirecionado em instantes', 'success')");

        return redirect()->route('site.profile.cards.index');
    }

    public function destroy(string $card_id)
    {
        $customer = auth()->user()->userable;

        $card = $customer->cards->where('id', $card_id)->first();
        if (!$card) {
            abort(404);
        }

        $pagarme = new PagarmeService();
        $pagarme->customers()->get(auth()->user()->userable->pagarme_id)->cards()->delete($card->id);

        $this->js("modal('Sucesso!', 'Cartão excluído com sucesso! Você será redirecionado em instantes.', 'success')");

        return redirect()->route('site.profile.cards.index');
    }
}
