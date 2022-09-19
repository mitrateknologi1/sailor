<?php

namespace App\Http\Controllers\api\master;

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
            'nik' => 'required|string|unique:users,nik',
            'nomor_hp' => 'required|string|unique:users,nomor_hp',
            'password' => 'required|string',
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
        $credentials = $request->validate([
            'nomor_hp' => ['required_if:nik,null'],
            'nik' => ['required_if:nomor_hp,null'],
            'role' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('nomor_hp', $credentials['nomor_hp'])->where('role', $credentials['role'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials.'
            ], 401);
        }

        if ($user->role == "admin") {
            return response([
                "message" => 'Not Authorized!',
            ], 403);
        }

        if ($user->status == 1) {
            $token = $user->createToken('myapptoken')->plainTextToken;

            return response([
                "user" => $user,
                "token" => $token,
            ], 201);
        } else {
            return response([
                'message' => 'Account disabled.'
            ], 405);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'Logged out.'
        ]);
    }
}
