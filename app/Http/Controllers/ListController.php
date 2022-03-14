<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;

class ListController extends Controller
{
    public function getAnak(Request $request){
        if($request->fungsi == 'pertumbuhan_anak'){
            $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->where('id', $request->id)->latest()->get();
            // foreach($kartuKeluarga as $kk){
            //     foreach($kk->anggotaKeluarga as $ak){
            //         if($ak->status_keluarga == 'Anak Kandung'){
            //             $data[] = $ak;
            //         }
            //     }
            // }
            return json_decode($kartuKeluarga);
        }

        
        // $anggotaKeluarga = $kartuKeluarga->anggotaKeluarga;

        // return json_decode($kartuKeluarga);
    }

    public function test(){

    }
}
