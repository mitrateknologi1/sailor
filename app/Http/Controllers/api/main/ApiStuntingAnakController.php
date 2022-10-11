<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\StuntingAnak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiTugas;

class ApiStuntingAnakController extends Controller
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
        $stuntingAnak = new StuntingAnak;

        if ($relation) {
            $stuntingAnak = StuntingAnak::with('bidan', 'anggotaKeluarga');
        }
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
        $stuntingAnak = StuntingAnak::with('bidan', 'anggotaKeluarga')->where(function ($query) use ($lokasiTugas) {
            if (Auth::user()->role != 'admin') { // bidan/penyuluh
                $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                });
            }
            if (Auth::user()->role == 'bidan') { // bidan
                $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
            }

            if (Auth::user()->role == 'penyuluh') { // penyuluh
                $query->where('is_valid', 1);
            }
        });

        $data = $stuntingAnak->orderBy('updated_at', 'desc')->get();
        foreach ($data as $d) {
            $d->anggotaKeluarga->kartu_keluarga = $d->anggotaKeluarga->kartuKeluarga;
            
            $d->anggotaKeluarga->wilayahDomisili->provinsi = $d->anggotaKeluarga->wilayahDomisili->provinsi;
            $d->anggotaKeluarga->wilayahDomisili->kabupatenKota = $d->anggotaKeluarga->wilayahDomisili->kabupatenKota;
            $d->anggotaKeluarga->wilayahDomisili->kecamatan = $d->anggotaKeluarga->wilayahDomisili->kecamatan;
            $d->anggotaKeluarga->wilayahDomisili->desaKelurahan = $d->anggotaKeluarga->wilayahDomisili->desaKelurahan;
        }
        return $data;

        // return $stuntingAnak->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            'tinggi_badan' => 'required',
            'zscore' => 'required',
            'kategori' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        return StuntingAnak::create($request->all());
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
            return StuntingAnak::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return StuntingAnak::where('id', $id)->first();
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
            'tinggi_badan' => 'nullable',
            'zscore' => 'nullable',
            'kategori' => 'nullable',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $stuntingAnak = StuntingAnak::find($id);

        if ($stuntingAnak) {
            $stuntingAnak->update($request->all());
            return $stuntingAnak;
        }

        return response([
            'message' => "Stunting Anak with id $id doesn't exist"
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
        $stuntingAnak = StuntingAnak::find($id);

        if (!$stuntingAnak) {
            return response([
                'message' => "Stunting Anak with id $id doesn't exist"
            ], 400);
        }

        return $stuntingAnak->delete();
    }
}
