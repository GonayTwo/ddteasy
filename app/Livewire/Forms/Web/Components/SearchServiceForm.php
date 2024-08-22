<?php

namespace App\Livewire\Forms\Web\Components;

use App\Enums\HouseRanges;
use App\Enums\PropertyTypes;
use App\Helpers\OrderHelper;
use App\Models\Orders\Order;
use App\Models\Services\Plague;
use App\Services\FindCep\FindCepService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SearchServiceForm extends Form
{
    #[Rule(['required', 'array', 'filled'], as: 'pragas')]
    public ?array $plagues = [];

    #[Rule(['required', new Enum(PropertyTypes::class)], as: 'tipo de propriedade')]
    public ?string $property_type = 'apartament';

    #[Rule(['nullable', 'required_if:form.property_type,apartament', 'numeric', 'min:1'], as: 'quartos')]
    public ?int $rooms = 1;

    #[Rule(['nullable', 'required_if:form.property_type,house', new Enum(HouseRanges::class)], as: 'metragem')]
    public ?string $range = 'minor-than100';

    #[Rule(['required', 'string', 'formato_cep'], as: 'CEP')]
    public ?string $cep;

    public function store()
    {
        $this->validate();

        $order = Order::make();
        $order->property = OrderHelper::propertyToArray(PropertyTypes::tryFrom($this->property_type), $this?->rooms, HouseRanges::tryFrom($this?->range));

        session()->put('scheduling.order', $order);
        session()->put('scheduling.address', FindCepService::cep()->get(str_replace('-', '', $this->cep)));
        session()->put('scheduling.selected_plagues', Plague::whereIn('slug', $this->plagues)->get());

        return redirect()->route('site.scheduling.index');
    }
}
