<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Anc;
use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiTugas;
use Illuminate\Support\Facades\Validator;
use App\Models\Bidan;
use App\Models\Pemberitahuan;
use App\Models\PemeriksaanAnc;

class ApiAncController extends Controller
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
        // $anc = new Anc;

        // if ($relation) {
        //     $anc = Anc::with('bidan', 'anggotaKeluarga');
        // }
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            $data = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->orderBy('created_at', 'DESC')
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
            $anc = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();
            $response = [];
                foreach ($anc as $d) {
                    array_push($response, $d);
                    $d->anggotaKeluarga->kartu_keluarga = $d->anggotaKeluarga->kartuKeluarga;
                    $d->anggotaKeluarga->wilayahDomisili->provinsi = $d->anggotaKeluarga->wilayahDomisili->provinsi;
                    $d->anggotaKeluarga->wilayahDomisili->kabupaten_kota = $d->anggotaKeluarga->wilayahDomisili->kabupatenKota;
                    $d->anggotaKeluarga->wilayahDomisili->kecamatan = $d->anggotaKeluarga->wilayahDomisili->kecamatan;
                    $d->anggotaKeluarga->wilayahDomisili->desa_kelurahan = $d->anggotaKeluarga->wilayahDomisili->desaKelurahan;
                }
                return $response;
        }

        // return $anc->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "anggota_keluarga_id" => "required|exists:anggota_keluarga,id",
            "bidan_id" => "nullable|exists:bidan,id",
            "pemeriksaan_ke" => "required",
            "kategori_badan" => "required",
            "kategori_tekanan_darah" => "required",
            "kategori_lengan_atas" => "required",
            "kategori_denyut_jantung" => "required",
            "kategori_hemoglobin_darah" => "required",
            "vaksin_tetanus_sebelum_hamil" => "required",
            "vaksin_tetanus_sesudah_hamil" => "required",
            "minum_tablet" => "required",
            "konseling" => "required",
            "posisi_janin" => "required",
            "is_valid" => "nullable|in:0,1",
            "tanggal_validasi" => "nullable",
            "alasan_ditolak" => "nullable",
        ]);

        $unValidatedData = Anc::where('anggota_keluarga_id', $request->anggota_keluarga_id)->where('is_valid', '!=', 1);
        $ibu = AnggotaKeluarga::find($request->anggota_keluarga_id);

        if($unValidatedData->count() > 0){
            return response()->json([
                'Terdapat Data Antenatal Care atas nama ' . $ibu->nama_lengkap . ', yang belum divalidasi.',
            ], 407);
        }

        return Anc::create($request->all());
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
            return Anc::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return Anc::where('id', $id)->first();
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
            "anggota_keluarga_id" => "required|exists:anggota_keluarga,id",
            "bidan_id" => "required|exists:bidan,id",
            "pemeriksaan_ke" => "required",
            "kategori_badan" => "required",
            "kategori_tekanan_darah" => "required",
            "kategori_lengan_atas" => "required",
            "kategori_denyut_jantung" => "required",
            "kategori_hemoglobin_darah" => "required",
            "vaksin_tetanus_sebelum_hamil" => "required",
            "vaksin_tetanus_sesudah_hamil" => "required",
            "minum_tablet" => "required",
            "konseling" => "required",
            "posisi_janin" => "required",
            "is_valid" => "nullable|in:0,1",
            "tanggal_validasi" => "nullable",
            "alasan_ditolak" => "nullable",
        ]);

        $anc = Anc::find($id);

        if ($anc) {
            $anc->update($request->all());
            return $anc;
        }

        return response([
            'message' => "ANC with id $id doesn't exist"
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anc = Anc::find($id);

        if (!$anc) {
            return response([
                'message' => "ANC with id $id doesn't exist"
            ], 404);
        }

        $pemeriksaan = PemeriksaanAnc::where('anc_id', $id);
        $pemeriksaan->delete();

        return $anc->delete();
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
                'message' => $validator->errors()
            ], 400);
        }

        $antenatalCare = Anc::find($id);
        if(!$antenatalCare){
            return response([
                'message' => "Data Antenatal Care with id $id not found!",
            ], 404);
        }

        $antenatalCare->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $antenatalCare->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $antenatalCare->id;
        $pemberitahuan->anggota_keluarga_id = $antenatalCare->anggota_keluarga_id;
        $pemberitahuan->tentang = 'anc';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data anc anda telah divalidasi.';
            $pemberitahuan->isi = 'Data anc anda (' . ucwords(strtolower($antenatalCare->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data anc anda' . ' (' . ucwords(strtolower($antenatalCare->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data anc ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        
        return response([
            'message' => "Data Antenatal Care validated!",
        ], 200);
    }
}
