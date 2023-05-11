<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;

class EditorJs extends Component
{
    public $script;

    public $title;

    public function render()
    {
        return view('livewire.editor-js');
    }

    public function mount()
    {
        $script = Script::has('images')->first();

        $this->title = $script->title;

        $this->script = $script;
    }

    public function autoSave($column)
    {
    
        $script = Script::has('images')->first();

        $script->$column = $this->$column;
        $script->save();
        
    }
}
