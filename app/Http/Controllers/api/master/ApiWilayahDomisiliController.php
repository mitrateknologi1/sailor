<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\WilayahDomisili;
use Carbon\Carbon;
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
        $anggotaKeluargaId = $request->anggota_keluarga_id;
        $wilayahDomisili = new WilayahDomisili;
        $filter = $request->is_filter;


        if ($anggotaKeluargaId) {
            $data = $wilayahDomisili->where("anggota_keluarga_id", $anggotaKeluargaId)->first();
        }

        if($filter){
            $data = $wilayahDomisili->with('provinsi', 'kecamatan', 'kabupatenKota', 'desaKelurahan')->groupBy('desa_kelurahan_id')->orderBy('updated_at', 'desc')->get();
        }else{
            $data = $wilayahDomisili->with('provinsi', 'kecamatan', 'kabupatenKota', 'desaKelurahan')->orderBy('updated_at', 'desc')->get();
        }
        
        foreach ($data as $r) {
            if($r->file_ket_domisili != null){
                $r->file_ket_domisili = asset('storage/surat_keterangan_domisili'). "/". $r->file_ket_domisili;
            }
        }
        return $data;
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
        $isUpdate = $request->is_update;
        if($isUpdate){
            $nik = $request->nik;
            $nikValidation = "required|unique:anggota_keluarga,nik,".$nik .",nik";
        }else{
            $nikValidation = "required|unique:anggota_keluarga,nik";
        }
        $request->validate([
            "nik" => $nikValidation,
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

        $data = [
            "anggota_keluarga_id" => $request->anggota_keluarga_id,
            "alamat" => $request->alamat,
            "desa_kelurahan_id" => $request->desa_kelurahan_id,
            "kecamatan_id" => $request->kecamatan_id,
            "kabupaten_kota_id" => $request->kabupaten_kota_id,
            "provinsi_id" => $request->provinsi_id,
            "file_ket_domisili" => $request->file_ket_domisili,
            "updated_at" => Carbon::now(),
        ];

        if ($wilayahDomisili) {
            $wilayahDomisili->update($data);
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
