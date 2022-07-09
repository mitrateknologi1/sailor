<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiPenyuluhController extends Controller
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
        $penyuluh = new Penyuluh;

        if ($relation) {
            $penyuluh = Penyuluh::with('user', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama',);
        }

        if ($lokasiTugasKelurahanId) {
            if (!$relation) {
                $penyuluh = Penyuluh::with('lokasiTugas');
            }
            $penyuluh->whereHas('lokasiTugas',  function ($query) use ($lokasiTugasKelurahanId) {
                $query->where('desa_kelurahan_id', $lokasiTugasKelurahanId);
            });
        }

        return $penyuluh->paginate($pageSize);
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
            "nik" => 'required|numeric|unique:penyuluh,nik',
            "nama_lengkap" => 'required|string',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|numeric',
            "tujuh_angka_terakhir_str" => 'required|string',
            "nomor_hp" => 'required|string|unique:bidan,nomor_hp',
            "email" => "required|string",
            "alamat" => 'required|string',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);
        return Penyuluh::create($request->all());
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
            return Penyuluh::with('user', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama')->where('id', $id)->first();
        }
        return Penyuluh::where('id', $id)->first();
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
        $penyuluh = Penyuluh::find($id);

        $request->validate([
            "user_id" => 'required|exists:users,id',
            "nik" => "required|numeric|unique:penyuluh,nik,$id",
            "nama_lengkap" => 'required|string',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|numeric',
            "tujuh_angka_terakhir_str" => 'required|string',
            "nomor_hp" => "required|string|unique:bidan,nomor_hp,$id",
            "email" => "required|string",
            "alamat" => 'required|string',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);

        $penyuluh->update($request->all());
        return $penyuluh;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penyuluh = Penyuluh::find($id);

        if (Storage::exists('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil)) {
            Storage::delete('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil);
        }

        $penyuluh->lokasiTugas()->delete();
        return $penyuluh->delete();
    }
}
