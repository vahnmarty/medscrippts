<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Script;
use App\Models\Category;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ScriptResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ScriptResource\RelationManagers;

class ScriptResource extends Resource
{
    protected static ?string $model = Script::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Select::make('category_id')->label('Category')->options(Category::get()->pluck('name', 'id'))->required(),
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
            RelationManagers\LinksRelationManager::class,
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
