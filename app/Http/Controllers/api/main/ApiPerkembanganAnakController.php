<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\PerkembanganAnak;
use Illuminate\Http\Request;

class ApiPerkembanganAnakController extends Controller
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
        $perkembanganAnak = new PerkembanganAnak;

        if ($relation) {
            $perkembanganAnak = PerkembanganAnak::with('bidan', 'anggotaKeluarga');
        }

        return $perkembanganAnak->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "motorik_kasar" => 'required',
            "motorik_halus" => 'required',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable'
        ]);

        return PerkembanganAnak::create($request->all());
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
            return PerkembanganAnak::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return PerkembanganAnak::where('id', $id)->first();
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
            "motorik_kasar" => 'nullable',
            "motorik_halus" => 'nullable',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable'
        ]);

        $perkembanganAnak = PerkembanganAnak::find($id);

        if ($perkembanganAnak) {
            $perkembanganAnak->update($request->all());
            return $perkembanganAnak;
        }

        return response([
            'message' => "Perkembangan Anak with id $id doesn't exist"
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
        $perkembanganAnak = PerkembanganAnak::find($id);

        if (!$perkembanganAnak) {
            return response([
                'message' => "Perkembangan Anak with id $id doesn't exist"
            ], 400);
        }

        return $perkembanganAnak->delete();
    }
}
