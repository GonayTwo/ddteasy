<div class="w-full font-poppins">
    <livewire:web.components.header title="Contrato de Serviço" />

    <div class="page-policies">
        <p class="text-lg text-gray-900">
            Última atualização: {{$serviceContract?->update_date->translatedFormat('j \de F \de Y') }}.
        </p>

        {!! $serviceContract?->text !!}

    </div>
</div>
