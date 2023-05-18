<?php

namespace App\Http\Livewire\Scripts;

use App\Models\Script;
use Livewire\Component;
use App\Models\Category;

class FilterScripts extends Component
{
    public $categories = [];
    public $scripts = [];
    public $category_id, $script_id;
    public $n = 0;

    public function render()
    {
        return view('livewire.scripts.filter-scripts');
    }

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->scripts = Script::where('user_id', auth()->id())->orderBy('title')->get();
        $this->n = Script::where('user_id', auth()->id())->count();
    }

    public function updatedCategoryId()
    {
        $this->emit('setCategory', $this->category_id);
    }

    public function updatedScriptId()
    {
        $this->emit('setScript', $this->script_id);
    }
}
