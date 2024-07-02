<?php

namespace App\Filament\Resources\Grade\CriteriaResource\Pages;

use App\Filament\Resources\Grade\CriteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCriterias extends ManageRecords
{
    protected static string $resource = CriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
