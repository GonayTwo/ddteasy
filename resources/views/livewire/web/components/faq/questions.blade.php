<div class="font-poppins">
    @if ($questions->count() < 1) <div
        class="w-full text-orange-ddteasy text-xl md:text-4xl text-center font-bold py-8 md:py-16 break-words">
        Não foram encontrados resultados para "{{ $search }}"
</div>
@endif
<div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white">
    @foreach ($questions as $question)
    <div x-data="{ open: false }" class="w-full overflow-hidden border-b border-gray-200">
        <div x-on:click="open = !open" class="flex justify-between items-center gap-2">
            <div class="flex items-center">
                <h4 class="font-bold text-left text-orange-ddteasy text-xl md:text-4xl py-6 md:py-12">
                    {{ $question->title }}
                </h4>
            </div>
            <i class="text-2xl text-orange-ddteasy bi" :class="(open) ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
        </div>
        <div x-show="open" @click.outside="open = false" class="mb-8">
            <p class="text-xl">{{ $question->text }}</p>
        </div>
    </div>
    @endforeach
</div>
</div>