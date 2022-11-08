<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\PerkembanganAnak;
use Illuminate\Http\Request;
use App\Models\LokasiTugas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Bidan;
use App\Models\Pemberitahuan;
use Illuminate\Support\Carbon;

class ApiPerkembanganAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            $data = PerkembanganAnak::with('anggotaKeluarga.kartuKeluarga', 'anggotaKeluarga.wilayahDomisili.provinsi', 'anggotaKeluarga.wilayahDomisili.kabupatenKota', 'anggotaKeluarga.wilayahDomisili.kecamatan', 'anggotaKeluarga.wilayahDomisili.desaKelurahan', 'bidan')
                ->where(function (Builder $query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') { // bidan/penyuluh
                        $query->whereHas('anggotaKeluarga', function (Builder $query) use ($lokasiTugas) {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                        });
                    }
                    if (Auth::user()->role == 'bidan') { // bidan
                        $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                    }

                    if (Auth::user()->role == 'penyuluh') { // penyuluh
                        $query->valid();
                    }
                })->orderBy('created_at', 'DESC')->get();
                return $data;
        }else{
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $perkembanganAnak = PerkembanganAnak::with('anggotaKeluarga.kartuKeluarga', 'anggotaKeluarga.wilayahDomisili.provinsi', 'anggotaKeluarga.wilayahDomisili.kabupatenKota', 'anggotaKeluarga.wilayahDomisili.kecamatan', 'anggotaKeluarga.wilayahDomisili.desaKelurahan', 'bidan')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();
            return $perkembanganAnak;
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
            'bidan_id' => 'nullable|exists:bidan,id',
            "motorik_kasar" => 'required',
            "motorik_halus" => 'required',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable'
        ]);

        $unValidatedData = PerkembanganAnak::where('anggota_keluarga_id', $request->anggota_keluarga_id)->where('is_valid', '!=', 1);
        $anak = AnggotaKeluarga::find($request->anggota_keluarga_id);
        if($unValidatedData->count() > 0){
            return response(["Terdapat Data Perkembangan Anak atas nama $anak->nama_lengkap yang belum divalidasi!"
            ], 407);
        }

        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : null,
            "motorik_kasar" => $request->motorik_kasar,
            "motorik_halus" => $request->motorik_halus,
            "is_valid" => $role == "bidan" ? 1 : 0,
            "tanggal_validasi" => $role == "bidan" ? Carbon::now() : null,
        ];

        return PerkembanganAnak::create($data);
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
            return PerkembanganAnak::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return PerkembanganAnak::where('id', $id)->first();
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
            "motorik_kasar" => 'nullable',
            "motorik_halus" => 'nullable',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable'
        ]);

        $perkembanganAnak = PerkembanganAnak::find($id);

        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
            "motorik_kasar" => $request->motorik_kasar,
            "motorik_halus" => $request->motorik_halus,
            "is_valid" => $role == "bidan" ? 1 : 0,
            "tanggal_validasi" => $role == "bidan" ? Carbon::now() : null,
            "alasan_ditolak" => $role == "bidan" && $request->is_valid == 2 ? $request->alasan_ditolak : null,
        ];

        if ($perkembanganAnak) {
            $perkembanganAnak->update($data);
            return $perkembanganAnak;
        }

        return response([
            'message' => "Perkembangan Anak with id $id doesn't exist"
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
        $perkembanganAnak = PerkembanganAnak::find($id);

        if (!$perkembanganAnak) {
            return response([
                'message' => "Perkembangan Anak with id $id doesn't exist"
            ], 404);
        }

        $pemberitahuan = Pemberitahuan::where('fitur_id', $perkembanganAnak->id)->where('tentang', 'perkembangan_anak');
        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return $perkembanganAnak->delete();
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
        $perkembanganAnak = PerkembanganAnak::find($id);
        if(!$perkembanganAnak){
            return response([
                'message' => "Data Perkembangan Anak with id $id not found!",
            ], 404);
        }

        $updatePerkembanganAnak = $perkembanganAnak
            ->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();
        if ($request->konfirmasi == 1) {
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $perkembanganAnak->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id,
                'fitur_id' => $perkembanganAnak->id,
                'anggota_keluarga_id' => $perkembanganAnak->anggota_keluarga_id,
                'judul' => 'Selamat, data perkembangan anak anda telah divalidasi.',
                'isi' => 'Data perkembangan anak anda (' . ucwords(strtolower($perkembanganAnak->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.',
                'tentang' => 'perkembangan_anak',
            ]);
        } else {
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $perkembanganAnak->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id,
                'fitur_id' => $perkembanganAnak->id,
                'anggota_keluarga_id' => $perkembanganAnak->anggota_keluarga_id,
                'judul' => 'Maaf, data perkembangan anak anda' . ' (' . ucwords(strtolower($perkembanganAnak->anggotaKeluarga->nama_lengkap)) . ') ditolak.',
                'isi' => 'Silahkan perbarui data untuk melihat alasan data perkembangan anak ditolak dan mengirim ulang data. Terima Kasih.',
                'tentang' => 'perkembangan_anak',
            ]);
        }

        if ($updatePerkembanganAnak) {
            $pemberitahuan;
            return response([
                'message' => "Data Perkembangan Anak validated",
            ], 200);
        } else {
            return response([
                'message' => "Failed to validated data perkembangan anak!",
            ], 500);
        }
    }
}
