<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function cekLogin(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'nomor_hp' => ['required'],
            'password' => ['required'],
            'role' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if(Auth::user()->status == 1){
                $request->session()->regenerate();
                // return redirect('/dashboard');
                return response()->json([
                    'res' => 'berhasil',
                ]);
            } else{
                return response()->json([
                    'res' => 'tidak_aktif',
                    'mes' => 'Akun anda dinonaktifkan, silahkan hubungi admin untuk informasi lebih lanjut.'
                ]);
            }
        }
        return response()->json([
            'res' => 'gagal',
            'mes' => 'Nomor HP dan kata sandi '. $request->role .' tidak ditemukan. Silahkan cek kembali inputan anda.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}