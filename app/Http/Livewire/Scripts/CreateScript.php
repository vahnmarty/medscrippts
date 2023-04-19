<?php

namespace App\Http\Livewire\Scripts;

use Log;
use Auth;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Jobs\GenerateQBanks;
use App\Jobs\GenerateFlashCards;
use OpenAI\Laravel\Facades\OpenAI;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateScript extends Component implements HasForms
{
    use InteractsWithForms;

    public $title, $category_id, $pathophysiology, $epidemiology, $signs, $diagnosis, $treatments;
    
    public function render()
    {
        return view('livewire.scripts.create-script')->layout('layouts.slider');
    }

    public function mount()
    {
        $this->form->fill(Script::first()->toArray());
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

    public function save()
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        $script = Script::create($data);

        # Job/Queue
        GenerateFlashCards::dispatch($script);
        GenerateQBanks::dispatch($script);

        $this->emitUp('refreshScripts');

        $this->dispatchBrowserEvent('closemodal-create');
    }



}

