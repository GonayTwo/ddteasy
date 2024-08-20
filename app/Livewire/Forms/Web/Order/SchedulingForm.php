<?php

namespace App\Livewire\Forms\Web\Order;

use App\Enums\PeriodTypes;
use App\Enums\ServicePeriods;
use App\Helpers\OrderHelper;
use App\Models\Address;
use App\Models\Partners\CompanyService;
use App\Services\FindCep\FindCepService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SchedulingForm extends Form
{
    #[Rule(['required', 'exists:company_services,id'], as: 'parceiro')]
    public ?string $service;

    #[Rule(['required', 'date', 'after_or_equal:today', 'before:3 months'], as: 'data')]
    public ?string $date = null;

    #[Rule(['required', 'string', 'formato_cep'], as: 'CEP')]
    public ?string $cep;

    #[Rule(['required', 'string'], as: 'número')]
    public ?string $number;

    #[Rule(['nullable', 'string', 'max:255'], as: 'complemento')]
    public ?string $complement = null;

    #[Rule(['required', new Enum(PeriodTypes::class)], as: 'tipo de período')]
    public ?string $period_type = 'period';

    #[Rule(['nullable', 'required_if:period_type,period', new Enum(ServicePeriods::class)], as: 'período')]
    public ?string $period = null;

    #[Rule(['nullable', 'required_if:period_type,hour', 'string', 'max:255'], as: 'hora')]
    public ?string $hour = null;

    #[Rule(['nullable', 'string', 'max:255'], as: 'observação')]
    public ?string $observation = null;

    public function store()
    {
        $this->validate();

        $order = session()->get('scheduling.order');

        if (!$this->period) {
            $this->period = 'morning';
        }

        $order->period = OrderHelper::periodToArray(PeriodTypes::from($this->period_type), ServicePeriods::tryFrom($this->period), $this->hour);
        $order->date = $this->date;
        $order->observation = $this->observation;
        $order->items = [CompanyService::find($this->service)];

        session()->put('scheduling.order', $order);

        $address = Address::make((array) FindCepService::cep()->get(str_replace('-', '', $this->cep)));
        $address->number = $this->number;
        $address->complement = $this->complement;
        session()->put('scheduling.address', $address);

        return redirect()->route('site.scheduling.checkout');
    }
}
