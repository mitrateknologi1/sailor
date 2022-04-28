<?php

namespace App\Http\Controllers\dashboard\utama\petaData;

use App\Http\Controllers\Controller;
use App\Models\DesaKelurahan;
use App\Models\Kecamatan;
use App\Models\PertumbuhanAnak;
use Illuminate\Http\Request;

class MapTumbuhKembangController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.utama.petaData.tumbuhKembang.index');
    }

    public function getMapDataPertumbuhanAnak(Request $request)
    {
        $zoomMap = $request->zoomMap;
        $mapDataArray = array();
        if ($zoomMap <= 11) {
            $daftarWilayah = Kecamatan::whereNotNull('polygon')->get();
        } else {
            $daftarWilayah = DesaKelurahan::whereNotNull('polygon')->get();
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
}
