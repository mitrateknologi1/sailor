<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use Illuminate\Support\Facades\Auth;

class PemberitahuanController extends Controller
{
    public function index(){
        if(Auth::user()->pemberitahuan->count() == 0){
            return response()->json([
                'pemberitahuan' => 0
            ]);
        } else{
            return view('dashboard.components.modals.utama.pemberitahuan', ['pemberitahuan' => Auth::user()->pemberitahuan]);
        }
    }

    public function destroy(Pemberitahuan $pemberitahuan){
        $pemberitahuan = Auth::user()->pemberitahuan->find($pemberitahuan->id);
        $pemberitahuan->delete();
        return view('dashboard.components.modals.utama.pemberitahuan', ['pemberitahuan' => Auth::user()->pemberitahuan]);
    }

    public function destroyAll(){
        Pemberitahuan::truncate();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
