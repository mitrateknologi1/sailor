<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\DeteksiDini;
use Illuminate\Http\Request;

class ApiDeteksiDiniController extends Controller
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
        $perikiraanMelahirkan = new DeteksiDini;

        if ($relation) {
            $perikiraanMelahirkan = DeteksiDini::with('bidan', 'anggotaKeluarga');
        }

        return $perikiraanMelahirkan->paginate($pageSize);
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
            "skor" => "required",
            "kategori" => "required",
            "is_valid" => "nullable|in:0,1",
            "tanggal_validasi" => "nullable",
            "alasan_ditolak" => "nullable"
        ]);

        return DeteksiDini::create($request->all());
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
            return DeteksiDini::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return DeteksiDini::where('id', $id)->first();
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
            "skor" => "nullable",
            "kategori" => "nullable",
            "is_valid" => "nullable|in:0,1",
            "tanggal_validasi" => "nullable",
            "alasan_ditolak" => "nullable"
        ]);

        $deteksiDini = DeteksiDini::find($id);

        if ($deteksiDini) {
            $deteksiDini->update($request->all());
            return $deteksiDini;
        }

        return response([
            'message' => "Deteksi Dini with id $id doesn't exist"
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
        $deteksiDini = DeteksiDini::find($id);

        if (!$deteksiDini) {
            return response([
                'message' => "Deteksi Dini with id $id doesn't exist"
            ], 400);
        }

        return $deteksiDini->delete();
    }
}
