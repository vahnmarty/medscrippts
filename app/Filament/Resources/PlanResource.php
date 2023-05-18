<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('stripe_plan')->required(),
                Forms\Components\Textarea::make('description')->required()->columnSpan('full'),
                Forms\Components\TextInput::make('price')->required()->numeric(),
                Forms\Components\Select::make('per')->placeholder('Single Checkout (default)')->options(['year' => 'Year'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stripe_plan')->wrap()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('price')
                ->formatStateUsing(fn (Plan $record): string => "$" . number_format($record->price,2) . ($record->per ? "/" . $record->per : '') )
                ->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPlans::route('/'),
            //'create' => Pages\CreatePlan::route('/create'),
            //'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }    
}
