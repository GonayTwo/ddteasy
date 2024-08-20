<div class="w-full font-poppins">
    <livewire:web.components.header title="Agendamento" />

    <div
        class="max-w-screen-xl mx-auto border-b border-violet-900 flex flex-row justify-between px-2 pb-2 pt-6
        md:text-lg text-gray-600">
        <div>
            Etapa <span class="text-orange-ddteasy font-semibold">01/02</span>
        </div>

        <div>
            <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover"
                class="focus:outline-none inline-flex items-center" type="button">
                <p>
                    Filtrar por <span class="text-orange-ddteasy font-semibold">{{ $sort->getLabel() }}</span>
                    <i class="bi bi-chevron-down"></i>
                </p>
            </button>

            <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-52">
                <ul class="py-2 text-sm" aria-labelledby="dropdownHoverButton">
                    @foreach (\App\Enums\SortOptions::cases() as $option)
                        <li>
                            <input type="radio" id="sort_{{ $option }}" wire:model="sort"
                                x-on:change="$dispatch('sort-selected')" value="{{ $option }}"
                                class="hidden peer">
                            <label for="sort_{{ $option }}"
                                class="block w-full px-4 py-2 text-lg cursor-pointer hover:text-orange-ddteasy transition-all ease-in-out peer-checked:text-orange-ddteasy">
                                {{ $option->getLabel() }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-6 md:py-12">
        <form wire:submit="save">
            <div class="w-full flex flex-col md:flex-row gap-4">
                <div class="px-2 md:px-4 w-full">
                    <h1 class="text-2xl md:text-4xl text-orange-ddteasy font-bold text-center w-full">
                        Selecione a empresa
                    </h1>

                    <div
                        class="flex flex-row md:flex-col gap-6 py-10 px-2 md:px-4 h-fit overflow-scroll md:h-auto md:overflow-auto">
                        @error('form.service')
                            <h2 class="text-lg md:text-xl text-center text-red-500 font-bold py-8">{{ $message }}</h2>
                        @enderror

                        @if ($companies)

                            @if ($companies->isEmpty())
                                <h2 class="text-xl md:text-2xl text-violet-900 font-bold text-center w-full">
                                    Ops, não foram encontradas empresas com este perfil...
                                </h2>
                                <a href="{{ route('site.home') }}"
                                    class="bg-orange-ddteasy py-2 px-8 max-w-xs mx-auto text-white text-center transition ease-in-out hover:bg-violet-900 text-xl font-semibold">Ir
                                    para a Home</a>
                            @endif

                            @foreach ($companies as $company)
                                <div
                                    class="w-96 max-w-full shrink-0 grow-0 md:w-auto flex flex-col md:flex-row p-8 rounded-xl border shadow-lg transition-all ease-in-out">
                                    <img src="{{ $company->getFilamentAvatarUrl() ??
                                        "https://ui-avatars.com/api/?name={$company->fantasy_name}&background=4a1d96&color=f28a20&bold=true" }}"
                                        alt="{{ $company->fantasy_name }}"
                                        class="block mx-auto md:flex md:mx-0 rounded-full w-full max-w-[150px] h-fit !aspect-square" />

                                    <div class="flex flex-col w-full">
                                        <div class="p-4 flex flex-col md:flex-row w-full">
                                            <div class="w-full">
                                                <h2 class="text-xl md:text-2xl font-bold text-violet-900 w-full">
                                                    {{ $company->fantasy_name }}
                                                </h2>

                                                <div
                                                    class="flex flex-nowrap md:flex-col w-full md:w-auto justify-between md:gap-2 md:pt-1">
                                                    {{-- TODO: Imprimir média e quantidade de avaliações da empresa --}}
                                                    {{-- <div class="flex flex-col md:flex-row">
                                            <div class="flex">
                                                <i class="bi bi-star-fill text-yellow-400"></i>
                                                <i class="bi bi-star-fill text-yellow-400"></i>
                                                <i class="bi bi-star-fill text-yellow-400"></i>
                                                <i class="bi bi-star-fill text-yellow-400"></i>
                                                <i class="bi bi-star-fill text-yellow-400"></i>
                                            </div>

                                            <p class="text-sm font-medium text-gray-500 md:text-base md:ml-2">
                                                20 avaliações
                                            </p>
                                        </div> --}}

                                                    {{-- TODO: Botão ver perfil --}}
                                                    {{-- <button
                                            class="text-violet-900 font-semibold text-sm md:mr-auto md:text-base">
                                            <i class="bi bi-search"></i> Ver perfil
                                        </button> --}}
                                                </div>
                                            </div>

                                            <div class="pt-4 text-start md:text-end">
                                                <small
                                                    class="text-sm md:text-base font-semibold text-orange-ddteasy">R$</small>
                                                <p class="text-2xl md:text-4xl font-bold text-orange-ddteasy">
                                                    {{ number_format($company->companyServices->first()->daily_price / 100, 2, ',', '.') }}
                                                </p>
                                                <p class="text-gray-600 text-sm md:text-base">Por dia</p>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex justify-center md:justify-end" x-data="{ id: $id('service') }">
                                            <input type="radio" :id="id" wire:model="form.service"
                                                value="{{ $company->companyServices->first()->id }}"
                                                class="hidden peer">
                                            <label :for="id"
                                                class="px-6 py-2 cursor-pointer bg-orange-ddteasy text-white text-lg md:text-2xl font-semibold hover:bg-violet-900 transition-all ease-in-out peer-checked:bg-violet-900">
                                                Selecionar Empresa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2 class="text-xl md:text-2xl text-violet-900 font-bold text-center w-full">
                                Selecione uma data para mostrar as empresas disponíveis
                            </h2>
                        @endif
                    </div>
                </div>

                <div class="px-2 md:px-4 w-full">
                    <h1 class="text-2xl md:text-4xl text-orange-ddteasy font-bold text-center w-full">
                        Agende o seu serviço
                    </h1>

                    <div class="py-10 px-2 relative" x-data="{ calendar: null }" x-init="calendar = new VanillaCalendar($refs.calendar, {
                        type: 'default',
                        settings: {
                            lang: 'pt-BR',
                            iso8601: false,
                            selection: {
                                year: false
                            },
                            visibility: {
                                theme: 'light',
                            },
                        },
                        date: {
                            min: moment().format('YYYY-MM-DD'),
                            max: moment().add(90, 'days').format('YYYY-MM-DD')
                        },
                        actions: {
                            clickDay(event, dates) {
                                @this.set('form.date', dates[0])
                            }
                        }
                    })
                    
                    calendar.init();" wire:ignore>

                        <div x-ref="calendar"></div>

                        @error('form.date')
                            <span class="text-red font-semibold">{{ $message }}</span>
                        @enderror

                        <div class="flex flex-row flex-wrap w-full py-8 justify-evenly gap-x-4">
                            <div class="flex align-middle gap-2">
                                <div class="bg-violet-900 border border-slate-200 h-6 aspect-video"></div>
                                <span class="text-sm">Dia selecionado</span>
                            </div>
                            <div class="flex align-middle gap-2">
                                <div class="bg-white border border-slate-200 h-6 aspect-video"></div>
                                <span class="text-sm">Agendáveis</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 max-w-full" x-data="{ show: true }">
                            <div class="w-full">
                                <input type="text" wire:model="form.cep" x-ref="cep" x-mask="99999-999"
                                    placeholder="CEP"
                                    x-on:keyup="if($refs.cep.value.length === 9){ $dispatch('cep-filled') } else { $dispatch('cep-cleaned') }"
                                    class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out">
                                @error('form.cep')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <input type="text" placeholder="Endereço" class="w-full p-3 bg-gray-100"
                                    wire:model="address" disabled>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <input type="text" placeholder="Nº" wire:model="form.number"
                                    class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out">
                                <input type="text" placeholder="Complemento" wire:model="form.complement"
                                    class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out">
                            </div>

                            <div class="w-full">
                                <ul class="w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <li>
                                        <input type="radio" id="period_option" wire:model="form.period_type"
                                            value="period" class="hidden peer" checked="false"
                                            x-on:change="show = true; $dispatch('period_type-selected')" />
                                        <label for="period_option"
                                            class="h-full inline-flex items-center justify-between w-full p-5 text-violet-900 bg-white border cursor-pointer peer-checked:bg-orange-ddteasy peer-checked:border-white peer-checked:text-white hover:text-white hover:bg-violet-900 transition ease-in-out">
                                            <div>
                                                <h2 class="text-lg font-semibold">Período</h2>
                                                <span>Selecione entre os períodos manhã, tarde e noite</span>
                                            </div>
                                        </label>
                                    </li>

                                    <li>
                                        <input type="radio" id="hour_option" wire:model="form.period_type"
                                            value="hour" class="hidden peer" checked="false"
                                            x-on:change="show = false; $dispatch('period_type-selected')" />
                                        <label for="hour_option"
                                            class="h-full inline-flex items-center justify-between w-full p-5 text-violet-900 bg-white border cursor-pointer peer-checked:bg-orange-ddteasy peer-checked:border-white peer-checked:text-white hover:text-white hover:bg-violet-900 transition ease-in-out">
                                            <div>
                                                <h2 class="text-lg font-semibold">Hora marcada</h2>
                                                <span>Gera um acréscimo de xx% no valor do serviço</span>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>

                            <div class="w-full">
                                <template x-if="show">
                                    <select
                                        class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out"
                                        wire:model="form.period">
                                        @foreach (\App\Enums\ServicePeriods::cases() as $period)
                                            <option value="{{ $period->value }}">{{ $period->getLabel() }}</option>
                                        @endforeach
                                    </select>
                                </template>

                                <template x-if="!show">
                                    <select
                                        class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out"
                                        wire:model="form.hour">
                                        @foreach ($hours as $hour)
                                            <option value="{{ $hour['value'] }}">{{ $hour['label'] }}</option>
                                        @endforeach
                                    </select>
                                </template>
                            </div>

                            <div class="w-full">
                                <textarea placeholder="Observação" wire:model="form.observation"
                                    class="w-full p-3 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                ease-in-out"
                                    rows="6"></textarea>
                            </div>

                            <div class="w-full text-center">
                                <button type="submit"
                                    class="bg-orange-ddteasy py-2 w-3/4 text-white text-center transition ease-in-out hover:bg-violet-900 text-xl font-semibold">Avançar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
