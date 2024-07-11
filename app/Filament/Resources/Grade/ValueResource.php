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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ValueResource extends Resource
{
    protected static ?string $model = Value::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Value';

    protected static ?string $navigationGroup = 'Grade';

    protected static ?string $navigationLabel = 'Value';

    protected static ?int $navigationSort = 3;

    protected static ?string $pluralLabel = 'Value';

    protected static ?string $pluralModelLabel = 'Value';

    protected static ?string $slug = 'grade/value';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('person_id')
                    ->label('Person')
                    ->required()
                    ->live()
                    ->native(false)
                    ->columnSpanFull()
                    ->relationship('person', 'athlete_name'),
                Forms\Components\Select::make('criteria_id')
                    ->label('Criteria')
                    ->required()
                    ->native(false)
                    ->options(Criteria::query()->pluck('criteria_name', 'id')),
                Forms\Components\TextInput::make('real_value')
                    ->label('Nilai Real')
                    ->required(),
                
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
                //
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageValues::route('/'),
        ];
    }
}
