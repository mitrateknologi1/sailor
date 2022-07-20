<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Anc;
use Illuminate\Http\Request;

class ApiAncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $pageSize = $request->page_size ?? 20;
        $anc = new Anc;

        if ($relation) {
            $anc = Anc::with('bidan', 'anggotaKeluarga');
        }

        return $anc->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "bidan_id" => "nullable|exists:bidan,id",
            "pemeriksaan_ke" => "required",
            "kategori_badan" => "required",
            "kategori_tekanan_darah" => "required",
            "kategori_lengan_atas" => "required",
            "kategori_denyut_jantung" => "required",
            "kategori_hemoglobin_darah" => "required",
            "vaksin_tetanus_sebelum_hamil" => "required",
            "vaksin_tetanus_sesudah_hamil" => "required",
            "minum_tablet" => "required",
            "konseling" => "required",
            "posisi_janin" => "required",
            "is_valid" => "nullable|in:0,1",
            "tanggal_validasi" => "nullable",
            "alasan_ditolak" => "nullable",
        ]);

        return Anc::create($request->all());
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
            return Anc::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return Anc::where('id', $id)->first();
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
            "anggota_keluarga_id" => "nullable|exists:anggota_keluarga,id",
            "bidan_id" => "nullable|exists:bidan,id",
            "pemeriksaan_ke" => "nullable",
            "kategori_badan" => "nullable",
            "kategori_tekanan_darah" => "nullable",
            "kategori_lengan_atas" => "nullable",
            "kategori_denyut_jantung" => "nullable",
            "kategori_hemoglobin_darah" => "nullable",
            "vaksin_tetanus_sebelum_hamil" => "nullable",
            "vaksin_tetanus_sesudah_hamil" => "nullable",
            "minum_tablet" => "nullable",
            "konseling" => "nullable",
            "posisi_janin" => "nullable",
            "is_valid" => "nullable|in:0,1",
            "tanggal_validasi" => "nullable",
            "alasan_ditolak" => "nullable",
        ]);

        $anc = Anc::find($id);

        if ($anc) {
            $anc->update($request->all());
            return $anc;
        }

        return response([
            'message' => "ANC with id $id doesn't exist"
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
        $anc = Anc::find($id);

        if (!$anc) {
            return response([
                'message' => "ANC with id $id doesn't exist"
            ], 400);
        }

        return $anc->delete();
    }
}
