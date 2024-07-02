<?php

namespace App\Filament\Resources\Grade;

use App\Filament\Resources\Grade\CriteriaResource\Pages;
use App\Filament\Resources\Grade\CriteriaResource\RelationManagers;
use App\Models\Grade\Criteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('criteria_name')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->option([
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                    ])
                    ->maxLength(255),
                Forms\Components\Select::make('quality')
                        ->label('Quality')
                        ->options([
                            'Kualitas Baik' => 'Kualitas Baik',
                        ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageCriterias::route('/'),
        ];
    }
}
