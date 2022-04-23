<?php

namespace App\Http\Controllers\dashboard\utama;

use App\Http\Controllers\Controller;
use App\Models\StuntingAnak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesMapController extends Controller
{
    public function index()
    {
        $stuntingAnak =
            DB::table('stunting_anak')
            ->whereRaw('id in (select max(id) from stunting_anak group by (anggota_keluarga_id))')
            ->get();

        $totalStuntingAnak = $stuntingAnak->where('kategori', 'Tinggi')->count();

        return response()->json($totalStuntingAnak);
    }
}
