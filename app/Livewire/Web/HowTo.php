<?php

namespace App\Livewire\Web;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Como Funciona')]
class HowTo extends Component
{
    public function render()
    {
        return view('livewire.web.how-to');
    }
}
