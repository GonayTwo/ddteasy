<?php

namespace App\Livewire\Web\Components;

use App\Models\Content\Testimony;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Testimonies extends Component
{
    public ?string $title;

    public ?Collection $testimonies;

    public function mount(string $title)
    {
        $this->title = $title;
        $this->testimonies = Testimony::orderByDesc('sort')->get();
    }

    public function render()
    {
        return view('livewire.web.components.testimonies');
    }
}
