<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Anc;
use App\Models\DeteksiDini;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\PerkembanganAnak;
use App\Models\PerkiraanMelahirkan;
use App\Models\PertumbuhanAnak;
use App\Models\RandaKabilasa;
use Illuminate\Support\Facades\Auth;
use App\Models\StuntingAnak;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::user()->profil) {
            return redirect()->route('lengkapiProfil');
        }

        if (Auth::user()->role == 'keluarga') {
            if (Auth::user()->is_remaja == 1) {
                return redirect('randa-kabilasa');
            }
            return view('dashboard.pages.utama.dashboard.keluarga');
        }



        $stuntingAnakTotal = $this->_stunting_anak()['total'];
        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $stuntingAnak = [
                'stuntingAnakTotal'
            ];
        } else {
            $stuntingAnakValidasi = $this->_stunting_anak()['validasi'];
            $stuntingAnakBelumValidasi = $this->_stunting_anak()['belum_validasi'];
            $stuntingAnakDitolak = $this->_stunting_anak()['ditolak'];

            $stuntingAnak = [
                'stuntingAnakValidasi',
                'stuntingAnakBelumValidasi',
                'stuntingAnakDitolak',
                'stuntingAnakTotal'
            ];
        }

        $ibuMelahirkanStuntingTotal = $this->_ibu_melahirkan_stunting()['total'];
        if (Auth::user()->role == 'penyuluh') {
            $ibuMelahirkanStunting = [
                'ibuMelahirkanStuntingTotal'
            ];
        } else {
            $ibuMelahirkanStuntingValidasi = $this->_ibu_melahirkan_stunting()['validasi'];
            $ibuMelahirkanStuntingBelumValidasi = $this->_ibu_melahirkan_stunting()['belum_validasi'];
            $ibuMelahirkanStuntingDitolak = $this->_ibu_melahirkan_stunting()['ditolak'];

            $ibuMelahirkanStunting = [
                'ibuMelahirkanStuntingValidasi',
                'ibuMelahirkanStuntingBelumValidasi',
                'ibuMelahirkanStuntingDitolak',
                'ibuMelahirkanStuntingTotal'
            ];
        }

        $perkiraanMelahirkanTotal = $this->_perkiraan_melahirkan()['total'];
        if (Auth::user()->role == 'penyuluh') {
            $perkiraanMelahirkan = [
                'perkiraanMelahirkanTotal'
            ];
        } else {
            $perkiraanMelahirkanValidasi = $this->_perkiraan_melahirkan()['validasi'];
            $perkiraanMelahirkanBelumValidasi = $this->_perkiraan_melahirkan()['belum_validasi'];
            $perkiraanMelahirkanDitolak = $this->_perkiraan_melahirkan()['ditolak'];

            $perkiraanMelahirkan = [
                'perkiraanMelahirkanValidasi',
                'perkiraanMelahirkanBelumValidasi',
                'perkiraanMelahirkanDitolak',
                'perkiraanMelahirkanTotal'
            ];
        }


        $deteksiDiniTotal = $this->_deteksi_dini()['total'];

        if (Auth::user()->role == 'penyuluh') {
            $deteksiDini = [
                'deteksiDiniTotal'
            ];
        } else {
            $deteksiDiniValidasi = $this->_deteksi_dini()['validasi'];
            $deteksiDiniBelumValidasi = $this->_deteksi_dini()['belum_validasi'];
            $deteksiDiniDitolak = $this->_deteksi_dini()['ditolak'];

            $deteksiDini = [
                'deteksiDiniValidasi',
                'deteksiDiniBelumValidasi',
                'deteksiDiniDitolak',
                'deteksiDiniTotal'
            ];
        }

        $ancTotal = $this->_anc()['total'];
        if (Auth::user()->role == 'penyuluh') {
            $anc = [
                'ancTotal'
            ];
        } else {
            $ancValidasi = $this->_anc()['validasi'];
            $ancBelumValidasi = $this->_anc()['belum_validasi'];
            $ancDitolak = $this->_anc()['ditolak'];

            $anc = [
                'ancValidasi',
                'ancBelumValidasi',
                'ancDitolak',
                'ancTotal'
            ];
        }

        $pertumbuhanAnakTotal = $this->_pertumbuhan_anak()['total'];
        if (Auth::user()->role == 'penyuluh') {
            $pertumbuhanAnak = [
                'pertumbuhanAnakTotal'
            ];
        } else {
            $pertumbuhanAnakValidasi = $this->_pertumbuhan_anak()['validasi'];
            $pertumbuhanAnakBelumValidasi = $this->_pertumbuhan_anak()['belum_validasi'];
            $pertumbuhanAnakDitolak = $this->_pertumbuhan_anak()['ditolak'];

            $pertumbuhanAnak = [
                'pertumbuhanAnakValidasi',
                'pertumbuhanAnakBelumValidasi',
                'pertumbuhanAnakDitolak',
                'pertumbuhanAnakTotal'
            ];
        }

        $perkembanganAnakTotal = $this->_perkembangan_anak()['total'];
        if (Auth::user()->role == 'penyuluh') {
            $perkembanganAnak = [
                'perkembanganAnakTotal'
            ];
        } else {
            $perkembanganAnakValidasi = $this->_perkembangan_anak()['validasi'];
            $perkembanganAnakBelumValidasi = $this->_perkembangan_anak()['belum_validasi'];
            $perkembanganAnakDitolak = $this->_perkembangan_anak()['ditolak'];

            $perkembanganAnak = [
                'perkembanganAnakValidasi',
                'perkembanganAnakBelumValidasi',
                'perkembanganAnakDitolak',
                'perkembanganAnakTotal'
            ];
        }

        $randaKabilasaTotal = $this->_randa_kabilasa()['total'];
        if (Auth::user()->role == 'penyuluh') {
            $randaKabilasa = [
                'randaKabilasaTotal',
            ];
        } else {
            $randaKabilasaMencegahMalnutrisiValidasi = $this->_randa_kabilasa()['validasi_mencegah_malnutrisi'];
            $randaKabilasaMencegahMalnutrisiDitolak = $this->_randa_kabilasa()['ditolak_mencegah_malnutrisi'];
            $randaKabilasaMencegahMalnutrisiBelumValidasi = $this->_randa_kabilasa()['belum_validasi_mencegah_malnutrisi'];

            $randaKabilasaMeningkatkanLifeSkillValidasi = $this->_randa_kabilasa()['validasi_meningkatkan_life_skill'];
            $randaKabilasaMeningkatkanLifeSkillDitolak = $this->_randa_kabilasa()['ditolak_meningkatkan_life_skill'];
            $randaKabilasaMeningkatkanLifeSkillBelumValidasi = $this->_randa_kabilasa()['belum_validasi_meningkatkan_life_skill'];
            $randaKabilasaMeningkatkanLifeSkillBelumAsesmen = $this->_randa_kabilasa()['belum_asesmen_meningkatkan_life_skill'];

            $randaKabilasaMencegahPernikahanDiniValidasi = $this->_randa_kabilasa()['validasi_mencegah_pernikahan_dini'];
            $randaKabilasaMencegahPernikahanDiniDitolak = $this->_randa_kabilasa()['ditolak_mencegah_pernikahan_dini'];
            $randaKabilasaMencegahPernikahanDiniBelumValidasi = $this->_randa_kabilasa()['belum_validasi_mencegah_pernikahan_dini'];
            $randaKabilasaMencegahPernikahanDiniBelumAsesmen = $this->_randa_kabilasa()['belum_asesmen_mencegah_pernikahan_dini'];

            $randaKabilasa = [
                'randaKabilasaTotal',
                'randaKabilasaMencegahMalnutrisiValidasi',
                'randaKabilasaMencegahMalnutrisiDitolak',
                'randaKabilasaMencegahMalnutrisiBelumValidasi',
                'randaKabilasaMeningkatkanLifeSkillValidasi',
                'randaKabilasaMeningkatkanLifeSkillDitolak',
                'randaKabilasaMeningkatkanLifeSkillBelumValidasi',
                'randaKabilasaMeningkatkanLifeSkillBelumAsesmen',
                'randaKabilasaMencegahPernikahanDiniValidasi',
                'randaKabilasaMencegahPernikahanDiniDitolak',
                'randaKabilasaMencegahPernikahanDiniBelumValidasi',
                'randaKabilasaMencegahPernikahanDiniBelumAsesmen'
            ];
        }


        if (Auth::user()->role == 'penyuluh') {
            $anggotaKeluarga = [];
        } else {
            $anggotaKeluargaValidasi = $this->_anggota_keluarga()['validasi'];
            $anggotaKeluargaBelumValidasi = $this->_anggota_keluarga()['belum_validasi'];
            $anggotaKeluargaDitolak = $this->_anggota_keluarga()['ditolak'];
            $anggotaKeluargaTotal = $this->_anggota_keluarga()['total'];

            $anggotaKeluarga = [
                'anggotaKeluargaValidasi',
                'anggotaKeluargaBelumValidasi',
                'anggotaKeluargaDitolak',
                'anggotaKeluargaTotal'
            ];
        }

        if (Auth::user()->role == 'penyuluh') {
            $keluarga = [];
        } else {
            $keluargaValidasi = $this->_keluarga()['validasi'];
            $keluargaBelumValidasi = $this->_keluarga()['belum_validasi'];
            $keluargaDitolak = $this->_keluarga()['ditolak'];
            $keluargaTotal = $this->_keluarga()['total'];

            $keluarga = [
                'keluargaValidasi',
                'keluargaBelumValidasi',
                'keluargaDitolak',
                'keluargaTotal'
            ];
        }


        return view('dashboard.pages.utama.dashboard.semua', compact([$stuntingAnak, $ibuMelahirkanStunting, $perkiraanMelahirkan, $deteksiDini, $anc, $pertumbuhanAnak, $perkembanganAnak, $randaKabilasa, $anggotaKeluarga, $keluarga]));
    }

    private function _stunting_anak()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh

        $dataTotal = StuntingAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }

        $dataValidasi = StuntingAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 1)
            ->count();


        $dataDitolak = StuntingAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = StuntingAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _ibu_melahirkan_stunting()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);

        $dataTotal = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
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
            })
            ->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }

        $dataValidasi = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _perkiraan_melahirkan()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $dataTotal = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                }
            })
            ->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }

        $dataValidasi = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _deteksi_dini()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $dataTotal = DeteksiDini::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
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
            })
            ->count();

        $dataValidasi = DeteksiDini::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = DeteksiDini::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = DeteksiDini::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _anc()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $dataTotal = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
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
            })
            ->count();

        $dataValidasi = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _pertumbuhan_anak()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $dataTotal = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });

                    if (Auth::user()->role == 'bidan') { // bidan
                        $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                    }

                    if (Auth::user()->role == 'penyuluh') { // penyuluh
                        $query->valid();
                    }
                }
            })->count();

        $dataValidasi = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });

                    if (Auth::user()->role == 'bidan') { // bidan
                        $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                    }
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });

                    if (Auth::user()->role == 'bidan') { // bidan
                        $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                    }
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });

                    if (Auth::user()->role == 'bidan') { // bidan
                        $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                    }
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _perkembangan_anak()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $dataTotal = PerkembanganAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
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
            })->count();

        $dataValidasi = PerkembanganAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = PerkembanganAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = PerkembanganAnak::with('anggotaKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_valid', 0)
            ->count();


        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _randa_kabilasa()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $dataTotal = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }

                if (Auth::user()->role == 'penyuluh') { // penyuluh
                    $query->where('is_valid_mencegah_malnutrisi', 1);
                    $query->where('is_valid_mencegah_pernikahan_dini', 1);
                    $query->where('is_valid_meningkatkan_life_skill', 1);
                }
            })
            ->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }


        $dataValidasiMencegahMalnutrisi = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_malnutrisi', 1)
            ->where('is_valid_mencegah_malnutrisi', 1)
            ->count();

        $dataDitolakMencegahMalnutrisi = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_malnutrisi', 1)
            ->where('is_valid_mencegah_malnutrisi', 2)
            ->count();

        $dataBelumDivalidasiMencegahMalnutrisi = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_malnutrisi', 1)
            ->where('is_valid_mencegah_malnutrisi', 0)
            ->count();


        $dataValidasiMeningkatkanLifeSkill = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_meningkatkan_life_skill', 1)
            ->where('is_valid_meningkatkan_life_skill', 1)
            ->count();

        $dataDitolakMeningkatkanLifeSkill = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_meningkatkan_life_skill', 1)
            ->where('is_valid_meningkatkan_life_skill', 2)
            ->count();

        $dataBelumValidasiMeningkatkanLifeSkill = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_meningkatkan_life_skill', 1)
            ->where('is_valid_meningkatkan_life_skill', 0)
            ->count();

        $dataBelumAsesmenMeningkatkanLifeSkill = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_meningkatkan_life_skill', 0)
            ->count();

        $dataValidasiMencegahPernikahanDini = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_pernikahan_dini', 1)
            ->where('is_valid_mencegah_pernikahan_dini', 1)
            ->count();

        $dataDitolakMencegahPernikahanDini = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_pernikahan_dini', 1)
            ->where('is_valid_mencegah_pernikahan_dini', 2)
            ->count();

        $dataBelumValidasiMencegahPernikahanDini = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_pernikahan_dini', 1)
            ->where('is_valid_mencegah_pernikahan_dini', 0)
            ->count();

        $dataBelumAsesmenMencegahPernikahanDini = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
            })
            ->where('is_mencegah_pernikahan_dini', 0)
            ->count();

        $data = [
            'total' => $dataTotal,

            'validasi_mencegah_malnutrisi' => $dataValidasiMencegahMalnutrisi,
            'ditolak_mencegah_malnutrisi' => $dataDitolakMencegahMalnutrisi,
            'belum_validasi_mencegah_malnutrisi' => $dataBelumDivalidasiMencegahMalnutrisi,

            'validasi_meningkatkan_life_skill' => $dataValidasiMeningkatkanLifeSkill,
            'ditolak_meningkatkan_life_skill' => $dataDitolakMeningkatkanLifeSkill,
            'belum_validasi_meningkatkan_life_skill' => $dataBelumValidasiMeningkatkanLifeSkill,
            'belum_asesmen_meningkatkan_life_skill' => $dataBelumAsesmenMeningkatkanLifeSkill,

            'validasi_mencegah_pernikahan_dini' => $dataValidasiMencegahPernikahanDini,
            'ditolak_mencegah_pernikahan_dini' => $dataDitolakMencegahPernikahanDini,
            'belum_validasi_mencegah_pernikahan_dini' => $dataBelumValidasiMencegahPernikahanDini,
            'belum_asesmen_mencegah_pernikahan_dini' => $dataBelumAsesmenMencegahPernikahanDini,

        ];

        return $data;
    }

    private function _keluarga()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
        $dataTotal = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')->where(function ($query) use ($lokasiTugas) {
            $query->whereIn('is_valid', [1, 2]);
            $query->orWhere(function ($query) use ($lokasiTugas) {
                $query->where('is_valid', 0);
                $query->whereHas('kepalaKeluarga', function ($query) use ($lokasiTugas) {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                });
            });
        })->count();

        $dataValidasi = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
            ->where(function ($query) use ($lokasiTugas) {
                $query->whereIn('is_valid', [1, 2]);
                $query->orWhere(function ($query) use ($lokasiTugas) {
                    $query->where('is_valid', 0);
                    $query->whereHas('kepalaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                });
            })
            ->where('is_valid', 1)
            ->count();


        $dataDitolak = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
            ->where(function ($query) use ($lokasiTugas) {
                $query->whereIn('is_valid', [1, 2]);
                $query->orWhere(function ($query) use ($lokasiTugas) {
                    $query->where('is_valid', 0);
                    $query->whereHas('kepalaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                });
            })
            ->where('is_valid', 2)
            ->count();
        $dataBelumDivalidasi = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
            ->where(function ($query) use ($lokasiTugas) {
                $query->whereIn('is_valid', [1, 2]);
                $query->orWhere(function ($query) use ($lokasiTugas) {
                    $query->where('is_valid', 0);
                    $query->whereHas('kepalaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                });
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }

    private function _anggota_keluarga()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
        $dataTotal = AnggotaKeluarga::with('statusHubunganDalamKeluarga', 'bidan')->where(function ($query) use ($lokasiTugas) {
            if (Auth::user()->role != 'admin') {
                $query->whereIn('is_valid', [1, 2]);
                $query->orWhere(function ($query) use ($lokasiTugas) {
                    $query->where('is_valid', 0);
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                });
            }
        })->count();

        $dataValidasi = AnggotaKeluarga::with('statusHubunganDalamKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->whereIn('is_valid', [1, 2]);
                    $query->orWhere(function ($query) use ($lokasiTugas) {
                        $query->where('is_valid', 0);
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    });
                }
            })
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = AnggotaKeluarga::with('statusHubunganDalamKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->whereIn('is_valid', [1, 2]);
                    $query->orWhere(function ($query) use ($lokasiTugas) {
                        $query->where('is_valid', 0);
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    });
                }
            })
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = AnggotaKeluarga::with('statusHubunganDalamKeluarga', 'bidan')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->whereIn('is_valid', [1, 2]);
                    $query->orWhere(function ($query) use ($lokasiTugas) {
                        $query->where('is_valid', 0);
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    });
                }
            })
            ->where('is_valid', 0)
            ->count();

        $data = [
            'validasi' => $dataValidasi,
            'ditolak' => $dataDitolak,
            'belum_validasi' => $dataBelumDivalidasi,
            'total' => $dataTotal
        ];

        return $data;
    }
}
