@php
    use App\Models\Grade\Criteria;

    $criteriaList = Criteria::whereNull('parent_id')->orderBy('priority')->get();
    $subCriteriaList = Criteria::whereNotNull('parent_id')->orderBy('priority')->get()->groupBy('parent_id');
@endphp
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
                            @if ($subCriteria->count() > 0)
                                @php
                                    $firstSubCriteria = $subCriteria->first();
                                @endphp
                                <td class="px-3 py-2">{{ $firstSubCriteria->criteria_name }}</td>
                                <td class="px-3 py-2">{{ $firstSubCriteria->bobot }}</td>
                                <td class="px-3 py-2">{{ round($criteria->bobot * $firstSubCriteria->bobot, 3) }}</td>
                                <td class="px-3 py-2 w-32">
                                    <livewire:real-value-input :criteria-id="$firstSubCriteria->id" />
                                </td>
                                <td class="px-3 py-2">Hasil</td>
                                <td class="px-3 py-2">Rank</td>
                            @else
                                <td class="px-3 py-2" colspan="5"></td>
                            @endif
                        </tr>
                        @if ($subCriteria->count() > 1)
                            @foreach ($subCriteria->slice(1) as $sub)
                                <tr class="divide-x divide-gray-950/5 dark:divide-white/10">
                                    <td class="px-3 py-2">{{ $sub->criteria_name }}</td>
                                    <td class="px-3 py-2">{{ $sub->bobot }}</td>
                                    <td class="px-3 py-2">{{ round($criteria->bobot * $sub->bobot, 3) }}</td>
                                    <td class="px-3 py-2 w-32">
                                        <livewire:real-value-input :criteria-id="$sub->id" />
                                    </td>
                                    <td class="px-3 py-2">{{</td>
                                    <td class="px-3 py-2">Rank</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>