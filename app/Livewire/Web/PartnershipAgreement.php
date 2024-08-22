<?php

namespace App\Livewire\Web;

use App\Models\Content\PartnershipAgreement as PartnershipAgreementModel;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Contrato de Parceria')]
class PartnershipAgreement extends Component
{
    public ?PartnershipAgreementModel $partnershipAgreement;

    public function mount()
    {
        $this->partnershipAgreement = PartnershipAgreementModel::orderByDesc('created_at')->limit(1)->get()->first();
    }
}
