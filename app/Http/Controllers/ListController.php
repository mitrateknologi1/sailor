<?php

namespace App\Http\Controllers;

use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function getAnak(Request $request){
        if($request->fungsi == 'pertumbuhan_anak'){ 
            $tanggalSekarang = date('Y-m-d');
            $tanggalPembanding = date('Y-m-d', strtotime('-5 year', strtotime($tanggalSekarang)));
            $profil_id = Auth::user()->profil->id; //bidan/penyuluh
            $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);

            $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')
            ->where('id', $request->id)->first();
            $anak = $kartuKeluarga->statusKeluarga('ANAK')
            ->where(function ($query) use($tanggalPembanding, $tanggalSekarang, $lokasiTugas) {    
                if(Auth::user()->role != 'admin'){ // bidan/penyuluh 
                    // $query->whereHas('anggotaKeluarga', function (Builder $query) use($lokasiTugas) {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    // });
                }    
                // if(Auth::user()->role != 'admin'){
                //     $query->whereIn('desa_kelurahan_id', $lokasiTugas); // menyamakan lokasi anak dengan bidan di lokasi tersebut
                // }
                $query->whereBetween('tanggal_lahir', [$tanggalPembanding, $tanggalSekarang]);
            })
            ->get();
            return $anak;
        }
    }

    public function getLokasiTugas(Request $request){
        if($request->role == 'bidan'){
            $lokasiTugas = LokasiTugas::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
            // ->where('profil_id', $request->profil_id)
            ->get();
            return $lokasiTugas;
        } 
    }

    public function listProvinsi(){
        $url = DB::table('provinsi')->get();
        $json = json_decode(($url));   
        return $json;
    }

    public function listKabupatenKota(Request $request){
        $url = DB::table('kabupaten_kota')->where('provinsi_id', $request->idProvinsi)->get();
        $json = json_decode(($url));   
        return $json;
    }

    public function listKecamatan(Request $request){
        $url = DB::table('kecamatan')->where('kabupaten_kota_id', $request->idKabupatenKota)->get();
        $json = json_decode(($url));   
        return $json;
    }

    public function listDesaKelurahan(Request $request){
        $url = DB::table('desa_kelurahan')->where('kecamatan_id', $request->idKecamatan)->get();
        $json = json_decode(($url));   
        return $json;
    }

    public function test(){

    }
}
