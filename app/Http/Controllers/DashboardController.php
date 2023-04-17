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
        if(Auth::user()->subscribed('default'))
        {
            return redirect('scripts');
        }else{
            return redirect('billing-portal');
        }
    }
}
