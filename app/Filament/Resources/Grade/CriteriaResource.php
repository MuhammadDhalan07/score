<?php

namespace App\Filament\Resources\Grade;

use App\Enums\Criteria\Priority;
use App\Filament\Resources\Grade\CriteriaResource\Pages;
use App\Filament\Resources\Grade\CriteriaResource\RelationManagers;
use App\Models\Grade\Criteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class CriteriaResource extends Resource
{
    protected static ?string $model = Criteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $label = 'Criteria';

    protected static ?string $navigationGroup = 'Grade';

    protected static ?string $navigationLabel = 'Criteria';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralLabel = 'Criteria';

    protected static ?string $pluralModelLabel = 'Criteria';

    protected static ?string $slug = 'grade/criteria';


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
                    ->orderBy('sort_hirarki');
        
                    return $query;
    }

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent, criteria_name',
                    fn (Builder $query, ?Model $record) => $query->whereNull('parent_id')->when($record, fn ($q) => $q->where('id', '<>', $record->id))->orderBy('sort'))
                    ->columnSpanFull()
                    ->inlineLabel()
                    ->native(false)
                    ->reactive(),
                Forms\Components\Select::make('priority')
                    ->options(Priority::class),
                Forms\Components\TextInput::make('quality')
                    ->label(fn (Get $get) => ($get('parent_id') ? 'Sub ' : ''). 'Criteria')
                    ->required()
                    ->inlineLabel()
                    ->columnSpanFull(),
                Forms\Components\Select::make('priority')
                    ->label('Priority')
                    ->required()
                    ->options(Priority::class)
                    ->inlineLabel()
                    ->columnSpanFull(),
    
    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('criteria_name')
                ->label('Criteria')
                ->formatStateUsing(function (?string $state, Model $record) {

                    if ($record->isParent()) {
                        $prefix = null;
                    } else {
                        $prefix = <<<'HTML'
                            <div class="font-medium">├─</div>
                        HTML;
                    }

                    return new HtmlString(<<<HTML
                        <div class="flex space-x-1">
                            {$prefix}
                            <div>$state</div>
                        </div>
                    HTML);
                })
                ->searchable('criteria'),
            Tables\Columns\TextColumn::make('priority')
                ->label('Priority')
                ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort')
            ->defaultSort('sort_hirarki');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCriterias::route('/'),
        ];
    }
}
