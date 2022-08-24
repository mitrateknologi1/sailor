<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\KartuKeluarga;
use App\Models\Pemberitahuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiKartuKeluargaController extends Controller
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
        $kartuKeluarga = new KartuKeluarga;

        if ($relation) {
            $kartuKeluarga = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'bidan');
        }

        if ($search) {
            return  $kartuKeluarga->search($search)->orderBy('updated_at', 'desc')->paginate($pageSize);
        }

        return  $kartuKeluarga->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "bidan_id" => 'nullable|string|exists:bidan,id',
            "nomor_kk" => 'required|unique:kartu_keluarga,nomor_kk',
            "nama_kepala_keluarga" => 'required|string',
            "alamat" => 'required|string',
            "rt" => 'nullable',
            "rw" => 'nullable',
            "kode_pos" => 'required',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
            "is_valid" => 'required|in:0,1',
            "tanggal_validasi" => 'nullable|string',
            "file_kk" => 'nullable|string',
        ]);

        return KartuKeluarga::create($request->all());
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
            return KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'bidan')->where('id', $id)->first();
        }
        return KartuKeluarga::where('id', $id)->first();
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
        $request->validate([
            "nomor_kk" => "required|unique:kartu_keluarga,nomor_kk|digits:16",
            "file_kartu_keluarga" => 'required|mimes:jpeg,jpg,png,pdf|max:3072',
        ]);

        $fileName = $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension();
        $path = 'upload/kartu_keluarga/';

        if (Storage::exists($path . $fileName)) {
            Storage::delete($path . $fileName);
        }

        $request->file('file_kartu_keluarga')->storeAs(
            $path,
            $fileName
        );

        return response([
            'file_kk' => $fileName
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
            "bidan_id" => 'nullable|string|exists:bidan,id',
            "nomor_kk" => "nullable|unique:kartu_keluarga,nomor_kk,$id",
            "alamat" => 'nullable|string',
            "rt" => 'nullable',
            "rw" => 'nullable',
            "kode_pos" => 'nullable',
            "desa_kelurahan_id" => "nullable|exists:desa_kelurahan,id",
            "kecamatan_id" => "nullable|exists:kecamatan,id",
            "kabupaten_kota_id" => "nullable|exists:kabupaten_kota,id",
            "provinsi_id" => "nullable|exists:provinsi,id",
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable|nullable|string',
            "file_kk" => 'nullable|string',
            "file_kk" => 'nullable|string',
        ]);

        $kartuKeluarga = KartuKeluarga::find($id);

        if ($kartuKeluarga) {
            $kartuKeluarga->update($request->all());
            return $kartuKeluarga;
        }

        return response([
            'message' => "Kartu Keluarga with id $id doesn't exist"
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
        $kartuKeluarga = KartuKeluarga::find($id);

        if (!$kartuKeluarga) {
            return response([
                'message' => "Kartu Keluarga with id $id doesn't exist"
            ], 400);
        }


        foreach ($kartuKeluarga->anggotaKeluarga as $anggota) {
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

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }
        }
        if (Storage::exists('upload/kartu_keluarga/' . $kartuKeluarga->file_kk)) {
            Storage::delete('upload/kartu_keluarga/' . $kartuKeluarga->file_kk);
        }

        if ($kartuKeluarga->kepalaKeluarga) {
            $user = User::where('id', $kartuKeluarga->kepalaKeluarga->user_id);

            $remaja = AnggotaKeluarga::where('kartu_keluarga_id', $kartuKeluarga->id)
                ->where('status_hubungan_dalam_keluarga_id', 4)
                ->whereNotNull('user_id')->get();
            foreach ($remaja as $r) {
                $r->user->delete();
            }
            // $remaja->user->delete();
            $user->delete();
        }

        $anggotaKeluarga = AnggotaKeluarga::where('kartu_keluarga_id', $kartuKeluarga->id);
        $anggotaKeluarga->delete();

        return $kartuKeluarga->delete();
    }
}
