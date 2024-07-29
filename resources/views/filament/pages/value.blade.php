<x-filament-panels::page>
    {{-- <div> --}}
        {{-- <x-filament::input.wrapper> --}}
            {{-- <x-filament::select --}}
                {{-- wire:model="selectedAthlete" --}}
                {{-- placeholder="Select an Athlete" --}}
                {{-- :options="$this->criteria->pluck('athlete_name', 'id')" --}}
            {{-- /> --}}
        {{-- </x-filament::input.wrapper> --}}
    {{-- </div> --}}
    {{$this->table}}
</x-filament-panels::page>
