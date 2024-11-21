<div class="bg-white font-poppins mx-auto">
    <form wire:submit="save" class="w-full">
        <div class="flex flex-wrap w-full gap-2" x-data="{show: $refs.property_type.value === 'apartament'}">
            <div class="w-full">
                <div x-data="{ choices: null }" x-init="
                    choices = new Choices($refs.plagues, {
                        allowHTML: false,
                        itemSelectText: '',
                        noChoicesText: 'Não há mais opções.',
                        removeItemButton: true,
                        classNames: {
                            containerInner: 'choices__inner !bg-transparent !border-violet-900 !rounded-none',
                            inputCloned: 'choices__input--cloned !bg-transparent focus:!ring-0 !text-lg',
                            item: 'choices__item !bg-orange-ddteasy !border-none',
                            itemChoice: 'choices__item--choice !bg-transparent hover:!bg-violet-900 hover:!text-white !transition !duration-100 !ease-in-out',
                            button: 'choices__button !border-0 !m-0',
                        }
                    });
                    choices.passedElement.element.addEventListener('change', function (event) {
                            values = getSelectValues($refs.plagues);
                            @this.set('form.plagues', values);
                        }, false);

                    items = [];
                    if(Array.isArray(items)){
                        items.forEach(function(select) {
                            choices.setChoiceByValue((select).toString());
                        });
                    }
                    
                    function getSelectValues(select) {
                        var result = [];
                        var options = select && select.options;
                        var opt;
                        for (var i = 0; i < options.length; i++) {
                            opt = options[i];
                            if (opt.selected) {
                                result.push(opt.value || opt.text);
                            }
                        }
                        return result;
                    }
                    " wire:ignore>
                    <select x-ref="plagues" multiple>
                        <option value="">Pragas</option>
                        @foreach ($plagues as $plague)
                        <option value="{{ $plague->slug }}">{{ $plague->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('form.plagues') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="w-full">
                <select wire:model='form.property_type' x-ref="property_type"
                    x-on:change="show = ($refs.property_type.value === 'apartament'); $dispatch('property_type-selected')"
                    class="w-full border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out">
                    @foreach (\App\Enums\PropertyTypes::cases() as $item)
                    <option value="{{ $item->value }}">{{ $item->getLabel() }}</option>
                    @endforeach
                </select>
                @error('form.property_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="w-full">
                <template x-if="show">
                    <select wire:model='form.rooms'
                        class="w-full border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out">
                        @for ($i = 1; $i <= 4; $i++) <option value="{{ $i }}">{{ $i }} Quarto(s)</option>
                            @endfor
                    </select>
                </template>
                
                <template x-if="!show">
                    <select wire:model='form.range'
                        class="w-full border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out">
                        @foreach (\App\Enums\HouseRanges::cases() as $item)
                        <option value="{{ $item->value }}">{{ $item->getLabel() }}</option>
                        @endforeach
                    </select>
                    
                </template>
                @error('form.rooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('form.range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="w-full flex flex-col">
                <input type="text" wire:model="form.cep" id="cep" x-ref="cep" x-mask="99999-999" placeholder="CEP"
                    x-on:keyup="if($refs.cep.value.length === 9){ $dispatch('cep-filled') } else if($refs.cep.value.length === 0){ $dispatch('cep-cleaned') }"
                    class="w-full border-violet-900 focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out">
                @error('form.cep')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <span class="text-sm text-slate-500" x-ref="address">{{ $address }}</span>
            </div>

            <div class="w-full">
                <button type="submit" @class(["w-full text-white text-center text-xl py-3 transition ease-in-out",
                    $address ? 'bg-orange-ddteasy hover:bg-orange-ddteasy/80' : 'bg-orange-ddteasy/70' ])
                    @disabled(!$address)>BUSCAR</button>
            </div>
        </div>
    </form>
    
<div x-data="{ open: @entangle('noSellersModal') }" x-show="open"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded shadow-md max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Estamos Expandindo!</h2>
        <p class="text-gray-600 mb-4">
            Não temos prestadores disponíveis para o CEP: <span class="font-bold">{{ $modalCep }}</span>.
        </p>
        <p class="text-gray-600 mb-4">
            Deixe seus dados abaixo e entraremos em contato quando houver cobertura na sua região.
        </p>
        <form wire:submit.prevent="saveContact" class="flex flex-col gap-3">
            <input type="text" wire:model.defer="contact.name" placeholder="Nome" required class="p-3 border rounded w-full" />
            @error('contact.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <input type="email" wire:model.defer="contact.email" placeholder="E-mail" required class="p-3 border rounded w-full" />
            @error('contact.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <input type="tel" wire:model.defer="contact.phone" placeholder="Telefone" required class="p-3 border rounded w-full" />
            @error('contact.phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="w-full bg-violet-900 text-white py-2 rounded mt-3 hover:bg-violet-800">Enviar</button>
        </form>
        <button @click="open = false" class="mt-4 text-red-500">Fechar</button>
    </div>
</div>



<div x-data="{ open: @entangle('noSellersModal2') }" x-show="open"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-green-200 p-6 rounded shadow-md max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Sucesso!</h2>
        <p class="text-gray-600 mb-4">{{ session('success') }}</p>
        <button @click="open = false" class="mt-4 text-red-500">Fechar</button>
    </div>
</div>

</div>
