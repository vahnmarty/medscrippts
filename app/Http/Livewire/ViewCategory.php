<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class ViewCategory extends Component
{
    public Category $category;

    public function render()
    {
        return view('livewire.view-category');
    }

    public function mount($id, $slug = null)
    {
        $this->category = Category::with('scripts')->find($id);
    }
}
