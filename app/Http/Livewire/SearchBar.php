<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;
use Auth;

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
        $this->lists = Script::where('user_id', Auth::id())
            ->orderBy('title')
            ->get()
            ->pluck('title', 'id')
            ->toArray();
        
    }

    public function select($id)
    {
        $script = Script::find($id);

        if(request()->is('scripts*')){
            $this->emit('setScript', $script?->id);
        }else{
            return redirect('scripts?script_id=' . $script->id );
        }
        
    }
}
