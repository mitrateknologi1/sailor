<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\PertumbuhanAnak;
use Illuminate\Http\Request;
use App\Models\Pemberitahuan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Bidan;
use App\Models\LokasiTugas;
use Illuminate\Database\Eloquent\Builder;

class ApiPertumbuhanAnakController extends Controller
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
            $data = PertumbuhanAnak::with('anggotaKeluarga.kartuKeluarga', 'anggotaKeluarga.wilayahDomisili.provinsi', 'anggotaKeluarga.wilayahDomisili.kabupatenKota', 'anggotaKeluarga.wilayahDomisili.kecamatan', 'anggotaKeluarga.wilayahDomisili.desaKelurahan', 'bidan')
                ->where(function (Builder $query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        $query->whereHas('anggotaKeluarga', function (Builder $query) use ($lokasiTugas) {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        });

                        if (Auth::user()->role == 'bidan') {
                            $query->orWhere('bidan_id', Auth::user()->profil->id);
                        }

                        if (Auth::user()->role == 'penyuluh') {
                            $query->valid();
                        }
                    }
                })->orderBy('created_at', 'DESC')->get();
            return $data;
        }else{
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $pertumbuhanAnak = PertumbuhanAnak::with('anggotaKeluarga.kartuKeluarga', 'anggotaKeluarga.wilayahDomisili.provinsi', 'anggotaKeluarga.wilayahDomisili.kabupatenKota', 'anggotaKeluarga.wilayahDomisili.kecamatan', 'anggotaKeluarga.wilayahDomisili.desaKelurahan', 'bidan')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();
            return $pertumbuhanAnak;
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
        $request->validate([
            'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id',
            'bidan_id' => "nullable|exists:bidan,id",
            "berat_badan" => 'required',
            "zscore" => 'required',
            "hasil" => 'required',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable',
        ]);

        $unValidatedData = PertumbuhanAnak::where('anggota_keluarga_id', $request->anggota_keluarga_id)->where('is_valid', '!=', 1);
        $anak = AnggotaKeluarga::find($request->anggota_keluarga_id);

        if($unValidatedData->count() > 0){
            return response(["Terdapat Data Pertumbuhan Anak atas nama $anak->nama_lengkap yang belum divalidasi!"
            ], 407);
        }

        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : null,
            "berat_badan" => $request->berat_badan,
            "zscore" => $request->zscore,
            "hasil" => $request->hasil,
            "is_valid" => $role == "bidan" ? 1 : 0,
            "tanggal_validasi" => $role == "bidan" ? Carbon::now() : null,
            "alasan_ditolak" => null,
        ];

        return PertumbuhanAnak::create($data);
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
            return PertumbuhanAnak::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return PertumbuhanAnak::where('id', $id)->first();
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
        $role = Auth::user()->role;
        $request->validate([
            'anggota_keluarga_id' => 'nullable|exists:anggota_keluarga,id',
            'bidan_id' => 'nullable|exists:bidan,id',
            "berat_badan" => 'nullable',
            "zscore" => 'nullable',
            "hasil" => 'nullable',
            "is_valid" => 'nullable|in:0,1',
        ]);

        $pertumbuhanAnak = PertumbuhanAnak::find($id);

        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
            "berat_badan" => $request->berat_badan,
            "zscore" => $request->zscore,
            "hasil" => $request->hasil,
            "is_valid" => $role == "bidan" ? 1 : 0,
            "tanggal_validasi" => $role == "bidan" ? Carbon::now() : null,
        ];

        if ($pertumbuhanAnak) {
            $pertumbuhanAnak->update($data);
            return $pertumbuhanAnak;
        }

        return response([
            'message' => "Pertumbuhan Anak with id $id doesn't exist"
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
        $pertumbuhanAnak = PertumbuhanAnak::find($id);

        if (!$pertumbuhanAnak) {
            return response([
                'message' => "Pertumbuhan Anak with id $id doesn't exist"
            ], 404);
        }

        $pemberitahuan = Pemberitahuan::where('fitur_id', $pertumbuhanAnak->id)->where('tentang', 'pertumbuhan_anak');
        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }


        return $pertumbuhanAnak->delete();
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

        $bidan_id_req = '';
        $bidan_id = Auth::user()->profil->id;

        $validator = Validator::make(
            $request->all(),
            [
                'bidan_id' => $bidan_id_req,
                'konfirmasi' => 'required',
                'alasan_ditolak' => $alasan_req,
            ],
            [
                'bidan_id.required' => 'Bidan harus diisi',
                'konfirmasi.required' => 'Konfirmasi harus diisi',
                'alasan_ditolak.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        $pertumbuhanAnak = PertumbuhanAnak::find($id);
        if(!$pertumbuhanAnak){
            return response([
                'message' => "Data Pertumbuhan Anak with id $id not found!",
            ], 404);
        }

        $updatePertumbuhanAnak = $pertumbuhanAnak
            ->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();
        if ($request->konfirmasi == 1) {
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $pertumbuhanAnak->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id,
                'fitur_id' => $pertumbuhanAnak->id,
                'anggota_keluarga_id' => $pertumbuhanAnak->anggota_keluarga_id,
                'judul' => 'Selamat, data pertumbuhan anak anda telah divalidasi.',
                'isi' => 'Data pertumbuhan anak anda (' . ucwords(strtolower($pertumbuhanAnak->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.',
                'tentang' => 'pertumbuhan_anak',
            ]);
        } else {
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $pertumbuhanAnak->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id,
                'fitur_id' => $pertumbuhanAnak->id,
                'anggota_keluarga_id' => $pertumbuhanAnak->anggota_keluarga_id,
                'judul' => 'Maaf, data pertumbuhan anak anda' . ' (' . ucwords(strtolower($pertumbuhanAnak->anggotaKeluarga->nama_lengkap)) . ') ditolak.',
                'isi' => 'Silahkan perbarui data untuk melihat alasan data pertumbuhan anak ditolak dan mengirim ulang data. Terima Kasih.',
                'tentang' => 'pertumbuhan_anak',
            ]);
        }

        if ($updatePertumbuhanAnak) {
            $pemberitahuan;
            return response([
                'message' => "Data Pertumbuhan Anak validated",
            ], 200);
        } else {
            return response([
                'message' => "Failed to validated data pertumbuhan anak!",
            ], 500);
        }
    }
}
