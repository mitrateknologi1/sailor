<?php

namespace App\Exports;

use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\RandaKabilasa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class RandaKabilasaExport implements FromView
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

    public function view(): View
    {
        $provinsi = $this->provinsi;
        $kabupaten = $this->kabupaten;
        $hariIni = $this->hariIni;
        $zoomMap = $this->zoomMap;

        $namaProvinsi = Provinsi::where('id', $provinsi)->first()->nama;
        $namaKabupaten = KabupatenKota::where('id', $kabupaten)->first()->nama;


        if ($zoomMap <= 11) {
            $daftarWilayah = Kecamatan::where('kabupaten_kota_id', $kabupaten)->get();
            $judulWilayah = 'Kecamatan';
        } else {
            $daftarWilayah = DesaKelurahan::whereHas('kecamatan', function ($query) use ($kabupaten) {
                return $query->where('kabupaten_kota_id', $kabupaten);
            })->get();
            $judulWilayah = 'Desa / Kelurahan';
        }
        foreach ($daftarWilayah as $wilayah) {
            $idWilayah = $wilayah->id;

            $mapDataWilayah[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
            ];

            $randaKabilasa =
                RandaKabilasa::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from randa_kabilasa group by (anggota_keluarga_id))')
                ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                    if ($zoomMap <= 11) {
                        $query->ofDataSesuaiKecamatan($idWilayah);
                    } else {
                        $query->ofDataSesuaiDesa($idWilayah);
                    }
                    $query->where('jenis_kelamin', 'LAKI-LAKI');
                })
                ->where('is_valid_mencegah_malnutrisi', 1)
                ->where('is_valid_mencegah_pernikahan_dini', 1)
                ->where('is_valid_meningkatkan_life_skill', 1)
                ->get();

            // Kategori HB
            $totalHbNormal = $randaKabilasa->where('kategori_hb', 'Normal')->count();
            $totalHbTerindikasiAnemia = $randaKabilasa->where('kategori_hb', 'Terindikasi Anemia')->count();
            $totalHbAnemia = $randaKabilasa->where('kategori_hb', 'Anemia')->count();

            // Kategori Lingkar Lengan Atas
            $totalLingkarKurangGizi = $randaKabilasa->where('kategori_lingkar_lengan_atas', 'Kurang Gizi')->count();
            $totalLingkarNormal = $randaKabilasa->where('kategori_lingkar_lengan_atas', 'Normal')->count();

            // Kategori IMT
            $totalImtSangatKurus = $randaKabilasa->where('kategori_imt', 'Sangat Kurus')->count();
            $totalImtKurus = $randaKabilasa->where('kategori_imt', 'Kurus')->count();
            $totalImtNormal = $randaKabilasa->where('kategori_imt', 'Normal')->count();
            $totalImtGemuk = $randaKabilasa->where('kategori_imt', 'Gemuk')->count();
            $totalImtSangatGemuk = $randaKabilasa->where('kategori_imt', 'Sangat Gemuk')->count();

            // Kategori Mencegah Malnutrisi
            $totalMencegahMalnutrisi = $randaKabilasa->where('kategori_mencegah_malnutrisi', 'Berpartisipasi Mencegah Stunting')->count();
            $totalTidakMencegahMalnutrisi = $randaKabilasa->where('kategori_mencegah_malnutrisi', 'Tidak Berpartisipasi Mencegah Stunting')->count();

            // Kategori Meningkatkan Life Skill
            $totalMeningkatkanLifeSkill = $randaKabilasa->where('kategori_meningkatkan_life_skill', 'Berpartisipasi Mencegah Stunting')->count();
            $totalTidakMeningkatkanLifeSkill = $randaKabilasa->where('kategori_meningkatkan_life_skill', 'Tidak Berpartisipasi Mencegah Stunting')->count();

            // Kategori Mencegah Pernikahan Dini
            $totalMencegahPernikahanDini = $randaKabilasa->where('kategori_mencegah_pernikahan_dini', 'Berpartisipasi Mencegah Stunting')->count();
            $totalTidakMencegahPernikahanDini = $randaKabilasa->where('kategori_mencegah_pernikahan_dini', 'Tidak Berpartisipasi Mencegah Stunting')->count();

            $dataArrayPria[] = [
                'totalHbNormal' => $totalHbNormal,
                'totalHbTerindikasiAnemia' => $totalHbTerindikasiAnemia,
                'totalHbAnemia' => $totalHbAnemia,
                'totalLingkarKurangGizi' => $totalLingkarKurangGizi,
                'totalLingkarNormal' => $totalLingkarNormal,
                'totalImtSangatKurus' => $totalImtSangatKurus,
                'totalImtKurus' => $totalImtKurus,
                'totalImtNormal' => $totalImtNormal,
                'totalImtGemuk' => $totalImtGemuk,
                'totalImtSangatGemuk' => $totalImtSangatGemuk,
                'totalMencegahMalnutrisi' => $totalMencegahMalnutrisi,
                'totalTidakMencegahMalnutrisi' => $totalTidakMencegahMalnutrisi,
                'totalMeningkatkanLifeSkill' => $totalMeningkatkanLifeSkill,
                'totalTidakMeningkatkanLifeSkill' => $totalTidakMeningkatkanLifeSkill,
                'totalMencegahPernikahanDini' => $totalMencegahPernikahanDini,
                'totalTidakMencegahPernikahanDini' => $totalTidakMencegahPernikahanDini,
                'totalData' => $randaKabilasa->count(),
            ];

            // Wanita
            $randaKabilasa =
                RandaKabilasa::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from randa_kabilasa group by (anggota_keluarga_id))')
                ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                    if ($zoomMap <= 11) {
                        $query->ofDataSesuaiKecamatan($idWilayah);
                    } else {
                        $query->ofDataSesuaiDesa($idWilayah);
                    }
                    $query->where('jenis_kelamin', 'PEREMPUAN');
                })
                ->where('is_valid_mencegah_malnutrisi', 1)
                ->where('is_valid_mencegah_pernikahan_dini', 1)
                ->where('is_valid_meningkatkan_life_skill', 1)
                ->get();

            // Kategori HB
            $totalHbNormal = $randaKabilasa->where('kategori_hb', 'Normal')->count();
            $totalHbTerindikasiAnemia = $randaKabilasa->where('kategori_hb', 'Terindikasi Anemia')->count();
            $totalHbAnemia = $randaKabilasa->where('kategori_hb', 'Anemia')->count();

            // Kategori Lingkar Lengan Atas
            $totalLingkarKurangGizi = $randaKabilasa->where('kategori_lingkar_lengan_atas', 'Kurang Gizi')->count();
            $totalLingkarNormal = $randaKabilasa->where('kategori_lingkar_lengan_atas', 'Normal')->count();

            // Kategori IMT
            $totalImtSangatKurus = $randaKabilasa->where('kategori_imt', 'Sangat Kurus')->count();
            $totalImtKurus = $randaKabilasa->where('kategori_imt', 'Kurus')->count();
            $totalImtNormal = $randaKabilasa->where('kategori_imt', 'Normal')->count();
            $totalImtGemuk = $randaKabilasa->where('kategori_imt', 'Gemuk')->count();
            $totalImtSangatGemuk = $randaKabilasa->where('kategori_imt', 'Sangat Gemuk')->count();

            // Kategori Mencegah Malnutrisi
            $totalMencegahMalnutrisi = $randaKabilasa->where('kategori_mencegah_malnutrisi', 'Berpartisipasi Mencegah Stunting')->count();
            $totalTidakMencegahMalnutrisi = $randaKabilasa->where('kategori_mencegah_malnutrisi', 'Tidak Berpartisipasi Mencegah Stunting')->count();

            // Kategori Meningkatkan Life Skill
            $totalMeningkatkanLifeSkill = $randaKabilasa->where('kategori_meningkatkan_life_skill', 'Berpartisipasi Mencegah Stunting')->count();
            $totalTidakMeningkatkanLifeSkill = $randaKabilasa->where('kategori_meningkatkan_life_skill', 'Tidak Berpartisipasi Mencegah Stunting')->count();

            // Kategori Mencegah Pernikahan Dini
            $totalMencegahPernikahanDini = $randaKabilasa->where('kategori_mencegah_pernikahan_dini', 'Berpartisipasi Mencegah Stunting')->count();
            $totalTidakMencegahPernikahanDini = $randaKabilasa->where('kategori_mencegah_pernikahan_dini', 'Tidak Berpartisipasi Mencegah Stunting')->count();

            $dataArrayWanita[] = [
                'totalHbNormal' => $totalHbNormal,
                'totalHbTerindikasiAnemia' => $totalHbTerindikasiAnemia,
                'totalHbAnemia' => $totalHbAnemia,
                'totalLingkarKurangGizi' => $totalLingkarKurangGizi,
                'totalLingkarNormal' => $totalLingkarNormal,
                'totalImtSangatKurus' => $totalImtSangatKurus,
                'totalImtKurus' => $totalImtKurus,
                'totalImtNormal' => $totalImtNormal,
                'totalImtGemuk' => $totalImtGemuk,
                'totalImtSangatGemuk' => $totalImtSangatGemuk,
                'totalMencegahMalnutrisi' => $totalMencegahMalnutrisi,
                'totalTidakMencegahMalnutrisi' => $totalTidakMencegahMalnutrisi,
                'totalMeningkatkanLifeSkill' => $totalMeningkatkanLifeSkill,
                'totalTidakMeningkatkanLifeSkill' => $totalTidakMeningkatkanLifeSkill,
                'totalMencegahPernikahanDini' => $totalMencegahPernikahanDini,
                'totalTidakMencegahPernikahanDini' => $totalTidakMencegahPernikahanDini,
                'totalData' => $randaKabilasa->count(),
            ];
        }
        return view('dashboard.pages.utama.petaData.randaKabilasa.exportRandaKabilasa', compact(['hariIni', 'mapDataWilayah', 'dataArrayPria', 'dataArrayWanita', 'provinsi', 'kabupaten', 'namaProvinsi', 'namaKabupaten', 'judulWilayah']));
    }
}
