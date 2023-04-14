<?php

namespace App\Http\Livewire;

use Sesssion;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Enums\BlurSetting;
use Auth;

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
        $user_setting = Auth::user()->getStudySettings();

        session()->put('blurAll', $enable);

        
        foreach($this->study_settings as $index => $setting)
        {
            $this->study_settings[$index]['blur'] = $enable;

            // Persist
            $var = 'blur_' . $setting['key'];
            $user_setting->$var = $enable;
            $user_setting->save();
        }
    }

    public function getSettings()
    {
        $data = BlurSetting::asArray();
        $user_setting = Auth::user()->getStudySettings();
        $settings = [];

        foreach($data as $key =>  $value)
        {
            $enum = BlurSetting::fromKey($key);
            $var = 'blur_' . $key;
            $blur = $user_setting->$var;

            $settings[] = [
                'description' => $enum->description,
                'key' => $enum->key,
                'value' => $enum->value,
                'blur' => $blur
            ];

            if(!$blur){
                $this->blurAll = false;
                session()->put('blurAll', false);
            }
            
        }

        $this->study_settings = $settings;
    }

    public function blur($key, $value)
    {
        $var = 'blur_' . $key;
        $settings = Auth::user()->getStudySettings();
        $settings->$var = !$settings->$var;
        $settings->save();

        //$this->emit('refreshScripts');
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
