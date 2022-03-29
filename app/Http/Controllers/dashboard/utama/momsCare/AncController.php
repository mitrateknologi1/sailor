<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\Anc;
use App\Models\AnggotaKeluarga;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PDO;

class AncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Anc::with(['anggotaKeluarga'])
                // ->where('bidan_id', auth()->user()->id)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-eye"></i></button><a href="' . url('anc/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_valid == 0) {
                        return '<span class="badge badge-danger bg-danger">Belum Divalidasi</span>';
                    } else {
                        return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                    }
                })
                ->addColumn('nama_ibu', function ($row) {
                    return $row->anggotaKeluarga->nama_lengkap;
                })
                ->addColumn('tanggal_haid_terakhir', function ($row) {
                    return Carbon::parse($row->tanggal_haid_terakhir)->translatedFormat('d F Y');
                })
                ->addColumn('selisih_hari', function ($row) {
                    $selisihHari = date_diff(Carbon::now(), Carbon::parse($row->tanggal_perkiraan_lahir));
                    $selisihHariSebut = $selisihHari->y . ' Tahun ' . $selisihHari->m . ' Bulan ' . $selisihHari->d . ' Hari';
                    return $selisihHariSebut;
                })
                ->addColumn('bidan', function ($row) {
                    return "Belum Ada";
                })
                ->addColumn('tanggal_dibuat', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->addColumn('tanggal_validasi', function ($row) {
                    if ($row->tanggal_validasi) {
                        return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['action', 'nama_ibu', 'bidan', 'status', 'tanggal_dibuat', 'tanggal_validasi', 'tanggal_haid_terakhir', 'selisih_hari'])
                ->make(true);
        }
        return view('dashboard.pages.utama.momsCare.anc.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        return view('dashboard.pages.utama.momsCare.anc.create', compact('kartuKeluarga'));
    }

    public function cekPemeriksaan(Request $request)
    {
        $idIbu = $request->id;
        $totalAnc = Anc::where('anggota_keluarga_id', $idIbu)->count();
        return response()->json($totalAnc + 1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function proses(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => 'required',
                'nama_ibu' => 'required',
                'pemeriksaan_ke' => 'required',
                'tanggal_haid_terakhir' => 'required',
                'kehamilan_ke' => 'required',
                'tinggi_badan' => 'required',
                'berat_badan' => 'required',
                'tekanan_darah_sistolik' => 'required',
                'tekanan_darah_diastolik' => 'required',
                'lengan_atas' => 'required',
                'tinggi_fundus' => 'required',
                'hemoglobin_darah' => 'required',
                'denyut_jantung' => 'required',
                'vaksin_tetanus_sebelum_hamil' => 'required',
                'vaksin_tetanus_sesudah_hamil' => 'required',
                'posisi_janin' => 'required',
                'minum_tablet' => 'required',
                'konseling' => 'required'
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_ibu.required' => 'Nama Ibu tidak boleh kosong',
                'pemeriksaan_ke.required' => 'Pemeriksaan Ke tidak boleh kosong',
                'tanggal_haid_terakhir.required' => 'Tanggal Haid Terakhir tidak boleh kosong',
                'kehamilan_ke.required' => 'Kehamilan Ke tidak boleh kosong',
                'tinggi_badan.required' => 'Tinggi Badan tidak boleh kosong',
                'berat_badan.required' => 'Berat Badan tidak boleh kosong',
                'tekanan_darah_sistolik.required' => 'Tekanan Darah Sistolik tidak boleh kosong',
                'tekanan_darah_diastolik.required' => 'Tekanan Darah Diastolik tidak boleh kosong',
                'lengan_atas.required' => 'Lengan Atas tidak boleh kosong',
                'tinggi_fundus.required' => 'Tinggi Fundus tidak boleh kosong',
                'hemoglobin_darah.required' => 'Hemoglobin Darah tidak boleh kosong',
                'denyut_jantung.required' => 'Denyut Jantung tidak boleh kosong',
                'vaksin_tetanus_sebelum_hamil.required' => 'Vaksin Tetanus Sebelum Hamil tidak boleh kosong',
                'vaksin_tetanus_sesudah_hamil.required' => 'Vaksin Tetanus Sesudah Hamil tidak boleh kosong',
                'posisi_janin.required' => 'Posisi Janin tidak boleh kosong',
                'minum_tablet.required' => 'Minum Tablet tidak boleh kosong',
                'konseling.required' => 'Konseling tidak boleh kosong'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $namaKepalaKeluarga = $request->nama_kepala_keluarga;
        $namaIbu = AnggotaKeluarga::where('id', $request->nama_ibu)->first()->nama_lengkap;
        $pemeriksaanKe = $request->pemeriksaan_ke;
        $tanggalHaidTerakhir = $request->tanggal_haid_terakhir;
        $kehamilanKe = $request->kehamilan_ke;
        $tinggiBadan = $request->tinggi_badan;
        $beratBadan = $request->berat_badan;
        $tekananDarahSistolik = $request->tekanan_darah_sistolik;
        $tekananDarahDiastolik = $request->tekanan_darah_diastolik;
        $lenganAtas = $request->lengan_atas;
        $tinggiFundus = $request->tinggi_fundus;
        $denyutJantung = $request->denyut_jantung;
        $hemoglobinDarah = $request->hemoglobin_darah;
        $vaksinTetanusSebelumHamil = $request->vaksin_tetanus_sebelum_hamil;
        $vaksinTetanusSesudahHamil = $request->vaksin_tetanus_sesudah_hamil;
        $posisiJanin = $request->posisi_janin;
        $minumTablet = $request->minum_tablet;
        $konseling = $request->konseling;

        if ($tinggiBadan <= 145) {
            $kategoriTinggiBadan = 'Resiko Tinggi';
        } else {
            $kategoriTinggiBadan = 'Normal';
        }

        if ($tekananDarahSistolik < 90) {
            $kategoriTekananDarah = 'Hipotensi';
        } else if ($tekananDarahSistolik >= 90 && $tekananDarahSistolik <= 120) {
            $kategoriTekananDarah = 'Normal';
        } else if ($tekananDarahSistolik >= 121 && $tekananDarahSistolik <= 139) {
            $kategoriTekananDarah = 'Prahipertensi';
        } else if ($tekananDarahSistolik >= 140) {
            $kategoriTekananDarah = 'Hipertensi';
        }

        if ($lenganAtas <= 23.5) {
            $kategoriLenganAtas = 'Kurang Gizi (BBLR)';
        } else {
            $kategoriLenganAtas = 'Normal';
        }

        if ($denyutJantung >= 120 && $denyutJantung <= 160) {
            $kategoriDenyutJantung = 'Normal';
        } else {
            $kategoriDenyutJantung = 'Tidak Normal';
        }

        if ($hemoglobinDarah >= 11) {
            $kategoriHemoglobinDarah = 'Normal';
        } else {
            $kategoriHemoglobinDarah = 'Anemia';
        }

        $tgl = date("d", strtotime($tanggalHaidTerakhir));
        // baca bulan
        $bln = date("m", strtotime($tanggalHaidTerakhir));
        // baca tahun
        $thn = date("Y", strtotime($tanggalHaidTerakhir));

        $hpl = mktime(0, 0, 0, $bln + 9, $tgl + 7, $thn);

        $selisihHari = date_diff(Carbon::now(), Carbon::parse($hpl));
        $usiaKehamilan = intval((($selisihHari->y * 52) + ($selisihHari->m * 4) + round($selisihHari->d / 7)));
        $tanggalPerkiraanLahir = Carbon::parse($hpl);

        $data = [
            'anggota_keluarga_id' => $request->nama_ibu,
            'nama_kepala_keluarga' => $namaKepalaKeluarga,
            'nama_ibu' => $namaIbu,
            'pemeriksaan_ke' => $pemeriksaanKe,
            'tanggal_haid_terakhir' => $tanggalHaidTerakhir,
            'kehamilan_ke' => $kehamilanKe,
            'tinggi_badan' => $tinggiBadan,
            'berat_badan' => $beratBadan,
            'tekanan_darah_sistolik' => $tekananDarahSistolik,
            'tekanan_darah_diastolik' => $tekananDarahDiastolik,
            'lengan_atas' => $lenganAtas,
            'tinggi_fundus' => $tinggiFundus,
            'denyut_jantung' => $denyutJantung,
            'hemoglobin_darah' => $hemoglobinDarah,
            'vaksin_tetanus_sebelum_hamil' => $vaksinTetanusSebelumHamil,
            'vaksin_tetanus_sesudah_hamil' => $vaksinTetanusSesudahHamil,
            'posisi_janin' => $posisiJanin,
            'minum_tablet' => $minumTablet,
            'konseling' => $konseling,
            'kategori_tinggi_badan' => $kategoriTinggiBadan,
            'kategori_tekanan_darah' => $kategoriTekananDarah,
            'kategori_lengan_atas' => $kategoriLenganAtas,
            'kategori_denyut_jantung' => $kategoriDenyutJantung,
            'kategori_hemoglobin_darah' => $kategoriHemoglobinDarah,
            'usia_kehamilan' => $usiaKehamilan,
            'tanggal_perkiraan_lahir' => $tanggalPerkiraanLahir,
            'tanggal_perkiraan_lahir_sebut' => Carbon::parse($hpl)->format('d F Y'),
            'tanggal_haid_terakhir_sebut' => Carbon::parse($tanggalHaidTerakhir)->format('d F Y'),
        ];

        return $data;
    }


    public function store(Request $request)
    {
        $data = $this->proses($request);

        $role = Auth::user()->role;

        $anc = new Anc();
        $anc->anggota_keluarga_id = $data['anggota_keluarga_id'];
        $anc->pemeriksaan_ke = $data['pemeriksaan_ke'];
        $anc->tanggal_haid_terakhir = Carbon::parse($data['tanggal_haid_terakhir']);
        $anc->kehamilan_ke = $data['kehamilan_ke'];
        $anc->tinggi_badan = $data['tinggi_badan'];
        $anc->berat_badan = $data['berat_badan'];
        $anc->tekanan_darah_sistolik = $data['tekanan_darah_sistolik'];
        $anc->tekanan_darah_diastolik = $data['tekanan_darah_diastolik'];
        $anc->lengan_atas = $data['lengan_atas'];
        $anc->tinggi_fundus = $data['tinggi_fundus'];
        $anc->denyut_jantung_janin = $data['denyut_jantung'];
        $anc->hemoglobin_darah = $data['hemoglobin_darah'];
        $anc->vaksin_tetanus_sebelum_hamil = $data['vaksin_tetanus_sebelum_hamil'];
        $anc->vaksin_tetanus_sesudah_hamil = $data['vaksin_tetanus_sesudah_hamil'];
        $anc->posisi_janin = $data['posisi_janin'];
        $anc->minum_tablet = $data['minum_tablet'];
        $anc->konseling = $data['konseling'];
        $anc->usia_kehamilan = $data['usia_kehamilan'];
        $anc->tanggal_perkiraan_lahir = Carbon::parse($data['tanggal_perkiraan_lahir']);
        if ($role == 'bidan') {
            $anc->bidan_id = Auth::user()->id;
            $anc->tanggal_validasi = Carbon::now();
            $anc->is_valid = 1;
        }
        $anc->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function show(Anc $anc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function edit(Anc $anc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anc $anc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anc $anc)
    {
        $anc->delete();

        return response()->json(['status' => 'success']);
    }
}
