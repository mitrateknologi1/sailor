<?php

namespace App\Http\Controllers;

use App\Models\Anc;
use App\Models\DeteksiDini;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\PerkembanganAnak;
use App\Models\PerkiraanMelahirkan;
use App\Models\PertumbuhanAnak;
use App\Models\RandaKabilasa;
use App\Models\StuntingAnak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoValidasiController extends Controller
{
    public function index()
    {
        $this->_validasi(StuntingAnak::where('is_valid', 0)->get());
        $this->_validasi(DeteksiIbuMelahirkanStunting::where('is_valid', 0)->get());
        $this->_validasi(PerkiraanMelahirkan::where('is_valid', 0)->get());
        $this->_validasi(DeteksiDini::where('is_valid', 0)->get());
        $this->_validasi(Anc::where('is_valid', 0)->get());
        $this->_validasi(PerkembanganAnak::where('is_valid', 0)->get());
        $this->_validasi(PertumbuhanAnak::where('is_valid', 0)->get());
        $this->_validasiRandaKabilasa();
        return 'sukses';
    }

    private function _validasi($daftarData)
    {
        foreach ($daftarData as $data) {
            $bidan = $data->anggotaKeluarga->getBidan($data->anggota_keluarga_id);
            if ($bidan) {
                $data->is_valid = 1;
                $data->bidan_id = $bidan->first()->id;
                $data->tanggal_validasi = Carbon::now();
                $data->save();
            }
        }
    }

    private function _validasiRandaKabilasa()
    {
        $daftarRandaKabilasa = RandaKabilasa::where(function ($query) {
            $query->where('is_mencegah_malnutrisi', 1)->where('is_mencegah_pernikahan_dini', 1)->where('is_meningkatkan_life_skill', 1);
        })->where(function ($query) {
            $query->where('is_valid_mencegah_malnutrisi', 0)->orWhere('is_valid_mencegah_pernikahan_dini', 0)->orWhere('is_valid_meningkatkan_life_skill', 0);
        })->get();

        foreach ($daftarRandaKabilasa as $randaKabilasa) {
            $bidan = $randaKabilasa->anggotaKeluarga->getBidan($randaKabilasa->anggota_keluarga_id);
            if ($bidan) {
                $randaKabilasa->is_valid_mencegah_malnutrisi = 1;
                $randaKabilasa->is_valid_mencegah_pernikahan_dini = 1;
                $randaKabilasa->is_valid_meningkatkan_life_skill = 1;
                if (!$randaKabilasa->bidan_id) {
                    $randaKabilasa->bidan_id = $bidan->first()->id;
                }
                $randaKabilasa->tanggal_validasi = Carbon::now();
                $randaKabilasa->save();
            }
        }
    }
}
