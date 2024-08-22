<footer class="bg-orange-ddteasy">
    <div class="mx-auto w-full max-w-screen-xl">
        <div class="border-b border-b-white md:flex md:justify-between md:align-middle p-4 py-6 md:py-14">
            <div class="mb-12 md:mb-0 flex align-middle">
                <a href="{{ route('site.home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo-ddteasy-2.svg') }}" class="max-w-[295px] md:h-full md:w-auto" alt="DDTeasy Logo" />
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 md:gap-20 text-lg font-medium text-white">
                <div>
                    <ul>
                        <li class="mb-6">
                            <a href="{{ route('site.services') }}" class="transition-all ease-in-out hover:text-violet-900">Serviços</a>
                        </li>
                        <li class="mb-6">
                            <a href="{{ route('site.partners.index') }}" class="transition-all ease-in-out hover:text-violet-900">Seja um Parceiro</a>
                        </li>
                        <li>
                            <a href="{{ route('site.privacy-policy') }}" class="transition-all ease-in-out hover:text-violet-900">Política de Privacidade</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li class="mb-6">
                            <a href="{{ route('site.how-to') }}" class="transition-all ease-in-out hover:text-violet-900">Como Funciona</a>
                        </li>
                        <li class="mb-6">
                            <a href="{{ route('site.faq') }}" class="transition-all ease-in-out hover:text-violet-900">Ajuda</a>
                        </li>
                        <li>
                            <a href="{{ route('site.terms-of-use') }}" class="transition-all ease-in-out hover:text-violet-900">Termos de Uso</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="text-white">
                <h1 class="text-2xl font-semibold mb-4 md:mb-8">Siga-nos</h1>
                <div class="flex text-5xl gap-6">
                    <a href="" target="_blank" class="transition-all ease-in-out hover:text-violet-900">
                        <span class="bi bi-facebook"></span>
                    </a>
                    <a href="" target="_blank" class="transition-all ease-in-out hover:text-violet-900">
                        <span class="bi bi-linkedin"></span>
                    </a>
                    <a href="" target="_blank" class="transition-all ease-in-out hover:text-violet-900">
                        <span class="bi bi-youtube"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="py-14 text-center text-lg">
            <a href="#" class="text-white py-3 px-4 rounded transition-all ease-in-out hover:bg-violet-900">Voltar ao topo <span class="bi bi-arrow-up"></span></a>
        </div>
    </div>
</footer>