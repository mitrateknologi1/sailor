<?php

namespace App\Http\Controllers\dashboard\utama\petaData;

use App\Exports\TumbuhKembangExport;
use App\Http\Controllers\Controller;
use App\Models\DesaKelurahan;
use App\Models\Kecamatan;
use App\Models\PertumbuhanAnak;
use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MapTumbuhKembangController extends Controller
{
    function __construct()
    {
        $this->middleware('profil_ada');
        $this->middleware('bukanKeluarga');
    }

    public function index()
    {
        $provinsi = Provinsi::all();
        return view('dashboard.pages.utama.petaData.tumbuhKembang.index', compact(['provinsi']));
    }

    public function getMapDataPertumbuhanAnak(Request $request)
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
            $pertumbuhanAnak =
                PertumbuhanAnak::with('anggotaKeluarga')
                ->whereRaw('id in (select max(id) from pertumbuhan_anak group by (anggota_keluarga_id))')
                ->whereHas('anggotaKeluarga', function ($query) use ($idWilayah, $zoomMap) {
                    if ($zoomMap <= 11) {
                        $query->ofDataSesuaiKecamatan($idWilayah);
                    } else {
                        $query->ofDataSesuaiDesa($idWilayah);
                    }
                })
                ->where('is_valid', 1)
                ->get();

            // Kategori HB
            $totalGiziBuruk = $pertumbuhanAnak->where('hasil', 'Gizi Buruk')->count();
            $totalGiziKurang = $pertumbuhanAnak->where('hasil', 'Gizi Kurang')->count();
            $totalGiziBaik = $pertumbuhanAnak->where('hasil', 'Gizi Baik')->count();
            $totalGiziLebih = $pertumbuhanAnak->where('hasil', 'Gizi Lebih')->count();

            $mapDataArray[] = [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'warnaPolygon' => $wilayah->warna_polygon,
                'koordinatPolygon' => json_decode($wilayah->polygon),
                'totalGiziBuruk' => $totalGiziBuruk,
                'totalGiziKurang' => $totalGiziKurang,
                'totalGiziBaik' => $totalGiziBaik,
                'totalGiziLebih' => $totalGiziLebih,
            ];
        }
        return response()->json($mapDataArray);
    }

    public function getDetailDataPertumbuhanAnak(Request $request)
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

        $mapDataArrayPria = [
            'totalGiziBuruk' => $totalGiziBuruk,
            'totalGiziKurang' => $totalGiziKurang,
            'totalGiziBaik' => $totalGiziBaik,
            'totalGiziLebih' => $totalGiziLebih,
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

        $mapDataArrayWanita = [
            'totalGiziBuruk' => $totalGiziBuruk,
            'totalGiziKurang' => $totalGiziKurang,
            'totalGiziBaik' => $totalGiziBaik,
            'totalGiziLebih' => $totalGiziLebih,
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
            return redirect(url('map-tumbuh-kembang'))
                ->withErrors($validator)
                ->withInput();
        }

        $provinsi = $request->provinsi;
        $kabupaten = $request->kabupaten;
        $zoomMap = $request->zoomMap;
        $hariIni = Carbon::now()->translatedFormat('d F Y');

        return Excel::download(new TumbuhKembangExport($provinsi, $kabupaten, $hariIni, $zoomMap), 'Data-Pertumbuhan-Anak-' . $hariIni . '-' . rand(1000, 9999) . '.xlsx');
    }
}
