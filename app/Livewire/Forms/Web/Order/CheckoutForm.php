<?php

namespace App\Livewire\Forms\Web\Order;

use App\Helpers\OrderHelper;
use App\Models\Partners\Company;
use App\Services\Pagarme;
use App\Services\Pagarme\Enums\OrderPaymentStatus;
use App\Services\Pagarme\Enums\PaymentMethods;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class CheckoutForm extends Form
{
    #[Rule(['required', new Enum(PaymentMethods::class)], as: 'método de pagamento')]
    public string $payment_method = 'pix';

    #[Rule(['nullable', 'required_if:form.payment_method,credit_card', 'string', 'min:3'], as: 'cartão de crédito')]
    public ?string $card = null;

    #[Rule(['accepted'], message: ['form.recomendations.*' => 'Você deve aceitar as Recomendações de Serviço.'])]
    public ?bool $recomendations;

    public function store()
    {
        $this->validate();
        DB::transaction(function () {
            $pagarme_order = OrderHelper::makeOrder(PaymentMethods::tryFrom($this->payment_method), $this?->card);

            $response = (new Pagarme\PagarmeService)->orders()->create($pagarme_order);
            $order = session()->get('scheduling.order');
            $order->pagarme_id = data_get($response, 'id');
            $order->company()->associate(Company::find($order->items[0]['company_id']));
            $order->customer()->associate(auth()->user()->userable);
            $order->payment_method = PaymentMethods::from($this->payment_method);
            $order->recomendations = $this->recomendations;
            $order->payment_status = OrderPaymentStatus::Pending;
            $order->save();

            $order->address()->save(session()->get('scheduling.address')); // Save the address with the correct addressable_id and addressable_type.

            session()->put('scheduling.checkout', ['message' => 'ok', 'data' => OrderHelper::getResponseData(PaymentMethods::tryFrom($this->payment_method), $response)]);
        });
    }
}
