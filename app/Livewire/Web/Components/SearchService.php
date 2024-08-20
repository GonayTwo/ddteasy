<?php

namespace App\Livewire\Web\Components;

use App\Enums\PropertyTypes;
use App\Livewire\Forms\Web\Components\SearchServiceForm;
use App\Models\Services\Plague;
use App\Services\FindCep\FindCepService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class SearchService extends Component
{
    public SearchServiceForm $form;

    public ?Collection $plagues;

    public ?string $address;

    public function mount()
    {
        $this->plagues = Plague::all();
    }

    public function save()
    {
        $this->form->store();
    }

    #[On('property_type-selected')]
    public function handlePropertyTypeSelect()
    {
        if ($this->form->property_type == PropertyTypes::Apartament->value) {
            $this->form->range = null;
        } else {
            $this->form->rooms = null;
        }
    }

    #[On('cep-filled')]
    public function searchCep()
    {
        try {
            $address = FindCepService::cep()->get(str_replace('-', '', $this->form->cep));
            $this->address = "{$address?->street}, {$address?->district}, {$address?->city} - {$address?->state}";
        } catch (\Exception) {
            $this->js("modal('Erro', 'Ops! Não foi possível encontrar o endereço', 'warning')");
        }
    }

    #[On('cep-cleaned')]
    public function cleanAddress()
    {
        $this->address = null;
    }
}
