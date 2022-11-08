<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\JawabanMencegahMalnutrisi;
use App\Models\JawabanMeningkatkanLifeSkill;
use App\Models\LokasiTugas;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiRandaKabilasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if (in_array(Auth::user()->role, ['bidan', 'penyuluh'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
            $data = RandaKabilasa::with('anggotaKeluarga.kartuKeluarga', 'anggotaKeluarga.wilayahDomisili.provinsi', 'anggotaKeluarga.wilayahDomisili.kabupatenKota', 'anggotaKeluarga.wilayahDomisili.kecamatan', 'anggotaKeluarga.wilayahDomisili.desaKelurahan', 'bidan', 'mencegahMalnutrisi', 'mencegahPernikahanDini')->orderBy('created_at', 'DESC')
                ->where(function ($query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        });
                    }
                    if (Auth::user()->role == 'bidan') {
                        $query->orWhere('bidan_id', Auth::user()->profil->id);
                    }

                    if (Auth::user()->role == 'penyuluh') {
                        $query->where('is_valid_mencegah_malnutrisi', 1);
                        $query->where('is_valid_mencegah_pernikahan_dini', 1);
                        $query->where('is_valid_meningkatkan_life_skill', 1);
                    }
                })->get();
            return $data;
        }else{
            $randaKabilasa = RandaKabilasa::with('anggotaKeluarga.kartuKeluarga', 'anggotaKeluarga.wilayahDomisili.provinsi', 'anggotaKeluarga.wilayahDomisili.kabupatenKota', 'anggotaKeluarga.wilayahDomisili.kecamatan', 'anggotaKeluarga.wilayahDomisili.desaKelurahan', 'mencegahMalnutrisi', 'mencegahPernikahanDini', 'bidan')->where('anggota_keluarga_id', Auth::user()->keluarga->id)->get();
            if($randaKabilasa->count() < 1){
                return response([
                    'message' => "Data Not Found!"
                ], 404);
            }
            return $randaKabilasa;
        }
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
        $anggotaKeluargaRule = $role == "bidan" ? "required:exists:anggota_keluarga,id" : "nullable:exists:anggota_keluarga,id";
        $request->validate([
            "anggota_keluarga_id" => $anggotaKeluargaRule,
            "bidan_id" => "nullable|exists:bidan,id",
            "kategori_hb" => "required",
            "kategori_lingkar_lengan_atas" => "required",
            "kategori_imt" => "required",
            "kategori_mencegah_malnutrisi" => "required",
        ]);

        $anggotaKeluargaId = $role == "bidan" ? $request->anggota_keluarga_id : Auth::user()->profil->id;

        $unValidatedData = RandaKabilasa::where('anggota_keluarga_id', $anggotaKeluargaId)
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
        $anak = AnggotaKeluarga::find($anggotaKeluargaId);

        if($unValidatedData->count() > 0){
            return response(["Terdapat Data Asesmen Mencegah Malnutrisi atas nama $anak->nama_lengkap yang belum divalidasi!"
            ], 407);
        }

        $dataRandaKabilasa = [
            "anggota_keluarga_id" => $role == "bidan" ? $request->anggota_keluarga_id : Auth::user()->profil->id,
            "bidan_id" => $role == "bidan" ? Auth::user()->profil->id : null,
            "is_mencegah_malnutrisi" => 1,
            "kategori_hb" => $request->kategori_hb,
            "kategori_lingkar_lengan_atas" => $request->kategori_lingkar_lengan_atas,
            "kategori_imt" => $request->kategori_imt,
            "kategori_mencegah_malnutrisi" => $request->kategori_mencegah_malnutrisi,
            "tanggal_validasi" => $role == "bidan" ? Carbon::now() : null,
            "is_valid_mencegah_malnutrisi" => $role == "bidan" ? 1 : 0,
        ];

        return RandaKabilasa::create($dataRandaKabilasa);
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
            return RandaKabilasa::with('bidan', 'anggotaKeluarga', 'mencegahMalnutrisi', 'mencegahPernikahanDini')->where('id', $id)->first();
        }
        return RandaKabilasa::where('id', $id)->first();
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
            "anggota_keluarga_id" => 'nullable|exists:anggota_keluarga,id',
            "bidan_id" => "nullable|exists:bidan,id",
            "is_mencegah_malnutrisi" => 'nullable|in:0,1',
            "is_mencegah_pernikahan_dini" => 'nullable|in:0,1',
            "is_meningkatkan_life_skill" => 'nullable|in:0,1',
            "kategori_hb" => 'nullable',
            "kategori_lingkar_lengan_atas" => 'nullable',
            "kategori_imt" => 'nullable',
            "kategori_mencegah_malnutrisi" => 'nullable',
            "kategori_meningkatkan_life_skill" => 'nullable',
            "kategori_mencegah_pernikahan_dini" => 'nullable',
            "is_valid_mencegah_malnutrisi" => 'nullable|in:0,1',
            "is_valid_mencegah_pernikahan_dini" => 'nullable|in:0,1',
            "is_valid_meningkatkan_life_skill" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak_mencegah_malnutrisi" => 'nullable',
            "alasan_ditolak_mencegah_pernikahan_dini" => 'nullable',
            "alasan_ditolak_meningkatkan_life_skill" => 'nullable',
        ]);

        $randaKabilasa = RandaKabilasa::find($id);

        if ($randaKabilasa) {
            $randaKabilasa->update($request->all());
            return $randaKabilasa;
        }

        return response([
            'message' => "Randa Kabilasa with id $id doesn't exist"
        ], 400);
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
                'message' => "Randa kabilasa with id $id doesn't exist"
            ], 404);
        }

        if ($randaKabilasa->mencegahMalnutrisi) {
            $randaKabilasa->mencegahMalnutrisi()->delete();
            $jawabanMencegahMalnutrisi = JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $randaKabilasa->mencegahMalnutrisi->id)->delete();
        }

        if ($randaKabilasa->mencegahPernikahanDini) {
            $randaKabilasa->mencegahPernikahanDini()->delete();
        }
        $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $randaKabilasa->id)->delete();
        $randaKabilasa->delete();

        $pemberitahuan = Pemberitahuan::where('fitur_id', $randaKabilasa->id)
            ->where('tentang', 'randa_kabilasa');

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return $randaKabilasa->delete();
    }
}
