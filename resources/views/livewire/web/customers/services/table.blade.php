<div>
    <livewire:web.components.header title="Área do Cliente" />

    <div class="w-full flex flex-col md:flex-row">
        <div class="p-4 md:p-8 shadow-md w-full md:w-1/4">
            <livewire:web.components.profile.sidebar route="site.profile.services.index" />
        </div>
        <div class="w-full p-4 md:p-8">
            <h2 class="text-3xl md:text-4xl font-poppins font-bold">Últimos Serviços</h2>
            <h3 class="text-md md:text-lg text-gray-500">Consulte aqui os últimos serviços agendados e realizados.</h3>


            <div class="w-full py-8">
                {{ $this->table }}
            </div>
        </div>
    </div>

</div>