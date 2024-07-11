<?php

namespace App\Filament\Pages;

use App\Models\Grade\Criteria;
use App\Models\Grade\Value as GradeValue;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;

class Value extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.value';

    // protected static ?string $slug = 'value';

    public $criteria;

    public $value;

    public function __construct()
    {
        $this->criteria = Criteria::all();
        $this->value = GradeValue::all();
    }


    public function table(Table $table): Table
    {
        return $table 
            ->query(GradeValue::query())
            ->content(fn () => view('filament.pages.value'))
            ->filters([
                Tables\Filters\Filter::make('parent_id')
                    ->columnSpanFull()
                    ->form([
                        Select::make('parent_id')
                        ->relationship('person', 'athlete_name')
                        ->hiddenLabel()
                        ->searchable()
                        ->columnSpanFull()
                        ->prefix('Athlete')
                    ])
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent);
    }

    public function sumbit()
    {
        // $data = $this->form->getState();
// 
        // GradeValue::create($data);
// 
        // session()->flash('success', 'Data berhasil disimpan.');
// 
        // return redirect()->route('filament.pages.value');
    }
}
