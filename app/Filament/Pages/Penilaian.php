<?php

namespace App\Filament\Pages;

use App\Models\Grade\Criteria;
use Filament\Actions\Action;
use Filament\Pages\Page;

class Penilaian extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.penilaian';

    public function penilaianAction(): Action
    {
        return Action::make('penilaian')
            ->label('Penilaian')
            ->action(function () {
                $kriteria = Criteria::whereNull('parent_id')->orderBy('priority')->get();

                $bobotKriteria = [];

                $totalKriteria = $kriteria->count();

                foreach($kriteria as $k) {
                    $bobot = 0;

                    foreach(range(1, $totalKriteria) as $value) {
                        if($k->priority <= $value) {
                            $bobot += 1/$value;
                        }
                    }

                    $bobotKriteria[] = [
                        'criteria_name' => $k->criteria_name,
                        'priority' => $k->priority,
                        'bobot' => $bobot/$totalKriteria
                    ];
                }
                 dd($bobotKriteria);
            });
    }
}
