<?php

namespace App\Exports;

use App\Models\Anc;
use App\Models\DesaKelurahan;
use App\Models\DeteksiDini;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MomsCareExport implements FromView
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

        if ($tab == 'deteksi_dini') {
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

                $deteksiDini =
                    DeteksiDini::with('anggotaKeluarga')
                    ->whereRaw('id in (select max(id) from deteksi_dini group by (anggota_keluarga_id))')
                    ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                        if ($zoomMap <= 11) {
                            $query->ofDataSesuaiKecamatan($idWilayah);
                        } else {
                            $query->ofDataSesuaiDesa($idWilayah);
                        }
                    })
                    ->where('is_valid', 1)
                    ->get();

                $totalResikoSangatTinggi = $deteksiDini->where('kategori', 'Kehamilan : KRST (Beresiko SANGAT TINGGI)')->count();
                $totalResikoTinggi = $deteksiDini->where('kategori', 'Kehamilan : KRT (Beresiko TINGGI)')->count();
                $totalResikoRendah = $deteksiDini->where('kategori', 'Kehamilan : KRR (Beresiko Rendah)')->count();

                $dataArray[] = [
                    'totalResikoSangatTinggi' => $totalResikoSangatTinggi,
                    'totalResikoTinggi' => $totalResikoTinggi,
                    'totalResikoRendah' => $totalResikoRendah,
                    'totalData' => $totalResikoSangatTinggi + $totalResikoTinggi + $totalResikoRendah,
                ];
            }
            return view('dashboard.pages.utama.petaData.momsCare.exportDeteksiDini', compact(['tab', 'hariIni', 'mapDataWilayah', 'dataArray', 'provinsi', 'kabupaten', 'namaProvinsi', 'namaKabupaten', 'judulWilayah']));
        } else {
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

                $anc =
                    Anc::with('anggotaKeluarga')
                    ->whereRaw('id in (select max(id) from anc group by (anggota_keluarga_id))')
                    ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                        if ($zoomMap <= 11) {
                            $query->ofDataSesuaiKecamatan($idWilayah);
                        } else {
                            $query->ofDataSesuaiDesa($idWilayah);
                        }
                    })
                    ->where('is_valid', 1)
                    ->get();

                // Kategori Badan
                $totalBadanResikoTinggi = $anc->where('kategori_badan', 'Resiko Tinggi')->count();
                $totalBadanNormal = $anc->where('kategori_badan', 'Normal')->count();

                // Kategori Tekanan Darah
                $totalTekananDarahNormal = $anc->where('kategori_tekanan_darah', 'Normal')->count();
                $totalTekananDarahHipotensi = $anc->where('kategori_tekanan_darah', 'Hipotensi')->count();
                $totalTekananDarahPrahipertensi = $anc->where('kategori_tekanan_darah', 'Prahipertensi')->count();
                $totalTekananDarahHipertensi = $anc->where('kategori_tekanan_darah', 'Hipertensi')->count();

                // Kategori Lengan Atas
                $totalLenganAtasNormal = $anc->where('kategori_lengan_atas', 'Normal')->count();
                $totalLenganAtasKurangGizi = $anc->where('kategori_lengan_atas', 'Kurang Gizi (BBLR)')->count();

                // Kategori Denyut Jantung
                $totalDenyutJantungNormal = $anc->where('kategori_denyut_jantung', 'Normal')->count();
                $totalDenyutJantungTidakNormal = $anc->where('kategori_denyut_jantung', 'Tidak Normal')->count();

                // Kategori Hemoglobin Darah
                $totalHemoglobinDarahNormal = $anc->where('kategori_hemoglobin_darah', 'Normal')->count();
                $totalHemoglobinDarahAnemia = $anc->where('kategori_hemoglobin_darah', 'Anemia')->count();

                // Kategori Vaksin Tetanus Sebelum Hamil
                $totalVaksinSebelumHamilSudah = $anc->where('vaksin_tetanus_sebelum_hamil', 'Sudah')->count();
                $totalVaksinSebelumHamilBelum = $anc->where('vaksin_tetanus_sebelum_hamil', 'Belum')->count();

                // Kategori Vaksin Tetanus Sesudah Hamil
                $totalVaksinSesudahHamilSudah = $anc->where('vaksin_tetanus_sesudah_hamil', 'Sudah')->count();
                $totalVaksinSesudahHamilBelum = $anc->where('vaksin_tetanus_sesudah_hamil', 'Belum')->count();

                // Kategori Posisi Janin
                $totalPosisiJaninNormal = $anc->where('posisi_janin', 'Normal')->count();
                $totalPosisiJaninSungsang = $anc->where('posisi_janin', 'Sungsang')->count();

                // Kategori Konseling
                $totalKonselingSudah = $anc->where('konseling', 'Sudah')->count();
                $totalKonselingBelum = $anc->where('konseling', 'Belum')->count();

                // Kategori Minum 90 Tablet
                $totalMinum90TabletSudah = $anc->where('minum_tablet', 'Sudah')->count();
                $totalMinum90TabletBelum = $anc->where('minum_tablet', 'Belum')->count();

                $dataArray[] = [
                    'totalBadanResikoTinggi' => $totalBadanResikoTinggi,
                    'totalBadanNormal' => $totalBadanNormal,
                    'totalTekananDarahNormal' => $totalTekananDarahNormal,
                    'totalTekananDarahHipotensi' => $totalTekananDarahHipotensi,
                    'totalTekananDarahPrahipertensi' => $totalTekananDarahPrahipertensi,
                    'totalTekananDarahHipertensi' => $totalTekananDarahHipertensi,
                    'totalLenganAtasNormal' => $totalLenganAtasNormal,
                    'totalLenganAtasKurangGizi' => $totalLenganAtasKurangGizi,
                    'totalHemoglobinDarahNormal' => $totalHemoglobinDarahNormal,
                    'totalHemoglobinDarahAnemia' => $totalHemoglobinDarahAnemia,
                    'totalMinum90TabletSudah' => $totalMinum90TabletSudah,
                    'totalMinum90TabletBelum' => $totalMinum90TabletBelum,
                    'totalPosisiJaninNormal' => $totalPosisiJaninNormal,
                    'totalPosisiJaninSungsang' => $totalPosisiJaninSungsang,
                    'totalKonselingSudah' => $totalKonselingSudah,
                    'totalKonselingBelum' => $totalKonselingBelum,
                    'totalVaksinSebelumHamilSudah' => $totalVaksinSebelumHamilSudah,
                    'totalVaksinSebelumHamilBelum' => $totalVaksinSebelumHamilBelum,
                    'totalVaksinSesudahHamilSudah' => $totalVaksinSesudahHamilSudah,
                    'totalVaksinSesudahHamilBelum' => $totalVaksinSesudahHamilBelum,
                    'totalDenyutJantungNormal' => $totalDenyutJantungNormal,
                    'totalDenyutJantungTidakNormal' => $totalDenyutJantungTidakNormal,
                    'totalData' => $anc->count(),
                ];
            }
            return view('dashboard.pages.utama.petaData.momsCare.exportAnc', compact(['tab', 'hariIni', 'mapDataWilayah', 'dataArray', 'provinsi', 'kabupaten', 'namaProvinsi', 'namaKabupaten', 'judulWilayah']));
        }
    }
}
