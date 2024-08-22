<div class="w-full font-poppins">
    <livewire:web.components.header title="Política de Privacidade" />

    <div class="page-policies">
        <p class="text-lg text-gray-900">
            Última atualização: {{$policy?->update_date->translatedFormat('j \de F \de Y') }}.
        </p>

        {!! $policy?->text !!}

    </div>
</div>
