<?php

namespace App\Filament\Resources\SmarterResource\Pages;

use App\Exports\Rank;
use App\Filament\Resources\SmarterResource;
use App\Models\Grade\Athlete;
use App\Models\Grade\Value;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSmarters extends ManageRecords
{
    protected static string $resource = SmarterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export')
                ->icon('fileicon-microsoft-excel')
                ->action(function () {
                    // Ambil data menggunakan logika yang sama dengan di SmartResource
                    $athletes = Value::with('person')
                        ->whereHas('person', function ($query) {
                        })
                        ->get();

                    return app(Rank::class)->setUp($athletes)->download('Laporan.xlsx');
                })
        ];
    }
}

