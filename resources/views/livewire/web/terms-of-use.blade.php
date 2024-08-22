<div class="w-full font-poppins">
    <livewire:web.components.header title="{{ $terms->title }}" />

    <div class="page-policies">
        <p class="text-lg text-gray-900">Última atualização: {{$terms->update_date->translatedFormat('j \de F \de Y') }}.</p>

        {!! $terms->text !!}

    </div>
</div>
