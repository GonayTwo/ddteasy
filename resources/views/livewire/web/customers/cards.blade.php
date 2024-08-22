<div>
    <livewire:web.components.header title="Área do Cliente" />
    <div class="w-full flex flex-col md:flex-row">
        <div class="p-4 md:p-8 shadow-md w-full md:w-1/4">
            <livewire:web.components.profile.sidebar route="site.profile.cards.index" />
        </div>
        <div class="w-full p-4 md:p-8">
            <div class="w-full">
                <h2 class="text-3xl md:text-4xl font-poppins font-bold">Cartões</h2>
                <h3 class="text-md md:text-lg text-gray-500">Veja aqui todos seus cartões cadastrados.</h3>
            </div>

            <livewire:web.components.profile.cards-list lazy />

        </div>
    </div>
</div>