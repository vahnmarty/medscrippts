<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScriptResource\Pages;
use App\Filament\Resources\ScriptResource\RelationManagers;
use App\Models\Script;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScriptResource extends Resource
{
    protected static ?string $model = Script::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('pathophysiology')->required()->columnSpan('full')->rows(3),
                Forms\Components\Textarea::make('epidemiology')->required()->columnSpan('full')->rows(3),
                Forms\Components\Textarea::make('signs')->required()->columnSpan('full')->rows(3),
                Forms\Components\Textarea::make('diagnosis')->required()->columnSpan('full')->rows(3),
                Forms\Components\Textarea::make('treatments')->required()->columnSpan('full')->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                //Tables\Columns\TextColumn::make('created_at')->dateTime(''),
            ])
            ->filters([
                Tables\Filters\Filter::make('masterscripts')
                    ->query(fn (Builder $query): Builder => $query->whereNull('user_id'))->default(),
                Tables\Filters\Filter::make('has_images')
                    ->query(fn (Builder $query): Builder => $query->has('images')),
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
            RelationManagers\ImagesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScripts::route('/'),
            'create' => Pages\CreateScript::route('/create'),
            'edit' => Pages\EditScript::route('/{record}/edit'),
        ];
    }    
}
