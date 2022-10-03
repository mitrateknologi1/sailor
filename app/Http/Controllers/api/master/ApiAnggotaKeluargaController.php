<?php

namespace App\Http\Controllers\api\master;

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
        $search = $request->search;
        $anggotaKeluarga = new AnggotaKeluarga;

        if(Auth::user()->role == "keluarga"){
            $data = AnggotaKeluarga::with('statusHubunganDalamKeluarga')
            ->where('kartu_keluarga_id', Auth::user()->profil->kartu_keluarga_id)
            ->orderBy('status_hubungan_dalam_keluarga_id', 'ASC')
            ->get();

            return response([
                'message' => "OK",
                'data' => $data
            ], 201);
        }else if(Auth::user()->role == "bidan"){
            //
        }

        if ($relation) {
            $anggotaKeluarga = AnggotaKeluarga::with('kartuKeluarga', 'user', 'statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili', 'agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan');
        }

        if ($search) {
            return $anggotaKeluarga->search($search)->orderBy('updated_at', 'desc')->paginate($pageSize);
        }

        return $anggotaKeluarga->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "bidan_id" => 'nullable|exists:bidan,id',
            "kartu_keluarga_id" => 'required|exists:kartu_keluarga,id',
            "user_id" => 'nullable|exists:users,id',
            "nama_lengkap" => 'required|string',
            "nik" => 'required|unique:anggota_keluarga,nik',
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
            "foto_profil" => 'nullable|string',
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
            return AnggotaKeluarga::with('kartuKeluarga', 'user', 'statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili', 'agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan')->where('id', $id)->first();
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
    public function upload(Request $request)
    {
        $isUpdate = $request->is_update;
        if($isUpdate){
            $nikValidation = "required|unique:anggota_keluarga,nik,". $request->nik . ",nik";
        }else{
            $nikValidation = "required|unique:anggota_keluarga,nik";
        }
        $request->validate([
            "nik" => $nikValidation,
            "file_foto_profil" => 'required|mimes:jpeg,jpg,png|max:3072',
        ]);

        $fileName = $request->nik . '.' . $request->file('file_foto_profil')->extension();
        $path = 'upload/foto_profil/keluarga/';

        if (Storage::exists($path . $fileName)) {
            Storage::delete($path . $fileName);
        }
        $request->file('file_foto_profil')->storeAs(
            $path,
            $fileName
        );

        return response([
            'foto_profil' => $fileName
        ], 201);
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
        $request->validate([
            "bidan_id" => 'required|exists:bidan,id',
            "kartu_keluarga_id" => 'required|exists:kartu_keluarga,id',
            "user_id" => 'required|exists:users,id',
            "nama_lengkap" => 'required|string',
            "nik" => "required|unique:anggota_keluarga,nik,$id",
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|exists:agama,id',
            "pendidikan_id" => 'required|exists:pendidikan,id',
            "jenis_pekerjaan_id" => 'required|exists:pekerjaan,id',
            "golongan_darah_id" => 'required|exists:golongan_darah,id',
            "status_perkawinan_id" => 'required|exists:status_perkawinan,id',
            "tanggal_perkawinan" => 'nullable|string',
            "status_hubungan_dalam_keluarga_id" => 'required|exists:status_hubungan,id',
            "kewarganegaraan" => 'required|string',
            "no_paspor" => 'required|string',
            "no_kitap" => 'required|string',
            "nama_ayah" => 'required|string',
            "nama_ibu" => 'required|string',
            "foto_profil" => 'nullable|string',
            "is_valid" => 'numeric|in:0,1',
            "tanggal_validasi" => 'nullable|string',
            "alasan_ditolak" => 'nullable|string',
        ]);

        $anggotaKeluarga = AnggotaKeluarga::find($id);

        if ($anggotaKeluarga) {
            $anggotaKeluarga->update($request->all());
            return $anggotaKeluarga;
        }

        return response([
            'message' => "Anggota Keluarga with id $id doesn't exist"
        ], 400);
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

        if (!$anggotaKeluarga) {
            return response([
                'message' => "Anggota Keluarga with id $id doesn't exist"
            ], 400);
        }

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
}
