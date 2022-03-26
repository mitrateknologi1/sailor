<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use Illuminate\Database\Eloquent\Builder;

class ListController extends Controller
{
    public function getAnak(Request $request)
    {
        if ($request->fungsi == 'pertumbuhan_anak') {
            $tanggalSekarang = date('Y-m-d');
            $tanggalPembanding = date('Y-m-d', strtotime('-5 year', strtotime($tanggalSekarang)));
            $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')
                ->where('id', $request->id)->first();
            $anak = $kartuKeluarga->statusKeluarga('ANAK')
                ->where(function ($query) use ($tanggalPembanding, $tanggalSekarang) {
                    $query->whereBetween('tanggal_lahir', [$tanggalPembanding, $tanggalSekarang]);
                })->get();
            return $anak;
        }
    }

    public function getIbu(Request $request)
    {
        $ibu = AnggotaKeluarga::where('kartu_keluarga_id', $request->id)
            ->where('status_hubungan_dalam_keluarga', 'ISTRI')
            ->get();
        return $ibu;
    }



    public function test()
    {
    }
}
