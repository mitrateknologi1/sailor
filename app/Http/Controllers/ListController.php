<?php

namespace App\Http\Controllers;

use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\WilayahDomisili;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function getAnak(Request $request)
    {
        if ($request->fungsi == 'pertumbuhan_anak') {
            $tanggalSekarang = date('Y-m-d');
            $tanggalPembanding = date('Y-m-d', strtotime('-5 year', strtotime($tanggalSekarang)));
            $method = $request->method;
            $anak_id = $request->anak;
            
            if(Auth::user()->role != 'admin'){ // bidan/penyuluh 
                $profil_id = Auth::user()->profil->id; //bidan/penyuluh
                $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);
            } else{
                $lokasiTugas ='';
            }

            $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->where('id', $request->id)->first();
            $anak = $kartuKeluarga->statusKeluarga('ANAK')
            ->where(function ($query) use($tanggalPembanding, $tanggalSekarang, $lokasiTugas, $anak_id, $method){    
                if(Auth::user()->role != 'admin'){ // bidan/penyuluh 
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                }    
                $query->whereBetween('tanggal_lahir', [$tanggalPembanding, $tanggalSekarang]);

                // if($method != 'POST'){
                // }
            })
            ->orWhere('id', $anak_id)->withTrashed()

            ->get();
            return $anak;

        } else if ($request->fungsi == 'perkembangan_anak') {
            if(Auth::user()->role != 'admin'){ // bidan/penyuluh 
                $profil_id = Auth::user()->profil->id; //bidan/penyuluh
                $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);
            } else{
                $lokasiTugas ='';
            }

            $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')
                ->where('id', $request->id)->first();
            $anak = $kartuKeluarga->statusKeluarga('ANAK')
            ->where(function ($query) use($lokasiTugas) {    
                if(Auth::user()->role != 'admin'){ // bidan/penyuluh 
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                }    
            })
            ->get();
            return $anak;
        }
    }

    public function getBidan(Request $request){
        $anak = AnggotaKeluarga::with('wilayahDomisili')
                ->where('id', $request->id)
                ->first();
        $lokasiAnak = $anak->wilayahDomisili->desa_kelurahan_id;
        // return $lokasiAnak;
        $bidan = Bidan::with('lokasiTugas')
        ->whereHas('lokasiTugas', function ($query) use ($lokasiAnak) {
            return $query->where('desa_kelurahan_id', $lokasiAnak);
        })->get();
        return $bidan;
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
