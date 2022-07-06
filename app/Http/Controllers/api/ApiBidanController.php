<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Bidan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiBidanController extends Controller
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
        $lokasiTugasKelurahanId = $request->lokasi_tugas_desa_kelurahan_id;
        $bidan = null;

        if ($relation || $lokasiTugasKelurahanId) {
            $bidan = Bidan::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama');
        } else {
            $bidan = new Bidan;
        }

        if ($lokasiTugasKelurahanId) {
            $bidan->whereHas('lokasiTugas',  function ($query) use ($lokasiTugasKelurahanId) {
                $query->where('desa_kelurahan_id', $lokasiTugasKelurahanId);
            });
        }

        return $bidan->paginate($pageSize);
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
            "user_id" => 'required|exists:users,id',
            "nik" => 'required|unique:bidan,nik',
            "nama_lengkap" => 'required',
            "jenis_kelamin" => 'required',
            "tempat_lahir" => 'required',
            "tanggal_lahir" => 'required',
            "agama_id" => 'required',
            "tujuh_angka_terakhir_str" => 'required',
            "nomor_hp" => 'required|unique:bidan,nomor_hp',
            "alamat" => 'required',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);
        return Bidan::create($request->all());
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
            return Bidan::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama')->where('id', $id)->first();
        }
        return Bidan::where('id', $id)->first();
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
            "nik" => "unique:bidan,nik,$id",
            "nomor_hp" => "unique:bidan,nomor_hp,$id",
            "desa_kelurahan_id" => "exists:desa_kelurahan,id",
            "kecamatan_id" => "exists:kecamatan,id",
            "kabupaten_kota_id" => "exists:kabupaten_kota,id",
            "provinsi_id" => "exists:provinsi,id",
        ]);

        $bidan = Bidan::find($id);
        $bidan->update($request->all());
        return $bidan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bidan = Bidan::find($id);

        if (Storage::exists('upload/foto_profil/bidan/' . $bidan->foto_profil)) {
            Storage::delete('upload/foto_profil/bidan/' . $bidan->foto_profil);
        }

        $bidan->lokasiTugas()->delete();

        return $bidan->delete();
    }
}
