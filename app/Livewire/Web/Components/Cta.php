<?php

namespace App\Livewire\Web\Components;

use Livewire\Component;

class Cta extends Component
{
    public ?string $title;

    public function mount(string $title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.web.components.cta');
    }
}
