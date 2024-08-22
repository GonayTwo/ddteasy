<div class="w-full mx-auto font-poppins py-12">
    <livewire:web.components.header title="Recuperar Conta" />
    <div>
        <div class="w-full px-5 py-3">

            <div class="w-full max-w-screen-md flex flex-col md:flex-row mx-auto gap-2">

                <form class="w-full" wire:submit="save">
                    <div class="mb-4">
                        <input type="password" wire:model="password" placeholder="Senha"
                            class="w-full p-3 border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input type="password" wire:model="password_confirmation" placeholder="Confirmar Senha"
                            class="w-full p-3 border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy">
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full py-2 bg-orange-ddteasy text-white text-2xl font-bold hover:bg-orange-ddteasy/80 transition-all ease-in-out">Confirmar</button>
                    <input type="hidden" wire:model="email" name="email" value="{{ $emailReset }}">
                    <input type="hidden" wire:model="token" name="token" value="{{ $tokenReset }}">
                </form>
            </div>

        </div>
    </div>
</div>
