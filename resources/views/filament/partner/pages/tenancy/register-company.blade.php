<x-filament-panels::page.simple>
    <x-slot name="subheading">
        {{ $this->backAction }}
    </x-slot>
    <x-filament-panels::form wire:submit="register">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
            alignment="right"
        />
    </x-filament-panels::form>
</x-filament-panels::page.simple>
