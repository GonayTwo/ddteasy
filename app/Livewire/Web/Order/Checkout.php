<?php

namespace App\Livewire\Web\Order;

use App\Enums\HouseRanges;
use App\Enums\PeriodTypes;
use App\Enums\PropertyTypes;
use App\Enums\ServicePeriods;
use App\Livewire\Forms\Web\Order\CheckoutForm;
use App\Models\Partners\CompanyService;
use Livewire\Attributes\Title;
use Livewire\Component;

class Checkout extends Component
{
    public CheckoutForm $form;

    public ?string $address;

    public ?string $date;

    public ?string $period;

    public ?string $property;

    public ?CompanyService $company_service;

    public ?string $qr_code;

    public ?string $qr_code_url;

    public ?string $qr_code_expires_at;

    public function mount()
    {
        $address = session()->get('scheduling.address');
        $cep = preg_replace("/(\d{5})(\d{3})/", '$1-$2', $address?->cep);
        $address_label = "{$address?->street}, {$address?->number}[complement]{$address?->district}, {$address?->city} - {$address?->state} CEP: $cep";
        $this->address = str_replace('[complement]', ($address?->complement) ? ", {$address->complement}, " : ', ', $address_label);

        $this->date = date('d/m/Y', strtotime(session()->get('scheduling.order.date')));

        $period = session()->get('scheduling.order.period');
        $this->period = ($period['type'] == PeriodTypes::Period->value) ? ServicePeriods::tryFrom($period['value'])?->getLabel() : $period['value'];

        $property = session()->get('scheduling.order.property');
        $this->property = ($property['type'] == PropertyTypes::House->value)
            ? PropertyTypes::House->getLabel() . ' - ' . HouseRanges::tryFrom($property['value'])->getLabel()
            : PropertyTypes::Apartament->getLabel() . " - {$property['value']} Quarto(s)";

        $this->company_service = CompanyService::find(session()->get('scheduling.order.items.0.id'));
    }

    #[Title('Checkout')]
    public function render()
    {
        return view('livewire.web.order.checkout');
    }

    public function save()
    {
        $this->form->store();
        $checkout_data = session()->get('scheduling.checkout');

        $this->qr_code = data_get($checkout_data['data'], 'qr_code');
        $this->qr_code_url = data_get($checkout_data['data'], 'qr_code_url');
        $this->qr_code_expires_at = data_get($checkout_data['data'], 'expires_at');
    }
}
