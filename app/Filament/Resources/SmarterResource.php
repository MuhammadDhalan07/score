<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmarterResource\Pages;
use App\Filament\Resources\SmarterResource\RelationManagers;
use App\Models\Grade\Athlete;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SmarterResource extends Resource
{
    protected static ?string $model = Athlete::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $breadcrumb = 'smarter';

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
                TextColumn::make('cabor'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('value')
                    ->slideOver()
                    ->form(fn(Form $form) => $form->schema([
                        
                    ]))
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
