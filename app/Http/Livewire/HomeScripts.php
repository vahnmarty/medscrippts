<?php

namespace App\Http\Livewire;

use App\Models\Script;
use Livewire\Component;
use App\Models\Category;

class HomeScripts extends Component
{
    public function render()
    {

        $scripts = Script::with('images')->has('images')->limit(6)->get();
        $categories = Category::withCount('scripts')->orderBy('name')->get();

        return view('livewire.home-scripts', compact('scripts', 'categories'));
    }
}
