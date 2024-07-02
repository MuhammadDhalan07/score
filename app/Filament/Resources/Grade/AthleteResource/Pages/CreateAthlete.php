<?php

namespace App\Filament\Resources\Grade\AthleteResource\Pages;

use App\Filament\Resources\Grade\AthleteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAthlete extends CreateRecord
{
    protected static string $resource = AthleteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}

