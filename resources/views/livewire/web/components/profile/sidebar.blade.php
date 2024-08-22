<ul class="w-full space-y-2 font-semibold font-poppins text-lg md:text-xl text-violet-900">
    <li>
        <h2 class="p-2 md:p-4 text-xl md:text-2xl">Olá, {{ auth()->user()->first_name }}!</h2>
    </li>
    <li>
        <hr>
    </li>
    <li>
        <a href="{{ route('site.profile.index') }}" @class(["flex items-center p-2 md:p-4 transition-all ease-in-out
            leading-none hover:bg-violet-900 hover:text-white", "text-white bg-violet-900"=> $route ==
            'site.profile.index'])>
            <i class="bi bi-person-fill mr-2"></i> Dados
        </a>
    </li>
    <li>
        <a href="{{ route('site.profile.address') }}" @class(["flex items-center p-2 md:p-4 transition-all ease-in-out
            leading-none hover:bg-violet-900 hover:text-white", "text-white bg-violet-900"=> $route ==
            'site.profile.address'])>
            <i class="bi bi-geo-alt-fill mr-2"></i> Endereço
        </a>
    </li>
    <li>
        <a href="{{ route('site.profile.services.index') }}" @class([ "flex items-center p-2 md:p-4 transition-all ease-in-out leading-none
            hover:bg-violet-900 hover:text-white" , "text-white bg-violet-900"=> $route
            =='site.profile.services.index'
            ])>
            <i class="bi bi-bug-fill mr-2"></i> Últimos Serviços
        </a>
    </li>
    <li>
        <a href="{{ route('site.profile.cards.index') }}" @class([ "flex items-center p-2 md:p-4 transition-all ease-in-out leading-none
            hover:bg-violet-900 hover:text-white" , "text-white bg-violet-900"=> $route
            =='site.profile.cards.index'
            ])>
            <i class="bi bi-credit-card-fill mr-2"></i> Cartões
        </a>
    </li>
    <li>
        <hr>
    </li>
    <li>
        <button type="button"
            class="w-full flex items-center p-2 md:p-4 transition-all ease-in-out leading-none hover:bg-violet-900 hover:text-white"
            wire:click="logout">
            <i class="bi bi-box-arrow-right mr-2"></i> Sair
        </button>
    </li>
</ul>