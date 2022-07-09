<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiAnggotaKeluargaController extends Controller
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
        $anggotaKeluarga = null;

        if ($relation) {
            $anggotaKeluarga = AnggotaKeluarga::with('kartuKeluarga', 'user', 'statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili', 'agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan');
        } else {
            $anggotaKeluarga = new AnggotaKeluarga;
        }

        return $anggotaKeluarga->paginate($pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "bidan_id" => 'required|exists:bidan,id',
            "kartu_keluarga_id" => 'required|exists:kartu_keluarga,id',
            "user_id" => 'exists:users,id',
            "nama_lengkap" => 'required|string',
            "nik" => 'required|numeric|unique:anggota_keluarga,nik',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|exists:agama,id',
            "pendidikan_id" => 'required|exists:pendidikan,id',
            "jenis_pekerjaan_id" => 'required|exists:pekerjaan,id',
            "golongan_darah_id" => 'required|exists:golongan_darah,id',
            "status_perkawinan_id" => 'required|exists:status_perkawinan,id',
            "status_hubungan_dalam_keluarga_id" => 'required|exists:status_hubungan,id',
            "kewarganegaraan" => 'required|string',
            "nama_ayah" => 'required|string',
            "nama_ibu" => 'required|string',
            "is_valid" => 'required|numeric|in:0,1',
            "tanggal_validasi" => 'required|string',
        ]);

        return AnggotaKeluarga::create($request->all());
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
            return AnggotaKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'bidan')->where('id', $id)->first();
        }
        return AnggotaKeluarga::where('id', $id)->first();
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
        $anggotaKeluarga = AnggotaKeluarga::find($id);
        $request->validate([
            "bidan_id" => 'exists:bidan,id',
            "kartu_keluarga_id" => 'exists:kartu_keluarga,id',
            "user_id" => 'exists:users,id',
            "nama_lengkap" => 'string',
            "nik" => "numeric|unique:anggota_keluarga,nik,$id",
            "jenis_kelamin" => 'in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'string',
            "tanggal_lahir" => 'string',
            "agama_id" => 'exists:agama,id',
            "pendidikan_id" => 'exists:pendidikan,id',
            "jenis_pekerjaan_id" => 'exists:pekerjaan,id',
            "golongan_darah_id" => 'exists:golongan_darah,id',
            "status_perkawinan_id" => 'exists:status_perkawinan,id',
            "status_hubungan_dalam_keluarga_id" => 'exists:status_hubungan,id',
            "kewarganegaraan" => 'string',
            "nama_ayah" => 'string',
            "nama_ibu" => 'string',
            "is_valid" => 'numeric|in:0,1',
            "tanggal_validasi" => 'string',
        ]);
        $anggotaKeluarga->update($request->all());
        return $anggotaKeluarga;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggotaKeluarga = AnggotaKeluarga::find($id);

        if ((Auth::user()->profil->id == $anggotaKeluarga->bidan_id) || (Auth::user()->role == 'admin')) {
            if (Storage::exists('upload/foto_profil/keluarga/' . $anggotaKeluarga->foto_profil)) {
                Storage::delete('upload/foto_profil/keluarga/' . $anggotaKeluarga->foto_profil);
            }

            if ($anggotaKeluarga->wilayahDomisili) {
                if (Storage::exists('upload/surat_keterangan_domisili/' . $anggotaKeluarga->wilayahDomisili->file_ket_domisili)) {
                    Storage::delete('upload/surat_keterangan_domisili/' . $anggotaKeluarga->wilayahDomisili->file_ket_domisili);
                }
                $anggotaKeluarga->wilayahDomisili->delete();
            }

            $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $anggotaKeluarga->id);

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }


            if ($anggotaKeluarga->user) {
                $anggotaKeluarga->user->delete();
            }
            return $anggotaKeluarga->delete();
        }

        return response([
            'message' => "Not Permitted",
        ], 403);
    }
}
