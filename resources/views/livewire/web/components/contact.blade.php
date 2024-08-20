<div class="w-full bg-violet-900 flex px-4 py-10 md:py-16">
    <form wire:submit="save" class="container mx-auto">
        <h1 class="w-full mb-8 font-bold text-white text-center text-3xl lg:text-5xl md:mb-16">{{ $title }}</h1>
        <div class="mx-auto grid grid-cols-1 mb-8 gap-6 md:grid-cols-2 md:w-4/6 md:gap-6 md:mb-8">
            <div class="flex flex-col gap-6">
                <div>
                    <input type="text" wire:model="form.name" class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out" placeholder="Nome">
                    @error('form.name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="text" wire:model="form.email" class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out" placeholder="E-mail">
                    @error('form.email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="text" wire:model="form.phone" x-mask="(99) 99999-9999" class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out" placeholder="Telefone">
                    @error('form.phone') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <textarea wire:model="form.message" class="w-full h-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out" placeholder="Mensagem"></textarea>
                @error('form.message') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="w-full text-center">
            <button class="bg-orange-ddteasy text-white text-2xl font-bold p-3 w-full md:w-3/6 hover:bg-orange-ddteasy/80 transition-all ease-in-out">Enviar</button>
        </div>
    </form>
</div>
