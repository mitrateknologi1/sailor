<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'nik' => 'required|string',
            'nomor_hp' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        User::create([
            'nik' => $fields['nik'],
            'nomor_hp' => $fields['nomor_hp'],
            'password' => bcrypt($fields['password']),
            'role' => 'keluarga',
            'is_remaja' => 0,
            'status' => 0,
        ]);

        $response = [
            'message' => "Account Created",
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $credsPhone = $request->validate([
            'nomor_hp' => ['required_if:nik,null'],
            'nik' => ['required_if:nomor_hp,null'],
            'password' => ['required']
        ]);

        if (!$request->nomor_hp) {
            $user = User::where('nik', $credsPhone['nik'])->first();
        } else {
            $user = User::where('nomor_hp', $credsPhone['nomor_hp'])->first();
        }

        if (Auth::attempt($credsPhone)) {
            if (Auth::user()->status == 1) {
                $token = $user->createToken('userToken')->plainTextToken;

                // get profile data
                // if ($user->role == "admin"){
                //     $profil = Admin::where('user_id', '=', Auth::user()->id)->first(); 
                // }

                return response([
                    "user" => $user,
                    "token" => $token,
                    // "profil" => $profil,
                ], 201);
            } else {
                return response([
                    'message' => 'Account disabled.'
                ], 401);
            }
        }
        return response([
            'message' => 'Bad credentials.'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'Logged out.'
        ]);
    }
}
