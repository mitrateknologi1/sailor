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
    public function index()
    {
        if (Auth::user()->role == 'keluarga') {
            if (Auth::user()->is_remaja == 1) {
                return redirect('randa-kabilasa');
            }
            return view('dashboard.pages.utama.dashboard.keluarga');
        }
        return view('dashboard.pages.utama.dashboard.admin');
    }
}
