<?php

namespace App\Http\Livewire\Scripts;

use Auth;
use Livewire\Component;
use App\Enums\BlurSetting;

class StudyMode extends Component
{
    public $study_settings = [];
    public $blurAll = true;

    public function render()
    {
        return view('livewire.scripts.study-mode');
    }

    public function mount()
    {
        if(session('blurAll')){
            $this->blurAll = session('blurAll');
        }

        $this->getSettings();
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
}
