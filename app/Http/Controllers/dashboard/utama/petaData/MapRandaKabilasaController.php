<?php

namespace App\Http\Controllers\dashboard\utama\petaData;

use App\Exports\RandaKabilasaExport;
use App\Http\Controllers\Controller;
use App\Models\DesaKelurahan;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\RandaKabilasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MapRandaKabilasaController extends Controller
{
    function __construct()
    {
        $this->middleware('profil_ada');
        $this->middleware('bukanKeluarga');
    }

    public function index()
    {
        return view('dashboard.pages.utama.petaData.randaKabilasa.index');
    }

    public function getMapDataRandaKabilasa(Request $request)
    {
        $zoomMap = $request->zoomMap;
        $mapDataArray = array();
        if ($zoomMap <= 11) {
            $daftarWilayah = Kecamatan::whereNotNull('polygon')->where('kabupaten_kota_id', $request->kabupaten)->get();
        } else {
            $daftarWilayah = DesaKelurahan::whereNotNull('polygon')->whereHas('kecamatan', function ($query) use ($request) {
                return $query->where('kabupaten_kota_id', $request->kabupaten);
            })->get();
        }
        foreach ($daftarWilayah as $wilayah) {
            $idWilayah = $wilayah->id;
            $randaKabilasa =
                RandaKabilasa::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from randa_kabilasa group by (anggota_keluarga_id))')
                ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                    if ($zoomMap <= 11) {
                        $query->ofDataSesuaiKecamatan($idWilayah);
                    } else {
                        $query->ofDataSesuaiDesa($idWilayah);
                    }
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

            $mapDataArray[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'koordinatPolygon' => json_decode($wilayah->polygon),
                'warnaPolygon' => $wilayah->warna_polygon,
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
            ];
        }
        return response()->json($mapDataArray);
    }

    public function getDetailDataRandaKabilasa(Request $request)
    {
        $idWilayah = $request->id;
        $zoomMap = $request->zoomMap;

        if ($zoomMap <= 11) {
            $wilayah = Kecamatan::whereNotNull('polygon')->where('id', $idWilayah)->first();
        } else {
            $wilayah = DesaKelurahan::whereNotNull('polygon')->where('id', $idWilayah)->first();
        }

        $mapDataWilayah = [
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

        $mapDataArrayPria = [
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

        $mapDataArrayWanita = [
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
        ];

        return response()->json([
            'wilayah' => $mapDataWilayah,
            'pria' => $mapDataArrayPria,
            'wanita' => $mapDataArrayWanita
        ]);
    }

    public function export(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'provinsi' => 'required',
                'kabupaten' => 'required',
            ],
            [
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return redirect(url('map-moms-care'))
                ->withErrors($validator)
                ->withInput();
        }

        $provinsi = $request->provinsi;
        $kabupaten = $request->kabupaten;
        $zoomMap = $request->zoomMap;
        $hariIni = Carbon::now()->translatedFormat('d F Y');

        return Excel::download(new RandaKabilasaExport($provinsi, $kabupaten, $hariIni, $zoomMap), 'Data-Randa-Kabilasa-' . $hariIni . '-' . rand(1000, 9999) . '.xlsx');
    }
}
