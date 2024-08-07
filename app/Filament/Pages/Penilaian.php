<?php

namespace App\Filament\Pages;

use App\Models\Grade\Criteria;
use App\Models\Grade\Value;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables;
use Filament\Tables\Table;


class Penilaian extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static string $view = 'filament.pages.penilaian';

    protected static ?string $navigationLabel = 'Rank';

    protected static ?string $title = 'Rank';

    protected static ?string $slug = 'rank';


    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Value::query())
            ->columns([
                TextColumn::make('person.athlete_name')
                    ->label('Nama')    
                    ->searchable()
                    ->sortable(),
                TextColumn::make('real_value')
            ]);
    }
    public function penilaianAction(): Action
    {
        return Action::make('penilaian')
            ->label('Penilaian')
            ->action(function () {


                // Criteria
                $kriteria = Criteria::whereNull('parent_id')->orderBy('priority')->get();

                // Sub Criteria
                $subCriteria = Criteria::whereNotNull('parent_id')->orderBy('priority')->get();

                $groupedSubCriteria = $subCriteria->groupBy('parent_id')->map(function ($group) {
                    return $group->groupBy('priority');
                });

                // Menampilkan hasil bobot yang sudah tersimpan
                dd($kriteria->toArray(), $groupedSubCriteria->toArray());
            });

                // Criteria
                // $kriteria = Criteria::whereNull('parent_id')->orderBy('priority')->get();
                // $bobotKriteria = [];
                // $totalKriteria = $kriteria->count();


                // foreach($kriteria as $k) {
                //     $bobot = 0;

                //     foreach(range(1, $totalKriteria) as $value) {
                //         if($k->priority <= $value) {
                //             $bobot += 1/$value;
                //         }
                //     }

                //     $bobotKriteria[] = [
                //         'criteria_name' => $k->criteria_name,
                //         'priority' => $k->priority,
                //         'bobot' => $bobot/$totalKriteria
                //     ];
                // }


                // Sub Criteria

            //     $subCriteria = Criteria::whereNotNull('parent_id')->orderBy('priority')->get();
            //     $bobotSubCriteria = [];
            //     $totalSubCriteria = $subCriteria->count();

            //     $groupedSubCriteria = $subCriteria->groupBy('parent_id')->map(function ($group) {
            //         return $group->groupBy('priority');
            //     });

            //     foreach ($groupedSubCriteria as $parent_id => $group) {
            //         $totalSubCriteria = $group->flatten()->count();

            //         foreach ($group as $priority => $items) {
            //             foreach ($items as $s) {
            //                 $bobot = 0;
            //                 foreach (range(1, $totalSubCriteria) as $value) {
            //                     if ($s->priority <= $value) {
            //                         $bobot += 1 / $value;
            //                     }
            //                 }
            //                 $bobotSubCriteria[] = [
            //                     'criteria_name' => $s->criteria_name,
            //                     'priority' => $s->priority,
            //                     'bobot' => $bobot / $totalSubCriteria
            //                 ];
            //             }
            //         }
            //     }

            //      dd($bobotSubCriteria);
            // });
    }
}
