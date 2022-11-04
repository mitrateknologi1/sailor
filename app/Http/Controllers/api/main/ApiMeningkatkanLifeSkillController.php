<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Bidan;
use App\Models\JawabanMeningkatkanLifeSkill;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiMeningkatkanLifeSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
        
        $request->validate([
            "randa_kabilasa_id" => "required",
            "kategori_meningkatkan_life_skill" => "required",
        ]);

        $id = $request->randa_kabilasa_id;

        $randaKabilasa = RandaKabilasa::find($id);
        if(!$randaKabilasa){
            return response([
                'message' => "Randa Kabilasa with id $id doesn't exist"
            ], 404);
        }

        $randaKabilasa->is_meningkatkan_life_skill = 1;
        $randaKabilasa->kategori_meningkatkan_life_skill = $request->kategori_meningkatkan_life_skill;

        if ($role != 'keluarga') {
            $randaKabilasa->is_valid_meningkatkan_life_skill = 1;
        } else {
            $randaKabilasa->is_valid_meningkatkan_life_skill = 0;
        }

        $randaKabilasa->save();

        return response([
            'message' => "Asesmen Meningkatkan Life Skill on Randa Kabilasa has been stored!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
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
        $randaKabilasa = RandaKabilasa::find($id);
        if(!$randaKabilasa){
            return response([
                'message' => "Randa kabilasa with id $id not found!"
            ], 200);
        }
        
        $request->validate([
            "kategori_meningkatkan_life_skill" => "required",
        ]);
        
        $randaKabilasa->kategori_meningkatkan_life_skill = $request->kategori_meningkatkan_life_skill;

        if ((Auth::user()->role == 'keluarga') && ($randaKabilasa->is_valid_meningkatkan_life_skill == 2)) {
            $randaKabilasa->is_valid_meningkatkan_life_skill = 0;
            $randaKabilasa->bidan_id = null;
            $randaKabilasa->tanggal_validasi = null;
            $randaKabilasa->alasan_ditolak_meningkatkan_life_skill = null;
        }

        $randaKabilasa->save();

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $randaKabilasa->anggota_keluarga_id)
            ->where('tentang', 'meningkatkan_life_skill')
            ->where('fitur_id', $randaKabilasa->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response([
            'message' => "Asesmen Meningkatkan Life Skill Updated!"
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
        $randaKabilasa->is_meningkatkan_life_skill = 0;
        $randaKabilasa->is_valid_meningkatkan_life_skill = 0;
        $randaKabilasa->kategori_meningkatkan_life_skill = null;
        $randaKabilasa->save();

        $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $id);

        $pemberitahuan = Pemberitahuan::where('fitur_id', $id)
            ->where('tentang', 'meningkatkan_life_skill');

        if($jawabanMeningkatkanLifeSkill){
            $jawabanMeningkatkanLifeSkill->delete();
        }
        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response([
            'message' => "Asesmen Meningkatkan Life Skill Deleted!"
        ], 200);
    }

    public function validasi(Request $request)
    {
        $id = $request->randa_kabilasa_id;
        if($id == null){
            return response([
                'message' => "provide randa kabilasa id"
            ], 400);
        }

        $randaKabilasa = RandaKabilasa::find($id);

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
        return response([
            'message' => "Asesmen Meningkatkan Life Skill Validated"
        ], 200);
    }
}
