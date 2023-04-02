<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use Sesssion;

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
        $data = [
            'Pathophysiology', 'Signs and Symptoms', 'Diagnosis', 'Treatments', 'Epidemiology',
        ];

        $settings = [];

        foreach($data as $config)
        {
            $settings[$config] = session('study-' . $config) ?? true;
        }

        $this->study_settings = $settings;
    }

    public function blur($setting, $value)
    {
        session()->put('study-' . $setting, $value);
    }
}
