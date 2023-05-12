<?php

namespace App\Http\Livewire;

use Auth;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Enums\BlurSetting;
use App\Models\StudySetting;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\AgentLayoutTrait;

class HomeScripts extends Component
{
    use WithPagination;
    use AgentLayoutTrait;

    const MAX = 3;
    
    public $reactive = false;

    public $n;

    public $category_id, $script_id;

    public $categories = [];

    public $settings = [];

    protected $queryString = ['script_id'];

    protected $listeners = [ 'refreshScripts', 'setCategory', 'setScript' ];

    public function render()
    {
        $scripts = $this->getScripts();

        foreach($scripts as $item)
        {
            $script = Script::find($item['id']);
            $script->views = $script->views + 1;
            $script->viewed_at = now();
            $script->save();
        }

        $this->reset('script_id');

        return view('livewire.home-scripts', compact('scripts'));
    }

    public function dehydrate()
    {
        $this->slide();
    }

    public  function slide()
    {
        $this->dispatchBrowserEvent('reboot-slider');
    }

    public function mount()
    {   

        $this->settings = $this->getSettings();
        $this->categories = $this->getCategories();
    }

    public function getScripts()
    {
        if($this->script_id){
            $scriptQuery = Script::with('images')->where('id', $this->script_id);
        }
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

    public function getCategories()
    {
        return Category::withCount('scripts')->orderBy('name')->get();
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
