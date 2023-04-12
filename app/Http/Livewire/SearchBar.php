<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;

class SearchBar extends Component
{
    public $keyword;

    public $lists = [];

    public function render()
    {
        return view('livewire.search-bar');
    }

    public function mount()
    {
        $this->search();
    }

    public function search()
    {
        $this->lists = Script::orderBy('title')->get()->pluck('title')->toArray();
    }

    public function select($keyword)
    {
        $script = Script::where('title', $keyword)->first();

        $this->emit('setScript', $script?->id);
    }
}
