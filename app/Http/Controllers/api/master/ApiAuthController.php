<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Bidan;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Penyuluh;
use App\Models\Provinsi;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'nik' => 'required|string|unique:users,nik',
            'nomor_hp' => 'required|string|unique:users,nomor_hp',
            'password' => 'required|string',
        ]);

        return User::create([
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

        if (Auth::attempt($credentials)) {
            if(Auth::user()->role == "admin"){
                return response([
                    "message" => 'Not Authorized for this service!',
                ], 403);
            }

            if (Auth::user()->role == 'keluarga') {
                if (Auth::user()->profil->kartuKeluarga->is_valid == 0) {
                    return response([
                        "message" => 'Account pending and waiting for validate',
                    ], 405);
                }
                if (Auth::user()->profil->kartuKeluarga->is_valid == 2) {
                    $id = Auth::user()->profil->kartuKeluarga->id;
                    return response([
                        "message" => 'Account rejected!',
                        "id_kartu_keluarga" => $id,
                    ], 406);
                }
            }

            if (Auth::user()->status == 1) {
                $token = $user->createToken('myapptoken')->plainTextToken;
                if($user->role == "bidan"){
                    $domisili = Bidan::where('user_id', $user->id)->first();
                }else if($user->role == "penyuluh"){
                    $domisili = Penyuluh::where('user_id', $user->id)->first();
                }else{
                    $domisili = AnggotaKeluarga::where('user_id', $user->id)->first();
                    return response([
                        "user" => $user,
                        "authDomisili" => $domisili,
                        "token" => $token,
                    ], 201);
                }

                return response([
                    "user" => $user,
                    "authDomisili" => $domisili,
                    "token" => $token,
                ], 201);
            } else {
                return response([
                    'message' => 'Account disabled.'
                ], 500);
            }
        }

        return response([
            'message' => 'Bad credentials.',
            'data' => $request->all(),
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'Logged out.'
        ]);
    }

    public function profile(){
        if (!Auth::user()->profil) {
            return response([
                "message" => 'profile not found!',
            ], 404);
        }else{
            if(Auth::user()->role == "keluarga"){
                $response = AnggotaKeluarga::with('agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan', 'statusHubunganDalamKeluarga', 'wilayahDomisili.provinsi', 'wilayahDomisili.kabupatenKota', 'wilayahDomisili.kecamatan', 'wilayahDomisili.desaKelurahan')
                                            ->where('id', Auth::user()->profil->id)->first();
            }
            if(Auth::user()->role == "bidan"){
                $response = Bidan::with('agama', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
                                            ->where('id', Auth::user()->profil->id)->first();
            }
            if(Auth::user()->role == "penyuluh"){
                $response = Penyuluh::with('agama', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
                                            ->where('id', Auth::user()->profil->id)->first();
            }
            return response($response, 200);
        }
        
    }
}
