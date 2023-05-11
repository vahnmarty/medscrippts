<?php

namespace App\Http\Livewire\Scripts;

use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;


class WebScripts extends Component
{
    use WithPagination;
    
    public $category_id, $script_id;

    public $categories = [];

    public $settings = [];

    public $title, $pathophysiology, $epidemiology, $signs, $diagnosis, $treatments, $notes;

    protected $queryString = ['script_id', 'category_id'];
    
    public function render()
    {
        $scripts = $this->getScripts();

        if($this->category_id){
            $category = Category::find($this->category_id);
        }else{
            $category = $scripts[0]['category'];
        }
        
        return view('livewire.scripts.web-scripts', compact('category', 'scripts'));
    }

    public function mount()
    {
        $this->categories = Category::whereHas('scripts', function($query){
                    $query->where('user_id', auth()->id());
                })->withCount('scripts')->get()->toArray();
    }

    public function getScripts()
    {
        $scriptQuery = Script::where('user_id', auth()->id())->with('images');
        

        if($this->category_id){
            $scriptQuery = $scriptQuery->where('category_id', $this->category_id);
        }

        if($this->script_id){
            $scriptQuery = Script::with('images')->where('id', $this->script_id);
        }

        $scripts = $scriptQuery->paginate(1);

        return $scripts;
    }

    public function selectCategory($id)
    {
        $this->category_id = $id;

        $this->resetPage();

        $this->dispatchBrowserEvent('closemodal-categories');
    }

    public function save($id, $field, $value)
    {
        $script = Script::find($id);

        $script->$field = $value;
        $script->save();
    }
}
