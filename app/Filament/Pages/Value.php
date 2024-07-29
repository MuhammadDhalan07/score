<?php

namespace App\Filament\Pages;

use App\Models\Grade\Criteria;
use App\Models\Grade\Value as GradeValue;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Livewire\Component;

class Value extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'SMARTER';

    protected static string $view = 'filament.pages.value';

    public $realValues = [];

    public $criteria;

    public $value;

    public $selectedAthlete;

    public function mount()
    {
        $this->criteria = Criteria::all();
        $this->value = GradeValue::all();
    }

    public function updatedSelectedAthlete()
    {
        $this->dispatchBrowserEvent('update-table');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => GradeValue::query())
            ->content(view('filament.pages.tables.value-table'))
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->relationship('person', 'athlete_name', fn($query) => $query->has('value'))
                    ->label('Athlete')
                    ->preload()
                    ->columnSpanFull()
                    ->native(false)
                    ->default(fn (): ?string => request('parent_id')),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent);
    }

    public function save(): Action
    {
        return Action::make('save')
            ->label('Save')
            ->requiresConfirmation()
            ->icon('heroicon-o-arrow-down-tray')
            ->tooltip('Save Changes')
            ->action(function () {
                $this->validate();
                
                Notification::make()
                ->title('Success')
                ->body('Changes Saved')
                ->success()
                ->color('success')
                ->send();
            });
    }
}
