<?php

namespace App\Filament\Resources\Grade;

use App\Filament\Resources\Grade\ValueResource\Pages;
use App\Filament\Resources\Grade\ValueResource\RelationManagers;
use App\Models\Grade\DetailValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ValueResource extends Resource
{
    protected static ?string $model = DetailValue::class;

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
                    ->relationship('person', 'name'),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->native(false)
                    ->hidden(fn ($get) => $get('person_id') == null)
                    ->relationship('category', 'name'),
                Forms\Components\TextInput::make('value_1')
                    ->label('Value 1')
                    ->required()
                    ->hidden(fn ($get) => $get('person_id') == null),
                Forms\Components\TextInput::make('value_2')
                    ->label('Value 2')
                    ->required()
                    ->hidden(fn ($get) => $get('person_id') == null),
                Forms\Components\TextInput::make('value_3')
                    ->label('Value 3')
                    ->required()
                    ->hidden(fn ($get) => $get('person_id') == null),
                Forms\Components\TextInput::make('value_4')
                    ->label('Value 4')
                    ->required()
                    ->hidden(fn ($get) => $get('person_id') == null),

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
