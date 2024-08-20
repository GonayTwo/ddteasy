<form wire:submit="update" class="w-full flex flex-col gap-4 font-poppins">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full">
            <label for="first_name">Nome:</label>
            <input wire:model.live="form.first_name" id="first_name" @class(['w-full
                focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                ease-in-out', 'border-red-500'=> $errors->has('form.first_name')]) type="text"
            placeholder="Nome" />
            @error('form.first_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full">
            <label for="last_name">Sobrenome:</label>
            <input wire:model.live="form.last_name" id="last_name" @class(['w-full
                focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                ease-in-out', 'border-red-500'=> $errors->has('form.last_name')]) type="text"
            placeholder="Sobrenome" />
            @error('form.last_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div>
        <div class="w-full">
            <label for="email">E-mail:</label>
            <input wire:model.live="form.email" id="email" @class(['w-full focus:border-orange-ddteasy
                focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
            $errors->has('form.email')]) type="text" placeholder="E-mail" />
            @error('form.email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="w-full text-right">
        <button class="text-lg font-bold text-white py-2 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">Atualizar</button>
    </div>
</form>