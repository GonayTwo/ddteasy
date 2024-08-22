<div class="w-full font-poppins">
    <livewire:web.components.header title="Como Funciona" />

    <div class="xl:container mx-auto py-20">
        <h1 class="text-5xl max-2xl:text-4xl text-orange-ddteasy font-bold text-center">Como Funciona</h1>

        <img src="{{ asset('images/linha-do-tempo.svg') }}" alt="Como funciona" class="hidden md:block mx-auto pt-20">

        <div class="w-full flex md:hidden flex-col gap-y-5">
            <div>
                <img src="{{ asset('images/img-passo-1.webp') }}" alt="Passo 1" class="block w-52 sm:w-fit max-w-full mx-auto mb-4">
                <div class="px-2">
                    <div class="bg-purple-900 text-2xl text-center w-12 h-12 font-bold rounded-full leading-[3rem] mx-auto mb-4 text-white">01</div>
                    <div class="border-purple-900 text-lg text-purple-900 font-semibold text-center py-2">
                        <span>Pesquise o serviço de acordo com a sua necessidade. É rápido e de graça!</span>
                    </div>
                </div>
            </div>
            <div>
                <img src="{{ asset('images/img-passo-2.webp') }}" alt="Passo 2" class="block w-52 sm:w-fit max-w-full mx-auto mb-4">
                <div class="px-2">
                    <div class="bg-purple-900 text-2xl text-center w-12 h-12 font-bold rounded-full leading-[3rem] mx-auto mb-4 text-white">02</div>
                    <div class="border-purple-900 text-lg text-purple-900 font-semibold text-center py-2">
                        <span>Escolha o melhor especialista, data e horário desejado.</span>
                    </div>
                </div>
            </div>
            <div>
                <img src="{{ asset('images/img-passo-3.webp') }}" alt="Passo 3" class="block w-52 sm:w-fit max-w-full mx-auto mb-4">
                <div class="px-2">
                    <div class="bg-purple-900 text-2xl text-center w-12 h-12 font-bold rounded-full leading-[3rem] mx-auto mb-4 text-white">03</div>
                    <div class="border-purple-900 text-lg text-purple-900 font-semibold text-center py-2">
                        <span>Finalize sua solicitação e pague com segurança e praticidade no próprio site.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block w-full max-w-fit mx-auto bg-white px-8 md:px-24 py-12 shadow-personal">
        <div class="text-center text-violet-900 mb-8">
            <h1 class="text-2xl md:text-4xl font-bold mb-2">Encontre um especialista e acabe com as pragas!</h1>
            <h2 class="text-xl md:text-2xl font-semibold">Preencha com as informações adequadas</h2>
        </div>

        <div class="max-w-lg mx-auto">
            <livewire:web.components.search-service />
        </div>

    </div>

    <livewire:web.components.cta title="Faça parte da maior plataforma de dedetização do Brasil" />
</div>