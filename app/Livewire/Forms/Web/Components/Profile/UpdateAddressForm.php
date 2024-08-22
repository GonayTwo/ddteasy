<?php

namespace App\Livewire\Forms\Web\Components\Profile;

use App\Services\FindCep\FindCepService;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdateAddressForm extends Form
{
    #[Rule(['required', 'string', 'formato_cep'], as: 'CEP')]
    public ?string $cep = '';

    #[Rule(['required', 'numeric'], as: 'número')]
    public ?string $number;

    #[Rule(['nullable', 'string', 'max:255'], as: 'complemento')]
    public ?string $complement = null;

    public function store()
    {
        auth()->user()->userable->address()->update($this->getAddressData());
    }

    private function getAddressData(): array
    {
        $cep = str_replace('-', '', $this->cep);
        $address_data = array_merge(
            (array) FindCepService::cep()->get($cep),
            (array) FindCepService::geolocation()->get($cep)->location,
            ['number' => $this->number, 'complement' => $this->complement]
        );
        unset($address_data['status']);

        return $address_data;
    }
}
