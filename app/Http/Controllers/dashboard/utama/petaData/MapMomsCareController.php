<?php

namespace App\Http\Controllers\dashboard\utama\petaData;

use App\Exports\MomsCareExport;
use App\Http\Controllers\Controller;
use App\Models\Anc;
use App\Models\DesaKelurahan;
use App\Models\DeteksiDini;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class MapMomsCareController extends Controller
{
    function __construct()
    {
        $this->middleware('bukanKeluarga');
    }

    public function index()
    {
        $provinsi = Provinsi::all();
        return view('dashboard.pages.utama.petaData.momsCare.index', compact(['provinsi']));
    }

    public function getMapDataDeteksiDini(Request $request)
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

            $mapDataArray[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'koordinatPolygon' => json_decode($wilayah->polygon),
                'warnaPolygon' => $wilayah->warna_polygon,
                'totalResikoSangatTinggi' => $totalResikoSangatTinggi,
                'totalResikoTinggi' => $totalResikoTinggi,
                'totalResikoRendah' => $totalResikoRendah,
            ];
        }
        return response()->json($mapDataArray);
    }

    public function getMapDataAnc(Request $request)
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

            // Kategori Hemoglobin Darah
            $totalHemoglobinDarahNormal = $anc->where('kategori_hemoglobin_darah', 'Normal')->count();
            $totalHemoglobinDarahAnemia = $anc->where('kategori_hemoglobin_darah', 'Anemia')->count();

            // Kategori Minum 90 Tablet
            $totalMinum90TabletSudah = $anc->where('minum_tablet', 'Sudah')->count();
            $totalMinum90TabletBelum = $anc->where('minum_tablet', 'Belum')->count();

            $mapDataArray[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'koordinatPolygon' => json_decode($wilayah->polygon),
                'warnaPolygon' => $wilayah->warna_polygon,
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
            ];
        }
        return response()->json($mapDataArray);
    }

    public function getDetailDataDeteksiDini(Request $request)
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

        $mapDataArray = [
            'totalResikoSangatTinggi' => $totalResikoSangatTinggi,
            'totalResikoTinggi' => $totalResikoTinggi,
            'totalResikoRendah' => $totalResikoRendah,
        ];

        return response()->json([
            'wilayah' => $mapDataWilayah,
            'data' => $mapDataArray
        ]);
    }

    public function getDetailDataAnc(Request $request)
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

        $mapDataArray = [
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
        ];

        return response()->json([
            'wilayah' => $mapDataWilayah,
            'data' => $mapDataArray
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

        $tab = $request->tab;
        $provinsi = $request->provinsi;
        $kabupaten = $request->kabupaten;
        $zoomMap = $request->zoomMap;
        $hariIni = Carbon::now()->translatedFormat('d F Y');

        $judulExport = $tab == 'deteksi_dini' ? "Data-Deteksi-Dini" : "Data-ANC";

        return Excel::download(new MomsCareExport($tab, $provinsi, $kabupaten, $hariIni, $zoomMap), $judulExport . '-' . $hariIni . '-' . rand(1000, 9999) . '.xlsx');
    }
}
