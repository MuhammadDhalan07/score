<?php

namespace App\Filament\Resources\SmarterResource\Pages;

use App\Filament\Resources\SmarterResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSmarters extends ManageRecords
{
    protected static string $resource = SmarterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
