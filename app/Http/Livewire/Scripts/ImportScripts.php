<?php

namespace App\Http\Livewire\Scripts;

use Livewire\Component;
use App\Models\Category;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;

class ImportScripts extends Component implements HasForms
{
    use InteractsWithForms;
    
    public function render()
    {
        return view('livewire.scripts.import-scripts');
    }

    public function mount()
    {
        $this->form->fill([
            'categories' => Category::get()->pluck('id')->toArray()
        ]);
    }

    protected function getFormSchema()
    {
        return [
            CheckboxList::make('categories')
                ->options(Category::orderBy('name')->get()->pluck('name', 'id'))
                ->bulkToggleable()
                ->columns(2)
        ];
    }

    public function import()
    {
        $data = $this->form->getState();
        $selected = $data['categories'];

        $categories = Category::whereIn('id', $selected)->with('scripts')->get();

        foreach($categories as $category)
        {
            foreach($category->scripts as $script)
            {
                $clone = $script->replicate(); 
                $clone->user_id = auth()->id();
                $clone->save();
            }
        }

        return redirect('dashboard');
    }
}
