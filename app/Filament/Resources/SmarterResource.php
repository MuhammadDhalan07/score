<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmarterResource\Pages;
use App\Filament\Resources\SmarterResource\RelationManagers;
use App\Models\Grade\Athlete;
use App\Models\Grade\Criteria;
use App\Models\Grade\Value;
use Awcodes\TableRepeater\Components\TableRepeater;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SmarterResource extends Resource
{
    protected static ?string $model = Athlete::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $breadcrumb = 'smarter';

    protected static ?string $slug = 'smarter';

    protected static ?string $pluralModelLabel = 'Smarter';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('athlete_name'),
                TextColumn::make('cabor')
                    ->label('Cabang Olahraga'),
                TextColumn::make('rank')
                    ->label('Rank')
                    ->formatStateUsing(fn(Model $record) => 
                        match (true) {
                            // $record->valueAll->sum('rank') >= 75 => sprintf('A(%s)', number_format($record->valueAll->sum('rank'), 2)),
                            $record->valueAll->sum('rank') >= 75 => sprintf('%s', number_format($record->valueAll->sum('rank'), 2)),
                            $record->valueAll->sum('rank') >= 50 => sprintf('%s', number_format($record->valueAll->sum('rank'), 2)),
                            $record->valueAll->sum('rank') >= 25 => sprintf('%s', number_format($record->valueAll->sum('rank'), 2)),
                            $record->valueAll->sum('rank') >= 0 => sprintf('%s', number_format($record->valueAll->sum('rank'), 2)),
                        }
                    )
                    ->default(0)
                    ,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('value')
                    ->label(false)
                    ->icon('heroicon-o-document-text')
                    ->tooltip('Input Criteria')
                    ->slideOver()
                    ->form(function(Form $form, Model $record) {
                        $schema = [];
                        $listInduk = Criteria::whereNull('parent_id')->with([
                            'sub.parent',
                            'sub.valueOne' => fn($q) => $q->where('person_id', $record->id),
                        ])->get();
                        foreach ($listInduk as $item) {
                            $default = $item->sub->transform(fn($item) => [
                                'person_id' => $record->id,
                                'criteria_id' => $item->id,
                                'criteria_name' => $item->criteria_name,
                                'bobot' => $item->bobot,
                                'nilai_utility' => $item->bobot * $item->parent->bobot,
                                'nilai_real' => $item->valueOne?->real_value ?? 0,
                                'hasil' => ($item->bobot * $item->parent->bobot) * $item->valueOne?->real_value ?? 0,
                            ]);
                            $schema[] = Repeater::make($item->id)
                            ->label('Kriteria '.$item->criteria_name)
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Hidden::make('person_id')->default($record->id),
                                        Hidden::make('criteria_id'),
                                        TextInput::make('criteria_name')
                                            ->readOnly(),
                                        TextInput::make('bobot')
                                            ->readOnly(),
                                        TextInput::make('nilai_real')
                                            ->live(onBlur: true)
                                            ->numeric()
                                            ->afterStateUpdated(function ($state, $old, Get $get, Set $set) {
                                                $set('hasil', $state * $get('nilai_utility'));
                                            }),
                                        TextInput::make('hasil')
                                            ->readOnly(),
                                    ])
                            ])
                            ->default($default)
                            ->deletable(false)
                            ->reorderable(false)
                            ->addable(false);
                        }
                        $form->schema($schema);
                        return $form;
                    })
                    ->action(function(Model $record, array $data) {
                        foreach ($data ?? [] as $indukCriteriaId => $listSub) {
                            foreach ($listSub as $item) {
                                Value::updateOrCreate([
                                    'person_id' => $item['person_id'],
                                    'criteria_id' => $item['criteria_id'],
                                ], [
                                    'real_value' => $item['nilai_real'],
                                    'rank' => $item['hasil']
                                ]);
                            }
                        }
                        Notification::make()
                            ->title('Success')
                            ->body('Nilai Berhasil Disimpan')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSmarters::route('/'),
        ];
    }
}
