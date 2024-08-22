<ul class="flex flex-wrap w-full gap-4 pt-4">
    <li class="w-full max-w-xs">
        <a href="{{ route('site.profile.cards.create') }}"
            class="flex w-full h-auto p-4 text-violet-900 border border-violet-900 rounded-xl aspect-video hover:bg-orange-ddteasy hover:text-white hover:border-orange-ddteasy hover:shadow hover:scale-105 transition-all ease-in-out">
            <div class="flex flex-col text-center m-auto gap-1">
                <span class="text-2xl md:text-4xl font-semibold font-poppins">
                    <i class="bi bi-plus-circle"></i>
                </span>
            </div>
        </a>
    </li>

    @foreach ($cards as $card)
    <li class="w-full max-w-xs">
        <a href="{{ route('site.profile.cards.edit', ['card_id' => $card->id]) }}"
            class="grid w-full p-4 text-white bg-violet-900 rounded-xl aspect-video hover:bg-orange-ddteasy hover:shadow hover:scale-105 transition-all ease-in-out">
            <div class="flex flex-col justify-between">
                <div>
                    <p class="text-sm">Nome</p>
                    <span class="font-poppins font-semibold md:text-lg">
                        {{ Str::upper($card->holder_name) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm">Número</p>
                    <span class="font-poppins font-semibold md:text-lg">
                        **** **** **** {{ $card->last_four_digits }}
                    </span>
                </div>
            </div>

            <div class="flex items-end justify-between w-full">
                <div>
                    <p class="text-sm">Validade</p>
                    <span class="font-poppins font-semibold md:text-lg">
                        {{ ((strlen($card->exp_month) < 2) ? "0{$card->exp_month}" : $card->exp_month) .
                            '/' . $card->exp_year }}
                    </span>
                </div>
                <div>
                    <p class="text-sm">Cód. segurança</p>
                    <span class="font-poppins font-semibold md:text-lg">
                        ***
                    </span>
                </div>
                <span class="font-poppins font-semibold text-right md:text-lg">
                    {{ $card->brand }}
                </span>
            </div>
        </a>
    </li>
    @endforeach
</ul>