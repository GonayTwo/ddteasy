<?php

namespace App\Livewire\Web;

use App\Models\Content\PrivacyPolicy as PrivacyPolicyModel;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Política de Privacidade')]
class PrivacyPolicy extends Component
{
    public ?PrivacyPolicyModel $policy;

    public function mount()
    {
        $this->policy = PrivacyPolicyModel::orderByDesc('created_at')->limit(1)->get()->first();
    }
}
