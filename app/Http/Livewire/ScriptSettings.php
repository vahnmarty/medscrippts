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

    public $category_id, $script_id;

    public function render()
    {
        return view('livewire.script-settings');
    }

    public function mount()
    {
        $this->categories = Category::get();
        $this->scripts = Script::get();
        $this->getSettings();
    }

    public function getSettings()
    {
        $data = BlurSetting::asArray();
        $settings = [];

        foreach($data as $name =>  $config)
        {
            $settings[] = [
                'name' => $name,
                'key' => $config,
                'value' => session('study.' . $config) ?? true
            ];
        }

        $this->study_settings = $settings;
    }

    public function blur($setting, $value)
    {
        session()->put('study.' . $setting, $value);

        $this->emit('refreshScripts');
    }
}
