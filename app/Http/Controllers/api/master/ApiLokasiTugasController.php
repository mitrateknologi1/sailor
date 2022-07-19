<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $jenisProfil = $request->jenis_profil;

        if ($jenisProfil) {
            return LokasiTugas::with('desaKelurahan')
                ->where('jenis_profil', $jenisProfil)
                ->groupBy('desa_kelurahan_id')
                ->paginate($pageSize);
        }

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
        $reqBody = json_decode($request->getContent());
        if (is_array($reqBody) && sizeof($reqBody) > 0) {
            $request->validate([
                "*.jenis_profil" => "required|in:bidan,penyuluh",
                "*.profil_id" => "required",
                "*.desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
                "*.kecamatan_id" => "required|exists:kecamatan,id",
                "*.kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
                "*.provinsi_id" => "required|exists:provinsi,id",
            ]);

            $lastRecord = LokasiTugas::orderBy('id', 'desc')->first();
            $currentId = $lastRecord->id + 1;
            $field = [];

            foreach ($reqBody as $key => $value) {
                array_push($field, [
                    'id' => $currentId++,
                    'jenis_profil' => $value->jenis_profil,
                    'profil_id' => $value->profil_id,
                    'desa_kelurahan_id' => $value->desa_kelurahan_id,
                    'kecamatan_id' => $value->kecamatan_id,
                    'kabupaten_kota_id' => $value->kabupaten_kota_id,
                    'provinsi_id' => $value->provinsi_id,
                    'created_at' => now(),
                    'provinsi_id' => now()
                ]);
            }

            LokasiTugas::insert($field);
            return $field;
        } else {
            $request->validate([
                "jenis_profil" => "required|in:bidan,penyuluh",
                "profil_id" => "required",
                "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
                "kecamatan_id" => "required|exists:kecamatan,id",
                "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
                "provinsi_id" => "required|exists:provinsi,id",
            ]);

            return LokasiTugas::create($request->all());
        }
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

        if ($lokasiTugas) {
            $lokasiTugas->update($request->all());
            return $lokasiTugas;
        }

        return response([
            'message' => "Lokasi Tugas with id $id doesn't exist"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $profilId = $request->profil_id;
        $deleteLokasiTugas = false;

        if ($id) {
            $deleteLokasiTugas = LokasiTugas::destroy($id);
        } else if ($profilId) {
            $deleteLokasiTugas = LokasiTugas::where('profil_id', $profilId)->delete();
        }

        if ($deleteLokasiTugas) {
            return response([
                'message' => 'Data deleted.'
            ], 200);
        }

        return response([
            'message' => 'failed to delete data.'
        ], 500);
    }
}
