<?php

namespace App\Http\Controllers\dashboard\utama\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\JawabanMencegahMalnutrisi;
use App\Models\KartuKeluarga;
use App\Models\MencegahMalnutrisi;
use App\Models\RandaKabilasa;
use App\Models\SoalMencegahMalnutrisi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MencegahMalnutrisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        $daftarSoal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.randaKabilasa.mencegahMalnutrisi.create', compact('kartuKeluarga', 'daftarSoal'));
    }

    public function proses(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => 'required',
                'nama_anak' => 'required',
                'nama_bidan' => Auth::user()->role == "admin" && $request->isMethod('post') ? 'required' : '',
                'lingkar_lengan_atas' => 'required',
                'tinggi_badan' => 'required',
                'berat_badan' => 'required',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_anak.required' => 'Nama Anak Tidak Boleh Kosong',
                'nama_bidan.required' => 'Nama Bidan Tidak Boleh Kosong',
                'lingkar_lengan_atas.required' => 'Lingkar Lengan Atas Tidak Boleh Kosong',
                'tinggi_badan.required' => 'Tinggi Badan Tidak Boleh Kosong',
                'berat_badan.required' => 'Berat Badan Tidak Boleh Kosong',
            ]
        );

        if ($request->method() != "PUT") {
            $randaKabilasa = RandaKabilasa::where('anggota_keluarga_id', $request->nama_anak)->where(function ($row) {
                $row->where('is_mencegah_pernikahan_dini', 0);
                $row->orWhere('is_meningkatkan_life_skill', 0);
            })->count();

            if ($randaKabilasa > 0) {
                return response()->json([
                    'error' => [
                        'nama_anak' => [
                            'Harap Selesaikan Seluruh Asesmen Sebelumnya Terlebih Dahulu'
                        ]
                    ]
                ]);
            }
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $pesanError = [];
        $totalSoal = SoalMencegahMalnutrisi::count();

        for ($i = 0; $i < $totalSoal; $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            if ($request->$jawaban == null) {
                $pesanError['jawaban-' . ($i + 1)] = 'Jawaban Tidak Boleh Kosong';
            }
        }

        if (!empty($pesanError)) {
            return response()->json([
                'error' => $pesanError
            ]);
        }

        $soalMencegahMalnutrisi = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();

        // Cek Jawaban
        $skor = 0;
        for ($i = 0; $i < $totalSoal; $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            if ($request->$jawaban[0] == "Tidak") {
                $skor += $soalMencegahMalnutrisi[$i]->skor_tidak;
            } else {
                $skor += $soalMencegahMalnutrisi[$i]->skor_ya;
            }
        }

        $totalSkor = $skor;

        if ($totalSkor == 0) {
            $kategoriHemoglobin = 'Normal';
        } else if ($totalSkor >= 1 && $totalSkor <= 5) {
            $kategoriHemoglobin = 'Terindikasi Anemia';
        } else {
            $kategoriHemoglobin = 'Anemia';
        }

        $lingkarLenganAtas = $request->lingkar_lengan_atas;
        if ($lingkarLenganAtas < 23) {
            $kategoriLingkarLenganAtas = "Kurang Gizi";
        } else {
            $kategoriLingkarLenganAtas = 'Normal';
        }

        $beratBadan = $request->berat_badan;
        $tinggiBadan = ($request->tinggi_badan / 100);
        $imt = $beratBadan / ($tinggiBadan * $tinggiBadan);
        if ($imt < 17.0) {
            $kategoriImt = "Sangat Kurus";
        } else if ($imt >= 17.0 && $imt <= 18.4) {
            $kategoriImt = "Kurus";
        } else if ($imt >= 18.5 && $imt <= 25.0) {
            $kategoriImt = "Normal";
        } else if ($imt >= 25.1 && $imt <= 27.0) {
            $kategoriImt = "Gemuk";
        } else if ($imt > 27.0) {
            $kategoriImt = "Sangat Gemuk";
        }

        if ($kategoriHemoglobin == 'Normal' && $kategoriLingkarLenganAtas == 'Normal' && $kategoriImt == 'Normal') {
            $kategoriMencegahMalnutrisi = 'Berpartisipasi Mencegah Stunting';
        } else {
            $kategoriMencegahMalnutrisi = 'Tidak Berpartisipasi Mencegah Stunting';
        }

        $anak = AnggotaKeluarga::where('id', $request->nama_anak)->withTrashed()->first();

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($anak->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'anggota_keluarga_id' => $request->nama_anak,
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => $anak->tanggal_lahir,
            'usia_tahun' => $usia,
            'lingkar_lengan_atas' => $request->lingkar_lengan_atas,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'kategori_hemoglobin' => $kategoriHemoglobin,
            'kategori_lingkar_lengan_atas' => $kategoriLingkarLenganAtas,
            'kategori_imt' => $kategoriImt,
            'kategori_mencegah_malnutrisi' => $kategoriMencegahMalnutrisi,
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Auth::user()->role;
        $data = $this->proses($request);

        $randaKabilasa = new RandaKabilasa();
        $randaKabilasa->anggota_keluarga_id = $data['anggota_keluarga_id'];
        $randaKabilasa->is_mencegah_malnutrisi = 1;
        $randaKabilasa->kategori_hb = $data['kategori_hemoglobin'];
        $randaKabilasa->kategori_lingkar_lengan_atas = $data['kategori_lingkar_lengan_atas'];
        $randaKabilasa->kategori_imt = $data['kategori_imt'];
        $randaKabilasa->kategori_mencegah_malnutrisi = $data['kategori_mencegah_malnutrisi'];
        if ($role == 'bidan') {
            $randaKabilasa->bidan_id = Auth::user()->profil->id;
            $randaKabilasa->tanggal_validasi = Carbon::now();
            $randaKabilasa->is_valid = 1;
        } else if ($role == 'admin') {
            $randaKabilasa->bidan_id = $request->nama_bidan;
            $randaKabilasa->tanggal_validasi = Carbon::now();
            $randaKabilasa->is_valid = 1;
        }
        $randaKabilasa->save();

        $mencegahMalnutrisi = new MencegahMalnutrisi();
        $mencegahMalnutrisi->randa_kabilasa_id = $randaKabilasa->id;
        $mencegahMalnutrisi->lingkar_lengan_atas = $data['lingkar_lengan_atas'];
        $mencegahMalnutrisi->tinggi_badan = $data['tinggi_badan'];
        $mencegahMalnutrisi->berat_badan = $data['berat_badan'];

        $mencegahMalnutrisi->save();

        $soal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();

        for ($i = 0; $i < count($soal); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanMencegahMalnutrisi = new JawabanMencegahMalnutrisi();
            $jawabanMencegahMalnutrisi->mencegah_malnutrisi_id = $mencegahMalnutrisi->id;
            $jawabanMencegahMalnutrisi->soal_id = $soal[$i]->id;
            $jawabanMencegahMalnutrisi->jawaban = $request->$jawaban[0];
            $jawabanMencegahMalnutrisi->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MencegahMalnutrisi  $mencegahMalnutrisi
     * @return \Illuminate\Http\Response
     */
    public function show(MencegahMalnutrisi $mencegahMalnutrisi)
    {
        $randaKabilasa = RandaKabilasa::where('id', $mencegahMalnutrisi->randa_kabilasa_id)->first();

        $lingkarLenganAtas = $mencegahMalnutrisi->lingkar_lengan_atas;
        $tinggiBadan = $mencegahMalnutrisi->tinggi_badan;
        $beratBadan = $mencegahMalnutrisi->berat_badan;
        $kategoriHemoglobin = $randaKabilasa->kategori_hb;
        $kategoriLingkarLenganAtas = $randaKabilasa->kategori_lingkar_lengan_atas;
        $kategoriImt = $randaKabilasa->kategori_imt;
        $kategori = $randaKabilasa->kategori_mencegah_malnutrisi;

        $anak = AnggotaKeluarga::where('id', $mencegahMalnutrisi->randaKabilasa->anggota_keluarga_id)->withTrashed()->first();

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($anak->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y'),
            'usia_tahun' => $usia,
            'desa_kelurahan' => $anak->wilayahDomisili->desaKelurahan->nama,
            'jenis_kelamin' => $anak->jenis_kelamin,
            'lingkar_lengan_atas' => $lingkarLenganAtas,
            'tinggi_badan' => $tinggiBadan,
            'berat_badan' => $beratBadan,
            'kategori_hemoglobin' => $kategoriHemoglobin,
            'kategori_lingkar_lengan_atas' => $kategoriLingkarLenganAtas,
            'kategori_imt' => $kategoriImt,
            'kategori' => $kategori,
            'tanggal_proses' => Carbon::parse($mencegahMalnutrisi->randaKabilasa->created_at)->translatedFormat('d F Y'),
            'tanggal_validasi' => Carbon::parse($mencegahMalnutrisi->randaKabilasa->tanggal_validasi)->translatedFormat('d F Y'),
            'bidan' => $mencegahMalnutrisi->randaKabilasa->bidan->nama_lengkap,
        ];

        $daftarSoal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();

        return view('dashboard.pages.utama.randaKabilasa.mencegahMalnutrisi.show', compact('mencegahMalnutrisi', 'data', 'daftarSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MencegahMalnutrisi  $mencegahMalnutrisi
     * @return \Illuminate\Http\Response
     */
    public function edit(MencegahMalnutrisi $mencegahMalnutrisi)
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        $daftarSoal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.randaKabilasa.mencegahMalnutrisi.edit', compact('kartuKeluarga', 'daftarSoal', 'mencegahMalnutrisi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MencegahMalnutrisi  $mencegahMalnutrisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MencegahMalnutrisi $mencegahMalnutrisi)
    {
        $role = Auth::user()->role;
        $data = $this->proses($request);

        $randaKabilasa = RandaKabilasa::where('id', $mencegahMalnutrisi->randa_kabilasa_id)->first();
        $randaKabilasa->kategori_hb = $data['kategori_hemoglobin'];
        $randaKabilasa->kategori_lingkar_lengan_atas = $data['kategori_lingkar_lengan_atas'];
        $randaKabilasa->kategori_imt = $data['kategori_imt'];
        $randaKabilasa->kategori_mencegah_malnutrisi = $data['kategori_mencegah_malnutrisi'];
        $randaKabilasa->save();

        $mencegahMalnutrisi->randa_kabilasa_id = $mencegahMalnutrisi->randa_kabilasa_id;
        $mencegahMalnutrisi->lingkar_lengan_atas = $data['lingkar_lengan_atas'];
        $mencegahMalnutrisi->tinggi_badan = $data['tinggi_badan'];
        $mencegahMalnutrisi->berat_badan = $data['berat_badan'];
        $mencegahMalnutrisi->save();

        $soal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();

        $jawabanMencegahMalnutrisi = JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $mencegahMalnutrisi->id)->delete();

        for ($i = 0; $i < count($soal); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanMencegahMalnutrisi = new JawabanMencegahMalnutrisi();
            $jawabanMencegahMalnutrisi->mencegah_malnutrisi_id = $mencegahMalnutrisi->id;
            $jawabanMencegahMalnutrisi->soal_id = $soal[$i]->id;
            $jawabanMencegahMalnutrisi->jawaban = $request->$jawaban[0];
            $jawabanMencegahMalnutrisi->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MencegahMalnutrisi  $mencegahMalnutrisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(MencegahMalnutrisi $mencegahMalnutrisi)
    {
        //
    }
}
