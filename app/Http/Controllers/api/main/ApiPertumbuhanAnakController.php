<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\PertumbuhanAnak;
use Illuminate\Http\Request;

class ApiPertumbuhanAnakController extends Controller
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
        $pertumbuhanAnak = new PertumbuhanAnak;

        if ($relation) {
            $pertumbuhanAnak = PertumbuhanAnak::with('bidan', 'anggotaKeluarga');
        }

        return $pertumbuhanAnak->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "berat_badan" => 'required',
            "zscore" => 'required',
            "hasil" => 'required',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable',
        ]);

        return PertumbuhanAnak::create($request->all());
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
            return PertumbuhanAnak::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return PertumbuhanAnak::where('id', $id)->first();
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
            "berat_badan" => 'nullable',
            "zscore" => 'nullable',
            "hasil" => 'nullable',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable',
        ]);

        $pertumbuhanAnak = PertumbuhanAnak::find($id);

        if ($pertumbuhanAnak) {
            $pertumbuhanAnak->update($request->all());
            return $pertumbuhanAnak;
        }

        return response([
            'message' => "Pertumbuhan Anak with id $id doesn't exist"
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
        $pertumbuhanAnak = PertumbuhanAnak::find($id);

        if (!$pertumbuhanAnak) {
            return response([
                'message' => "Stunting Anak with id $id doesn't exist"
            ], 400);
        }

        return $pertumbuhanAnak->delete();
    }
}
