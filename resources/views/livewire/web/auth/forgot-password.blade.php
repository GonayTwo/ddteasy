<div class="w-full font-poppins">
    <livewire:web.components.header title="Esqueci minha senha" />

    <div class="container px-2 mx-auto py-12 md:px-0">
        <div class="w-full max-w-xl mx-auto flex flex-col gap-8">
            <div>
                <h1 class="text-center text-orange-ddteasy text-2xl lg:text-4xl font-semibold mb-5">
                    Recupere a sua senha.
                </h1>
                <p class="text-center text-lg">
                    Insira o seu e-mail abaixo para receber instruções de como recuperar a sua senha.
                </p>
            </div>
            <form wire:submit="save" class="flex flex-col gap-8">
                <div class="w-full">
                    <label for="email">Insira o seu e-mail:</label>
                    <input wire:model.live="form.email" id="email" @class(['w-full focus:border-orange-ddteasy
                        focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                    $errors->has('form.email')]) type="text" placeholder="E-mail" />
                    @error('form.email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full text-center">
                    <button class="text-lg font-bold text-white py-2 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">Enviar email</button>
                </div>
            </form>
        </div>
    </div>
</div>