<?php

namespace App\Http\Livewire\Scripts;

use Log;
use Auth;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Enums\CrudResource;
use App\Jobs\GenerateQBanks;
use App\Jobs\GenerateFlashCards;
use OpenAI\Laravel\Facades\OpenAI;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class CrudScript extends Component implements HasForms
{
    use InteractsWithForms;

    public $action = CrudResource::Create;

    public $script_id;

    public $title, $category_id, $pathophysiology, $epidemiology, $signs, $diagnosis, $treatments, $notes;

    protected $listeners = ['editScript' => 'edit', 'createScript' => 'create'];
    
    public function render()
    {
        return view('livewire.scripts.crud-script')->layout('layouts.slider');
    }

    public function mount()
    {
        
    }

    public function create()
    {
        $this->reset(['title', 'category_id', 'pathophysiology', 'epidemiology', 'signs', 'diagnosis', 'treatments', 'script_id']);
        $this->action = CrudResource::Create;

        $this->dispatchBrowserEvent('openmodal-script');
    }

    public function edit($id)
    {
        $script = Script::find($id);

        $this->script_id = $id;

        $this->action = CrudResource::Update;

        $this->form->fill([
            'title' => $script->title,
            'category_id' => $script->category_id,
            'pathophysiology' => $script->pathophysiology,
            'epidemiology' => $script->epidemiology,
            'signs' => $script->signs,
            'diagnosis' => $script->diagnosis,
            'treatments' => $script->treatments
        ]);

        $this->dispatchBrowserEvent('openmodal-script');
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

        if($this->action == CrudResource::Create){
            $script = Script::create($data);

            # Job/Queue
            GenerateFlashCards::dispatch($script);
            GenerateQBanks::dispatch($script);
        }else{
            $script = Script::find($this->script_id);
            $script->update($data);
        }
        

        $this->emit('refreshScripts');

        $this->dispatchBrowserEvent('closemodal-script');
    }



}

