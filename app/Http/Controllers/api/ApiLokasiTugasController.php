<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;

class ApiLokasiTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        return LokasiTugas::paginate($pageSize);
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
            "jenis_profil" => "required|in:bidan,penyuluh",
            "profil_id" => "required|exists:bidan,id",
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exist:kecamatan,id",
            "kabupaten_kota_id" => "required|exist:kabupaten_kota,id",
            "provinsi_id" => "required|exist:provinsi,id",
        ]);

        return LokasiTugas::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return LokasiTugas::find($id);
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
            "jenis_profil" => "in:bidan,penyuluh",
            "profil_id" => "exists:bidan,id",
            "desa_kelurahan_id" => "exists:desa_kelurahan,id",
            "kecamatan_id" => "exists:kecamatan,id",
            "kabupaten_kota_id" => "exists:kabupaten_kota,id",
            "provinsi_id" => "exists:provinsi,id",
        ]);
        $lokasiTugas = LokasiTugas::find($id);
        $lokasiTugas->update($request->all());
        return $lokasiTugas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return LokasiTugas::destroy($id);
    }
}
