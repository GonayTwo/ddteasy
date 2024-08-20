<div>
    <livewire:web.components.header title="Cadastro" />
    <div class="container mx-auto font-poppins py-12">
        <div class="w-full text-center px-4 mb-8">
            <h1 class="font-bold text-orange-ddteasy mb-6 text-3xl md:text-5xl">Cadastre-se já como cliente</h1>
            <p class="max-w-screen-sm text-gray-600 mx-auto text-base md:text-lg">
                Faça seu cadastro e aproveite todas as
                facilidades que a DDTeasy pode oferecer para você e
                sua empresa!
            </p>
        </div>

        <form wire:submit="save" class="mx-auto max-w-screen-xl" x-data="{  showPass: false }">

            <div class="flex flex-col md:flex-row gap-8 mb-8 px-4">
                <div class="w-full flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="w-full">
                            <label for="first_name">Nome*</label>
                            <input wire:model.live="form.first_name" id="first_name" @class(['w-full
                                focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out', 'border-red-500'=> $errors->has('form.first_name')]) type="text"
                            placeholder="Nome" />
                            @error('form.first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="last_name">Sobrenome*</label>
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
                            <label for="email">E-mail*</label>
                            <input wire:model.live="form.email" id="email" @class(['w-full focus:border-orange-ddteasy
                                focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                            $errors->has('form.email')]) type="text" placeholder="E-mail" />
                            @error('form.email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="w-full">
                            <label for="password">Senha*</label>
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
                            <label for="password_confirmation">Confirmar senha*</label>
                            <input wire:model.live="form.password_confirmation" id="password_confirmation"
                                @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out', 'border-red-500'=> $errors->has('form.password_confirmation')])
                            x-bind:type="(showPass) ? 'text' : 'password'" placeholder="Confirmar senha" />
                            @error('form.password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="w-full">
                            <label for="cpf">CPF*</label>
                            <input wire:model.live="form.cpf" id="cpf" @class(['w-full focus:border-orange-ddteasy
                                focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                            $errors->has('form.cpf')]) type="text" x-mask="999.999.999-99" placeholder="999.999.999-99"
                            />
                            @error('form.cpf')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-center text-orange-ddteasy text-2xl mb-2">
                            Como prefere ser contatado?
                        </h3>
                        <div class="flex flex-row flex-wrap w-full lg:w-1/2 md:mx-auto justify-evenly">
                            @foreach (\App\Enums\ContactMethods::cases() as $item)
                            <div class="max-w-fit flex gap-2 items-center">
                                <input type="checkbox" id="contact_{{ $item->value }}" value="{{ $item->value }}"
                                    wire:model.live="form.contact_methods" @class(['w-5 h-5 rounded focus:border-0
                                    ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                                    cursor-pointer', 'border-red-500'=> $errors->has('form.contact_methods')])>
                                <label for="contact_{{ $item->value }}"
                                    class="text-gray-600 duration-300 hover:text-orange-ddteasy transition-all ease-in-out cursor-pointer">
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
                </div>
                <div class="w-full flex flex-col gap-4">
                    <div>
                        <label for="phone">Telefone*</label>
                        <input type="text" wire:model.live="form.phone" id="phone" x-mask="(99) 99999-9999"
                            @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                            ease-in-out', 'border-red-500'=> $errors->has('form.phone')])
                        placeholder="(99) 99999-9999">
                        @error('form.phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="birth_date">Data de nascimento*</label>
                        <input type="date" wire:model.live="form.birth_date" id="birth_date" @class(['w-full
                            focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                            ease-in-out', 'border-red-500'=> $errors->has('form.birth_date')])>
                        @error('form.birth_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="cep">CEP*</label>
                        <input type="text" wire:model.live="form.cep" id="cep" x-ref="cep" x-mask="99999-999"
                            placeholder="99999-999"
                            x-on:keyup="if($refs.cep.value.length === 9){ $dispatch('cep-filled') }" @class(['block
                            w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                            ease-in-out', 'border-red-500'=> $errors->has('form.cep')])>
                        @error('form.cep')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="address">Endereço:</label>
                        <input type="text" id="address" placeholder="Endereço" wire:model.live="address_preview"
                            class="w-full bg-slate-100 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out"
                            disabled>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-full">
                            <label for="number">Número*</label>
                            <input type="text" wire:model.live="form.number" id="number" placeholder="123"
                                @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out', 'border-red-500'=> $errors->has('form.number')])>
                            @error('form.number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label for="complement">Complemento</label>
                            <input type="text" wire:model.live="form.complement" id="complement" placeholder="Bloco A"
                                @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out', 'border-red-500'=> $errors->has('form.complement')])>
                            @error('form.complement')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div>
                            <div class="max-w-fit flex gap-2 items-center">
                                <input type="checkbox" wire:model.live="form.consent" @class([ 'w-4 h-4 rounded focus:border-0
                                ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                                cursor-pointer' , 'border-red-500'=> $errors->has('form.consent')])>
                                <label class="text-gray-600 text-sm">
                                    Li e concordo com os
                                    <a href="{{ route('site.terms-of-use') }}" target="_blank"
                                        class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">Termos de Uso</a>, 
                                    <a href="{{ route('site.privacy-policy') }}" target="_blank"
                                        class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                                        Políticas de Privacidade
                                    </a>
                                    e
                                    <a href="{{ route('site.service-contract') }}" target="_blank"
                                        class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                                        Contrato de Serviço
                                    </a>
                                </label>
                            </div>
                            @error('form.consent')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <div class="max-w-fit flex gap-2 items-center">
                                <input type="checkbox" wire:model.live="form.newsletter" class="w-4 h-4 rounded focus:border-0
                                ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                                cursor-pointer">
                                <label class="text-gray-600 text-sm">
                                    Aceito receber atualizações de marketing por e-mail
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <button
                    class="text-lg font-bold text-white py-4 px-8 mx-auto bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">Cadastrar-se</button>
            </div>
        </form>
    </div>
</div>