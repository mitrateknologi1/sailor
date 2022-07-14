<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\DeteksiIbuMelahirkanStunting;
use Illuminate\Http\Request;

class ApiIbuMelahirkanStuntingController extends Controller
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
        $ibuMelahirkanStunting = new DeteksiIbuMelahirkanStunting;

        if ($relation) {
            $ibuMelahirkanStunting = DeteksiIbuMelahirkanStunting::with('bidan', 'anggotaKeluarga');
        }

        return $ibuMelahirkanStunting->paginate($pageSize);
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
            'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id',
            'bidan_id' => 'nullable|exists:bidan,id',
            'kategori' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        return DeteksiIbuMelahirkanStunting::create($request->all());
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
            return DeteksiIbuMelahirkanStunting::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return DeteksiIbuMelahirkanStunting::where('id', $id)->first();
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
            'anggota_keluarga_id' => 'nullable|exists:anggota_keluarga,id',
            'bidan_id' => 'nullable|exists:bidan,id',
            'kategori' => 'nullable',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $ibuMelahirkanStunting = DeteksiIbuMelahirkanStunting::find($id);

        if ($ibuMelahirkanStunting) {
            $ibuMelahirkanStunting->update($request->all());
            return $ibuMelahirkanStunting;
        }

        return response([
            'message' => "Deteksi Ibu Melahirkan Stunting with id $id doesn't exist"
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
        $ibuMelahirkanStunting = DeteksiIbuMelahirkanStunting::find($id);

        if (!$ibuMelahirkanStunting) {
            return response([
                'message' => "Deteksi Ibu Melahirkan Stunting with id $id doesn't exist"
            ], 400);
        }

        return $ibuMelahirkanStunting->delete();
    }
}
