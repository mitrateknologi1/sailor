<?php

namespace App\Exports;

use App\Models\DesaKelurahan;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\StuntingAnak;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeteksiStuntingExport implements FromView
{
    protected $tab;
    protected $provinsi;
    protected $kabupaten;
    protected $hariIni;
    protected $zoomMap;

    function __construct($tab, $provinsi, $kabupaten, $hariIni, $zoomMap)
    {
        $this->tab = $tab;
        $this->provinsi = $provinsi;
        $this->kabupaten = $kabupaten;
        $this->hariIni = $hariIni;
        $this->zoomMap = $zoomMap;
    }

    public function view(): View
    {
        $tab = $this->tab;
        $provinsi = $this->provinsi;
        $kabupaten = $this->kabupaten;
        $hariIni = $this->hariIni;
        $zoomMap = $this->zoomMap;

        $namaProvinsi = Provinsi::where('id', $provinsi)->first()->nama;
        $namaKabupaten = KabupatenKota::where('id', $kabupaten)->first()->nama;
        $judulWilayah = '';

        if ($tab == 'stunting_anak') {
            $mapDataArray = array();
            $mapDataWilayah = array();
            $mapDataArrayPria = array();
            $mapDataArrayWanita = array();
            if ($zoomMap <= 11) {
                $daftarWilayah = Kecamatan::where('kabupaten_kota_id', $kabupaten)->orderBy('nama', 'asc')->get();
                $judulWilayah = 'Kecamatan';
            } else {
                $daftarWilayah = DesaKelurahan::whereHas('kecamatan', function ($query) use ($kabupaten) {
                    return $query->where('kabupaten_kota_id', $kabupaten);
                })->orderBy('nama', 'asc')->get();
                $judulWilayah = 'Desa / Kelurahan';
            }
            foreach ($daftarWilayah as $wilayah) {
                $idWilayah = $wilayah->id;
                $mapDataWilayah[] = [
                    'id' => $wilayah->id,
                    'nama' => $wilayah->nama,
                ];

                $stuntingAnak =
                    StuntingAnak::with('anggotaKeluarga')
                    ->whereRaw('id in (select max(id) from stunting_anak group by (anggota_keluarga_id))')
                    ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                        if ($zoomMap <= 11) {
                            $query->ofDataSesuaiKecamatan($idWilayah);
                        } else {
                            $query->ofDataSesuaiDesa($idWilayah);
                        }
                        $query->where('jenis_kelamin', 'LAKI-LAKI');
                    })
                    ->where('is_valid', 1)
                    ->get();

                $totalStuntingAnakSangatPendek = $stuntingAnak->where('kategori', 'Sangat Pendek (Resiko Stunting Tinggi)')->count();
                $totalStuntingAnakPendek = $stuntingAnak->where('kategori', 'Pendek (Resiko Stunting Sedang)')->count();
                $totalStuntingAnakNormal = $stuntingAnak->where('kategori', 'Normal')->count();
                $totalStuntingAnakTinggi = $stuntingAnak->where('kategori', 'Tinggi')->count();

                $dataArrayPria[] = [
                    'totalStuntingAnakSangatPendek' => $totalStuntingAnakSangatPendek,
                    'totalStuntingAnakPendek' => $totalStuntingAnakPendek,
                    'totalStuntingAnakNormal' => $totalStuntingAnakNormal,
                    'totalStuntingAnakTinggi' => $totalStuntingAnakTinggi,
                    'totalData' => $totalStuntingAnakSangatPendek + $totalStuntingAnakPendek + $totalStuntingAnakNormal + $totalStuntingAnakTinggi,
                ];

                $stuntingAnak =
                    StuntingAnak::with('anggotaKeluarga')
                    ->whereRaw('id in (select max(id) from stunting_anak group by (anggota_keluarga_id))')
                    ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                        if ($zoomMap <= 11) {
                            $query->ofDataSesuaiKecamatan($idWilayah);
                        } else {
                            $query->ofDataSesuaiDesa($idWilayah);
                        }
                        $query->where('jenis_kelamin', 'PEREMPUAN');
                    })
                    ->where('is_valid', 1)
                    ->get();

                $totalStuntingAnakSangatPendek = $stuntingAnak->where('kategori', 'Sangat Pendek (Resiko Stunting Tinggi)')->count();
                $totalStuntingAnakPendek = $stuntingAnak->where('kategori', 'Pendek (Resiko Stunting Sedang)')->count();
                $totalStuntingAnakNormal = $stuntingAnak->where('kategori', 'Normal')->count();
                $totalStuntingAnakTinggi = $stuntingAnak->where('kategori', 'Tinggi')->count();

                $dataArrayWanita[] = [
                    'totalStuntingAnakSangatPendek' => $totalStuntingAnakSangatPendek,
                    'totalStuntingAnakPendek' => $totalStuntingAnakPendek,
                    'totalStuntingAnakNormal' => $totalStuntingAnakNormal,
                    'totalStuntingAnakTinggi' => $totalStuntingAnakTinggi,
                    'totalData' =>
                    $totalStuntingAnakSangatPendek + $totalStuntingAnakPendek + $totalStuntingAnakNormal + $totalStuntingAnakTinggi,
                ];
            }

            return view('dashboard.pages.utama.petaData.deteksiStunting.exportStuntingAnak', compact(['tab', 'hariIni', 'mapDataWilayah', 'dataArrayPria', 'dataArrayWanita', 'provinsi', 'kabupaten', 'namaProvinsi', 'namaKabupaten', 'judulWilayah']));
        } else {
            if ($zoomMap <= 11) {
                $daftarWilayah = Kecamatan::where('kabupaten_kota_id', $kabupaten)->orderBy('nama', 'asc')->get();
                $judulWilayah = 'Kecamatan';
            } else {
                $daftarWilayah = DesaKelurahan::whereHas('kecamatan', function ($query) use ($kabupaten) {
                    return $query->where('kabupaten_kota_id', $kabupaten);
                })->orderBy('nama', 'asc')->get();
                $judulWilayah = 'Desa / Kecamatan';
            }
            foreach ($daftarWilayah as $wilayah) {
                $idWilayah = $wilayah->id;
                $mapDataWilayah[] = [
                    'id' => $wilayah->id,
                    'nama' => $wilayah->nama,
                ];
                $deteksiIbuMelahirkanStunting =
                    DeteksiIbuMelahirkanStunting::with('anggotaKeluarga')
                    ->whereRaw('id in (select max(id) from deteksi_ibu_melahirkan_stunting group by (anggota_keluarga_id))')
                    ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                        if ($zoomMap <= 11) {
                            $query->ofDataSesuaiKecamatan($idWilayah);
                        } else {
                            $query->ofDataSesuaiDesa($idWilayah);
                        }
                    })
                    ->where('is_valid', 1)
                    ->get();

                $totalBeresikoMelahirkanStunting = $deteksiIbuMelahirkanStunting->where('kategori', 'Beresiko Melahirkan Stunting')->count();
                $totalTidakBeresikoMelahirkanStunting = $deteksiIbuMelahirkanStunting->where('kategori', 'Tidak Beresiko Melahirkan Stunting')->count();

                $dataArray[] = [
                    'totalBeresikoMelahirkanStunting' => $totalBeresikoMelahirkanStunting,
                    'totalTidakBeresikoMelahirkanStunting' => $totalTidakBeresikoMelahirkanStunting,
                    'totalData' => $totalBeresikoMelahirkanStunting + $totalTidakBeresikoMelahirkanStunting,
                ];
            }
            return view('dashboard.pages.utama.petaData.deteksiStunting.exportIbuMelahirkanStunting', compact(['tab', 'hariIni', 'mapDataWilayah', 'dataArray', 'provinsi', 'kabupaten', 'namaProvinsi', 'namaKabupaten', 'judulWilayah']));
        }
    }
}
