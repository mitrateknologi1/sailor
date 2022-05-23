<?php

namespace App\Http\Controllers\dashboard\utama\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\MencegahPernikahanDini;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MencegahPernikahanDiniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('profil_ada');
    }


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
            return view('dashboard.pages.utama.randaKabilasa.mencegahPernikahanDini.create', compact('randaKabilasa'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'jawaban_1' => 'required',
                'jawaban_2' => 'required',
                'jawaban_3' => 'required',
            ],
            [
                'jawaban_1.required' => 'Jawaban Tidak Boleh Kosong',
                'jawaban_2.required' => 'Jawaban Tidak Boleh Kosong',
                'jawaban_3.required' => 'Jawaban Tidak Boleh Kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $nilai1 = $request->jawaban_1[0] == 'Ya' ? 2 : 0;
        $nilai2 = $request->jawaban_2[0] == 'Ya' ? 1 : 0;
        $nilai3 = $request->jawaban_3[0] == 'Ya' ? 2 : 0;

        $hasil = ($nilai1 + $nilai2 + $nilai3);

        if ($hasil >= 2) {
            $kategori = 'Tidak Berpartisipasi Mencegah Stunting';
        } else {
            $kategori = 'Berpartisipasi Mencegah Stunting';
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
        $role = Auth::user()->role;
        $data = $this->proses($request);
        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);

        $randaKabilasa->is_mencegah_pernikahan_dini = 1;
        $randaKabilasa->kategori_mencegah_pernikahan_dini = $data['kategori'];

        if ($role != 'keluarga') {
            $randaKabilasa->is_valid_mencegah_pernikahan_dini = 1;
        } else {
            $randaKabilasa->is_valid_mencegah_pernikahan_dini = 0;
        }

        $randaKabilasa->save();

        $mencegahPernikahanDini = new MencegahPernikahanDini();
        $mencegahPernikahanDini->randa_kabilasa_id = $request->randaKabilasa;
        $mencegahPernikahanDini->jawaban_1 = $request->jawaban_1[0];
        $mencegahPernikahanDini->jawaban_2 = $request->jawaban_2[0];
        $mencegahPernikahanDini->jawaban_3 = $request->jawaban_3[0];

        $mencegahPernikahanDini->save();

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

        $kategori = $randaKabilasa->kategori_mencegah_pernikahan_dini;

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
            'is_valid_mencegah_pernikahan_dini' => $randaKabilasa->is_valid_mencegah_pernikahan_dini,
            'bidan_konfirmasi' => $randaKabilasa->anggotaKeluarga->getBidan($randaKabilasa->anggota_keluarga_id)
        ];

        return view('dashboard.pages.utama.randaKabilasa.mencegahPernikahanDini.show', compact('randaKabilasa', 'data'));
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
            return view('dashboard.pages.utama.randaKabilasa.mencegahPernikahanDini.edit', compact('randaKabilasa'));
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

        $randaKabilasa = RandaKabilasa::find($request->randaKabilasa);
        $randaKabilasa->kategori_mencegah_pernikahan_dini = $data['kategori'];

        if ((Auth::user()->role == 'keluarga') && ($randaKabilasa->is_valid_mencegah_pernikahan_dini == 2)) {
            $randaKabilasa->is_valid_mencegah_pernikahan_dini = 0;
            $randaKabilasa->bidan_id = null;
            $randaKabilasa->tanggal_validasi = null;
            $randaKabilasa->alasan_ditolak_mencegah_pernikahan_dini = null;
        }

        $randaKabilasa->save();

        $mencegahPernikahanDini = MencegahPernikahanDini::where('randa_kabilasa_id', $randaKabilasa->id)->first();
        $mencegahPernikahanDini->randa_kabilasa_id = $randaKabilasa->id;
        $mencegahPernikahanDini->jawaban_1 = $request->jawaban_1[0];
        $mencegahPernikahanDini->jawaban_2 = $request->jawaban_2[0];
        $mencegahPernikahanDini->jawaban_3 = $request->jawaban_3[0];
        $mencegahPernikahanDini->save();

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $randaKabilasa->anggota_keluarga_id)
            ->where('tentang', 'mencegah_pernikahan_dini')
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

            $randaKabilasa->is_mencegah_pernikahan_dini = 0;
            $randaKabilasa->save();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $randaKabilasa->id)
                ->where('tentang', 'mencegah_pernikahan_dini');

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            $mencegahPernikahanDini = MencegahPernikahanDini::where('randa_kabilasa_id', $request->randaKabilasa)->delete();

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

        $randaKabilasa->is_valid_mencegah_pernikahan_dini = $request->konfirmasi;
        $randaKabilasa->bidan_id = $bidan_id;
        $randaKabilasa->tanggal_validasi = Carbon::now();
        $randaKabilasa->alasan_ditolak_mencegah_pernikahan_dini = $alasan;
        $randaKabilasa->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $randaKabilasa->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $randaKabilasa->id;
        $pemberitahuan->anggota_keluarga_id = $randaKabilasa->anggota_keluarga_id;
        $pemberitahuan->tentang = 'mencegah_pernikahan_dini';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data asesmen mencegah pernikahan dini anda telah divalidasi.';
            $pemberitahuan->isi = 'Data asesmen mencegah pernikahan dini anda (' . ucwords(strtolower($randaKabilasa->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data asesmen mencegah pernikahan dini anda' . ' (' . ucwords(strtolower($randaKabilasa->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data asesmen mencegah pernikahan dini ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
