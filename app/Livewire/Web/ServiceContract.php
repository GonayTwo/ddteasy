<?php

namespace App\Livewire\Web;

use App\Models\Content\ServiceContract as ServiceContractModel;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Contrato de Serviço')]
class ServiceContract extends Component
{
    public ?ServiceContractModel $serviceContract;

    public function mount()
    {
        $this->serviceContract = ServiceContractModel::orderByDesc('created_at')->limit(1)->get()->first();
    }
}
