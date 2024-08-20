<form wire:submit="update" class="flex flex-col gap-4 font-poppins" x-data="{ showPass: false }">
    <div>
        <div class="w-full">
            <label for="password">Senha:</label>
            <div class="w-full relative">
                <input wire:model.live="form.password" id="password" @class(['w-full
                    focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                    ease-in-out', 'border-red-500'=>
                $errors->has('form.password')]) x-bind:type="(showPass) ? 'text' : 'password'"
                placeholder="Senha" />
                <button type="button"
                    class="absolute top-0 right-0 aspect-square h-full text-violet-900 hover:text-violet-900/90 transition-all ease-in-out"
                    x-on:click="showPass = !showPass"><i class="bi text-xl"
                        x-bind:class="(showPass) ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i></button>
            </div>
            @error('form.password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div>
        <div class="w-full">
            <label for="password_confirmation">Confirmar senha:</label>
            <input wire:model.live="form.password_confirmation" id="password_confirmation"
                @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                ease-in-out', 'border-red-500'=> $errors->has('form.password_confirmation')])
            x-bind:type="(showPass) ? 'text' : 'password'" placeholder="Confirmar senha" />
            @error('form.password_confirmation')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="w-full text-right">
        <button class="text-lg font-bold text-white py-2 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">Atualizar</button>
    </div>
</form>
