<?php

namespace App\Livewire\Web\Components;

use App\Models\Contacts\Whatsapp;
use Livewire\Component;

class FloatingWhatsapp extends Component
{
    public ?Whatsapp $whatsapp;

    public function mount()
    {
        $this->whatsapp = Whatsapp::where('float', true)->first();
    }
}
