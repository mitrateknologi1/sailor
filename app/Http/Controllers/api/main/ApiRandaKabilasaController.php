<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
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
        // $relation = $request->relation;
        // $pageSize = $request->page_size ?? 20;
        // $randaKabilasa = new RandaKabilasa;

        // if ($relation) {
        //     $randaKabilasa = RandaKabilasa::with('bidan', 'anggotaKeluarga', 'mencegahMalnutrisi', 'mencegahPernikahanDini');
        // }

        // return $randaKabilasa->orderBy('updated_at', 'desc')->paginate($pageSize);

        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $data = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi', 'mencegahPernikahanDini')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
                    $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }

                if (Auth::user()->role == 'penyuluh') { // penyuluh
                    $query->where('is_valid_mencegah_malnutrisi', 1);
                    $query->where('is_valid_mencegah_pernikahan_dini', 1);
                    $query->where('is_valid_meningkatkan_life_skill', 1);
                }
            })->get();
            
        $response = [];
        foreach ($data as $d) {
            array_push($response, $d);
            $d->anggotaKeluarga->kartu_keluarga = $d->anggotaKeluarga->kartuKeluarga;
            $d->anggotaKeluarga->wilayahDomisili->provinsi = $d->anggotaKeluarga->wilayahDomisili->provinsi;
            $d->anggotaKeluarga->wilayahDomisili->kabupaten_kota = $d->anggotaKeluarga->wilayahDomisili->kabupatenKota;
            $d->anggotaKeluarga->wilayahDomisili->kecamatan = $d->anggotaKeluarga->wilayahDomisili->kecamatan;
            $d->anggotaKeluarga->wilayahDomisili->desa_kelurahan = $d->anggotaKeluarga->wilayahDomisili->desaKelurahan;
        }

        return $response;
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
        $bidanRule = $role == "bidan" ? "nullable|exists:bidan,id" : "required|exists:bidan,id";
        $request->validate([
            "anggota_keluarga_id" => "required",
            "bidan_id" => $bidanRule,
            "kategori_hb" => "required",
            "kategori_lingkar_lengan_atas" => "required",
            "kategori_imt" => "required",
            "kategori_mencegah_malnutrisi" => "required",
        ]);

        $dataRandaKabilasa = [
            "anggota_keluarga_id" => $request->anggota_keluarga_id,
            "bidan_id" => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
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
