<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Script;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect('scripts');
        
        $scripts = Script::with('images')->has('images')->limit(6)->get();
        $categories = Category::withCount('scripts')->orderBy('name')->get();
        return view('dashboard', compact('scripts', 'categories'));
    }
}
