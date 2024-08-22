<div>
    <livewire:web.components.header title="Área do Cliente" />
    <div class="w-full flex flex-col md:flex-row">
        <div class="p-4 md:p-8 shadow-md w-full md:w-1/4">
            <livewire:web.components.profile.sidebar route="" />
        </div>
        <div class="w-full p-4 md:p-8">
            <div class="w-full">
                <h2 class="text-3xl md:text-4xl font-poppins font-bold">Adicionar Cartão</h2>
                <h3 class="text-md md:text-lg text-gray-500">Adicione um novo cartão como forma de pagamento</h3>
            </div>

            <div class="w-full flex flex-col md:flex-row">
                <form wire:submit="save" class="max-w-screen-sm py-4">
                    <div class="flex flex-col gap-y-4">
                        <div class="w-full">
                            <label for="number">Número*</label>
                            <input wire:model.lazy="form.number" x-mask="9999 9999 9999 9999" id="number" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                            $errors->has('form.number')]) type="text" placeholder="Número do cartão" />
                            @error('form.number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="holder_name">Nome*</label>
                            <input wire:model.lazy="form.holder_name" id="holder_name" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                            $errors->has('form.holder_name')]) type="text" placeholder="Nome" />
                            @error('form.holder_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label for="exp_month">Mês*</label>
                                <select wire:model="form.exp_month" id="exp_month" @class(['w-full
                                    focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all
                                    ease-in-out', 'border-red-500'=> $errors->has('form.exp_month')])>
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                                @error('form.exp_month')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label for="exp_year">Ano*</label>
                                <select wire:model="form.exp_year" id="exp_year" @class(['w-full focus:border-orange-ddteasy
                                    focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                                    $errors->has('form.exp_year')])>
                                    @for ($i = date('Y'); $i <= date('Y', strtotime('+20 years')); $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                                @error('form.exp_year')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label for="cvv">CVV*</label>
                                <input wire:model.lazy="form.cvv" x-mask="9999" id="cvv" @class(['w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out', 'border-red-500'=>
                                $errors->has('form.cvv')]) type="text" placeholder="CVV" />
                                @error('form.cvv')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex">
                                <button class="ms-auto mt-auto text-lg font-semibold text-white py-2 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/80 transition-all ease-in-out">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="w-full flex justify-center items-center">

                    <div class="rounded-xl bg-purple-900 text-white flex flex-col justify-end items-start p-4 font-poppins aspect-video w-full max-w-lg">
                        <div class="mb-4">
                            <span class="font-semibold text-sm">Nº do cartão:</span>
                            <h3 class="h-7 text-xl font-bold" x-text="$wire.form.number"></h3>
                        </div>

                        <div class="mb-4">
                            <span class="font-semibold text-sm">CVV:</span>
                            <h3 class="h-7 text-lg font-bold" x-text="$wire.form.cvv"></h3>
                        </div>

                        <div class="flex justify-between w-full">
                            <div>
                                <span class="font-semibold text-sm">Titular:</span>
                                <h3 class="h-7 text-lg font-bold" x-text="$wire.form.holder_name"></h3>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-sm">Validade:</span>
                                <h3 class="h-7 text-lg font-bold"><span x-text="$wire.form.exp_month"></span>/<span x-text="$wire.form.exp_year"></span></h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>