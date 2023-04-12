<?php

namespace App\Http\Livewire;

use Sesssion;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Enums\BlurSetting;

class ScriptSettings extends Component
{
    public $study_settings = [];
    public $categories = [];
    public $scripts = [];
    public $blurAll = true;
    public $category_id, $script_id;

    public function render()
    {
        return view('livewire.script-settings');
    }

    public function mount()
    {
        $this->categories = Category::get();
        $this->scripts = Script::get();

        if(session('blurAll')){
            $this->blurAll = session('blurAll');
        }

        $this->getSettings();

        //dd($this->blurAll);
    }

    public function setBlurAll($enable)
    {
        $this->blurAll = $enable;

        session()->put('blurAll', $enable);
        
        foreach($this->study_settings as $index => $setting)
        {
            $this->study_settings[$index]['value'] = $enable;

            session()->put('study.' . $setting['key'], $enable);
        }

        $this->emit('refreshScripts');
    }

    public function getSettings()
    {
        $data = BlurSetting::asArray();
        $settings = [];

        foreach($data as $name =>  $config)
        {
            $enable = session('study.' . $config) ?? true;
            $settings[] = [
                'name' => $name,
                'key' => $config,
                'value' => $enable
            ];

            if(!$enable){
                $this->blurAll = false;
                session()->put('blurAll', false);
            }
            
        }

        $this->study_settings = $settings;
    }

    public function blur($setting, $value)
    {
        session()->put('study.' . $setting, $value);

        $this->emit('refreshScripts');
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
