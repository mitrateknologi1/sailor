<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Bidan;
use App\Models\JawabanMencegahMalnutrisi;
use App\Models\MencegahMalnutrisi;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiMencegahMalnutrisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $randaKabilasaId = $request->randa_kabilas_id;
        $mencegahMalnutrisi = new MencegahMalnutrisi;

        if ($relation) {
            $mencegahMalnutrisi = MencegahMalnutrisi::with('randaKabilasa');
        }
        if ($randaKabilasaId) {
            return $mencegahMalnutrisi->where('randa_kabilasa_id', $randaKabilasaId)->orderBy('updated_at', 'desc')->get();
        }

        return $mencegahMalnutrisi->orderBy('updated_at', 'desc')->get();
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
            "lingkar_lengan_atas" => "required",
            "tinggi_badan" => "required",
            "berat_badan" => "required",
        ]);

        $data = [
            "randa_kabilasa_id" => $request->randa_kabilasa_id,
            "lingkar_lengan_atas" => $request->lingkar_lengan_atas,
            "tinggi_badan" => $request->tinggi_badan,
            "berat_badan" => $request->berat_badan,
        ];

        return MencegahMalnutrisi::create($data);
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
            return MencegahMalnutrisi::with('randaKabilasa')->where('id', $id)->first();
        }
        return MencegahMalnutrisi::where('id', $id)->first();
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
            "kategori_hb" => "required",
            "kategori_lingkar_lengan_atas" => "required",
            "kategori_imt" => "required",
            "kategori_mencegah_malnutrisi" => "required",
            "lingkar_lengan_atas" => "required",
            "tinggi_badan" => "required",
            "berat_badan" => "required",
        ]);

        $mencegahMalnutrisi = MencegahMalnutrisi::find($id);

        if(!$mencegahMalnutrisi){
            return response([
                'message' => "Mencegah Malnutrisi with id $id doesn't exist"
            ], 404);
        }

        $role = Auth::user()->role;

        //randa kabilasa
        $randaKabilasa = RandaKabilasa::where('id', $mencegahMalnutrisi->randa_kabilasa_id)->first();
        $randaKabilasa->kategori_hb = $request->kategori_hb;
        $randaKabilasa->kategori_lingkar_lengan_atas = $request->kategori_lingkar_lengan_atas;
        $randaKabilasa->kategori_imt = $request->kategori_imt;
        $randaKabilasa->kategori_mencegah_malnutrisi = $request->kategori_mencegah_malnutrisi;

        if (($role == 'keluarga') && ($randaKabilasa->is_valid_mencegah_malnutrisi == 2)) {
            $randaKabilasa->is_valid_mencegah_malnutrisi = 0;
            $randaKabilasa->bidan_id = null;
            $randaKabilasa->tanggal_validasi = null;
            $randaKabilasa->alasan_ditolak_mencegah_malnutrisi = null;
        }

        $randaKabilasa->save();

        //mencegah malnutrisi
        $mencegahMalnutrisi->randa_kabilasa_id = $mencegahMalnutrisi->randa_kabilasa_id;
        $mencegahMalnutrisi->lingkar_lengan_atas = $request->lingkar_lengan_atas;
        $mencegahMalnutrisi->tinggi_badan = $request->tinggi_badan;
        $mencegahMalnutrisi->berat_badan = $request->berat_badan;
        $mencegahMalnutrisi->save();

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $mencegahMalnutrisi->randaKabilasa->anggota_keluarga_id)
            ->where('tentang', 'mencegah_malnutrisi')
            ->where('fitur_id', $mencegahMalnutrisi->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response([
            'message' => "Mencegah Malnutrisi with id $id updated"
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
        $mencegahMalnutrisi = MencegahMalnutrisi::find($id);

        if (!$mencegahMalnutrisi) {
            return response([
                'message' => "Mencegah Malnutrisi with id $id doesn't exist"
            ], 404);
        }

        return $mencegahMalnutrisi->delete();
    }

    public function validasi(Request $request)
    {
        $id = $request->id;
        $mencegahMalnutrisiId = $request->mencegah_malnutrisi_id;
        if($id == null){
            return response([
                'message' => "provide id!"
            ], 400);
        }
        
        $randaKabilasa = RandaKabilasa::where('id', $id)->first();

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

        if(!$randaKabilasa){
            return response([
                'message' => "Data randa kabilasa with id $id not found!"
            ], 404);
        }

        $randaKabilasa->is_valid_mencegah_malnutrisi = $request->konfirmasi;
        $randaKabilasa->bidan_id = $bidan_id;
        $randaKabilasa->tanggal_validasi = Carbon::now();
        $randaKabilasa->alasan_ditolak_mencegah_malnutrisi = $alasan;
        $randaKabilasa->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $randaKabilasa->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $mencegahMalnutrisiId;
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
        return response([
            'message' => "Asesmen Mencegah Malnutrisi validated!"
        ], 200);
    }
}
