<?php

namespace App\Http\Controllers;

use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\StuntingAnak;
use App\Models\WilayahDomisili;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function getAnak(Request $request)
    {
        if ($request->rentang_umur == 'balita') {
            $id = $request->id;
            $profil_id = Auth::user()->profil->id; //bidan/penyuluh
            $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);
            $tanggalSekarang = date('Y-m-d');
            $tanggalPembanding = date('Y-m-d', strtotime('-5 year', strtotime($tanggalSekarang)));

            $lokasiAnak = '';
            if ($request->method == "PUT") {
                $anak = AnggotaKeluarga::with('wilayahDomisili')->withTrashed()->valid()->where('id', $request->id_anak)->first();
                $lokasiAnak = $anak->wilayahDomisili->desa_kelurahan_id;
            }

            $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                ->where('status_hubungan_dalam_keluarga_id', 4)
                ->whereBetween('tanggal_lahir', [$tanggalPembanding, $tanggalSekarang])
                ->whereHas('wilayahDomisili', function ($query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        return $query->whereIn('desa_kelurahan_id', $lokasiTugas);
                    }
                })

                ->orWhere(function ($query) use ($request, $id) {
                    if (($request->method == 'PUT')) {
                        $query->where('id', $request->id_anak);
                        $query->where('kartu_keluarga_id', $id);
                        $query->where('status_hubungan_dalam_keluarga_id', 4);
                    }
                })

                ->orderBy('tanggal_lahir', 'desc')
                ->get();

            if (Auth::user()->role == 'keluarga') {
                $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                    ->where('status_hubungan_dalam_keluarga_id', 4)
                    ->whereBetween('tanggal_lahir', [$tanggalPembanding, $tanggalSekarang])
                    ->orderBy('tanggal_lahir', 'desc')
                    ->get();
            }

            $anggotaKeluargaHapus = '';
            if ($request->method == "PUT") {
                $idAnak = $request->id_anak;
                $anggotaKeluargaHapus = AnggotaKeluarga::where('kartu_keluarga_id', $id)
                    ->where('status_hubungan_dalam_keluarga_id', 4)
                    ->whereBetween('tanggal_lahir', [$tanggalPembanding, $tanggalSekarang])
                    ->whereHas('wilayahDomisili', function ($query) use ($lokasiTugas, $lokasiAnak) {
                        if (Auth::user()->role != 'admin') {
                            return $query->whereIn('desa_kelurahan_id', $lokasiTugas)->orWhere('desa_kelurahan_id', $lokasiAnak);
                        }
                    })
                    ->onlyTrashed()
                    ->where('id', $idAnak)
                    ->first();
            }
            return response()->json([
                'anggota_keluarga' => $anggotaKeluarga,
                'anggota_keluarga_hapus' => $anggotaKeluargaHapus
            ]);
        } else if ($request->rentang_umur == 'semua_umur') {
            $id = $request->id;
            $profil_id = Auth::user()->profil->id; //bidan/penyuluh
            $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);
            $lokasiAnak = '';
            if ($request->method == "PUT") {
                $anak = AnggotaKeluarga::with('wilayahDomisili')->valid()->withTrashed()->where('id', $request->id_anak)->first();
                $lokasiAnak = $anak->wilayahDomisili->desa_kelurahan_id;
            }

            $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                ->where('status_hubungan_dalam_keluarga_id', 4)
                ->whereHas('wilayahDomisili', function ($query) use ($request, $lokasiTugas, $lokasiAnak) {
                    if (Auth::user()->role != 'admin') {
                        $query->whereIn('desa_kelurahan_id', $lokasiTugas);
                    }
                })

                ->orWhere(function ($query) use ($request, $id) {
                    if (($request->method == 'PUT')) {
                        $query->where('id', $request->id_anak);
                        $query->where('kartu_keluarga_id', $id);
                        $query->where('status_hubungan_dalam_keluarga_id', 4);
                    }
                })

                ->orderBy('tanggal_lahir', 'desc')
                ->get();

            if (Auth::user()->role == 'keluarga') {
                $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                    ->where('status_hubungan_dalam_keluarga_id', 4)
                    ->orderBy('tanggal_lahir', 'desc')
                    ->get();
            }

            $anggotaKeluargaHapus = '';
            if ($request->method == "PUT") {
                $idAnak = $request->id_anak;
                $anggotaKeluargaHapus = AnggotaKeluarga::where('kartu_keluarga_id', $id)
                    ->where('status_hubungan_dalam_keluarga_id', 4)
                    ->whereHas('wilayahDomisili', function ($query) use ($request, $lokasiTugas, $lokasiAnak) {
                        if (Auth::user()->role != 'admin') {
                            return $query->whereIn('desa_kelurahan_id', $lokasiTugas)->orWhere('desa_kelurahan_id', $lokasiAnak);
                        }
                    })
                    ->onlyTrashed()
                    ->where('id', $idAnak)
                    ->first();
            }
            return response()->json([
                'anggota_keluarga' => $anggotaKeluarga,
                'anggota_keluarga_hapus' => $anggotaKeluargaHapus
            ]);
        } else if ($request->rentang_umur == 'remaja') {
            $id = $request->id;
            $profil_id = Auth::user()->profil->id; //bidan/penyuluh
            $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);
            $tanggalSekarang = date('Y-m-d');
            $lokasiAnak = '';
            if ($request->method == "PUT") {
                $anak = AnggotaKeluarga::with('wilayahDomisili')->valid()->withTrashed()->where('id', $request->id_anak)->first();
                $lokasiAnak = $anak->wilayahDomisili->desa_kelurahan_id;
            }

            if (Auth::user()->is_remaja != 1) {
                $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                    ->where('status_hubungan_dalam_keluarga_id', 4)
                    ->whereHas('wilayahDomisili', function ($query) use ($request, $lokasiTugas, $lokasiAnak) {
                        if (Auth::user()->role != 'admin') {
                            if ($request->method == "POST") {
                                return $query->whereIn('desa_kelurahan_id', $lokasiTugas);
                            }
                        }
                    })

                    ->orWhere(function ($query) use ($request, $id) {
                        if (($request->method == 'PUT')) {
                            $query->where('id', $request->id_anak);
                            $query->where('kartu_keluarga_id', $id);
                            $query->where('status_hubungan_dalam_keluarga_id', 4);
                        }
                    })

                    ->whereHas('user', function ($query) {
                        $query->where('is_remaja', 1);
                    })
                    ->orderBy('tanggal_lahir', 'desc')
                    ->get();

                if (Auth::user()->role == 'keluarga') {
                    $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                        ->where('status_hubungan_dalam_keluarga_id', 4)
                        ->whereHas('user', function ($query) {
                            $query->where('is_remaja', 1);
                        })
                        ->orderBy('tanggal_lahir', 'desc')
                        ->get();
                }
            }

            if (Auth::user()->is_remaja == 1) {
                $anggotaKeluarga = AnggotaKeluarga::valid()->withTrashed()->where('id', Auth::user()->profil->id)->get();
            }

            $anggotaKeluargaHapus = '';
            if (Auth::user()->is_remaja != 1) {
                if ($request->method == "PUT") {
                    $idAnak = $request->id_anak;
                    $anggotaKeluargaHapus = AnggotaKeluarga::where('kartu_keluarga_id', $id)
                        ->where('status_hubungan_dalam_keluarga_id', 4)
                        ->whereHas('wilayahDomisili', function ($query) use ($request, $lokasiTugas, $lokasiAnak) {
                            if (Auth::user()->role != 'admin') {
                                return $query->whereIn('desa_kelurahan_id', $lokasiTugas)->orWhere('desa_kelurahan_id', $lokasiAnak);
                            }
                        })
                        ->onlyTrashed()
                        ->where('id', $idAnak)
                        ->first();
                }
            }

            return response()->json([
                'anggota_keluarga' => $anggotaKeluarga,
                'anggota_keluarga_hapus' => $anggotaKeluargaHapus
            ]);
        }
    }

    public function getBidan(Request $request)
    {
        $anak = AnggotaKeluarga::with('wilayahDomisili')
            ->where('id', $request->id)
            ->first();
        $lokasiAnak = $anak->wilayahDomisili->desa_kelurahan_id;
        // return $lokasiAnak;
        $bidan = Bidan::with('lokasiTugas')
            ->whereHas('lokasiTugas', function ($query) use ($lokasiAnak) {
                return $query->where('desa_kelurahan_id', $lokasiAnak);
            })->latest()->get();
        return $bidan;
    }

    public function getBidanAnggotaKeluarga(Request $request)
    {
        $lokasiAnggotaKeluarga = $request->lokasi_id;
        $bidan = Bidan::with('lokasiTugas')
            ->whereHas('lokasiTugas', function ($query) use ($lokasiAnggotaKeluarga) {
                return $query->where('desa_kelurahan_id', $lokasiAnggotaKeluarga);
            })->get();
        return $bidan;
    }

    public function getLokasiTugas(Request $request)
    {
        if ($request->role == 'bidan') {
            $lokasiTugas = LokasiTugas::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')
                // ->where('profil_id', $request->profil_id)
                ->get();
            return $lokasiTugas;
        }
    }

    public function listProvinsi()
    {
        $url = DB::table('provinsi')->where('id', 72)->get(); // khusus sulteng
        $json = json_decode(($url));
        return $json;
    }

    public function listKabupatenKota(Request $request)
    {
        $url = DB::table('kabupaten_kota')->where('provinsi_id', $request->idProvinsi)->orderBy('nama', 'ASC')->get();
        $json = json_decode(($url));
        return $json;
    }

    public function listKecamatan(Request $request)
    {
        $url = DB::table('kecamatan')->where('kabupaten_kota_id', $request->idKabupatenKota)->orderBy('nama', 'ASC')->get();
        $json = json_decode(($url));
        return $json;
    }

    public function listDesaKelurahan(Request $request)
    {
        $url = DB::table('desa_kelurahan')->where('kecamatan_id', $request->idKecamatan)->orderBy('nama', 'ASC')->get();
        $json = json_decode(($url));
        return $json;
    }


    public function getIbu(Request $request)
    {
        $id = $request->id;
        $profil_id = Auth::user()->profil->id; //bidan/penyuluh
        $lokasiTugas = LokasiTugas::ofLokasiTugas($profil_id);

        $lokasiIbu = '';
        if ($request->method == "PUT") {
            $ibu = AnggotaKeluarga::with('wilayahDomisili')->withTrashed()->where('id', $request->id_edit)->first();
            $lokasiIbu = $ibu->wilayahDomisili->desa_kelurahan_id;
        }

        $anggotaKeluarga = AnggotaKeluarga::where('kartu_keluarga_id', $id)
            ->where('status_hubungan_dalam_keluarga_id', 3)

            ->whereHas('wilayahDomisili', function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') {
                    return $query->whereIn('desa_kelurahan_id', $lokasiTugas);
                }
            })

            ->orWhere(function ($query) use ($request, $id) {
                if (($request->method == 'PUT')) {
                    $query->where('id', $request->id_edit);
                    $query->where('kartu_keluarga_id', $id);
                    $query->where('status_hubungan_dalam_keluarga_id', 3);
                }
            })
            ->get();

        if (Auth::user()->role == 'keluarga') {
            $anggotaKeluarga = AnggotaKeluarga::valid()->where('kartu_keluarga_id', $id)
                ->where('status_hubungan_dalam_keluarga_id', 3)
                ->orderBy('tanggal_lahir', 'desc')
                ->get();
        }

        $anggotaKeluargaHapus = '';
        if ($request->method == "PUT") {
            $id_edit = $request->id_edit;
            $anggotaKeluargaHapus = AnggotaKeluarga::where('kartu_keluarga_id', $id)
                ->where('status_hubungan_dalam_keluarga_id', 3)
                ->whereHas('wilayahDomisili', function ($query) use ($request, $lokasiTugas, $lokasiIbu) {
                    if (Auth::user()->role != 'admin') {
                        return $query->whereIn('desa_kelurahan_id', $lokasiTugas)->orWhere('desa_kelurahan_id', $lokasiIbu);
                    }
                })
                ->onlyTrashed()
                ->where('id', $id_edit)
                ->first();
        }
        return response()->json([
            'anggota_keluarga' => $anggotaKeluarga,
            'anggota_keluarga_hapus' => $anggotaKeluargaHapus
        ]);
    }

    public function listProvinsiFitur(Request $request)
    {
        $tabel = $request->fitur;
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh

        $provinsi = Provinsi::whereHas('wilayahDomisili', function ($query) use ($lokasiTugas, $tabel) {
            $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas, $tabel) {
                $query->whereHas($tabel, function ($query) use ($lokasiTugas) {
                    $query->where(function ($query) use ($lokasiTugas) {
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
                    });
                });
            });
        })->get();

        return response()->json($provinsi);
    }

    public function listKabupatenFitur(Request $request)
    {
        $provinsi = $request->provinsi;
        $tabel = $request->fitur;
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh

        $kabupaten = KabupatenKota::whereHas('wilayahDomisili', function ($query) use ($lokasiTugas, $tabel) {
            $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas, $tabel) {
                $query->whereHas($tabel, function ($query) use ($lokasiTugas) {
                    $query->where(function ($query) use ($lokasiTugas) {
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
                    });
                });
            });
        })->where('provinsi_id', $provinsi)->get();

        return response()->json($kabupaten);
    }

    public function listKecamatanFitur(Request $request)
    {
        $kabupaten = $request->kabupaten;
        $tabel = $request->fitur;
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh

        $kecamatan = Kecamatan::whereHas('wilayahDomisili', function ($query) use ($lokasiTugas, $tabel) {
            $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas, $tabel) {
                $query->whereHas($tabel, function ($query) use ($lokasiTugas) {
                    $query->where(function ($query) use ($lokasiTugas) {
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
                    });
                });
            });
        })->where('kabupaten_kota_id', $kabupaten)->get();

        return response()->json($kecamatan);
    }

    public function listDesaFitur(Request $request)
    {
        $kecamatan = $request->kecamatan;
        $tabel = $request->fitur;
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh

        $desa = DesaKelurahan::whereHas('wilayahDomisili', function ($query) use ($lokasiTugas, $tabel) {
            $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas, $tabel) {
                $query->whereHas($tabel, function ($query) use ($lokasiTugas) {
                    $query->where(function ($query) use ($lokasiTugas) {
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
                    });
                });
            });
        })->where('kecamatan_id', $kecamatan)->get();

        return response()->json($desa);
    }
}
