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
            $scripts = Script::where('user_id', auth()->id())->count();

            if($scripts){
                return redirect('scripts');
            }

            return redirect('scripts/import');
            
        }else{
            return redirect('subscription');
        }
    }
}
