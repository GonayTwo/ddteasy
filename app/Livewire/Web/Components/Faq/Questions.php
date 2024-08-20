<?php

namespace App\Livewire\Web\Components\Faq;

use App\Models\Faq\Question;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Questions extends Component
{
    #[Reactive]
    public ?string $search;

    public function render()
    {
        return view('livewire.web.components.faq.questions', [
            'questions' => Question::select(['id', 'title', 'text', 'sort'])
                ->where('title', 'LIKE', "%{$this->search}%")
                ->orWhere('text', 'LIKE', "%{$this->search}%")
                ->orderByDesc('sort', 'id')
                ->get(),
        ]);
    }

    public function placeholder()
    {
        return <<<'html'
            <div role="status" class="flex w-full justify-center  py-8 md:py-16">
                <i class="bi bi-bug-fill text-violet-900 motion-safe:animate-bounce mx-1 text-4xl" style="animation-delay: 0.1s"></i>
                <i class="bi bi-bug-fill text-violet-900 motion-safe:animate-bounce mx-1 text-4xl" style="animation-delay: 0.2s"></i>
                <i class="bi bi-bug-fill text-violet-900 motion-safe:animate-bounce mx-1 text-4xl" style="animation-delay: 0.3s"></i>
                <span class="sr-only">Loading...</span>
            </div>
        html;
    }
}
