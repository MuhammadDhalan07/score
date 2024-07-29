<div>
    <div class="bg-white shadow-sm fi-section rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <table class="table w-full text-sm border-collapse">
            <thead>
                <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Kriteria</th>
                    <th class="px-3 py-2">Bobot</th>
                    <th class="px-3 py-2">Nilai Utility</th>
                    <th class="px-3 py-2">Nilai Real</th>
                    <th class="px-3 py-2">Hasil</th>
                    <th class="px-3 py-2">Rank</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-950/5 dark:divide-white/10">
                @foreach ($records as $key => $criteria)
                <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                    <td class="px-3 py-2">{{ $key + 1 }}</td>
                    <td class="px-3 py-2">{{ $criteria->criteria_name }}</td>
                    <td class="px-3 py-2">{{ $criteria->bobot }}</td>
                    @foreach ($criteria->sub as $sub)
                        @php
                            $personId = data_get($sub->value, '0.person.id');
                            $key = sprintf('%s-%s', $sub->id, $personId);
                            $inputValue = $sub->value()->where('person_id', $personId)->first()?->real_value;
                            $utility = round($criteria->bobot * $sub->bobot, 3);
                            $real = round($utility * $criteria->real_value, 3);
                            $this->realValueInput[$sub->id . '-' . $personId] = $inputValue;
                        @endphp

                        <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                            <td></td>
                            <td class="px-3 py-2">{{ $sub->criteria_name }}</td>
                            <td class="px-3 py-2">{{ $sub->bobot }}</td>
                            <td class="px-3 py-2">{{ round($criteria->bobot * $sub->bobot, 3) }}</td>
                            <td class="w-32 px-3 py-2">
                                @foreach ($sub->value as $item)
                                @php
                                    $this->manyRealValue[$item->person_id] = $item->real_value;
                                @endphp
                                    <x-filament::input
                                        type="number"
                                        wire:model="manyRealValue.{{ $item->person_id }}"
                                        wire:blur="saveRealValue"
                                        class="block w-full"
                                    />
                                @endforeach
                            </td>
                            <td class="px-3 py-2">
                                {{ $criteria->real_value}} - 
                                {{ $real }}
                            </td>
                        </tr>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

