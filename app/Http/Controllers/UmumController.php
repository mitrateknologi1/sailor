<?php

namespace App\Http\Controllers;

use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UmumController extends Controller
{
    public function cekBidanDomisili(Request $request)
    {
        $kelurahanAnggotaKeluargaID = $request->desaKelurahanID;
        $kelurahanLokasiTugasBidan = LokasiTugas::pluck('desa_kelurahan_id')->toArray();
        if (in_array($kelurahanAnggotaKeluargaID, $kelurahanLokasiTugasBidan)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
