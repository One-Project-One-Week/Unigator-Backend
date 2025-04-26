<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Program;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Enums\Program\PaymentType;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProgramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->native(false),
                Repeater::make('detail')
                    ->label('Detail')
                    ->schema([
                        TextInput::make('year')
                            ->required(),
                        TextInput::make('tuition_fees')
                            ->required(),
                    ])
                    ->columns(2)
                    ->defaultItems(1)
                    ->collapsible()
                    ->addActionLabel('Add another year'),
                TextInput::make('degree_type'),
                TextInput::make('duration')
                    ->required(),
                TagsInput::make('application_requirement'),
                TagsInput::make('intake')
                    ->label('Intake')
                    ->placeholder('Enter intake month')
                    ->required(),
                Select::make('payment_plan')
                    ->options(PaymentType::class)
                    ->required()
                    ->native(false),
                Select::make('level')
                    ->options([
                        'Undergraduate' => 'Undergraduate',
                        'Postgraduate' => 'Postgraduate',
                        'Doctorate' => 'Doctorate',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('average_cost')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('detail')
                    ->label('Years & Fees')
                    ->formatStateUsing(function ($state) {
                        if (is_string($state)) {
                            $state = '[' . $state . ']'; // wrap with array brackets
                            $state = json_decode($state, true);
                        }

                        if (!is_array($state)) {
                            return '-';
                        }

                        return collect($state)->map(function ($item) {
                            $year = $item['year'] ?? '-';
                            $fee = $item['tuition_fees'] ?? '0';
                            return "{$year} - " . number_format((float) $fee) . " USD";
                        })->implode(' | ');
                    })
                    ->wrap(),
                TextColumn::make('application_requirement')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'view' => Pages\ViewProgram::route('/{record}'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}