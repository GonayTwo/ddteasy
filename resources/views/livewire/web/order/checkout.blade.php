<div class="w-full font-poppins">
    <livewire:web.components.header title="Pagamento" />

    <div
        class="max-w-[1200px] mx-auto border-b border-violet-900 flex flex-row max-sm:flex-col justify-between py-2 mt-5">
        <div class="text-lg text-gray-600">
            Etapa <span class="text-orange-ddteasy font-semibold">02/02</span>
        </div>
    </div>

    <div class="container mx-auto py-16">
        <h1 class="text-center text-orange-ddteasy text-4xl max-lg:text-2xl max-md:text-xl mb-12 font-bold">Informar
            seus dados para pagamento</h1>

        <form wire:submit="save" class="w-full" x-data="{ payment_method: '' }">
            <div class="w-full flex flex-wrap flex-row">
                <div class="flex flex-wrap w-2/4 basis-2/4 max-lg:basis-full max-lg:w-full px-2">

                    <div
                        class="w-full h-fit max-w-max600 px-12 py-12 mx-auto max-h-fit shadow-[0_15px_50px_rgba(0,0,0,0.6)]">
                        <div class="relative flex flex-col py-5 border-b border-gray-300">
                            <h2 class="text-orange-ddteasy text-3xl max-md:text-xl text-center font-bold mb-8">Endereço
                            </h2>
                            <p class="text-center">{{ $address }}</p>
                        </div>

                        <div class="relative flex flex-col py-5 border-b border-gray-300">
                            <h2 class="text-orange-ddteasy text-3xl max-md:text-xl text-center font-bold mb-8">Data do
                                Serviço</h2>
                            <h3 class="text-violet-900 text-3xl text-center font-bold mb-3">{{ $date }}</h3>
                            <p class="text-center">{{ $period }}</p>
                        </div>

                        <div class="relative flex flex-col py-5">
                            <h2 class="text-orange-ddteasy text-3xl max-md:text-xl text-center font-bold mb-8">
                                Empresa Escolhida
                            </h2>

                            <div class="inline-flex flex-nowrap w-full">
                                <img src="{{ $company_service->company->getFilamentAvatarUrl() ?? "https://ui-avatars.com/api/?name={$company_service->company->fantasy_name}&background=4a1d96&color=f28a20&bold=true" }}"
                                    alt="{{ $company_service->company->fantasy_name }}"
                                    class="rounded-full w-[150px] h-[150px]">

                                <div class="flex flex-col gap-y-4 w-full py-5 pl-4">
                                    <h3 class="text-violet-900 text-2xl font-bold">
                                        {{ $company_service->company->fantasy_name }}</h3>

                                    {{-- TODO: Avaliações da empresa --}}
                                    {{-- <div class="flex items-center mb-4">
                                        <i class="bi bi-star-fill text-yellow-400"></i>
                                        <i class="bi bi-star-fill text-yellow-400"></i>
                                        <i class="bi bi-star-fill text-yellow-400"></i>
                                        <i class="bi bi-star-fill text-yellow-400"></i>
                                        <i class="bi bi-star-fill text-yellow-400"></i>
                                        <p class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">20
                                            avaliações</p>
                                    </div> --}}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="flex flex-wrap flex-col w-2/4 basis-2/4 max-lg:basis-full max-lg:w-full px-2"
                    x-data="{ show: true }">

                    <div class="border w-full border-slate-900 h-fit p-11 mb-10">
                        <div class="flex flex-row flex-wrap relative">
                            <div class="block basis-9/12">
                                <h2 class="text-3xl text-violet-900 font-bold">{{ $company_service->service->name }}
                                </h2>
                                <p>{{ $company_service->service->plagues->pluck('name')->join(', ') }}</p>
                                <p>{{ $property }}</p>
                            </div>

                            <div class="block basis-3/12 text-end">
                                <span class="block text-gray-500 text-xl font-semibold line-through">
                                    R$ {{ number_format($company_service->daily_price / 100, 2, ',', '.') }}
                                </span>
                                <span class="text-red-600">10% de desconto!</span>
                                <span>total com desconto</span>
                                <span class="block text-violet-900 text-3xl font-semibold">
                                    R$ {{ number_format($company_service->daily_price * 0.9 / 100, 2, ',', '.') }}
                                </span>

                            </div>

                        </div>

                        @if ($company_service->service->observations)
                            <hr class="w-2/4 my-8">

                            <div class="w-full relative observations-content">
                                {!! $company_service->service->observations !!}
                            </div>
                        @endif
                    </div>


                    <h2 class="text-violet-900 font-bold text-3xl py-4" x-show="show">
                        Método de pagamento:
                    </h2>

                    <ul class="grid w-full gap-6 md:grid-cols-2 py-4" x-show="show">
                        @foreach (\App\Services\Pagarme\Enums\PaymentMethods::cases() as $payment_method)
                            <li>
                                <input type="radio" id="payment_{{ $payment_method }}"
                                    wire:model="form.payment_method" x-ref="payment_method"
                                    value="{{ $payment_method }}" class="hidden peer" checked="false"
                                    x-on:change="payment_method = $el.value" />
                                <label for="payment_{{ $payment_method }}"
                                    class="inline-flex items-center justify-between w-full p-5 text-violet-900 fill-violet-900 bg-white border border-violet-900 cursor-pointer peer-checked:bg-orange-ddteasy peer-checked:border-white peer-checked:text-white peer-checked:fill-white hover:text-white hover:bg-violet-900 hover:fill-white transition ease-in-out">
                                    <div class="w-full flex flex-col items-center">
                                        {!! $payment_method->getIcon() !!}
                                        <span class="text-lg font-semibold">{{ $payment_method->getLabel() }}</span>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <template x-if="payment_method === 'credit_card'">
                        <div class="flex flex-col gap-2">
                            <a class="ms-auto text-sm text-orange-ddteasy font-semibold hover:text-violet-900 underline transition-all ease-in-out"
                                href="{{ route('site.profile.cards.create') }}">
                                Cadastrar novo cartão <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <select wire:model="form.card"
                                class="w-full border-violet-900 mb-2 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out">
                                <option value="" selected>Selecione um cartão de crédito</option>
                                @foreach (auth()->user()->userable->cards as $card)
                                    <option value="{{ $card->id }}">
                                        **** **** **** {{ $card->last_four_digits }} -
                                        {{ (strlen($card->exp_month) < 2 ? "0{$card->exp_month}" : $card->exp_month) . "/{$card->exp_year}" }}
                                        -
                                        {{ $card->holder_name }} -
                                        {{ $card->brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </template>
                    @error('form.card')
                        <span class="text-red-500 text-sm mb-4">{{ $message }}</span>
                    @enderror

                    @if ($qr_code && $qr_code_url && $qr_code_expires_at)
                        <div class="w-full py-6" x-data="{ qr_code: '{{ $qr_code }}' }">
                            <img src="{{ $qr_code_url }}" alt="Pix QR Code">
                            <p class="text-lg">
                                Expiração: {{ date('d/m/Y H:i:s', strtotime($qr_code_expires_at)) }}
                            </p>
                            <button type="button"
                                class="text-center text-sm text-white bg-orange-ddteasy font-semibold p-2"
                                x-on:click="
                            navigator.clipboard.writeText(qr_code)
                            modal('Sucesso!', 'Código copiado para a área de transferência com sucesso!', 'success')
                            ">
                                <i class="bi bi-clipboard-fill"></i>
                                Copiar para área de transferência
                            </button>
                        </div>
                    @endif

                    <div class="flex flex-col gap-2" x-show="show">
                        <div>
                            <div class="max-w-fit flex gap-2 items-center">
                                <input type="checkbox" wire:model.live="form.recomendations"
                                    @class([
                                        'w-4 h-4 rounded focus:border-0                                                                                                                                                                         cursor-pointer',
                                        'border-red-500' => $errors->has('form.recomendations'),
                                    ])>
                                <label class="text-gray-600 text-sm">
                                    Concordo com as
                                    <a href="{{ route('site.services') }}" target="_blank"
                                        class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                                        Recomendações de Serviço
                                    </a>
                                </label>
                            </div>
                            @error('form.recomendations')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end py-4">
                        <span class="text-2xl text-gray-900">Valor Total:</span>
                        
                        <!-- Valor original riscado -->
                        <span class="ml-8 text-xl text-gray-500 line-through">
                            R$ {{ number_format($company_service->daily_price / 100, 2, ',', '.') }}
                        </span>

                        <!-- Valor com desconto -->
                        <span class="ml-8 text-3xl text-violet-900 font-bold">
                            R$ {{ number_format($company_service->daily_price * 0.9 / 100, 2, ',', '.') }}
                        </span>
                        
                        <!-- Mensagem de desconto -->
                        <span class="block text-red-600 text-sm">10% de desconto aplicado</span>
                    </div>


                    <div class="text-end" x-show="show">
                        <button x-on:click="show = false"
                            class="text-center text-2xl text-white bg-orange-ddteasy font-semibold py-2 px-20">
                            Confirmar Pedido
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
