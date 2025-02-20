<div class="w-full font-poppins">
    <livewire:web.components.header title="Finalizar Cadastro" />

    <div class="container mx-auto px-2">
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="max-w-screen-xl mx-auto grid grid-cols-1 xl:grid-cols-2 gap-4" x-data="{  showPass: false }">
                <h1 class="text-center text-2xl md:text-4xl text-orange-ddteasy font-bold col-span-full pt-8">
                    Empresa
                </h1>

                <div>
                    <label>Razão social</label>
                    <input type="text" wire:model.live="form.corporate_name" @class(['text-sm md:text-base w-full
                        focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.corporate_name')])
                    placeholder="Razão social">

                    @error('form.corporate_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label>Nome fantasia</label>
                    <input type="text" wire:model.live="form.fantasy_name" @class(['text-sm md:text-base w-full
                        focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.fantasy_name')])
                    placeholder="Nome fantasia">

                    @error('form.fantasy_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-full">
                    <label>CNPJ</label>
                    <input type="text" wire:model.live="form.cnpj" x-mask="99.999.999/9999-99" @class(['text-sm
                        md:text-base w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.cnpj')]) placeholder="CNPJ">

                    @error('form.cnpj')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-5 gap-4 col-span-full">
                    <div class="col-span-full md:col-span-1">
                        <label>CEP</label>
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
                        <label>Endereço</label>
                        <input type="text" wire:model="street" @class(['text-sm md:text-base w-full bg-gray-50
                            transition-all ease-in-out', 'border-red-500'=>
                        $errors->has('street')]) placeholder="Endereço" disabled>
                        @error('street')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-full md:col-span-1">
                        <label>Número</label>
                        <input type="text" wire:model.live="form.number" @class(['text-sm md:text-base w-full
                            focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                            ease-in-out', 'border-red-500'=>
                        $errors->has('form.number')])
                        placeholder="Número">

                        @error('form.number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-full md:col-span-1">
                        <label>Complemento <span class="text-gray-400 text-sm">(Opcional)</span></label>
                        <input type="text" wire:model.live="form.complement" @class(['text-sm md:text-base w-full
                            focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                            ease-in-out', 'border-red-500'=>
                        $errors->has('form.complement')])
                        placeholder="Complemento">

                        @error('form.complement')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 col-span-full">
                    <div>
                        <label>Bairro</label>
                        <input type="text" wire:model="district" @class(['text-sm md:text-base w-full bg-gray-50
                            transition-all ease-in-out', 'border-red-500'=>
                        $errors->has('district')]) placeholder="Bairro" disabled>
                        @error('district')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label>Cidade</label>
                        <input type="text" wire:model="city" @class(['text-sm md:text-base w-full bg-gray-50
                            transition-all ease-in-out', 'border-red-500'=>
                        $errors->has('city')]) placeholder="Cidade" disabled>
                        @error('city')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label>Estado</label>
                        <input type="text" wire:model="state" @class(['text-sm md:text-base w-full bg-gray-50
                            transition-all ease-in-out', 'border-red-500'=>
                        $errors->has('state')]) placeholder="Estado" disabled>
                        @error('state')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label>Contrato Social (PDF)</label>
                    <input type="file" wire:model.live="form.social_contract" accept="application/pdf" @class(['text-sm
                        mb-2 md:text-base w-full border border-gray-500 focus:border-orange-ddteasy
                        focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                    $errors->has('form.social_contract')]) />
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700" x-show="uploading">
                        <div class="bg-violet-900 h-1.5 rounded-full" x-bind:style="{ width: progress + '%'}"></div>
                    </div>

                    @error('form.social_contract')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label>Licença sanitária (PDF)</label>
                    <input type="file" wire:model.live="form.sanitary_license" accept="application/pdf" @class(['text-sm
                        mb-2 md:text-base w-full border border-gray-500 focus:border-orange-ddteasy
                        focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                    $errors->has('form.sanitary_license')]) />
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700" x-show="uploading">
                        <div class="bg-violet-900 h-1.5 rounded-full" x-bind:style="{ width: progress + '%'}"></div>
                    </div>

                    @error('form.sanitary_license')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <h1 class="text-center text-2xl md:text-4xl text-orange-ddteasy font-bold mt-4 col-span-full">
                    Responsável
                </h1>

                <div>
                    <label>Nome</label>
                    <input type="text" wire:model.live="form.first_name" @class(['text-sm md:text-base w-full
                        focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.first_name')])
                    placeholder="Nome do responsável">

                    @error('form.first_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label>Sobrenome</label>
                    <input type="text" wire:model.live="form.last_name" @class(['text-sm md:text-base w-full
                        focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.last_name')]) placeholder="Sobrenome">

                    @error('form.last_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-full">
                    <label>E-mail</label>
                    <input type="email" wire:model.live="form.email" @class(['text-sm md:text-base w-full
                        focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.email')])
                    placeholder="exemplo@seudominio.com.br">

                    @error('form.email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label>CPF</label>
                    <input type="text" wire:model.live="form.cpf" x-mask="999.999.999-99" @class(['text-sm md:text-base
                        w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.cpf')])
                    placeholder="CPF">

                    @error('form.cpf')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label>Telefone</label>
                    <input type="text" wire:model.live="form.phone" x-mask="(99) 99999-9999" @class(['text-sm
                        md:text-base w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                        ease-in-out', 'border-red-500'=>
                    $errors->has('form.phone')])
                    placeholder="Telefone">

                    @error('form.phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label>Senha</label>
                    <div class="w full relative">
                        <input x-bind:type="(showPass) ? 'text' : 'password'" wire:model.live="form.password"
                            @class(['text-sm md:text-base w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy
                            transition-all ease-in-out', 'border-red-500'=>
                        $errors->has('form.password')])
                        placeholder="Senha">
                        <button type="button"
                            class="absolute top-0 right-0 aspect-square h-full text-violet-900 hover:text-violet-900/90 transition-all ease-in-out"
                            x-on:click="showPass = !showPass"><i class="bi text-xl"
                                x-bind:class="(showPass) ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i></button>

                    </div>

                    @error('form.password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label>Confirmar senha</label>
                    <input x-bind:type="(showPass) ? 'text' : 'password'" wire:model.live="form.password_confirmation"
                        @class(['text-sm md:text-base w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy
                        transition-all ease-in-out', 'border-red-500'=>
                    $errors->has('form.password_confirmation')])
                    placeholder="Confirmar senha">

                    @error('form.password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <h2 class="text-lg text-orange-ddteasy text-center font-semibold">
                        Como podemos falar com você?
                    </h2>
                    <div class="flex flex-row flex-wrap w-full lg:w-2/3 md:mx-auto justify-evenly pt-2">
                        @foreach (\App\Enums\ContactMethods::cases() as $item)
                        <div class="max-w-fit flex gap-2 items-center">
                            <input type="checkbox" id="contact_{{ $item->value }}" value="{{ $item->value }}"
                                wire:model.live="form.contact_methods" @class(['w-4 h-4 text-sm rounded focus:border-0
                                ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                                cursor-pointer', 'border-red-500'=> $errors->has('form.contact_methods')])>
                            <label for="contact_{{ $item->value }}" class="text-gray-600 duration-300 hover:text-orange-ddteasy transition-all ease-in-out
                                cursor-pointer">
                                {{ $item->getLabel() }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('form.contact_methods')
                    <div class="flex">
                        <span class="mx-auto text-red-500 text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div>
                    <div class="max-w-fit flex gap-2 items-center">
                        <input type="checkbox" wire:model.live="form.consent" @class([ 'w-4 h-4 rounded focus:border-0
                                    ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                                    cursor-pointer' , 'border-red-500'=> $errors->has('form.consent')])>
                        <label class="text-gray-600 text-sm">
                            Li e concordo com os
                            <a href="{{ route('site.terms-of-use') }}" target="_blank"
                                class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                                Termos de Uso
                            </a>
                            ,
                            <a href="{{ route('site.privacy-policy') }}" target="_blank"
                                class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                                Políticas de Privacidade
                            </a>
                            e
                            <a href="{{ route('site.partnership-agreement') }}" target="_blank"
                                class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                                Contrato de Parceria
                            </a>
                        </label>
                    </div>
                    @error('form.consent')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-full text-center pt-4 pb-12">
                    <button type="submit"
                        class="text-lg font-semibold text-white py-4 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">
                        Finalizar cadastro!
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>