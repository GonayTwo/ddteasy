<form wire:submit="update" class="w-full flex flex-col gap-4 font-poppins">
    <div>
        <label for="cpf">CPF:</label>
        <input wire:model.live="form.cpf" id="cpf" @class([
            'w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out',
            'border-red-500' => $errors->has('form.cpf'),
        ]) type="text" x-mask="999.999.999-99"
            placeholder="999.999.999-99" />
        @error('form.cpf')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="birth_date">Data de nascimento:</label>
        <input type="date" wire:model.live="form.birth_date" id="birth_date" @class([
            'w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out',
            'border-red-500' => $errors->has('form.birth_date'),
        ])>
        @error('form.birth_date')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="phone">Telefone:</label>
        <input type="text" wire:model.live="form.phone" id="phone" x-mask="(99) 99999-9999"
            @class([
                'w-full focus:border-orange-ddteasy focus:ring-orange-ddteasy transition-all ease-in-out',
                'border-red-500' => $errors->has('form.phone'),
            ]) placeholder="(99) 99999-9999">
        @error('form.phone')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <span class="mb-2">Métodos de Contato:</span>
        <div class="flex flex-row flex-wrap w-full justify-start gap-4">
            @foreach (\App\Enums\ContactMethods::cases() as $item)
                <div class="max-w-fit flex gap-2 items-center">
                    <input type="checkbox" id="contact_{{ $item->value }}" value="{{ $item->value }}"
                        wire:model.live="form.contact_methods" @class([
                            'w-4 h-4 rounded focus:border-0 ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out cursor-pointer',
                            'border-red-500' => $errors->has('form.contact_methods'),
                        ])>
                    <label for="contact_{{ $item->value }}"
                        class="text-gray-600 duration-300 hover:text-orange-ddteasy text-sm transition-all ease-in-out cursor-pointer">
                        {{ $item->getLabel() }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.contact_methods')
            <div class="flex">
                <span class="mx-auto text-red-500 text-sm">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <div>
        <span>Termos de Uso e Política de Privacidade:</span>
        <div class="max-w-fit flex gap-2 items-center">
            <input type="checkbox" wire:model.live="form.consent" @class([
                'w-4 h-4 rounded focus:border-0 ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out cursor-pointer',
                'border-red-500' => $errors->has('form.consent'),
            ])>
            <label class="text-gray-600 text-sm">
                Li e concordo com os
                <a href="{{ route('site.terms-of-use') }}" target="_blank"
                    class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                    Termos de Uso
                </a>,
                <a href="{{ route('site.privacy-policy') }}" target="_blank"
                    class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                    Políticas de Privacidade
                </a>
                e
                <a href="{{ route('site.service-contract') }}" target="_blank"
                    class="text-orange-ddteasy font-semibold hover:text-violet-900 transition-all ease-in-out">
                    Contrato de Serviço
                </a>
            </label>
        </div>
        @error('form.consent')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <span>Marketing:</span>
        <div class="max-w-fit flex gap-2 items-center">
            <input type="checkbox" wire:model.live="form.newsletter"
                class="w-4 h-4 rounded focus:border-0
                ring-offset-0 checked:bg-violet-900 focus:ring-violet-900 transition-all ease-in-out
                cursor-pointer">
            <label class="text-gray-600 text-sm">
                Aceito receber atualizações de marketing por e-mail
            </label>
        </div>
    </div>

    <div class="w-full text-right">
        <button
            class="text-lg font-bold text-white py-2 px-8 bg-orange-ddteasy hover:bg-orange-ddteasy/90 transition-all ease-in-out">Atualizar</button>
    </div>
</form>
