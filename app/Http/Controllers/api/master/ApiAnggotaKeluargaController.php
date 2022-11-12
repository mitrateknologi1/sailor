<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Pemberitahuan;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Bidan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiAnggotaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kartuKeluargaId = $request->kartu_keluarga_id;

        if(Auth::user()->role == "keluarga"){
            $data = AnggotaKeluarga::with('agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan', 'user', 'statusHubunganDalamKeluarga', 'bidan', 'kartuKeluarga.provinsi', 'kartuKeluarga.kabupatenKota', 'kartuKeluarga.kecamatan', 'kartuKeluarga.desaKelurahan', 'wilayahDomisili.provinsi', 'wilayahDomisili.kabupatenKota', 'wilayahDomisili.kecamatan', 'wilayahDomisili.desaKelurahan')
            ->where('kartu_keluarga_id', Auth::user()->profil->kartu_keluarga_id)
            ->orderBy('status_hubungan_dalam_keluarga_id', 'ASC');    
            $result = $data->get();
            // return $result;
        }else if(Auth::user()->role == "bidan"){
            if($kartuKeluargaId){
                $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
                $data = AnggotaKeluarga::with('agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan', 'user', 'kartuKeluarga.provinsi', 'kartuKeluarga.kabupatenKota', 'kartuKeluarga.kecamatan', 'kartuKeluarga.desaKelurahan','statusHubunganDalamKeluarga', 'bidan','wilayahDomisili.provinsi', 'wilayahDomisili.kabupatenKota', 'wilayahDomisili.kecamatan', 'wilayahDomisili.desaKelurahan')
                ->where('kartu_keluarga_id', $kartuKeluargaId);
                $data->where(function (Builder $query) use ($lokasiTugas) {
                    $query->whereIn('is_valid', [1, 2]);
                    $query->orWhere(function (Builder $query) use ($lokasiTugas) {
                        $query->where('is_valid', 0);
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    });
                });
                $result = $data->get();
                // return $result;
            }else{
                $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
                $data = AnggotaKeluarga::with('agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan', 'user', 'kartuKeluarga.provinsi', 'kartuKeluarga.kabupatenKota', 'kartuKeluarga.kecamatan', 'kartuKeluarga.desaKelurahan', 'statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili.provinsi', 'wilayahDomisili.kabupatenKota', 'wilayahDomisili.kecamatan', 'wilayahDomisili.desaKelurahan');
                $data->where(function (Builder $query) use ($lokasiTugas) {
                    $query->whereIn('is_valid', [1, 2]);
                    $query->orWhere(function (Builder $query) use ($lokasiTugas) {
                        $query->where('is_valid', 0);
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    });
                });
                $result = $data->orderBy('updated_at', 'desc')->get();
                // return $result;
            }
        }else{
            //penyuluh
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
                $data = AnggotaKeluarga::with('agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan', 'user', 'kartuKeluarga.provinsi', 'kartuKeluarga.kabupatenKota', 'kartuKeluarga.kecamatan', 'kartuKeluarga.desaKelurahan','statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili.provinsi', 'wilayahDomisili.kabupatenKota', 'wilayahDomisili.kecamatan', 'wilayahDomisili.desaKelurahan')
                ->where('kartu_keluarga_id', $kartuKeluargaId);
                $data->where(function (Builder $query) use ($lokasiTugas) {
                        $query->where('is_valid', 1);
                });
                $result = $data->get();
                // return $result;
        }
        foreach ($result as $r) {
            if($r->foto_profil != null){
                $r->foto_profil = asset('storage/upload/foto_profil/keluarga'). "/". $r->foto_profil;
            }
        }
        return $result;
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
            "bidan_id" => 'nullable|exists:bidan,id',
            "kartu_keluarga_id" => 'required|exists:kartu_keluarga,id',
            "user_id" => 'nullable|exists:users,id',
            "nama_lengkap" => 'required|string',
            "nik" => 'required|unique:anggota_keluarga,nik',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|exists:agama,id',
            "pendidikan_id" => 'required|exists:pendidikan,id',
            "jenis_pekerjaan_id" => 'required|exists:pekerjaan,id',
            "golongan_darah_id" => 'required|exists:golongan_darah,id',
            "status_perkawinan_id" => 'required|exists:status_perkawinan,id',
            "status_hubungan_dalam_keluarga_id" => 'required|exists:status_hubungan,id',
            "kewarganegaraan" => 'required|string',
            "nama_ayah" => 'required|string',
            "nama_ibu" => 'required|string',
            "is_valid" => 'required|numeric|in:0,1',
            "foto_profil" => 'nullable|string',
        ]);

        $data = AnggotaKeluarga::create($request->all());
        if (Auth::user() && Auth::user()->role == 'bidan') {
            $remaja = AnggotaKeluarga::with('user')->where('status_hubungan_dalam_keluarga_id', 4)
                ->where('tanggal_lahir', '<=', Carbon::now()->subYears(10))
                ->where('tanggal_lahir', '>=', Carbon::now()->subYears(19))
                ->where('id', $data->id)
                ->whereDoesntHave('user')
                ->first();

            if ($remaja) {
                $user = User::create([
                    'nik' => $remaja->nik,
                    'password' => Hash::make('password'),
                    'role' => 'keluarga',
                    'is_remaja' => 1,
                    'status' => 1,
                ]);

                $remaja->user_id = $user->id;
                $remaja->save();
            }
        }
        return $data;
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
            return AnggotaKeluarga::with('kartuKeluarga', 'user', 'statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili', 'agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan')->where('id', $id)->first();
        }
        return AnggotaKeluarga::with('agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusHubunganDalamKeluarga', 'statusPerkawinan','wilayahDomisili.provinsi','wilayahDomisili.kabupatenKota','wilayahDomisili.kecamatan','wilayahDomisili.desaKelurahan')->where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $isUpdate = $request->is_update;
        if($isUpdate){
            $nikValidation = "required|unique:anggota_keluarga,nik,". $request->nik . ",nik";
        }else{
            $nikValidation = "required|unique:anggota_keluarga,nik";
        }
        $request->validate([
            "nik" => $nikValidation,
            "file_foto_profil" => 'required|mimes:jpeg,jpg,png|max:3072',
        ]);

        $fileName = $request->nik . '.' . $request->file('file_foto_profil')->extension();
        $path = 'upload/foto_profil/keluarga/';

        if (Storage::exists($path . $fileName)) {
            Storage::delete($path . $fileName);
        }
        $request->file('file_foto_profil')->storeAs(
            $path,
            $fileName
        );

        return response([
            'foto_profil' => $fileName
        ], 201);
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
        $statusHubungan = $request->status_hubungan_dalam_keluarga_id;
        if($statusHubungan == 1){
            $userIdRule = 'required|exists:users,id';
        }else{
            $userIdRule = 'nullable|string';
        }
        $request->validate([
            "bidan_id" => 'required|exists:bidan,id',
            "kartu_keluarga_id" => 'required|exists:kartu_keluarga,id',
            "user_id" => $userIdRule,
            "nama_lengkap" => 'required|string',
            "nik" => "required|unique:anggota_keluarga,nik,$id",
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|exists:agama,id',
            "pendidikan_id" => 'required|exists:pendidikan,id',
            "jenis_pekerjaan_id" => 'required|exists:pekerjaan,id',
            "golongan_darah_id" => 'required|exists:golongan_darah,id',
            "status_perkawinan_id" => 'required|exists:status_perkawinan,id',
            "tanggal_perkawinan" => 'nullable|string',
            "status_hubungan_dalam_keluarga_id" => 'required|exists:status_hubungan,id',
            "kewarganegaraan" => 'required|string',
            "no_paspor" => 'required|string',
            "no_kitap" => 'required|string',
            "nama_ayah" => 'required|string',
            "nama_ibu" => 'required|string',
            "foto_profil" => 'nullable|string',
            "is_valid" => 'numeric|in:0,1',
            "tanggal_validasi" => 'nullable|string',
            "alasan_ditolak" => 'nullable|string',
        ]);

        $anggotaKeluarga = AnggotaKeluarga::find($id);

        if ($anggotaKeluarga) {
            $anggotaKeluarga->update($request->all());
            return $anggotaKeluarga;
        }

        return response([
            'message' => "Anggota Keluarga with id $id doesn't exist"
        ], 400);
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
        $anggotaKeluarga = AnggotaKeluarga::find($id);

        if (!$anggotaKeluarga) {
            return response([
                'message' => "Anggota Keluarga with id $id doesn't exist"
            ], 404);
        }

        if (Storage::exists('upload/foto_profil/keluarga/' . $anggotaKeluarga->foto_profil)) {
            Storage::delete('upload/foto_profil/keluarga/' . $anggotaKeluarga->foto_profil);
        }

        if ($anggotaKeluarga->wilayahDomisili) {
            if (Storage::exists('upload/surat_keterangan_domisili/' . $anggotaKeluarga->wilayahDomisili->file_ket_domisili)) {
                Storage::delete('upload/surat_keterangan_domisili/' . $anggotaKeluarga->wilayahDomisili->file_ket_domisili);
            }
            $anggotaKeluarga->wilayahDomisili->delete();
        }

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $anggotaKeluarga->id);

        if ($pemberitahuan) {
            if($forceDelete){
                $pemberitahuan->forceDelete();
            }else{
                $pemberitahuan->delete();
            }
        }


        if ($anggotaKeluarga->user) {
            if($forceDelete){
                $anggotaKeluarga->user->forceDelete();
            }else{
                $anggotaKeluarga->user->delete();
            }
        }
        if($forceDelete){
            return $anggotaKeluarga->forceDelete();
        }else{
            return $anggotaKeluarga->delete();
        }
    }

    /**
     * validate anggota keluarga.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validasi(Request $request)
    {
        $id = $request->id;
        if(!$id){
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

        $anggotaKeluarga = AnggotaKeluarga::find($id);
        if(!$anggotaKeluarga){
            return response([
                'message' => "anggota keluarga with id $id not found!"
            ], 404);
        }

        $updateAnggotaKeluarga = $anggotaKeluarga
            ->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();
        if ($request->konfirmasi == 1) {
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id,
                'anggota_keluarga_id' => $anggotaKeluarga->id,
                'judul' => 'Selamat, data ' . strtolower($anggotaKeluarga->statusHubunganDalamKeluarga->status_hubungan) . ' anda telah divalidasi.',
                'isi' => 'Data ' . ucwords(strtolower($anggotaKeluarga->statusHubunganDalamKeluarga->status_hubungan)) . ' anda (' . ucwords(strtolower($anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.',
                'tentang' => 'anggota_keluarga',
            ]);
            
            $remaja = AnggotaKeluarga::with('user')->where('status_hubungan_dalam_keluarga_id', 4)
                ->where('tanggal_lahir', '<=', Carbon::now()->subYears(10))
                ->where('tanggal_lahir', '>=', Carbon::now()->subYears(19))
                ->where('id', $anggotaKeluarga->id)
                ->whereDoesntHave('user')
                ->first();

            if ($remaja) {
                $user = User::create([
                    'nik' => $remaja->nik,
                    'password' => Hash::make('password'),
                    'role' => 'keluarga',
                    'is_remaja' => 1,
                    'status' => 1,
                ]);

                $remaja->user_id = $user->id;
                $remaja->save();
            }
        } else {
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id,
                'anggota_keluarga_id' => $anggotaKeluarga->id,
                'judul' => 'Maaf, data ' . strtolower($anggotaKeluarga->statusHubunganDalamKeluarga->status_hubungan) . ' anda (' . ucwords(strtolower($anggotaKeluarga->nama_lengkap)) . ') ditolak.',
                'isi' => 'Silahkan perbarui data untuk melihat alasan data ditolak dan mengirim ulang data. Terima Kasih.',
                'tentang' => 'anggota_keluarga',
            ]);
        }

        if ($updateAnggotaKeluarga) {
            return response([
                'message' => "data updated"
            ], 201);
        } else {
            return response([
                'message' => "failed to update data"
            ], 500);
        }
    }
}
