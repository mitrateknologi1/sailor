<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\WilayahDomisili;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiWilayahDomisiliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $anggotaKeluargaId = $request->anggota_keluarga_id;
        $wilayahDomisili = new WilayahDomisili;

        if ($relation) {
            $wilayahDomisili = WilayahDomisili::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'anggotaKeluarga');
        }

        if ($anggotaKeluargaId) {
            return $wilayahDomisili->where("anggota_keluarga_id", $anggotaKeluargaId)->first();
        }

        return $wilayahDomisili->orderBy('updated_at', 'desc')->get();
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
            "anggota_keluarga_id" => "required|exists:anggota_keluarga,id",
            "alamat" => "required|string",
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);
        return WilayahDomisili::create($request->all());
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
            return WilayahDomisili::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return WilayahDomisili::find($id);
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
            "nik" => "required|unique:anggota_keluarga,nik",
            "file_domisili" => 'required|mimes:jpeg,jpg,png,pdf|max:3072',
        ]);

        $fileName = $request->nik . '.' . $request->file('file_domisili')->extension();
        $path = 'upload/surat_keterangan_domisili/';

        if (Storage::exists($path . $fileName)) {
            Storage::delete($path . $fileName);
        }
        $request->file('file_domisili')->storeAs(
            $path,
            $fileName
        );

        return response([
            'file_domisili' => $fileName
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
            "anggota_keluarga_id" => "exists:anggota_keluarga,id",
            "alamat" => "string",
            "desa_kelurahan_id" => "exists:desa_kelurahan,id",
            "kecamatan_id" => "exists:kecamatan,id",
            "kabupaten_kota_id" => "exists:kabupaten_kota,id",
            "provinsi_id" => "exists:provinsi,id",
        ]);
        $wilayahDomisili = WilayahDomisili::find($id);

        if ($wilayahDomisili) {
            $wilayahDomisili->update($request->all());
            return $wilayahDomisili;
        }

        return response([
            'message' => "Wilayah Domisili with id $id doesn't exist"
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
        $wilayahDomisili = WilayahDomisili::find($id);

        if (!$wilayahDomisili) {
            return response([
                'message' => "Wilayah Domisili with id $id doesn't exist"
            ], 400);
        }

        if (Storage::exists('upload/surat_keterangan_domisili/' . $wilayahDomisili->file_ket_domisili)) {
            Storage::delete('upload/surat_keterangan_domisili/' . $wilayahDomisili->file_ket_domisili);
        }
        return $wilayahDomisili->delete();
    }
}
