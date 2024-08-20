<form wire:submit="save" class="w-full flex flex-col gap-4 font-poppins">
    <div class="grid grid-cols-5 gap-4 col-span-full">
        <div class="col-span-full md:col-span-1">
            <label>CEP*</label>
            <input type="text" wire:model.live="form.cep" x-mask="99999-999" x-ref="cep" x-on:keyup="
                if($refs.cep.value.length === 9){ 
                    $dispatch('cep-filled') 
                } else if ($refs.cep.value.length != 9) { 
                    $dispatch('cep-cleaned') 
                }" placeholder="CEP" @class(['text-sm md:text-base w-full focus:border-orange-ddteasy
                focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
            $errors->has('form.cep')])/>

            @error('form.cep')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-full md:col-span-2">
            <label>Endereço*</label>
            <input type="text" wire:model="street" @class(['text-sm md:text-base w-full bg-gray-50 transition-all
                ease-in-out', 'border-red-500'=>
            $errors->has('street')]) placeholder="Endereço" disabled>
            @error('street')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-full md:col-span-1">
            <label>Número*</label>
            <input type="text" wire:model.live="form.number" @class(['text-sm md:text-base w-full
                focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
            $errors->has('form.number')])
            placeholder="Número">

            @error('form.number')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-full md:col-span-1">
            <label>Complemento</label>
            <input type="text" wire:model.live="form.complement" @class(['text-sm md:text-base w-full
                focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
            $errors->has('form.complement')])
            placeholder="Complemento">

            @error('form.complement')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 col-span-full">
        <div class="col-span-full md:col-span-2">
            <label>Bairro*</label>
            <input type="text" wire:model="district" @class(['text-sm md:text-base w-full bg-gray-50 transition-all
                ease-in-out', 'border-red-500'=>
            $errors->has('district')]) placeholder="Bairro" disabled>
            @error('district')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-full md:col-span-2">
            <label>Cidade*</label>
            <input type="text" wire:model="city" @class(['text-sm md:text-base w-full bg-gray-50 transition-all
                ease-in-out', 'border-red-500'=>
            $errors->has('city')]) placeholder="Cidade" disabled>
            @error('city')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-full md:col-span-1">
            <label>Estado*</label>
            <input type="text" wire:model="state" @class(['text-sm md:text-base w-full bg-gray-50 transition-all
                ease-in-out', 'border-red-500'=>
            $errors->has('state')]) placeholder="Estado" disabled>
            @error('state')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button
            class="col-start-5 col-span-1 text-lg font-bold text-white py-2 text-centerz bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">Atualizar</button>
    </div>

</form>