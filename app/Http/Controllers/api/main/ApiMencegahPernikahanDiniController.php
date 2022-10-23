<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Bidan;
use App\Models\MencegahPernikahanDini;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiMencegahPernikahanDiniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $randaKabilasaId = $request->randa_kabilasa_id;
        $mencegahPernikahanDini = new MencegahPernikahanDini;

        if ($relation) {
            $mencegahPernikahanDini = MencegahPernikahanDini::with('randaKabilasa');
        }
        if ($randaKabilasaId) {
            return $mencegahPernikahanDini->where('randa_kabilasa_id', $randaKabilasaId)->orderBy('updated_at', 'desc')->get();
        }

        return $mencegahPernikahanDini->orderBy('updated_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "randa_kabilasa_id" => "required|exists:randa_kabilasa,id",
            "jawaban_1" => "required",
            "jawaban_2" => "required",
            "jawaban_3" => "required",
            "kategori_mencegah_pernikahan_dini" => "required",
        ]);

        $role = Auth::user()->role;
        $randaKabilasa = RandaKabilasa::find($request->randa_kabilasa_id);
        if(!$randaKabilasa){
            return response([
                'message' => "Randa Kabilasa with id $request->randa_kabilasa_id doesn't exist"
            ], 404);
        }

        $randaKabilasa->is_mencegah_pernikahan_dini = 1;
        $randaKabilasa->kategori_mencegah_pernikahan_dini = $request->kategori_mencegah_pernikahan_dini;

        if ($role != 'keluarga') {
            $randaKabilasa->is_valid_mencegah_pernikahan_dini = 1;
        } else {
            $randaKabilasa->is_valid_mencegah_pernikahan_dini = 0;
        }

        $randaKabilasa->save();

        $mencegahPernikahanDini = new MencegahPernikahanDini();
        $mencegahPernikahanDini->randa_kabilasa_id = $request->randa_kabilasa_id;
        $mencegahPernikahanDini->jawaban_1 = $request->jawaban_1;
        $mencegahPernikahanDini->jawaban_2 = $request->jawaban_2;
        $mencegahPernikahanDini->jawaban_3 = $request->jawaban_3;

        $mencegahPernikahanDini->save();

        return $mencegahPernikahanDini;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $relation = $request->relation;

        if ($relation) {
            return MencegahPernikahanDini::with('randaKabilasa')->where('id', $id)->first();
        }
        return MencegahPernikahanDini::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "randa_kabilasa_id" => "required|exists:randa_kabilasa,id",
            "jawaban_1" => "required",
            "jawaban_2" => "required",
            "jawaban_3" => "required",
            "kategori_mencegah_pernikahan_dini" => "required",
        ]);

        $randaKabilasa = RandaKabilasa::find($id);
        if(!$randaKabilasa){
            return response([
                'message' => "Mencegah Pernikahan Dini with id $id doesn't exist"
            ], 404);
        }
        $randaKabilasa->kategori_mencegah_pernikahan_dini = $request->kategori_mencegah_pernikahan_dini;

        if ((Auth::user()->role == 'keluarga') && ($randaKabilasa->is_valid_mencegah_pernikahan_dini == 2)) {
            $randaKabilasa->is_valid_mencegah_pernikahan_dini = 0;
            $randaKabilasa->bidan_id = null;
            $randaKabilasa->tanggal_validasi = null;
            $randaKabilasa->alasan_ditolak_mencegah_pernikahan_dini = null;
        }

        $randaKabilasa->save();

        $mencegahPernikahanDini = MencegahPernikahanDini::where('randa_kabilasa_id', $id)->first();
        $mencegahPernikahanDini->randa_kabilasa_id = $id;
        $mencegahPernikahanDini->jawaban_1 = $request->jawaban_1;
        $mencegahPernikahanDini->jawaban_2 = $request->jawaban_2;
        $mencegahPernikahanDini->jawaban_3 = $request->jawaban_3;
        $mencegahPernikahanDini->save();

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $randaKabilasa->anggota_keluarga_id)
            ->where('tentang', 'mencegah_pernikahan_dini')
            ->where('fitur_id', $randaKabilasa->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response([
            'message' => "Mencegah Pernikahan Dini with randa kabilasa id $id updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $randaKabilasa = RandaKabilasa::find($id);
        if (!$randaKabilasa) {
            return response([
                'message' => "Mencegah Pernikahan Dini with randa kabilasa id $id doesn't exist"
            ], 404);
        }
        $randaKabilasa->is_mencegah_pernikahan_dini = 0;
        $randaKabilasa->is_valid_mencegah_pernikahan_dini = 0;
        $randaKabilasa->save();

        $pemberitahuan = Pemberitahuan::where('fitur_id', $id)
            ->where('tentang', 'mencegah_pernikahan_dini');

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        $mencegahPernikahanDini = MencegahPernikahanDini::where('randa_kabilasa_id', $id)->delete();

        return response([
            'message' => "Mencegah Pernikahan Dini with randa kabilasa id $id deleted!"
        ], 200);
    }

    public function validasi(Request $request)
    {
        $id = $request->id;
        if($id == null){
            return response([
                'message' => "provide id!"
            ], 400);
        }

        if ($request->konfirmasi == 1) {
            $alasan_req = '';
            $alasan = null;
        } else {
            $alasan_req = 'required';
            $alasan = $request->alasan;
        }

        $bidan_id = Auth::user()->profil->id;

        $validator = Validator::make(
            $request->all(),
            [
                'konfirmasi' => 'required',
                'alasan' => $alasan_req,
            ],
            [
                'konfirmasi.required' => 'Konfirmasi harus diisi',
                'alasan.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        $randaKabilasa = RandaKabilasa::find($id);

        $randaKabilasa->is_valid_mencegah_pernikahan_dini = $request->konfirmasi;
        $randaKabilasa->bidan_id = $bidan_id;
        $randaKabilasa->tanggal_validasi = Carbon::now();
        $randaKabilasa->alasan_ditolak_mencegah_pernikahan_dini = $alasan;
        $randaKabilasa->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $randaKabilasa->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $id;
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
        return response([
            'message' => "Asesmen Mencegah Pernikahan Dini Validated!"
        ], 200);
    }
}
