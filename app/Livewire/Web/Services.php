<?php

namespace App\Livewire\Web;

use Livewire\Attributes\Title;
use Livewire\Component;

class Services extends Component
{
    #[Title('Serviços')]
    public function render()
    {
        return view('livewire.web.services');
    }
}
