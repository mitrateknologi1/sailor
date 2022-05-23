<?php

namespace App\Http\Controllers;

use App\Models\Anc;
use App\Models\DeteksiDini;
use App\Models\StuntingAnak;
use Illuminate\Http\Request;
use App\Models\PertumbuhanAnak;
use App\Models\PerkembanganAnak;
use App\Models\MencegahMalnutrisi;
use App\Models\PerkiraanMelahirkan;
use App\Http\Controllers\Controller;
use App\Models\MencegahPernikahanDini;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\RandaKabilasa;

class LandingPageController extends Controller
{
    public function index()
    {
        $data = [
            'stuntingAnakCount' => StuntingAnak::where('is_valid', 1)->count(),
            'deteksiIbuMelahirkanStuntingCount' => DeteksiIbuMelahirkanStunting::where('is_valid', 1)->count(),
            'perkiraanMelahirkanCount' => PerkiraanMelahirkan::where('is_valid', 1)->count(),
            'deteksiDiniCount' => DeteksiDini::where('is_valid', 1)->count(),
            'ancCount' => Anc::where('is_valid', 1)->count(),
            'perkembanganAnakCount' => PerkembanganAnak::where('is_valid', 1)->count(),
            'pertumbuhanAnakCount' => PertumbuhanAnak::where('is_valid', 1)->count(),
            'mencegahMalnutrisi' => RandaKabilasa::where('is_valid_mencegah_malnutrisi', 1)->count(),
            'mencegahPernikahanDini' => RandaKabilasa::where('is_valid_mencegah_pernikahan_dini', 1)->count(),
            'meningkatkanLifeSkillCount' => RandaKabilasa::where('is_valid_meningkatkan_life_skill', 1)->count(),
        ];
        return view('landingPage.pages.home', $data);
    }
}
