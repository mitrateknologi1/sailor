<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $relation = $request->relation;
        $search = $request->search;
        $user = new User;

        $user = User::with('keluarga');
        if ($relation) {
            $user = User::with('keluarga');
        }

        if ($search) {
            return $user->search($search)->where('role', 'keluarga')->orderBy("updated_at", "desc")->paginate($pageSize);
        }

        // return $user->where('role', 'keluarga')->orderBy('updated_at', 'desc')->paginate($pageSize);
        return $user->where('role', 'keluarga')->orderBy('updated_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'nik' => 'required|numeric|unique:users,nik',
            'nomor_hp' => 'required|string|unique:users,nomor_hp',
            'password' => 'required|string',
            'is_remaja' => 'required|numeric|in:0,1',
            'status' => 'required|numeric|in:0,1',
        ]);

        return User::create([
            'nik' => $fields['nik'],
            'nomor_hp' => $fields['nomor_hp'],
            'password' => bcrypt($fields['password']),
            'role' => 'keluarga',
            'is_remaja' =>  $fields['is_remaja'],
            'status' =>  $fields['status'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $relation = $request->relation;
        if ($relation) {
            return User::with('keluarga')->where('role', 'keluarga')->where('id', $id)->first();
        }
        return User::where('role', 'keluarga')->where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $fields = $request->validate([
            'nik' => "required|numeric|unique:users,nik,$id",
            'nomor_hp' => "required|string|unique:users,nomor_hp,$id",
            'password' => 'required|string',
            'is_remaja' => 'required|numeric|in:0,1',
            'status' => 'required|numeric|in:0,1',
        ]);

        $user = User::find($id);

        if ($user) {
            $user->update([
                'nik' => $fields['nik'],
                'nomor_hp' => $fields['nomor_hp'],
                'password' => bcrypt($fields['password']),
                'role' => 'keluarga',
                'is_remaja' =>  $fields['is_remaja'],
                'status' =>  $fields['status'],
            ]);
            return $user;
        }

        return response([
            'message' => "User with id $id doesn't exist"
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => "User with id $id doesn't exist"
            ], 400);
        }

        if (!$user->kepalaKeluarga) {
            return $user->delete();
        }

        if ($user->is_remaja == 0) { //kepala keluarga\
            if (Storage::exists('upload/kartu_keluarga/' . $user->kepalaKeluarga->kartuKeluarga->file_kk)) {
                Storage::delete('upload/kartu_keluarga/' . $user->kepalaKeluarga->kartuKeluarga->file_kk);
            }

            foreach ($user->kepalaKeluarga->kartuKeluarga->anggotaKeluarga as $anggota) {
                if (Storage::exists('upload/foto_profil/keluarga/' . $anggota->foto_profil)) {
                    Storage::delete('upload/foto_profil/keluarga/' . $anggota->foto_profil);
                }
                if (Storage::exists('upload/surat_keterangan_domisili/' . $anggota->wilayahDomisili->file_ket_domisili)) {
                    Storage::delete('upload/surat_keterangan_domisili/' . $anggota->wilayahDomisili->file_ket_domisili);
                }

                $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $anggota->id);

                if ($anggota->wilayahDomisili) {
                    $anggota->wilayahDomisili->delete();
                }

                if ($anggota->user) {
                    $anggota->user->delete();
                }

                if ($pemberitahuan) {
                    $pemberitahuan->delete();
                }


                $anggota->delete();
            }

            return $user->kepalaKeluarga->kartuKeluarga->delete();
        } else if ($user->is_remaja == 1) { //remaja
            if (Storage::exists('upload/foto_profil/keluarga/' . $user->remaja->foto_profil)) {
                Storage::delete('upload/foto_profil/keluarga/' . $user->remaja->foto_profil);
            }

            $user->remaja->delete();
            return $user->delete();
        }
    }
}
