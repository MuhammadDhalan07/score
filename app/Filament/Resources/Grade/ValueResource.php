<?php

namespace App\Filament\Resources\Grade;

use App\Filament\Resources\Grade\ValueResource\Pages;
use App\Filament\Resources\Grade\ValueResource\RelationManagers;
use App\Models\Grade\Criteria;
use App\Models\Grade\Value;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ValueResource extends Resource
{
    protected static ?string $model = Value::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $label = 'Value';

    protected static ?string $navigationGroup = 'Setting';

    protected static ?string $navigationLabel = 'Pull Up Value';

    protected static ?int $navigationSort = 3;

    protected static ?string $pluralLabel = 'Pull Up Value';

    protected static ?string $pluralModelLabel = 'Pull Up Value';

    protected static ?string $slug = 'setting/pull-up-value';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('person_id')
                    ->label('Person')
                    ->required()
                    ->native(false)
                    ->columnSpanFull()
                    ->relationship('person', 'athlete_name', function ($query) {
                        $selectedPersonIds = Value::pluck('person_id')->toArray();
                        $query->whereNotIn('id', $selectedPersonIds);
                    }),
                // Forms\Components\Select::make('criteria_id')
                    // ->label('Criteria')
                    // ->required()
                    // ->columnSpanFull()
                    // ->native(false)
                    // ->options(Criteria::query()->whereNull('parent_id')->pluck('criteria_name', 'id'))
                    // ->multiple(),
                
// 
                // TableRepeater::make('detailsValue')
                //     ->relationship()
                //     ->hidden(fn ($get) => $get('person_id') == null)
                //     ->addActionLabel('Add Value')
                //     ->headers([
                //         Header::make('category_id')
                //             ->label('Category')
                //             ->markAsRequired(),
                //         Header::make('value')
                //             ->label('Value')
                //             ->markAsRequired(),
                //     ])
                //     ->schema([
                //         Forms\Components\Select::make('category_id')
                //             ->label('Category')
                //             ->required()
                //             ->native(false)
                //             ->options(Criteria::query()->pluck('name', 'id')),
                //         Forms\Components\TextInput::make('value_1')
                //             ->label('Value 1')
                //             ->required(),
                //     ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('person.athlete_name')
                    ->label('Person'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageValues::route('/'),
        ];
    }
}
