<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\PerkiraanMelahirkan;
use Illuminate\Http\Request;

class ApiPerkiraanMelahirkanController extends Controller
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
        $perikiraanMelahirkan = new PerkiraanMelahirkan;

        if ($relation) {
            $perikiraanMelahirkan = PerkiraanMelahirkan::with('bidan', 'anggotaKeluarga');
        }

        return $perikiraanMelahirkan->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            'tanggal_haid_terakhir' => 'required',
            'tanggal_perkiraan_lahir' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        return PerkiraanMelahirkan::create($request->all());
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
            return PerkiraanMelahirkan::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return PerkiraanMelahirkan::where('id', $id)->first();
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
            'tanggal_haid_terakhir' => 'nullable',
            'tanggal_perkiraan_lahir' => 'nullable',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $perikiraanMelahirkan = PerkiraanMelahirkan::find($id);

        if ($perikiraanMelahirkan) {
            $perikiraanMelahirkan->update($request->all());
            return $perikiraanMelahirkan;
        }

        return response([
            'message' => "Perkiraan Melahirkan with id $id doesn't exist"
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
        $perkiraanMelahirkan = PerkiraanMelahirkan::find($id);

        if (!$perkiraanMelahirkan) {
            return response([
                'message' => "Perkiraan Melahirkan with id $id doesn't exist"
            ], 400);
        }

        return $perkiraanMelahirkan->delete();
    }
}
