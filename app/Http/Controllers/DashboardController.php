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

        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);

        if (Auth::user()->role == "bidan") {
            $stuntingAnakBelumValidasi = $this->_stunting_anak($lokasiTugas)['belum_validasi'];
            $stuntingAnak = [
                'stuntingAnakBelumValidasi',
            ];
        } else {
            $stuntingAnakTotal = $this->_stunting_anak($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') { // penyuluh
                $stuntingAnak = [
                    'stuntingAnakTotal'
                ];
            } else {
                $stuntingAnakValidasi = $this->_stunting_anak($lokasiTugas)['validasi'];
                $stuntingAnakBelumValidasi = $this->_stunting_anak($lokasiTugas)['belum_validasi'];
                $stuntingAnakDitolak = $this->_stunting_anak($lokasiTugas)['ditolak'];

                $stuntingAnak = [
                    'stuntingAnakValidasi',
                    'stuntingAnakBelumValidasi',
                    'stuntingAnakDitolak',
                    'stuntingAnakTotal'
                ];
            }
        }

        if (Auth::user()->role == 'bidan') {
            $ibuMelahirkanStuntingBelumValidasi = $this->_ibu_melahirkan_stunting($lokasiTugas)['belum_validasi'];
            $ibuMelahirkanStunting = [
                'ibuMelahirkanStuntingBelumValidasi',
            ];
        } else {
            $ibuMelahirkanStuntingTotal = $this->_ibu_melahirkan_stunting($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $ibuMelahirkanStunting = [
                    'ibuMelahirkanStuntingTotal'
                ];
            } else {
                $ibuMelahirkanStuntingValidasi = $this->_ibu_melahirkan_stunting($lokasiTugas)['validasi'];
                $ibuMelahirkanStuntingBelumValidasi = $this->_ibu_melahirkan_stunting($lokasiTugas)['belum_validasi'];
                $ibuMelahirkanStuntingDitolak = $this->_ibu_melahirkan_stunting($lokasiTugas)['ditolak'];

                $ibuMelahirkanStunting = [
                    'ibuMelahirkanStuntingValidasi',
                    'ibuMelahirkanStuntingBelumValidasi',
                    'ibuMelahirkanStuntingDitolak',
                    'ibuMelahirkanStuntingTotal'
                ];
            }
        }


        if (Auth::user()->role == 'bidan') {
            $perkiraanMelahirkanBelumValidasi = $this->_perkiraan_melahirkan($lokasiTugas)['belum_validasi'];
            $perkiraanMelahirkan = [
                'perkiraanMelahirkanBelumValidasi',
            ];
        } else {
            $perkiraanMelahirkanTotal = $this->_perkiraan_melahirkan($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $perkiraanMelahirkan = [
                    'perkiraanMelahirkanTotal'
                ];
            } else {
                $perkiraanMelahirkanValidasi = $this->_perkiraan_melahirkan($lokasiTugas)['validasi'];
                $perkiraanMelahirkanBelumValidasi = $this->_perkiraan_melahirkan($lokasiTugas)['belum_validasi'];
                $perkiraanMelahirkanDitolak = $this->_perkiraan_melahirkan($lokasiTugas)['ditolak'];

                $perkiraanMelahirkan = [
                    'perkiraanMelahirkanValidasi',
                    'perkiraanMelahirkanBelumValidasi',
                    'perkiraanMelahirkanDitolak',
                    'perkiraanMelahirkanTotal'
                ];
            }
        }



        if (Auth::user()->role == 'bidan') {
            $deteksiDiniBelumValidasi = $this->_deteksi_dini($lokasiTugas)['belum_validasi'];
            $deteksiDini = [
                'deteksiDiniBelumValidasi',
            ];
        } else {
            $deteksiDiniTotal = $this->_deteksi_dini($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $deteksiDini = [
                    'deteksiDiniTotal'
                ];
            } else {
                $deteksiDiniValidasi = $this->_deteksi_dini($lokasiTugas)['validasi'];
                $deteksiDiniBelumValidasi = $this->_deteksi_dini($lokasiTugas)['belum_validasi'];
                $deteksiDiniDitolak = $this->_deteksi_dini($lokasiTugas)['ditolak'];

                $deteksiDini = [
                    'deteksiDiniValidasi',
                    'deteksiDiniBelumValidasi',
                    'deteksiDiniDitolak',
                    'deteksiDiniTotal'
                ];
            }
        }

        if (Auth::user()->role == 'bidan') {
            $ancBelumValidasi = $this->_anc($lokasiTugas)['belum_validasi'];
            $anc = [
                'ancBelumValidasi',
            ];
        } else {
            $ancTotal = $this->_anc($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $anc = [
                    'ancTotal'
                ];
            } else {
                $ancValidasi = $this->_anc($lokasiTugas)['validasi'];
                $ancBelumValidasi = $this->_anc($lokasiTugas)['belum_validasi'];
                $ancDitolak = $this->_anc($lokasiTugas)['ditolak'];

                $anc = [
                    'ancValidasi',
                    'ancBelumValidasi',
                    'ancDitolak',
                    'ancTotal'
                ];
            }
        }


        if (Auth::user()->role == 'bidan') {
            $pertumbuhanAnakBelumValidasi = $this->_pertumbuhan_anak($lokasiTugas)['belum_validasi'];
            $pertumbuhanAnak = [
                'pertumbuhanAnakBelumValidasi',
            ];
        } else {
            $pertumbuhanAnakTotal = $this->_pertumbuhan_anak($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $pertumbuhanAnak = [
                    'pertumbuhanAnakTotal'
                ];
            } else {
                $pertumbuhanAnakValidasi = $this->_pertumbuhan_anak($lokasiTugas)['validasi'];
                $pertumbuhanAnakBelumValidasi = $this->_pertumbuhan_anak($lokasiTugas)['belum_validasi'];
                $pertumbuhanAnakDitolak = $this->_pertumbuhan_anak($lokasiTugas)['ditolak'];

                $pertumbuhanAnak = [
                    'pertumbuhanAnakValidasi',
                    'pertumbuhanAnakBelumValidasi',
                    'pertumbuhanAnakDitolak',
                    'pertumbuhanAnakTotal'
                ];
            }
        }

        if (Auth::user()->role == 'bidan') {
            $perkembanganAnakBelumValidasi = $this->_perkembangan_anak($lokasiTugas)['belum_validasi'];
            $perkembanganAnak = [
                'perkembanganAnakBelumValidasi'
            ];
        } else {
            $perkembanganAnakTotal = $this->_perkembangan_anak($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $perkembanganAnak = [
                    'perkembanganAnakTotal'
                ];
            } else {
                $perkembanganAnakValidasi = $this->_perkembangan_anak($lokasiTugas)['validasi'];
                $perkembanganAnakBelumValidasi = $this->_perkembangan_anak($lokasiTugas)['belum_validasi'];
                $perkembanganAnakDitolak = $this->_perkembangan_anak($lokasiTugas)['ditolak'];

                $perkembanganAnak = [
                    'perkembanganAnakValidasi',
                    'perkembanganAnakBelumValidasi',
                    'perkembanganAnakDitolak',
                    'perkembanganAnakTotal'
                ];
            }
        }

        if (Auth::user()->role == 'bidan') {
            $randaKabilasaMencegahMalnutrisiBelumValidasi = $this->_randa_kabilasa($lokasiTugas)['belum_validasi_mencegah_malnutrisi'];
            $randaKabilasaMeningkatkanLifeSkillBelumValidasi = $this->_randa_kabilasa($lokasiTugas)['belum_validasi_meningkatkan_life_skill'];
            $randaKabilasaMencegahPernikahanDiniBelumValidasi = $this->_randa_kabilasa($lokasiTugas)['belum_validasi_mencegah_pernikahan_dini'];
            $randaKabilasa = [
                'randaKabilasaMencegahMalnutrisiBelumValidasi',
                'randaKabilasaMeningkatkanLifeSkillBelumValidasi',
                'randaKabilasaMencegahPernikahanDiniBelumValidasi',
            ];
        } else {
            $randaKabilasaTotal = $this->_randa_kabilasa($lokasiTugas)['total'];
            if (Auth::user()->role == 'penyuluh') {
                $randaKabilasa = [
                    'randaKabilasaTotal',
                ];
            } else {
                $randaKabilasaMencegahMalnutrisiValidasi = $this->_randa_kabilasa($lokasiTugas)['validasi_mencegah_malnutrisi'];
                $randaKabilasaMencegahMalnutrisiDitolak = $this->_randa_kabilasa($lokasiTugas)['ditolak_mencegah_malnutrisi'];
                $randaKabilasaMencegahMalnutrisiBelumValidasi = $this->_randa_kabilasa($lokasiTugas)['belum_validasi_mencegah_malnutrisi'];

                $randaKabilasaMeningkatkanLifeSkillValidasi = $this->_randa_kabilasa($lokasiTugas)['validasi_meningkatkan_life_skill'];
                $randaKabilasaMeningkatkanLifeSkillDitolak = $this->_randa_kabilasa($lokasiTugas)['ditolak_meningkatkan_life_skill'];
                $randaKabilasaMeningkatkanLifeSkillBelumValidasi = $this->_randa_kabilasa($lokasiTugas)['belum_validasi_meningkatkan_life_skill'];
                $randaKabilasaMeningkatkanLifeSkillBelumAsesmen = $this->_randa_kabilasa($lokasiTugas)['belum_asesmen_meningkatkan_life_skill'];

                $randaKabilasaMencegahPernikahanDiniValidasi = $this->_randa_kabilasa($lokasiTugas)['validasi_mencegah_pernikahan_dini'];
                $randaKabilasaMencegahPernikahanDiniDitolak = $this->_randa_kabilasa($lokasiTugas)['ditolak_mencegah_pernikahan_dini'];
                $randaKabilasaMencegahPernikahanDiniBelumValidasi = $this->_randa_kabilasa($lokasiTugas)['belum_validasi_mencegah_pernikahan_dini'];
                $randaKabilasaMencegahPernikahanDiniBelumAsesmen = $this->_randa_kabilasa($lokasiTugas)['belum_asesmen_mencegah_pernikahan_dini'];

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
        }

        if (Auth::user()->role == 'bidan') {
            $anggotaKeluargaBelumValidasi = $this->_anggota_keluarga($lokasiTugas)['belum_validasi'];
            $anggotaKeluarga = [
                'anggotaKeluargaBelumValidasi',
            ];
        } else {
            if (Auth::user()->role == 'penyuluh') {
                $anggotaKeluarga = [];
            } else {
                $anggotaKeluargaValidasi = $this->_anggota_keluarga($lokasiTugas)['validasi'];
                $anggotaKeluargaBelumValidasi = $this->_anggota_keluarga($lokasiTugas)['belum_validasi'];
                $anggotaKeluargaDitolak = $this->_anggota_keluarga($lokasiTugas)['ditolak'];
                $anggotaKeluargaTotal = $this->_anggota_keluarga($lokasiTugas)['total'];

                $anggotaKeluarga = [
                    'anggotaKeluargaValidasi',
                    'anggotaKeluargaBelumValidasi',
                    'anggotaKeluargaDitolak',
                    'anggotaKeluargaTotal'
                ];
            }
        }

        if (Auth::user()->role == 'bidan') {
            $keluargaBelumValidasi = $this->_keluarga($lokasiTugas)['belum_validasi'];
            $keluarga = [
                'keluargaBelumValidasi',
            ];
        } else {
            if (Auth::user()->role == 'penyuluh') {
                $keluarga = [];
            } else {
                $keluargaValidasi = $this->_keluarga($lokasiTugas)['validasi'];
                $keluargaBelumValidasi = $this->_keluarga($lokasiTugas)['belum_validasi'];
                $keluargaDitolak = $this->_keluarga($lokasiTugas)['ditolak'];
                $keluargaTotal = $this->_keluarga($lokasiTugas)['total'];

                $keluarga = [
                    'keluargaValidasi',
                    'keluargaBelumValidasi',
                    'keluargaDitolak',
                    'keluargaTotal'
                ];
            }
        }

        return view('dashboard.pages.utama.dashboard.semua', compact([$stuntingAnak, $ibuMelahirkanStunting, $perkiraanMelahirkan, $deteksiDini, $anc, $pertumbuhanAnak, $perkembanganAnak, $randaKabilasa, $anggotaKeluarga, $keluarga]));
    }

    private function _stunting_anak($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $stuntingAnak =
                StuntingAnak::with('anggotaKeluarga', 'bidan')
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
                ->get();

            $dataBelumDivalidasi = $stuntingAnak->count();

            $data = [
                'belum_validasi' => $dataBelumDivalidasi,
            ];

            return $data;
        } else {
            $stuntingAnak =
                StuntingAnak::with('anggotaKeluarga', 'bidan')
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
                ->get();
        }

        $dataTotal = $stuntingAnak->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }

        $dataValidasi = $stuntingAnak
            ->where('is_valid', 1)
            ->count();


        $dataDitolak = $stuntingAnak
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $stuntingAnak
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

    private function _ibu_melahirkan_stunting($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $deteksiIbuMelahirkanStunting = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')
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
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $deteksiIbuMelahirkanStunting,
            ];

            return $data;
        } else {
            $deteksiIbuMelahirkanStunting = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')
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
                ->get();
        }

        $dataTotal = $deteksiIbuMelahirkanStunting->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }

        $dataValidasi = $deteksiIbuMelahirkanStunting
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $deteksiIbuMelahirkanStunting
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $deteksiIbuMelahirkanStunting
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

    private function _perkiraan_melahirkan($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $perkiraanMelahirkan = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')
                ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    }
                })
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $perkiraanMelahirkan,
            ];

            return $data;
        } else {
            $perkiraanMelahirkan = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')
                ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    }
                })->get();
        }

        $dataTotal = $perkiraanMelahirkan
            ->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }

        $dataValidasi = $perkiraanMelahirkan
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $perkiraanMelahirkan
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $perkiraanMelahirkan
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

    private function _deteksi_dini($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $deteksiDini = DeteksiDini::with('anggotaKeluarga', 'bidan')
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
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $deteksiDini,
            ];

            return $data;
        } else {
            $deteksiDini = DeteksiDini::with('anggotaKeluarga', 'bidan')
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
                })->get();
        }

        $dataTotal = $deteksiDini
            ->count();

        $dataValidasi = $deteksiDini
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $deteksiDini
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $deteksiDini
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

    private function _anc($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $anc = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')
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
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $anc,
            ];

            return $data;
        } else {
            $anc = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')
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
                })->get();
        }

        $dataTotal = $anc
            ->count();

        $dataValidasi = $anc
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $anc
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $anc
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

    private function _pertumbuhan_anak($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $pertumbuhanAnak = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
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
                })
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $pertumbuhanAnak,
            ];

            return $data;
        } else {
            $pertumbuhanAnak = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
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
                })->get();
        }

        $dataTotal = $pertumbuhanAnak->count();

        $dataValidasi = $pertumbuhanAnak
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $pertumbuhanAnak
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $pertumbuhanAnak
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

    private function _perkembangan_anak($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $perkembanganAnak = PerkembanganAnak::with('anggotaKeluarga', 'bidan')
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
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $perkembanganAnak,
            ];

            return $data;
        } else {
            $perkembanganAnak = PerkembanganAnak::with('anggotaKeluarga', 'bidan')
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
                })->get();
        }

        $dataTotal = $perkembanganAnak->count();

        $dataValidasi = $perkembanganAnak
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $perkembanganAnak
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $perkembanganAnak
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

    private function _randa_kabilasa($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $dataBelumDivalidasiMencegahMalnutrisi = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')
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

            $dataBelumValidasiMeningkatkanLifeSkill = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')
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

            $dataBelumValidasiMencegahPernikahanDini = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')
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

            $data = [
                'belum_validasi_mencegah_malnutrisi' => $dataBelumDivalidasiMencegahMalnutrisi,
                'belum_validasi_meningkatkan_life_skill' => $dataBelumValidasiMeningkatkanLifeSkill,
                'belum_validasi_mencegah_pernikahan_dini' => $dataBelumValidasiMencegahPernikahanDini,

            ];

            return $data;
        } else {
            $randaKabilasa = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')
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
                })->get();
        }

        $dataTotal = $randaKabilasa
            ->count();

        if (Auth::user()->role == 'penyuluh') { // penyuluh
            $data = [
                'total' => $dataTotal,
            ];

            return $data;
        }


        $dataValidasiMencegahMalnutrisi = $randaKabilasa
            ->where('is_mencegah_malnutrisi', 1)
            ->where('is_valid_mencegah_malnutrisi', 1)
            ->count();

        $dataDitolakMencegahMalnutrisi = $randaKabilasa
            ->where('is_mencegah_malnutrisi', 1)
            ->where('is_valid_mencegah_malnutrisi', 2)
            ->count();

        $dataBelumDivalidasiMencegahMalnutrisi = $randaKabilasa
            ->where('is_mencegah_malnutrisi', 1)
            ->where('is_valid_mencegah_malnutrisi', 0)
            ->count();


        $dataValidasiMeningkatkanLifeSkill = $randaKabilasa
            ->where('is_meningkatkan_life_skill', 1)
            ->where('is_valid_meningkatkan_life_skill', 1)
            ->count();

        $dataDitolakMeningkatkanLifeSkill = $randaKabilasa
            ->where('is_meningkatkan_life_skill', 1)
            ->where('is_valid_meningkatkan_life_skill', 2)
            ->count();

        $dataBelumValidasiMeningkatkanLifeSkill = $randaKabilasa
            ->where('is_meningkatkan_life_skill', 1)
            ->where('is_valid_meningkatkan_life_skill', 0)
            ->count();

        $dataBelumAsesmenMeningkatkanLifeSkill = $randaKabilasa
            ->where('is_meningkatkan_life_skill', 0)
            ->count();

        $dataValidasiMencegahPernikahanDini = $randaKabilasa
            ->where('is_mencegah_pernikahan_dini', 1)
            ->where('is_valid_mencegah_pernikahan_dini', 1)
            ->count();

        $dataDitolakMencegahPernikahanDini = $randaKabilasa
            ->where('is_mencegah_pernikahan_dini', 1)
            ->where('is_valid_mencegah_pernikahan_dini', 2)
            ->count();

        $dataBelumValidasiMencegahPernikahanDini = $randaKabilasa
            ->where('is_mencegah_pernikahan_dini', 1)
            ->where('is_valid_mencegah_pernikahan_dini', 0)
            ->count();

        $dataBelumAsesmenMencegahPernikahanDini = $randaKabilasa
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

    private function _keluarga($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $keluarga = KartuKeluarga::where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->whereHas('kepalaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
            })
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $keluarga,
            ];

            return $data;
        } else {
            $keluarga = KartuKeluarga::where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->whereHas('kepalaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
            })->get();
        }

        $dataTotal = $keluarga->count();

        $dataValidasi = $keluarga
            ->where('is_valid', 1)
            ->count();


        $dataDitolak = $keluarga
            ->where('is_valid', 2)
            ->count();
        $dataBelumDivalidasi = $keluarga
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

    private function _anggota_keluarga($lokasiTugas)
    {
        if (Auth::user()->role == 'bidan') {
            $anggotaKeluarga = AnggotaKeluarga::where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                }
            })
                ->where('is_valid', 0)
                ->count();

            $data = [
                'belum_validasi' => $anggotaKeluarga,
            ];

            return $data;
        } else {
            $anggotaKeluarga = AnggotaKeluarga::where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                }
            })->get();
        }

        $dataTotal = $anggotaKeluarga->count();

        $dataValidasi = $anggotaKeluarga
            ->where('is_valid', 1)
            ->count();

        $dataDitolak = $anggotaKeluarga
            ->where('is_valid', 2)
            ->count();

        $dataBelumDivalidasi = $anggotaKeluarga
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
