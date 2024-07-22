@php
    use App\Models\Grade\Criteria;
    use App\Models\Grade\Value;
    use App\Models\Grade\Athlete;

    $criteriaList = Criteria::whereNull('parent_id')->orderBy('priority')->get();
    $subCriteriaList = Criteria::whereNotNull('parent_id')->orderBy('priority')->get()->groupBy('parent_id');
    $personId = Value::query()->pluck('person_id')->first(); 

    $athlete = Athlete::query()->where('id', $personId)->first();
    // dd($athlete);
@endphp
<div>
    <div class="bg-white shadow-sm fi-section rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <table class="tabel w-full text-sm border-collapse">
            <tbody class="divide-y divide-gray-950/5 dark:divide-white/10">
                @if ($athlete)
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2">Name</td>
                        <td class="px-3 py-2">
                            <span class="text-xs text-gray-400">{{ $athlete->athlete_code }}</span>
                            {{ $athlete->athlete_name }}
                        </td>
                    </tr>
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2">CABOR</td>
                        <td class="px-3 py-2">{{ $athlete->cabor }}</td>
                    </tr>
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2">Date of Entry</td>
                        <td class="px-3 py-2">{{ $athlete->date_of_entry }}</td>
                    </tr>
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2">Long Time</td>
                        <td class="px-3 py-2">{{ $athlete->long_time }}</td>
                    </tr>
                @else
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2" colspan="2">No athlete found with the given ID.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div>
    <div class="bg-white shadow-sm fi-section rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <table class="table w-full text-sm border-collapse">
            <thead>
                <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Kriteria</th>
                    <th class="px-3 py-2">Bobot</th>
                    <th class="px-3 py-2">Sub Kriteria</th>
                    <th class="px-3 py-2">Bobot</th>
                    <th class="px-3 py-2">Nilai Utility</th>
                    <th class="px-3 py-2">Nilai Real</th>
                    <th class="px-3 py-2">Hasil</th>
                    <th class="px-3 py-2">Rank</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-950/5 dark:divide-white/10">
                @foreach ($criteriaList as $key => $criteria)
                    @php
                        $subCriteria = $subCriteriaList[$criteria->id] ?? collect();
                        $rowspan = $subCriteria->count() > 0 ? $subCriteria->count() : 1;
                    @endphp
                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                        <td class="px-3 py-2" rowspan="{{ $rowspan }}">{{ $key + 1 }}</td>
                        <td class="px-3 py-2" rowspan="{{ $rowspan }}">{{ $criteria->criteria_name }}</td>
                        <td class="px-3 py-2" rowspan="{{ $rowspan }}">{{ $criteria->bobot }}</td>
                        @if ($subCriteria->isNotEmpty())
                            @foreach ($subCriteria as $subKey => $sub)
                                @if ($subKey == 0)
                                    <td class="px-3 py-2">{{ $sub->criteria_name }}</td>
                                    <td class="px-3 py-2">{{ $sub->bobot }}</td>
                                    <td class="px-3 py-2">{{ round($criteria->bobot * $sub->bobot, 3) }}</td>
                                    <td class="px-3 py-2 w-32">
                                        <livewire:real-value-input :criteria-id="$sub->id" :person-id="$personId" /> 
                                    </td>
                                    <td class="px-3 py-2">Hasil</td>
                                    <td class="px-3 py-2">Rank</td>
                                @else
                                    <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                                        <td class="px-3 py-2">{{ $sub->criteria_name }}</td>
                                        <td class="px-3 py-2">{{ $sub->bobot }}</td>
                                        <td class="px-3 py-2">{{ round($criteria->bobot * $sub->bobot, 3) }}</td>
                                        <td class="px-3 py-2 w-32">
                                            <livewire:real-value-input :criteria-id="$sub->id" :person-id="$personId" />
                                        </td>
                                        <td class="px-3 py-2"></td>
                                        <td class="px-3 py-2">Rank</td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <td class="px-3 py-2" colspan="5"></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
