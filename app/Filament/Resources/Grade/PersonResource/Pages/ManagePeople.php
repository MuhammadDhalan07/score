<?php

namespace App\Filament\Resources\Grade\PersonResource\Pages;

use App\Filament\Resources\Grade\PersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePeople extends ManageRecords
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
