<?php

namespace App\Http\Livewire\Scripts;

use Livewire\Component;
use App\Models\Category;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateScript extends Component implements HasForms
{
    use InteractsWithForms;
    
    public function render()
    {
        return view('livewire.scripts.create-script');
    }

    protected function getFormSchema()
    {
        return [
            Grid::make(2)
            ->schema([
                TextInput::make('title')
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::orderBy('name')->get()->pluck('name', 'id'))
                    ->required(),
            ]),
            Textarea::make('pathophysiology')->label('Pathophysiology (Path)')->inlineLabel()->rows(2),
            Textarea::make('epidemiology')->label('Epidemiology (Epi)')->inlineLabel()->rows(2),
            Textarea::make('signs')->label('Signs and Symptoms (S/S)')->inlineLabel()->rows(2),
            Textarea::make('diagnosis')->label('Diagnosis (Dx)')->inlineLabel()->rows(2),
            Textarea::make('treatments')->label('Treatments (Tx)')->inlineLabel()->rows(2),
        ];
    }
}
