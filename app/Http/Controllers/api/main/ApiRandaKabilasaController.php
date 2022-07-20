<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Illuminate\Http\Request;

class ApiRandaKabilasaController extends Controller
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
        $randaKabilasa = new RandaKabilasa;

        if ($relation) {
            $randaKabilasa = RandaKabilasa::with('bidan', 'anggotaKeluarga', 'mencegahMalnutrisi', 'mencegahPernikahanDini');
        }

        return $randaKabilasa->paginate($pageSize);
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
            "anggota_keluarga_id" => 'required|exists:anggota_keluarga,id',
            "bidan_id" => "nullable|exists:bidan,id",
            "is_mencegah_malnutrisi" => 'nullable|in:0,1',
            "is_mencegah_pernikahan_dini" => 'nullable|in:0,1',
            "is_meningkatkan_life_skill" => 'nullable|in:0,1',
            "kategori_hb" => 'required',
            "kategori_lingkar_lengan_atas" => 'required',
            "kategori_imt" => 'required',
            "kategori_mencegah_malnutrisi" => 'nullable',
            "kategori_meningkatkan_life_skill" => 'nullable',
            "kategori_mencegah_pernikahan_dini" => 'nullable',
            "is_valid_mencegah_malnutrisi" => 'nullable|in:0,1',
            "is_valid_mencegah_pernikahan_dini" => 'nullable|in:0,1',
            "is_valid_meningkatkan_life_skill" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak_mencegah_malnutrisi" => 'nullable',
            "alasan_ditolak_mencegah_pernikahan_dini" => 'nullable',
            "alasan_ditolak_meningkatkan_life_skill" => 'nullable',
        ]);

        return RandaKabilasa::create($request->all());
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
            return RandaKabilasa::with('bidan', 'anggotaKeluarga', 'mencegahMalnutrisi', 'mencegahPernikahanDini')->where('id', $id)->first();
        }
        return RandaKabilasa::where('id', $id)->first();
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
            "anggota_keluarga_id" => 'nullable|exists:anggota_keluarga,id',
            "bidan_id" => "nullable|exists:bidan,id",
            "is_mencegah_malnutrisi" => 'nullable|in:0,1',
            "is_mencegah_pernikahan_dini" => 'nullable|in:0,1',
            "is_meningkatkan_life_skill" => 'nullable|in:0,1',
            "kategori_hb" => 'nullable',
            "kategori_lingkar_lengan_atas" => 'nullable',
            "kategori_imt" => 'nullable',
            "kategori_mencegah_malnutrisi" => 'nullable',
            "kategori_meningkatkan_life_skill" => 'nullable',
            "kategori_mencegah_pernikahan_dini" => 'nullable',
            "is_valid_mencegah_malnutrisi" => 'nullable|in:0,1',
            "is_valid_mencegah_pernikahan_dini" => 'nullable|in:0,1',
            "is_valid_meningkatkan_life_skill" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak_mencegah_malnutrisi" => 'nullable',
            "alasan_ditolak_mencegah_pernikahan_dini" => 'nullable',
            "alasan_ditolak_meningkatkan_life_skill" => 'nullable',
        ]);

        $randaKabilasa = RandaKabilasa::find($id);

        if ($randaKabilasa) {
            $randaKabilasa->update($request->all());
            return $randaKabilasa;
        }

        return response([
            'message' => "Randa Kabilasa with id $id doesn't exist"
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
        $randaKabilasa = RandaKabilasa::find($id);

        if (!$randaKabilasa) {
            return response([
                'message' => "Randa kabilasa with id $id doesn't exist"
            ], 400);
        }

        if ($randaKabilasa->mencegahMalnutrisi) {
            $randaKabilasa->mencegahMalnutrisi()->delete();
        }

        if ($randaKabilasa->mencegahPernikahanDini) {
            $randaKabilasa->mencegahPernikahanDini()->delete();
        }
        $randaKabilasa->delete();

        $pemberitahuan = Pemberitahuan::where('fitur_id', $randaKabilasa->id)
            ->where('tentang', 'randa_kabilasa');

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return $randaKabilasa->delete();
    }
}
