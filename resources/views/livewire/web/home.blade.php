<div class="font-poppins">
    <div class="relative w-full h-auto xl:h-[80vh] bg-center bg-cover px-4 pt-12 md:px-0 md:ps-20 md:pt-32 z-10"
        style="background-image: url('{{ asset('images/hero.jpg') }}')">
        <div class="md:flex md:space-x-8 md:items-stretch">
            <div class="max-w-screen-sm bg-white p-2 md:p-12 shadow-lg">
                <div class="text-violet-900 mb-8 text-center md:text-start">
                    <h1 class="text-xl md:text-4xl font-bold mb-2">Encontre um especialista e acabe com as pragas!</h1>
                    <h2 class="text-lg md:text-2xl font-semibold">Preencha com as informações adequadas</h2>
                </div>
                <livewire:web.components.search-service />
            </div>
                <div class="relative h-1/2 self-end text-white mb-6 md:mb-12 text-center md:text-start rounded-lg">
                    <div class="absolute inset-0 bg-black opacity-30 rounded-lg"></div>
                    <div class="relative p-4 md:p-8">
                        <h1 class="mb-4 leading-snug font-bold text-xl md:text-5xl">
                            As melhores opções em controle de pragas num só lugar
                        </h1>
                        <h2 class="font-semibold md:w-5/6 md:text-3xl">
                            Aqui você encontra os mais qualificados profissionais para resolver o seu problema.
                        </h2>
                    </div>                    
                </div>
        </div>
    </div>

    <div class="flex flex-row flex-wrap bg-slate-50 py-10 px-8 md:py-20 md:px-10 xl:pb-[240px] 2xl:pb-20 items-center md:justify-end">
        <div class="w-full xl:w-1/2 xl:pl-24 xl:pr-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="85" height="69" viewBox="0 0 85 69" fill="none">
                <path
                    d="M48.3662 68.4789V47.8873C48.3662 34.9577 51.3991 24.4225 57.4648 16.2817C63.6901 7.98121 72.8685 2.55399 85 0V15.5634C79.5728 16.8404 75.2629 19.2347 72.0704 22.7465C68.8779 26.0986 66.8028 30.169 65.8451 34.9577H80.2113V68.4789H48.3662ZM0 68.4789V47.8873C0 34.9577 3.03286 24.4225 9.09859 16.2817C15.3239 7.98121 24.4225 2.55399 36.3944 0V15.5634C30.9671 16.8404 26.6573 19.2347 23.4648 22.7465C20.2723 26.0986 18.1972 30.169 17.2394 34.9577H31.6056V68.4789H0Z"
                    fill="#582583" />
            </svg>

            <h3 class="my-4 md:my-6 text-orange-ddteasy text-base md:text-4xl font-semibold">
                Profissionais Capacitados, atenciosos e, também, extremamente rápidos.
            </h3>

            <span class="text-slate-600">Adriana Ribeiro</span>
        </div>
    </div>

    <div class="w-full bg-parceiro bg-cover bg-no-repeat md:bg-center py-10 px-8 md:py-20 md:ps-40 flex justify-start">
        <h1 class="text-violet-900 text-xl md:w-2xl lg:text-4xl font-bold md:w-1/2 leading-relaxed">
            Conectamos você diretamente com as melhores empresas e profissionais do mercado.
        </h1>
    </div>

    <div class="container mx-auto py-10 md:py-20">
        <div class="flex flex-wrap">
            <img src="{{ asset('images/quemsomos.webp') }}" alt="Somos a DDTeasy"
                class="w-full md:w-2/4 h-auto aspect-video object-cover">

            <div class="flex flex-col flex-wrap justify-center w-full px-8 md:px-16 lg:w-2/4">
                <h1 class="text-orange-ddteasy text-3xl lg:text-5xl text-center py-8 md:text-left font-bold">
                    Quem Somos
                </h1>

                <p class="text-slate-600 text-lg">
                    Nós somos a maior e melhor plataforma de controle de pragas,
                    desinsetização, desratização, descupinização, controle de pombos em casas e empresas de todo o
                    Brasil. <br><br>
                    Só na DDTEASY você se conecta diretamente com as melhores
                    empresas e profissionais do mercado, com segurança, comodidade e simplicidade.
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-10 md:py-20">
        <h1 class="text-orange-ddteasy text-3xl lg:text-5xl text-center font-bold">
            Como Funciona
        </h1>

        <img src="{{ asset('images/linha-do-tempo.svg') }}" alt="Como funciona"
        class="hidden md:block mx-auto pt-20" />
        
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

    <div class="w-full bg-home-cta bg-cover bg-center bg-no-repeat py-20">
        <div class="w-full lg:w-1/2 px-4 text-center">
            <h1 class="text-white text-2xl lg:text-5xl font-bold mb-10">
                Segurança e Eficiência
            </h1>

            <a href="{{ route('site.how-to') }}"
                class="text-white text-center text-3xl max-lg:text-xl font-semibold bg-orange-ddteasy py-1 px-12">
                Acabe com as pragas
            </a>
        </div>
    </div>

    <livewire:web.components.testimonies title="Quem já usou" />

    <livewire:web.components.cta title="Faça parte da maior plataforma de dedetização do Brasil" />
    <livewire:web.components.contact title="Entre em contato" />
</div>