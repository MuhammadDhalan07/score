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
                    $athletes = Value::with('person')->get();
                    return app(Rank::class)->setUp($athletes)->download('Laporan.xlsx');
                })
        ];
    }
}
