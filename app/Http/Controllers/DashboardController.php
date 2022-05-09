<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        // Carbon::setLocale('id');
        if(Auth::user()->role == 'keluarga'){
            return view('dashboard.pages.utama.dashboard.keluarga');
        }
        return view('dashboard.pages.utama.dashboard.admin');
    }

    
}
