<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\DeteksiIbuMelahirkanStunting;
use Illuminate\Http\Request;
use App\Models\LokasiTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AnggotaKeluarga;
use App\Models\JawabanDeteksiIbuMelahirkanStunting;
use App\Models\SoalIbuMelahirkanStunting;
use Carbon\Carbon;
use App\Models\Bidan;
use App\Models\Pemberitahuan;

class ApiIbuMelahirkanStuntingController extends Controller
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
        // // $ibuMelahirkanStunting = new DeteksiIbuMelahirkanStunting;

        // if ($relation) {
        //     $ibuMelahirkanStunting = DeteksiIbuMelahirkanStunting::with('bidan', 'anggotaKeluarga');
        // }
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            $data = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
                ->where(function ($query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        });
                    }
                    if (Auth::user()->role == 'bidan') {
                        $query->orWhere('bidan_id', Auth::user()->profil->id);
                    }

                    if (Auth::user()->role == 'penyuluh') { // penyuluh
                        $query->where('is_valid', 1);
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
        }else{
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $deteksiIbuMelahirkanStunting = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();
            $response = [];
                foreach ($deteksiIbuMelahirkanStunting as $d) {
                    array_push($response, $d);
                    $d->anggotaKeluarga->kartu_keluarga = $d->anggotaKeluarga->kartuKeluarga;
                    $d->anggotaKeluarga->wilayahDomisili->provinsi = $d->anggotaKeluarga->wilayahDomisili->provinsi;
                    $d->anggotaKeluarga->wilayahDomisili->kabupaten_kota = $d->anggotaKeluarga->wilayahDomisili->kabupatenKota;
                    $d->anggotaKeluarga->wilayahDomisili->kecamatan = $d->anggotaKeluarga->wilayahDomisili->kecamatan;
                    $d->anggotaKeluarga->wilayahDomisili->desa_kelurahan = $d->anggotaKeluarga->wilayahDomisili->desaKelurahan;
                }
                return $response;
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
        $request->validate([
            'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id',
            'bidan_id' => 'nullable|exists:bidan,id',
            'kategori' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $unValidatedData = DeteksiIbuMelahirkanStunting::where('anggota_keluarga_id', $request->anggota_keluarga_id)->where('is_valid', '!=', 1);
        $ibu = AnggotaKeluarga::find($request->anggota_keluarga_id);
        if($unValidatedData->count() > 0){
            return response(["Terdapat Data Ibu Melahirkan Stunting yang belum divalidasi atas nama $ibu->nama_lengkap"
            ], 407);
        }
        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => Auth::user()->role == "bidan" ? Auth::user()->profil->id : null,
            'kategori' => $request->kategori,
            'is_valid' => Auth::user()->role == "bidan" ? 1 : 0,
            'tanggal_validasi' => Auth::user()->role == "bidan" ? Carbon::now() : null,
            'alasan_ditolak' => Auth::user()->role == "bidan" && $request->is_valid == 2 ? $request->alasan_ditolak : null
        ];

        return DeteksiIbuMelahirkanStunting::create($data);
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
            return DeteksiIbuMelahirkanStunting::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return DeteksiIbuMelahirkanStunting::where('id', $id)->first();
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
            'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id',
            'bidan_id' => 'nullable|exists:bidan,id',
            'kategori' => 'nullable',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable'
        ]);

        $role = Auth::user()->role;
        $data = [
            'kategori' => $request->kategori,
            'is_valid' => $role == "bidan" ? 1 : 0,
            'tanggal_validasi' => $role == "bidan" ? Carbon::now() : null,
            'alasan_ditolak' => $role == "bidan" && $request->is_valid == 2 ? $request->alasan_ditolak : null
        ];

        $ibuMelahirkanStunting = DeteksiIbuMelahirkanStunting::find($id);

        if ($ibuMelahirkanStunting) {
            $ibuMelahirkanStunting->update($data);
            return $ibuMelahirkanStunting;
        }

        return response([
            'message' => "Deteksi Ibu Melahirkan Stunting with id $id doesn't exist"
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $forceDelete = $request->force_delete;
        $ibuMelahirkanStunting = DeteksiIbuMelahirkanStunting::find($id);

        if (!$ibuMelahirkanStunting) {
            return response([
                'message' => "Deteksi Ibu Melahirkan Stunting with id $id doesn't exist"
            ], 404);
        }

        if($forceDelete){
            JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $id)->forceDelete();
            $ibuMelahirkanStunting->forceDelete();
            return response([
                'message' => "Data deleted!"
            ], 200);
        }

        JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $id)->delete();

        $ibuMelahirkanStunting->delete();
        return response([
            'message' => "Data deleted!"
        ], 200);
    }

    public function validasi(Request $request)
    {
        $id = $request->id;
        if($id == null){
            return response([
                'message' => "provide id!",
            ], 400);
        }

        if ($request->konfirmasi == 1) {
            $alasan_req = '';
            $alasan = null;
        } else {
            $alasan_req = 'required';
            $alasan = $request->alasan_ditolak;
        }

        $bidan_id = Auth::user()->profil->id;

        $validator = Validator::make(
            $request->all(),
            [
                'konfirmasi' => 'required',
                'alasan_ditolak' => $alasan_req,
            ],
            [
                'konfirmasi.required' => 'Konfirmasi harus diisi',
                'alasan_ditolak.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors(),
            ], 400);
        }

        $deteksiIbuStunting = DeteksiIbuMelahirkanStunting::find($id);
        if(!$deteksiIbuStunting){
            return response([
                'message' => "Data Deteksi Ibu Stunting with id $id not found!",
            ], 404);
        }

        $deteksiIbuStunting->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $deteksiIbuStunting->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $deteksiIbuStunting->id;
        $pemberitahuan->anggota_keluarga_id = $deteksiIbuStunting->anggota_keluarga_id;
        $pemberitahuan->tentang = 'deteksi_ibu_melahirkan_stunting';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data deteksi ibu melahirkan stunting anda telah divalidasi.';
            $pemberitahuan->isi = 'Data deteksi ibu melahirkan stunting anda (' . ucwords(strtolower($deteksiIbuStunting->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data deteksi ibu melahirkan stunting anda' . ' (' . ucwords(strtolower($deteksiIbuStunting->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data deteksi ibu melahirkan stunting ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();

        return response([
            'message' => "Data Ibu Stunting validated!",
        ], 200);
    }
}
