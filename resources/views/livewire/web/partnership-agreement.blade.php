<div class="w-full font-poppins">
    <livewire:web.components.header title="Contrato de Parceria" />

    <div class="page-policies">
        <p class="text-lg text-gray-900">
            Última atualização: {{$partnershipAgreement?->update_date->translatedFormat('j \de F \de Y') }}.
        </p>

        {!! $partnershipAgreement?->text !!}

    </div>
</div>
