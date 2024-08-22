<?php

namespace App\Livewire\Web;

use App\Models\Content\TermsOfUse as TermsOfUseModel;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Termos de Uso')]
class TermsOfUse extends Component
{
    public ?TermsOfUseModel $terms;

    public function mount()
    {
        $this->terms = TermsOfUseModel::orderByDesc('created_at')->limit(1)->get()->first();
    }
}
