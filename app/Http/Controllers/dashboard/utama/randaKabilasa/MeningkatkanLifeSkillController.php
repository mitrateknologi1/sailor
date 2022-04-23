<?php

namespace App\Http\Controllers\dashboard\utama\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\JawabanMeningkatkanLifeSkill;
use App\Models\RandaKabilasa;
use App\Models\SoalMeningkatkanLifeSkill;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);
        $daftarSoal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.randaKabilasa.meningkatkanLifeSkill.create', compact('randaKabilasa', 'daftarSoal'));
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
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);

        $randaKabilasa->is_meningkatkan_life_skill = 1;
        $randaKabilasa->kategori_meningkatkan_life_skill = $data['kategori'];
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
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y'),
            'usia_tahun' => $usia,
            'desa_kelurahan' => $anak->wilayahDomisili->desaKelurahan->nama,
            'jenis_kelamin' => $anak->jenis_kelamin,
            'kategori' => $kategori,
            'tanggal_proses' => Carbon::parse($randaKabilasa->created_at)->translatedFormat('d F Y'),
            'tanggal_validasi' => Carbon::parse($randaKabilasa->tanggal_validasi)->translatedFormat('d F Y'),
            'bidan' => $randaKabilasa->bidan->nama_lengkap,
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
        $daftarSoal = SoalMeningkatkanLifeSkill::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.randaKabilasa.meningkatkanLifeSkill.edit', compact('randaKabilasa', 'daftarSoal'));
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
        $randaKabilasa->is_meningkatkan_life_skill = 0;
        $randaKabilasa->kategori_meningkatkan_life_skill = null;
        $randaKabilasa->save();

        $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $request->randaKabilasa)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
