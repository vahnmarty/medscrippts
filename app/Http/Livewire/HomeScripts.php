<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;
use App\Models\Category;

class HomeScripts extends Component
{
    public $category_id, $script_id;

    protected $listeners = [ 'refreshScripts' => '$refresh', 'setCategory', 'setScript' ];

    public function render()
    {

        $scriptQuery = Script::with('images')->limit(6);
        $categories = Category::withCount('scripts')->orderBy('name')->get();

        if($this->category_id){
            $scriptQuery = $scriptQuery->where('category_id', $this->category_id);
        }

        if($this->script_id){
            $scriptQuery = Script::with('images')->where('id', $this->script_id);
        }

        $scripts = $scriptQuery->get();

        return view('livewire.home-scripts', compact('scripts', 'categories'));
    }

    public function setCategory($id)
    {
        $this->category_id = $id;
    }

    public function setScript($id)
    {
        $this->script_id = $id;
    }
}
