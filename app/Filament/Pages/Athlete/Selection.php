<?php

namespace App\Filament\Pages\Athlete;

use Filament\Pages\Page;

class Selection extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.athlete.selection';

    protected static bool $shouldRegisterNavigation = false;

}
