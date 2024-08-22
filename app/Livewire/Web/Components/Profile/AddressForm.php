<?php

namespace App\Livewire\Web\Components\Profile;

use App\Livewire\Forms\Web\Components\Profile\UpdateAddressForm;
use App\Services\FindCep\FindCepService;
use Livewire\Attributes\On;
use Livewire\Component;

class AddressForm extends Component
{
    public UpdateAddressForm $form;

    public ?string $street;

    public ?string $district;

    public ?string $city;

    public ?string $state;

    public function mount()
    {
        $address = auth()->user()->userable->address;

        $this->form->cep = $address?->cep;
        $this->form->number = $address?->number;
        $this->form->complement = $address?->complement;

        $this->street = $address?->street;
        $this->district = $address?->district;
        $this->city = $address?->city;
        $this->state = $address?->state;

    }

    public function save()
    {
        $this->form->store();
        $this->js("modal('Sucesso!', 'Endereço atualizado com sucesso!', 'success')");
    }

    #[On('cep-filled')]
    public function searchCep()
    {
        try {
            $clean_cep = str_replace('-', '', $this->form->cep);
            if (strlen($clean_cep) == 8) {
                $address = FindCepService::cep()->get($clean_cep);
                $this->street = $address?->street;
                $this->district = $address?->district;
                $this->city = $address?->city;
                $this->state = $address?->state;
                $this->resetValidation(['street', 'district', 'city', 'state']);
            }
        } catch (\Exception) {
            $this->js("modal('Erro', 'Ops! Não foi possível encontrar o endereço', 'warning')");
        }
    }

    #[On('cep-cleaned')]
    public function cleanAddress()
    {
        collect(['street', 'district', 'city', 'state'])->each(fn ($property) => $this->$property = '');
    }
}
