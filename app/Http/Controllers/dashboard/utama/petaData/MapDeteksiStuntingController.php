<?php

namespace App\Http\Controllers\dashboard\utama\petaData;

use App\Exports\DeteksiStuntingExport;
use App\Http\Controllers\Controller;
use App\Models\DesaKelurahan;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\StuntingAnak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MapDeteksiStuntingController extends Controller
{
    function __construct()
    {
        $this->middleware('bukanKeluarga');
    }

    public function index()
    {
        $provinsi = Provinsi::all();
        return view('dashboard.pages.utama.petaData.deteksiStunting.index', compact(['provinsi']));
    }

    public function getMapDataStuntingAnak(Request $request)
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
            $stuntingAnak =
                StuntingAnak::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from stunting_anak group by (anggota_keluarga_id))')
                ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                    if ($zoomMap <= 11) {
                        $query->ofDataSesuaiKecamatan($idWilayah);
                    } else {
                        $query->ofDataSesuaiDesa($idWilayah);
                    }
                })
                ->where('is_valid', 1)
                ->get();

            $totalStuntingAnakSangatPendek = $stuntingAnak->where('kategori', 'Sangat Pendek (Resiko Stunting Tinggi)')->count();
            $totalStuntingAnakPendek = $stuntingAnak->where('kategori', 'Pendek (Resiko Stunting Sedang)')->count();
            $totalStuntingAnakNormal = $stuntingAnak->where('kategori', 'Normal')->count();
            $totalStuntingAnakTinggi = $stuntingAnak->where('kategori', 'Tinggi')->count();

            $mapDataArray[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'koordinatPolygon' => json_decode($wilayah->polygon),
                'warnaPolygon' => $wilayah->warna_polygon,
                'totalStuntingAnakSangatPendek' => $totalStuntingAnakSangatPendek,
                'totalStuntingAnakPendek' => $totalStuntingAnakPendek,
                'totalStuntingAnakNormal' => $totalStuntingAnakNormal,
                'totalStuntingAnakTinggi' => $totalStuntingAnakTinggi,
            ];
        }
        return response()->json($mapDataArray);
    }

    public function getMapDataDeteksiIbuMelahirkanStunting(Request $request)
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


            $mapDataArray[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'koordinatPolygon' => json_decode($wilayah->polygon),
                'warnaPolygon' => $wilayah->warna_polygon,
                'totalBeresikoMelahirkanStunting' => $totalBeresikoMelahirkanStunting,
                'totalTidakBeresikoMelahirkanStunting' => $totalTidakBeresikoMelahirkanStunting,
            ];
        }
        return response()->json($mapDataArray);
    }

    public function getDetailDataStuntingAnak(Request $request)
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

        $mapDataArrayPria = [
            'totalStuntingAnakSangatPendek' => $totalStuntingAnakSangatPendek,
            'totalStuntingAnakPendek' => $totalStuntingAnakPendek,
            'totalStuntingAnakNormal' => $totalStuntingAnakNormal,
            'totalStuntingAnakTinggi' => $totalStuntingAnakTinggi,
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

        $mapDataArrayWanita = [
            'totalStuntingAnakSangatPendek' => $totalStuntingAnakSangatPendek,
            'totalStuntingAnakPendek' => $totalStuntingAnakPendek,
            'totalStuntingAnakNormal' => $totalStuntingAnakNormal,
            'totalStuntingAnakTinggi' => $totalStuntingAnakTinggi,
        ];

        return response()->json([
            'wilayah' => $mapDataWilayah,
            'pria' => $mapDataArrayPria,
            'wanita' => $mapDataArrayWanita
        ]);
    }

    public function getDetailDataIbuMelahirkanStunting(Request $request)
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

        $mapDataArray = [
            'totalBeresikoMelahirkanStunting' => $totalBeresikoMelahirkanStunting,
            'totalTidakBeresikoMelahirkanStunting' => $totalTidakBeresikoMelahirkanStunting,
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
            return redirect(url('map-deteksi-stunting'))
                ->withErrors($validator)
                ->withInput();
        }

        $tab = $request->tab;
        $provinsi = $request->provinsi;
        $kabupaten = $request->kabupaten;
        $zoomMap = $request->zoomMap;
        $hariIni = Carbon::now()->translatedFormat('d F Y');

        $judulExport = $tab == 'stunting_anak' ? "Data-Stunting-Anak" : "Data-Deteksi-Ibu-Melahirkan-Stunting";

        return Excel::download(new DeteksiStuntingExport($tab, $provinsi, $kabupaten, $hariIni, $zoomMap), $judulExport . '-' . $hariIni . '-' . rand(1000, 9999) . '.xlsx');
    }
}
