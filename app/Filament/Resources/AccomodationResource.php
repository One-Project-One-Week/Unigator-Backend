<?php

namespace App\Filament\Resources;

use App\Enums\Accommodation\Type;
use App\Filament\Resources\AccomodationResource\Pages;
use App\Filament\Resources\AccomodationResource\RelationManagers;
use App\Models\Accomodation;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AccomodationResource extends Resource
{
    protected static ?string $model = Accomodation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('estimated_cost')
                    ->required()
                    ->numeric()
                    ->prefix('USD'),
                Select::make('type')
                    ->options(Type::class)
                    ->required()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('estimated_cost')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('USD '),
                TextColumn::make('type')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('university_id', Auth::user()->university->id);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccomodations::route('/'),
            'create' => Pages\CreateAccomodation::route('/create'),
            'edit' => Pages\EditAccomodation::route('/{record}/edit'),
        ];
    }
}