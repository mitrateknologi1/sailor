<?php

namespace App\Exports;

use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\PertumbuhanAnak;
use App\Models\Provinsi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TumbuhKembangExport implements FromView
{
    protected $provinsi;
    protected $kabupaten;
    protected $hariIni;
    protected $zoomMap;

    function __construct($provinsi, $kabupaten, $hariIni, $zoomMap)
    {
        $this->provinsi = $provinsi;
        $this->kabupaten = $kabupaten;
        $this->hariIni = $hariIni;
        $this->zoomMap = $zoomMap;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $provinsi = $this->provinsi;
        $kabupaten = $this->kabupaten;
        $hariIni = $this->hariIni;
        $zoomMap = $this->zoomMap;

        $namaProvinsi = Provinsi::where('id', $provinsi)->first()->nama;
        $namaKabupaten = KabupatenKota::where('id', $kabupaten)->first()->nama;

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

            $pertumbuhanAnak =
                PertumbuhanAnak::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from pertumbuhan_anak group by (anggota_keluarga_id))')
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

            // Kategori HB
            $totalGiziBuruk = $pertumbuhanAnak->where('hasil', 'Gizi Buruk')->count();
            $totalGiziKurang = $pertumbuhanAnak->where('hasil', 'Gizi Kurang')->count();
            $totalGiziBaik = $pertumbuhanAnak->where('hasil', 'Gizi Baik')->count();
            $totalGiziLebih = $pertumbuhanAnak->where('hasil', 'Gizi Lebih')->count();

            $dataArrayPria[] = [
                'totalGiziBuruk' => $totalGiziBuruk,
                'totalGiziKurang' => $totalGiziKurang,
                'totalGiziBaik' => $totalGiziBaik,
                'totalGiziLebih' => $totalGiziLebih,
                'totalData' => $totalGiziBuruk + $totalGiziKurang + $totalGiziBaik + $totalGiziLebih,
            ];


            $pertumbuhanAnak =
                PertumbuhanAnak::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from pertumbuhan_anak group by (anggota_keluarga_id))')
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

            // Kategori HB
            $totalGiziBuruk = $pertumbuhanAnak->where('hasil', 'Gizi Buruk')->count();
            $totalGiziKurang = $pertumbuhanAnak->where('hasil', 'Gizi Kurang')->count();
            $totalGiziBaik = $pertumbuhanAnak->where('hasil', 'Gizi Baik')->count();
            $totalGiziLebih = $pertumbuhanAnak->where('hasil', 'Gizi Lebih')->count();

            $dataArrayWanita[] = [
                'totalGiziBuruk' => $totalGiziBuruk,
                'totalGiziKurang' => $totalGiziKurang,
                'totalGiziBaik' => $totalGiziBaik,
                'totalGiziLebih' => $totalGiziLebih,
                'totalData' => $totalGiziBuruk + $totalGiziKurang + $totalGiziBaik + $totalGiziLebih,
            ];
        }

        return view('dashboard.pages.utama.petaData.tumbuhKembang.exportTumbuh', compact(['hariIni', 'mapDataWilayah', 'dataArrayPria', 'dataArrayWanita', 'provinsi', 'kabupaten', 'namaProvinsi', 'namaKabupaten', 'judulWilayah']));
    }
}
