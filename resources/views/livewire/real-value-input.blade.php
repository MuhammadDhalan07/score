<div>
    <x-filament::input.wrapper>
            <x-filament::input
                type="number"
                wire:model.debounce.500ms="realValue"
                wire:blur="saveRealValue"
                class="block w-full"
            />
        
    </x-filament::input.wrapper>
</div>
