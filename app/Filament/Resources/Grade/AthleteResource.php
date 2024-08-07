<?php

namespace App\Filament\Resources\Grade;

use App\Filament\Resources\Grade\AthleteResource\Pages;
use App\Filament\Resources\Grade\AthleteResource\RelationManagers;
use App\Models\Grade\Athlete;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class AthleteResource extends Resource
{
    protected static ?string $model = Athlete::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $label = 'Athlete';

    protected static ?string $navigationGroup = 'Base';

    protected static ?string $navigationLabel = 'Athlete';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralLabel = 'Athlete';

    protected static ?string $pluralModelLabel = 'Athlete';

    protected static ?string $slug = 'base/athlete';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('athlete_name')
                    ->label('Athlete Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('athlete_code')
                    ->label('Athlete Code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_entry')
                    ->label('Date of Entry')
                    ->required()
                    ->native(false)
                    ,
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Date of Birth')
                    ->required()
                    ->native(false)
                    ,
                Forms\Components\TextInput::make('long_time')
                    ->label('Long Time')
                    ->numeric()
                    ->suffix('years')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cabor')
                    ->label('Cabor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->extraHeaderAttributes([
                        'class' => 'w-10',
                    ])
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('athlete_name')
                    ->label('Athlete Name')
                    ->wrap()
                    ->formatStateUsing(fn (Model $record, ?string $state) => new HtmlString(<<<BLADE
                        <div>
                            $state
                        </div>
                        <div class="text-sm text-gray-500">{$record->athlete_code}</div>
                    BLADE))
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_entry')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('long_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cabor')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),]),
                Tables\Actions\Action::make('selection')
                    ->tooltip('Selection Athlete')
                    ->form(function ($record) {
                        
                    })
                    // ->url(fn ($record) => \App\Filament\Pages\Athlete\Selection::getUrl())
                    ->slideOver()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAthletes::route('/'),
            'create' => Pages\CreateAthlete::route('/create'),
            'edit' => Pages\EditAthlete::route('/{record}/edit'),
        ];
    }
}
