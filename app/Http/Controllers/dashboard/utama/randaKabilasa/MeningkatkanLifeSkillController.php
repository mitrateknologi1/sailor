<?php

namespace App\Http\Controllers\dashboard\utama\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\JawabanMeningkatkanLifeSkill;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use App\Models\SoalMeningkatkanLifeSkill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeningkatkanLifeSkillController extends Controller
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
    public function create(Request $request)
    {
        if (in_array(Auth::user()->role, ['admin', 'bidan', 'keluarga'])) {
            $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);
            $daftarSoal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();
            return view('dashboard.pages.utama.randaKabilasa.meningkatkanLifeSkill.create', compact('randaKabilasa', 'daftarSoal'));
        } else {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function proses(Request $request)
    {
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);

        $pesanError = [];
        $totalSoal = SoalMeningkatkanLifeSkill::count();

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

        $soalMencegahMalnutrisi = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();

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

        if ($totalSkor >= 2) {
            $kategori = 'Berpartisipasi Mencegah Stunting';
        } else {
            $kategori = 'Tidak Berpartisipasi Mencegah Stunting';
        }

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($randaKabilasa->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'anggota_keluarga_id' => $randaKabilasa->anggota_keluarga_id,
            'nama_anak' => $randaKabilasa->anggotaKeluarga->nama_lengkap,
            'tanggal_lahir' => $randaKabilasa->anggotaKeluarga->tanggal_lahir,
            'usia_tahun' => $usia,
            'kategori' => $kategori,
        ];
        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->proses($request);

        $role = Auth::user()->role;
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);

        $randaKabilasa->is_meningkatkan_life_skill = 1;
        $randaKabilasa->kategori_meningkatkan_life_skill = $data['kategori'];

        if ($role != 'keluarga') {
            $randaKabilasa->is_valid_meningkatkan_life_skill = 1;
        } else {
            $randaKabilasa->is_valid_meningkatkan_life_skill = 0;
        }

        $randaKabilasa->save();

        $soal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();

        for ($i = 0; $i < count($soal); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanMeningkatkanLifeSkill = new JawabanMeningkatkanLifeSkill();
            $jawabanMeningkatkanLifeSkill->randa_kabilasa_id = $request->randaKabilasa;
            $jawabanMeningkatkanLifeSkill->soal_id = $soal[$i]->id;
            $jawabanMeningkatkanLifeSkill->jawaban = $request->$jawaban[0];
            $jawabanMeningkatkanLifeSkill->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);

        $daftarSoal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();
        $kategori = $randaKabilasa->kategori_meningkatkan_life_skill;

        $anak = AnggotaKeluarga::where('id', $randaKabilasa->anggota_keluarga_id)->withTrashed()->first();

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($anak->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'id' => $randaKabilasa->id,
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y'),
            'usia_tahun' => $usia,
            'desa_kelurahan' => $anak->wilayahDomisili->desaKelurahan->nama,
            'jenis_kelamin' => $anak->jenis_kelamin,
            'kategori' => $kategori,
            'tanggal_proses' => Carbon::parse($randaKabilasa->created_at)->translatedFormat('d F Y'),
            'tanggal_validasi' => Carbon::parse($randaKabilasa->tanggal_validasi)->translatedFormat('d F Y'),
            'bidan' => $randaKabilasa->bidan->nama_lengkap ?? '-',
            'is_valid_meningkatkan_life_skill' => $randaKabilasa->is_valid_meningkatkan_life_skill,
            'bidan_konfirmasi' => $randaKabilasa->anggotaKeluarga->getBidan($randaKabilasa->anggota_keluarga_id)
        ];

        return view('dashboard.pages.utama.randaKabilasa.meningkatkanLifeSkill.show', compact('randaKabilasa', 'data', 'daftarSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);
        if ((Auth::user()->profil->id == $randaKabilasa->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $randaKabilasa->anggotaKeluarga->kartu_keluarga_id)) {
            $daftarSoal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();
            return view('dashboard.pages.utama.randaKabilasa.meningkatkanLifeSkill.edit', compact('randaKabilasa', 'daftarSoal'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $this->proses($request);

        $soal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);

        $randaKabilasa->kategori_meningkatkan_life_skill = $data['kategori'];


        if ((Auth::user()->role == 'keluarga') && ($randaKabilasa->is_valid_meningkatkan_life_skill == 2)) {
            $randaKabilasa->is_valid_meningkatkan_life_skill = 0;
            $randaKabilasa->bidan_id = null;
            $randaKabilasa->tanggal_validasi = null;
            $randaKabilasa->alasan_ditolak_meningkatkan_life_skill = null;
        }

        $randaKabilasa->save();

        $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $request->randaKabilasa)->delete();

        for ($i = 0; $i < count($soal); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanMeningkatkanLifeSkill = new JawabanMeningkatkanLifeSkill();
            $jawabanMeningkatkanLifeSkill->randa_kabilasa_id = $request->randaKabilasa;
            $jawabanMeningkatkanLifeSkill->soal_id = $soal[$i]->id;
            $jawabanMeningkatkanLifeSkill->jawaban = $request->$jawaban[0];
            $jawabanMeningkatkanLifeSkill->save();
        }

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $randaKabilasa->anggota_keluarga_id)
            ->where('tentang', 'meningkatkan_life_skill')
            ->where('fitur_id', $randaKabilasa->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);
        if ((Auth::user()->profil->id == $randaKabilasa->bidan_id) || (Auth::user()->role == 'admin')) {
            $randaKabilasa->is_meningkatkan_life_skill = 0;
            $randaKabilasa->kategori_meningkatkan_life_skill = null;
            $randaKabilasa->save();

            $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $request->randaKabilasa)->delete();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $randaKabilasa->id)
                ->where('tentang', 'meningkatkan_life_skill');

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return abort(404);
        }
    }

    public function validasi(Request $request, RandaKabilasa $randaKabilasa)
    {
        $id = $request->id;

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

        $randaKabilasa->is_valid_meningkatkan_life_skill = $request->konfirmasi;
        $randaKabilasa->bidan_id = $bidan_id;
        $randaKabilasa->tanggal_validasi = Carbon::now();
        $randaKabilasa->alasan_ditolak_meningkatkan_life_skill = $alasan;
        $randaKabilasa->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $randaKabilasa->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $randaKabilasa->id;
        $pemberitahuan->anggota_keluarga_id = $randaKabilasa->anggota_keluarga_id;
        $pemberitahuan->tentang = 'meningkatkan_life_skill';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data asesmen meningkatkan life skill dan potensi diri anda telah divalidasi.';
            $pemberitahuan->isi = 'Data asesmen meningkatkan life skill dan potensi diri anda (' . ucwords(strtolower($randaKabilasa->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data asesmen meningkatkan life skill dan potensi diri anda' . ' (' . ucwords(strtolower($randaKabilasa->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data asesmen meningkatkan life skill dan potensi diri ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
