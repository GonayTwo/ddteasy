<div class="w-full">
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Fechar</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-violet-900 dark:text-white">Recuperar a senha</h3>
                    <form class="space-y-6" action="#">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-violet-900 dark:text-white">E-mail</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="exemplo@email.com.br" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-orange-ddteasy  focus:ring-blue-300 px-5 py-2.5 text-center">Recuperar senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:web.components.header title="Área do Usuário" />
    <div class="w-full font-poppins">
        <div class="w-full max-w-screen-lg flex flex-col md:flex-row mx-auto gap-2">
            <div class="w-full px-4 md:px-8 py-16 md:py-24">
                <div class="text-center mb-4 md:mb-8">
                    <h2 class="text-orange-ddteasy font-bold mb-4 text-3xl md:text-4xl">Login do usuário</h2>
                    <p>Faça login informando seu e-mail e senha abaixo.</p>
                    <p>É um parceiro? <a href="/parceiros/login" class="text-violet-800">Clique aqui</a> para fazer login<p>
                </div>

                <form class="w-full" wire:submit="save">
                    <div class="mb-4">
                        <input type="text" wire:model="form.email" placeholder="E-mail" class="w-full p-3 border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy">
                        @error('form.email') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" wire:model="form.password" placeholder="Senha" class="w-full p-3 border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy">
                        @error('form.password') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="w-full flex flex-col md:flex-row md:justify-between text-sm mb-4">
                        <div class="flex items-center mb-4">
                            <input id="remember" wire:model="form.remember" type="checkbox" class="w-4 h-4 text-violet-900 bg-gray-100 border-gray-400 rounded focus:ring-orange-ddteasy transition-all ease-in-out">
                            <label for="remember" class="ml-2 text-sm cursor-pointer hover:text-orange-ddteasy transition-all ease-in-out">Lembrar-me</label>
                        </div>
                        <span>Problemas com a senha?
                            <a href="{{ route('site.auth.forgot-password') }}" class="text-orange-ddteasy font-medium hover:text-violet-900 transition-all ease-in-out">
                                Clique aqui
                            </a>
                        </span>
                    </div>

                    <button type="submit" class="w-full py-2 bg-orange-ddteasy text-white text-2xl font-bold hover:bg-orange-ddteasy/80 transition-all ease-in-out">Entrar</button>
                </form>
            </div>
            <div class="w-full flex">
                <div class="w-full bg-gray-200 px-4 md:px-8 py-16 md:py-24 my-auto flex flex-col gap-10 text-center">
                    <h2 class="text-orange-ddteasy font-bold mb-4 text-3xl md:text-4xl">Ainda não é usuário?</h2>
                    <p>Clique no botão abaixo e cadastre-se agora mesmo!</p>
                    <a href="{{ route('site.auth.register') }}" class="w-full py-2 bg-orange-ddteasy text-white text-2xl font-bold hover:bg-orange-ddteasy/80 transition-all ease-in-out">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</div>