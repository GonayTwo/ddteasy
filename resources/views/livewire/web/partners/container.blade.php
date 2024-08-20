<div class="w-full font-poppins">
    <livewire:web.components.header title="Seja um Parceiro" />

    <div class="bg-slate-100 py-20">
        <h2 class="text-center text-orange-ddteasy text-4xl max-lg:text-2xl font-bold">Somos a maior plataforma de
            dedetização do Brasil</h2>

        <div class="container mt-20 mx-auto">
            <div class="flex flex-row flex-wrap justify-center items-baseline">
                <div class="flex flex-col flex-card max-md:basis-full justify-center items-center px-2 max-md:mb-6">
                    <img src="{{ asset('images/card1.svg') }}" class="block mx-auto w-[250px]"
                        alt="Navegação Simples">

                    <h6 class="text-orange-ddteasy text-center font-bold text-3xl my-12 mx-6">Navegação<br />Simples
                    </h6>

                    <p class="text-center text-gray-600">Otimize seu tempo e dinheiro através da nossa plataforma, e
                        facilite a gestão e acompanhamento de solicitações, tudo em um só lugar.</p>
                </div>

                <div class="flex flex-col flex-card max-md:basis-full justify-center items-center px-2 max-md:mb-6">
                    <img src="{{ asset('images/card2.svg') }}" class="block mx-auto w-[250px]"
                        alt="Mais Clientes">

                    <h6 class="text-orange-ddteasy text-center font-bold text-3xl my-12 mx-6">Mais<br />Clientes</h6>

                    <p class="text-center text-gray-600">Tenha acesso a centenas de clientes a procura de você.</p>
                </div>

                <div class="flex flex-col flex-card max-md:basis-full justify-center items-center px-2 max-md:mb-6">
                    <img src="{{ asset('images/card3.svg') }}" class="block mx-auto w-[250px]"
                        alt="Menos Custos">

                    <h6 class="text-orange-ddteasy text-center font-bold text-3xl my-12 mx-6">Menos<br />Custos</h6>

                    <p class="text-center text-gray-600">Deixe que nossa plataforma cuide da captação de clientes e do
                        investimento em marketing e reduza seus custos.</p>
                </div>

                <div class="flex flex-col flex-card max-md:basis-full justify-center items-center px-2 max-md:mb-6">
                    <img src="{{ asset('images/card4.svg') }}" class="block mx-auto w-[250px]"
                        alt="Aumente sua Visibilidade">

                    <h6 class="text-orange-ddteasy text-center font-bold text-3xl my-12 mx-6">Aumente sua Visibilidade
                    </h6>

                    <p class="text-center text-gray-600">Seja reconhecido pelo seus produtos e alcance clientes que
                        nunca teria a possibilidade com a divulgação tradicional.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-10 px-4 md:py-20 md:px-16 max-lg:px-2">
        <h4 class="text-center text-orange-ddteasy text-3xl md:text-4xl font-semibold mb-10">Impulsione sua empresa com
            a gente!</h4>

        <form wire:submit="save">
            <div class="flex flex-wrap flex-row justify-center px-4 md:px-16 gap-6 md:gap-4">
                <div class="flex flex-col md:flex-row w-full gap-4">
                    <div class="w-full">
                        <input type="text" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy
                            transition-all ease-in-out', 'border-red-500'=> $errors->has('form.name')])
                        placeholder="Nome Completo" wire:model.live="form.name" autocomplete="off">
                        @error('form.name')
                        <span class="text-red-500 text-sm pt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full">
                        <input type="email" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy
                            transition-all ease-in-out', 'border-red-500'=> $errors->has('form.email')])
                        placeholder="E-mail Corporativo" wire:model.live="form.email" autocomplete="off">
                        @error('form.email')
                        <span class="text-red-500 text-sm pt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col md:flex-row w-full gap-4">
                    <div class="w-full">
                        <input type="text" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy
                            transition-all ease-in-out', 'border-red-500'=> $errors->has('form.company')])
                        placeholder="Nome da Empresa" wire:model.live="form.company" autocomplete="off">
                        @error('form.company')
                        <span class="text-red-500 text-sm pt-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full">
                        <input type="text" x-mask="(99) 99999-9999" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy
                            transition-all ease-in-out', 'border-red-500'=> $errors->has('form.phone')])
                        placeholder="Telefone" wire:model.live="form.phone" autocomplete="off">
                        @error('form.phone')
                        <span class="text-red-500 text-sm pt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col flex-wrap grow shrink-0 basis-full">
                    <p class="text-center text-orange-ddteasy font-semibold text-lg md:text-xl mb-4">Como podemos falar
                        com você?</p>
                    <div class="flex flex-row flex-wrap w-full lg:w-1/3 md:mx-auto justify-evenly">
                        @foreach (\App\Enums\ContactMethods::cases() as $item)
                        <div class="max-w-fit flex gap-2 items-center">
                            <input type="checkbox" id="contact_{{ $item->value }}" value="{{ $item->value }}"
                                wire:model.live="form.contact_methods" @class(['w-5 h-5 rounded focus:border-0
                                ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                                cursor-pointer', 'border-red-500'=>
                            ($errors->has('form.contact_methods') || $errors->has('form.contact_methods.*'))])>
                            <label for="contact_{{ $item->value }}"
                                class="text-gray-600 duration-300 hover:text-orange-ddteasy transition-all ease-in-out cursor-pointer">
                                {{ $item->getLabel() }}
                            </label>
                        </div>
                        @endforeach

                        @error('form.contact_methods')
                        <span class="text-red-500 text-sm pt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 basis-3/4 max-lg:basis-full justify-center">
                    <button
                        class="text-center bg-orange-ddteasy w-full text-xl md:text-2xl font-semibold duration-150 hover:bg-[#de7204] text-white py-4 px-8 transition-all ease-in-out">Enviar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="relative w-full bg-parceiro bg-cover bg-no-repeat bg-center py-20 flex justify-start before:absolute before:content-[''] before:w-full before:h-full before:top-0 before:left-0 before:bg-white/[0.5]">
        <div class="relative w-2/4 max-lg:w-full px-20 z-10">
            <h1 class="text-violet-900 text-xl xl:text-4xl max-lg:w-2xl font-bold xl:leading-[56px]">Conectamos você diretamente com
                as melhores empresas e profissionais do mercado.</h1>
        </div>
    </div>
</div>