<?php

namespace App\Http\Controllers\dashboard\utama\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\JawabanMencegahMalnutrisi;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\MencegahMalnutrisi;
use App\Models\Pemberitahuan;
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
        if (in_array(Auth::user()->role, ['admin', 'bidan', 'keluarga'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            if (Auth::user()->role == 'admin') {
                $kartuKeluarga = KartuKeluarga::valid()
                    ->latest()->get();
            } else if (Auth::user()->role == 'bidan') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->valid()
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    })->latest()->get();
            } else if (Auth::user()->role == 'keluarga') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->where('id', Auth::user()->profil->kartu_keluarga_id)->latest()->get();
            }
            $daftarSoal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();
            if (count($daftarSoal) > 0) {
                return view('dashboard.pages.utama.randaKabilasa.mencegahMalnutrisi.create', compact('kartuKeluarga', 'daftarSoal'));
            } else {
                return redirect(url('randa-kabilasa'))->with('error', 'soal_tidak_ada');
            }
        } else {
            return abort(404);
        }
    }

    public function proses(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => Auth::user()->role == 'keluarga' ? 'nullable' : 'required',
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

        $terdapatDataBelumValidasi = RandaKabilasa::where('anggota_keluarga_id', $request->nama_anak)
            ->where(function ($row) {
                $row->where('is_mencegah_pernikahan_dini', 0);
                $row->orWhere('is_meningkatkan_life_skill', 0);
                $row->where('is_valid_mencegah_malnutrisi', 0);
                $row->orWhere('is_valid_mencegah_malnutrisi', 2);

                $row->orWhere('is_valid_mencegah_pernikahan_dini', 0);
                $row->orWhere('is_valid_mencegah_pernikahan_dini', 2);

                $row->orWhere('is_valid_meningkatkan_life_skill', 0);
                $row->orWhere('is_valid_meningkatkan_life_skill', 2);
            });
        $anak = AnggotaKeluarga::find($request->nama_anak);

        if ($role == 'admin') {
            $bidan_id = $request->nama_bidan;
        } else if ($role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;
        } else if ($role == 'keluarga') {
            $bidan_id = null;
        }

        $randaKabilasa = new RandaKabilasa();
        $randaKabilasa->anggota_keluarga_id = $data['anggota_keluarga_id'];
        $randaKabilasa->is_mencegah_malnutrisi = 1;
        $randaKabilasa->kategori_hb = $data['kategori_hemoglobin'];
        $randaKabilasa->kategori_lingkar_lengan_atas = $data['kategori_lingkar_lengan_atas'];
        $randaKabilasa->kategori_imt = $data['kategori_imt'];
        $randaKabilasa->kategori_mencegah_malnutrisi = $data['kategori_mencegah_malnutrisi'];
        $randaKabilasa->bidan_id = $bidan_id;

        if ($role != 'keluarga') {
            $randaKabilasa->tanggal_validasi = Carbon::now();
            $randaKabilasa->is_valid_mencegah_malnutrisi = 1;
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat menambahkan mencegah malnutrisi ' . $anak->nama_lengkap . ', dikarenakan masih terdapat data yang berstatus belum divalidasi/ditolak.',
                ]);
            }
        } else {
            $randaKabilasa->is_valid_mencegah_malnutrisi = 0;
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat mengirim mencegah malnutrisi ' . $anak->nama_lengkap . ', dikarenakan masih terdapat data yang berstatus belum divalidasi/ditolak. Silahkan Perbarui Data tersebut apabila statusnya ditolak.',
                ]);
            }
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
            'id' => $mencegahMalnutrisi->id,
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
            'bidan' => $mencegahMalnutrisi->randaKabilasa->bidan->nama_lengkap ?? '-',
            'is_valid_mencegah_malnutrisi' => $randaKabilasa->is_valid_mencegah_malnutrisi,
            'bidan_konfirmasi' => $randaKabilasa->anggotaKeluarga->getBidan($randaKabilasa->anggota_keluarga_id)
        ];

        $daftarSoal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->withTrashed()->get();

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
        if ((Auth::user()->profil->id == $mencegahMalnutrisi->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $mencegahMalnutrisi->anggotaKeluarga->kartu_keluarga_id)) {
            $kartuKeluarga = KartuKeluarga::latest()->get();
            $daftarSoal = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();
            return view('dashboard.pages.utama.randaKabilasa.mencegahMalnutrisi.edit', compact('kartuKeluarga', 'daftarSoal', 'mencegahMalnutrisi'));
        } else {
            return abort(404);
        }
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

        if ((Auth::user()->role == 'keluarga') && ($randaKabilasa->is_valid_mencegah_malnutrisi == 2)) {
            $randaKabilasa->is_valid_mencegah_malnutrisi = 0;
            $randaKabilasa->bidan_id = null;
            $randaKabilasa->tanggal_validasi = null;
            $randaKabilasa->alasan_ditolak_mencegah_malnutrisi = null;
        }

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

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $mencegahMalnutrisi->randaKabilasa->anggota_keluarga_id)
            ->where('tentang', 'mencegah_malnutrisi')
            ->where('fitur_id', $mencegahMalnutrisi->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response()->json([
            'id' => $mencegahMalnutrisi->id,
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

    public function validasi(Request $request, MencegahMalnutrisi $mencegahMalnutrisi)
    {
        $id = $request->id;
        $randaKabilasa = RandaKabilasa::where('id', $mencegahMalnutrisi->randa_kabilasa_id)->first();

        if ($request->konfirmasi == 1) {
            $alasan_req = '';
            $alasan = null;
        } else {
            $alasan_req = 'required';
            $alasan = $request->alasan;
        }

        if (Auth::user()->role == 'admin') {
            $bidan_id_req = 'required';
            $bidan_id = $request->bidan_id;
        } else {
            $bidan_id_req = '';
            $bidan_id = Auth::user()->profil->id;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'bidan_id' => $bidan_id_req,
                'konfirmasi' => 'required',
                'alasan' => $alasan_req,
            ],
            [
                'bidan_id.required' => 'Bidan harus diisi',
                'konfirmasi.required' => 'Konfirmasi harus diisi',
                'alasan.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $randaKabilasa->is_valid_mencegah_malnutrisi = $request->konfirmasi;
        $randaKabilasa->bidan_id = $bidan_id;
        $randaKabilasa->tanggal_validasi = Carbon::now();
        $randaKabilasa->alasan_ditolak_mencegah_malnutrisi = $alasan;
        $randaKabilasa->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $randaKabilasa->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $mencegahMalnutrisi->id;
        $pemberitahuan->anggota_keluarga_id = $randaKabilasa->anggota_keluarga_id;
        $pemberitahuan->tentang = 'mencegah_malnutrisi';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data asesmen mencegah malnutrisi anda telah divalidasi.';
            $pemberitahuan->isi = 'Data asesmen mencegah malnutrisi anda (' . ucwords(strtolower($randaKabilasa->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data asesmen mencegah malnutrisi anda' . ' (' . ucwords(strtolower($randaKabilasa->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data asesmen mencegah malnutrisi ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
