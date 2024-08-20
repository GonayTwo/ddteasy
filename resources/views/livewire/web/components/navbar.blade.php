<nav class="bg-white">
    <div class="flex flex-wrap items-center mx-auto p-4 lg:px-20 lg:py-6">
        <a href="{{ route('site.home') }}" class="flex items-center">
            <img src="{{ asset('images/logo-ddteasy.svg') }}" class="h-12 lg:w-60 lg:h-auto"
                alt="DDTeasy Logo" />
        </a>
        <button data-collapse-toggle="navbar" type="button"
            class="ml-auto inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-violet-900 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-0"
            aria-controls="navbar" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <span class="text-2xl bi bi-list"></span>
        </button>
        <div class="hidden w-full lg:block lg:w-auto lg:flex-grow" id="navbar">
            <ul
                class="text-lg flex flex-col py-4 lg:p-0 mt-4 rounded-lg font-medium lg:flex-row lg:space-x-8 lg:mt-0 lg:border-0 gap-1">
                <li class="flex lg:ml-auto">
                    <a href="{{ route('site.home') }}"
                        class="block py-2 pl-3 pr-4 m-auto text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-orange-ddteasy lg:p-0 transition-all ease-in-out"
                       >A DDTeasy</a>
                </li>
                <li class="flex">
                    <a href="{{ route('site.services') }}"
                        class="block py-2 pl-3 pr-4 m-auto text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-orange-ddteasy lg:p-0 transition-all ease-in-out"
                       >Serviços</a>
                </li>
                <li class="flex">
                    <a href="{{ route('site.how-to') }}"
                        class="block py-2 pl-3 pr-4 m-auto text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-orange-ddteasy lg:p-0 transition-all ease-in-out"
                       >Como Funciona</a>
                </li>
                <li class="flex">
                    <a href="{{ route('site.partners.index') }}"
                        class="block py-2 pl-3 pr-4 m-auto text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-orange-ddteasy lg:p-0 transition-all ease-in-out"
                       >Seja um Parceiro</a>
                </li>
                <li class="flex lg:!mr-auto">
                    <a href="{{ route('site.faq') }}"
                        class="block py-2 pl-3 pr-4 m-auto text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-orange-ddteasy lg:p-0 transition-all ease-in-out"
                       >Ajuda</a>
                </li>
                <li class="flex">
                    @guest
                    <a href="{{ route('site.auth.login') }}"
                        class="w-full text-white text-center bg-orange-ddteasy hover:bg-orange-ddteasy/80 lg:text-lg rounded-lg py-2 lg:px-12 lg:py-3 mr-3 lg:mr-0 transition-all ease-in-out"
                       >
                        <span class="bi bi-box-arrow-in-right"></span> Login
                    </a>
                    @endguest

                    @auth
                    <a href="{{ route('site.profile.index') }}"
                        class="w-full text-white text-center bg-orange-ddteasy hover:bg-orange-ddteasy/80 lg:text-lg rounded-lg py-2 lg:px-12 lg:py-3 mr-3 lg:mr-0 transition-all ease-in-out"
                       >
                        <span class="bi bi-person-circle"></span> Olá, {{ auth()->user()->first_name }}
                    </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>