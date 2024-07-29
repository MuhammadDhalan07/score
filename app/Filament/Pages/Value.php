<?php

namespace App\Filament\Pages;

use App\Models\Grade\Athlete;
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
use Livewire\Attributes\On;
use Livewire\Component;

class Value extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'SMARTER';

    protected static ?string $slug = '/smarter';

    protected static string $view = 'filament.pages.value';

    public $realValues = [];

    public $criteria;

    public $value;

    public $selectedAthlete;

    public $realValueInput = [];
    
    public $manyRealValue = [];

    #[On('refresh-tabel')]
    public function refreshTable()
    {
        $this->mount();
    }

    #[On('saveRealValue')]
    public function saveRealValue()
    {
        $input = $this->validate([
            'realValueInput.*' => 'numeric|string',
        ]);

        foreach ($input['realValueInput'] ?? [] as $key => $value) {
            [
                $criteriaId,
                $personId,
            ] = explode('-', $key);

            $value = GradeValue::updateOrCreate(
                [
                    'criteria_id' => $criteriaId, 
                    'person_id' => $personId
                ],
                [
                    'real_value' => $value
                ]
            );
        }
    }

    public function mount()
    {
        
    }

    public function updatedSelectedAthlete()
    {
        $this->dispatchBrowserEvent('update-table');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => 
                Criteria::query()->with([
                    'value',
                    'sub.value.person',
                    'sub.parent.value.person',
                ])->whereNull('parent_id')
            )
            ->content(view('filament.pages.tables.value-table'))
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->options(fn() => Athlete::pluck('athlete_name', 'id'))
                    ->query(fn($data, $query) => $query->when($data['value'], fn($q, $athleteId) => 
                        $q->whereHas('value', fn($q) => $q->where('person_id', $athleteId))
                            ->orWhereHas('sub.value', fn($q) => $q->where('person_id', $athleteId))
                    ))
                    ->label('Athlete')
                    ->preload()
                    ->columnSpanFull()
                    ->native(false)
                    ->default(fn () => null),
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
