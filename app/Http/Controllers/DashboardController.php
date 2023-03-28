<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Script;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $scripts = Script::with('images')->has('images')->limit(6)->get();
        return view('dashboard', compact('scripts'));
    }
}
