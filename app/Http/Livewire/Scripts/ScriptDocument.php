<?php

namespace App\Http\Livewire\Scripts;

use Auth;
use App\Models\Image;
use App\Models\Script;
use Livewire\Component;
use App\Enums\BlurSetting;
use Livewire\WithFileUploads;


class ScriptDocument extends Component
{

    use WithFileUploads;
    
    public $script_id;

    public $settings = [];

    public $title, $category_id, $pathophysiology, $epidemiology, $signs, $diagnosis, $treatments, $notes;

    public $links;

    public $images = [];

    protected $rules = [
        //'title' => 'required|max:191',
        'pathophysiology' => 'required|max:191',
        'epidemiology' => 'required|max:191',
        'signs' => 'required|max:191',
        'diagnosis' => 'required|max:191',
        'treatments' => 'required|max:191',
    ];

    public function render()
    {
        $script = Script::find($this->script_id);

        $this->pathophysiology = $script->pathophysiology;
        $this->epidemiology = $script->epidemiology;
        $this->signs = $script->signs;
        $this->diagnosis = $script->diagnosis;
        $this->treatments = $script->treatments;
        $this->links = $script->getLinksString();
        
        return view('livewire.scripts.script-document', compact('script'));
    }

    public function mount($id)
    {
        $this->script_id = $id;;

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

    public function save()
    {
        $this->validate();
        
        $script = Script::find($this->script_id);

        $script->update([
            //'title' => $this->title,
            //'category_id' => $this->category_id,
            'pathophysiology' => $this->pathophysiology,
            'epidemiology' => $this->epidemiology,
            'signs' => $this->signs,
            'diagnosis' => $this->diagnosis,
            'treatments' => $this->treatments
        ]);

        $links = explode(',', $this->links);

        $script->links()->delete();

        foreach($links as $link)
        {
            $script->links()->create(['url' => $link]);
        }
    }

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'image|max:4098', // 1MB Max
        ]);

        
        $script = Script::find($this->script_id);
    
 
        foreach ($this->images as $photo) {
            $file = $photo->store('images', 'public');

            $image_url = asset('storage/' . $file);

            $script->images()->firstOrCreate([
                'url' => $image_url,
                'filename' => basename($image_url)
            ]);
        }
    }

    public function deleteImage($image_id)
    {
        Image::destroy($image_id);
    }
}
