<?php

namespace App\Http\Livewire\Scripts;

use Auth;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Enums\BlurSetting;
use Jenssegers\Agent\Agent;
use Livewire\WithPagination;


class WebScripts extends Component
{
    use WithPagination;
    
    public $category_id, $script_id;

    public $categories = [];

    public $settings = [];

    public $title, $pathophysiology, $epidemiology, $signs, $diagnosis, $treatments, $notes;

    protected $queryString = ['script_id', 'category_id'];

    protected $listeners = [ 'refreshScripts', 'setCategory', 'setScript' ];
    
    public function render()
    {
        $scripts = $this->getScripts();

        if($this->category_id){
            $category = Category::find($this->category_id);
        }else{
            $category = $scripts[0]['category'];
        }

        if($scripts[0])
        {
            $script = Script::find($scripts[0]['id']);
            $script->views = $script->views + 1;
            $script->viewed_at = now();
            $script->save();
        }
        
        return view('livewire.scripts.web-scripts', compact('category', 'scripts'));
    }

    public function mount()
    {
        $agent = new Agent;

        if($agent->isMobile())
        {
            return redirect('scripts');
        }
        
        $this->settings = $this->getSettings();

        $this->categories = Category::withCount('userScripts')->get()->toArray();
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

        $scripts = $scriptQuery->withCount('flashcards')->withCount('qbanks')->paginate(1);

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

    public function setCategory($id)
    {
        $this->category_id = $id;
    }

    public function setScript($id)
    {
        $this->script_id = $id;

        $this->resetPage();
    }

    public function blur($key)
    {
        $var = 'blur_' . $key;
        $settings = Auth::user()->getStudySettings();
        $settings->$var = !$settings->$var;
        $settings->save();

        $this->refreshSettings();
    }

    public function refreshScripts()
    {
        $this->refreshSettings();
        $this->render();
    }

    public function refreshSettings()
    {
        $this->settings = $this->getSettings();
    }

    public function getSettings()
    {
        $settings = [];
        $setting = Auth::user()->getStudySettings();

        $data = BlurSetting::asArray();

        foreach($data as $key =>  $config)
        {
            $enum = BlurSetting::fromKey($key);
            $settings[] = [
                'description' => $enum->description,
                'key' => $enum->key,
                'value' => $enum->value,
                'blur' => $setting['blur_' . $enum->key]
            ];
        }

        return $settings;
    }

}
