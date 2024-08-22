<div>
    <header class="fi-simple-header py-8">
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            {{ $this->getNavigationLabel() }}
        </h1>
        <p class="fi-simple-header-subheading mt-2 text-left text-sm text-gray-500 dark:text-gray-400">
            {{ $this->getSubheading() }}
        </p>
    </header>

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="pb-4">
            <x-filament-panels::form.actions 
            :actions="$this->getFormActions()"
            :full-width="$this->hasFullWidthFormActions()" 
            :alignment="$this->getFormActionsAlignment()" />
        </div>
    </x-filament-panels::form>
</div>