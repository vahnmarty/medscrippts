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
        if(Auth::user()->hasSubscribed())
        {
            return redirect('scripts');
        }else{
            return redirect('subscription');
        }
    }
}
