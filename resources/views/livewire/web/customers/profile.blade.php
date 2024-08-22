<div>
    <livewire:web.components.header title="Área do Cliente" />

    <div class="w-full flex flex-col md:flex-row">
        <div class="p-4 md:p-8 shadow-md w-full md:w-1/4">
            <livewire:web.components.profile.sidebar route="site.profile.index" />
        </div>
        <div class="w-full p-4 md:p-8">
            <h2 class="text-3xl md:text-4xl font-poppins font-bold">Dados</h2>
            <h3 class="text-md md:text-lg text-gray-500">Mantenha seus dados sempre atualizados!</h3>

            <div class="w-full ml-auto md:w-2/3">
                <livewire:web.components.profile.user-form />
            </div>

            <hr class="w-full my-6">
            
            <div class="w-full ml-auto md:w-2/3">
                <livewire:web.components.profile.customer-form />
            </div>
            
            <hr class="w-full my-6">
            
            <div class="w-full ml-auto md:w-2/3">
                <livewire:web.components.profile.password-form />
            </div>
        </div>
    </div>
</div>

</div>