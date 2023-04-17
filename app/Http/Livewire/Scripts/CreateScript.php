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
                    ->options(Category::get()->pluck('name', 'id'))
                    ->required(),
            ]),
            Textarea::make('pathophysiology')->label('Pathophysiology (Path)')->inlineLabel(),
            Textarea::make('epidemiology')->label('Epidemiology (Epi)')->inlineLabel(),
            Textarea::make('signs')->label('Signs and Symptoms (S/S)')->inlineLabel(),
            Textarea::make('diagnosis')->label('Diagnosis (Dx)')->inlineLabel(),
            Textarea::make('treatments')->label('Treatments (Tx)')->inlineLabel(),
        ];
    }
}
