<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Models\StudySetting;
use App\Enums\BlurSetting;
use Auth;

class HomeScripts extends Component
{
    public $category_id, $script_id;

    public $scripts = [], $categories = [];

    public $settings = [];

    protected $listeners = [ 'refreshScripts', 'setCategory', 'setScript' ];

    public function render()
    {
        return view('livewire.home-scripts');
    }

    public function mount()
    {   
        $this->settings = $this->getSettings();
        $this->scripts = $this->getScripts();
        $this->categories = $this->getCategories();
    }

    public function getScripts()
    {
        $scriptQuery = Script::with('images')->limit(6);
        

        if($this->category_id){
            $scriptQuery = $scriptQuery->where('category_id', $this->category_id);
        }

        if($this->script_id){
            $scriptQuery = Script::with('images')->where('id', $this->script_id);
        }

        $scripts = $scriptQuery->get();

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
        $this->scripts = $this->getScripts();
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
