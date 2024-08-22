<?php

namespace App\Livewire\Web;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ajuda')]
class Faq extends Component
{
    public ?string $search = '';
}
