<div class="w-full flex flex-col">

    <livewire:web.components.header title="Ajuda" />

    <div class="text-center px-4">
        <h1 class="text-orange-ddteasy text-3xl md:text-4xl font-bold py-8 md:py-16">Perguntas Frequentes</h1>
        <input type="text" wire:model.live="search" placeholder="Digite aqui a sua dúvida"
            class="container border-1 border-violet-900 placeholder:text-violet-900/70 text-center text-base md:text-xl font-semibold py-2 md:py-6 rounded-full w-full focus:ring-0 focus:border-violet-900">
    </div>

    <div class="container mx-auto px-6 md:px-0">
        <livewire:web.components.faq.questions :$search lazy />
    </div>

    <livewire:web.components.contact title="Ainda possui alguma dúvida? Entre em contato" />
</div>