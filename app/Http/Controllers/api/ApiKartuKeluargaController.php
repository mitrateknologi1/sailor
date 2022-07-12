<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\KartuKeluarga;
use App\Models\Pemberitahuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiKartuKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $relation = $request->relation;
        $kartuKeluarga = new KartuKeluarga;

        if ($relation) {
            $kartuKeluarga = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'bidan');
        }

        return  $kartuKeluarga->paginate($pageSize);
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
            "bidan_id" => 'required|exists:bidan,id',
            "nomor_kk" => 'required|unique:kartu_keluarga,nomor_kk',
            "nama_kepala_keluarga" => 'required|string',
            "alamat" => 'required|string',
            "rt" => 'numeric',
            "rw" => 'numeric',
            "kode_pos" => 'numeric',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
            "is_valid" => 'required|in:0,1',
            "tanggal_validasi" => "string",
            "alasan_ditolak" => "string",
            "file_kartu_keluarga" => 'mimes:jpeg,jpg,png,pdf|max:3072',
        ]);

        $fileKK = null;
        if ($request->file_kartu_keluarga) {
            $request->file('file_kartu_keluarga')->storeAs(
                'upload/kartu_keluarga/',
                $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension()
            );
            $fileKK = $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension();
        }

        return KartuKeluarga::create([
            "bidan_id" => $request->bidan_id,
            "nomor_kk" => $request->nomor_kk,
            "nama_kepala_keluarga" => $request->nama_kepala_keluarga,
            "alamat" => $request->alamat,
            "rt" => $request->rt,
            "rw" => $request->rw,
            "kode_pos" => $request->kode_pos,
            "desa_kelurahan_id" => $request->desa_kelurahan_id,
            "kecamatan_id" => $request->kecamatan_id,
            "kabupaten_kota_id" => $request->kabupaten_kota_id,
            "provinsi_id" => $request->provinsi_id,
            "is_valid" => $request->is_valid,
            "tanggal_validasi" => $request->tanggal_validasi,
            "alasan_ditolak" => $request->alasan_ditolak,
            "file_kk" => $fileKK,
        ]);
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
            return KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'bidan')->where('id', $id)->first();
        }
        return KartuKeluarga::where('id', $id)->first();
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
            "bidan_id" => 'exists:bidan,id',
            "nomor_kk" => "numeric|unique:kartu_keluarga,nomor_kk,$id",
            "alamat" => 'string',
            "rt" => 'numeric',
            "rw" => 'numeric',
            "kode_pos" => 'numeric',
            "desa_kelurahan_id" => "exists:desa_kelurahan,id",
            "kecamatan_id" => "exists:kecamatan,id",
            "kabupaten_kota_id" => "exists:kabupaten_kota,id",
            "provinsi_id" => "exists:provinsi,id",
            "is_valid" => 'in:0,1',
            "tanggal_validasi" => "string",
            "file_kartu_keluarga" => 'mimes:jpeg,jpg,png,pdf|max:3072',
        ]);

        $kartuKeluarga = KartuKeluarga::find($id);

        $fileKK = null;
        if ($request->file_kartu_keluarga) {
            if (Storage::exists('upload/kartu_keluarga/' . $kartuKeluarga->file_kk)) {
                Storage::delete('upload/kartu_keluarga/' . $kartuKeluarga->file_kk);
            }
            $request->file('file_kartu_keluarga')->storeAs(
                'upload/kartu_keluarga/',
                $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension()
            );
            $fileKK = $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension();
        }

        $kartuKeluarga->update([
            "bidan_id" => $request->bidan_id ?? $kartuKeluarga->bidan_id,
            "nomor_kk" => $request->nomor_kk ?? $kartuKeluarga->nomor_kk,
            "nama_kepala_keluarga" => $request->nama_kepala_keluarga ?? $kartuKeluarga->nama_kepala_keluarga,
            "alamat" => $request->alamat ?? $kartuKeluarga->alamat,
            "rt" => $request->rt ?? $kartuKeluarga->rt,
            "rw" => $request->rw ?? $kartuKeluarga->rw,
            "kode_pos" => $request->kode_pos ?? $kartuKeluarga->kode_pos,
            "desa_kelurahan_id" => $request->desa_kelurahan_id ?? $kartuKeluarga->desa_kelurahan_id,
            "kecamatan_id" => $request->kecamatan_id ?? $kartuKeluarga->kecamatan_id,
            "kabupaten_kota_id" => $request->kabupaten_kota_id ?? $kartuKeluarga->kabupaten_kota_id,
            "provinsi_id" => $request->provinsi_id ?? $kartuKeluarga->provinsi_id,
            "is_valid" => $request->is_valid ?? $kartuKeluarga->is_valid,
            "tanggal_validasi" => $request->tanggal_validasi ?? $kartuKeluarga->tanggal_validasi,
            "alasan_ditolak" => $request->alasan_ditolak ?? $kartuKeluarga->alasan_ditolak,
            "file_kk" => $fileKK ?? $kartuKeluarga->file_kk,
        ]);
        return $kartuKeluarga;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kartuKeluarga = KartuKeluarga::find($id);


        foreach ($kartuKeluarga->anggotaKeluarga as $anggota) {
            if (Storage::exists('upload/foto_profil/keluarga/' . $anggota->foto_profil)) {
                Storage::delete('upload/foto_profil/keluarga/' . $anggota->foto_profil);
            }

            if (Storage::exists('upload/surat_keterangan_domisili/' . $anggota->wilayahDomisili->file_ket_domisili)) {
                Storage::delete('upload/surat_keterangan_domisili/' . $anggota->wilayahDomisili->file_ket_domisili);
            }

            $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $anggota->id);

            if ($anggota->wilayahDomisili) {
                $anggota->wilayahDomisili->delete();
            }

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }
        }
        if (Storage::exists('upload/kartu_keluarga/' . $kartuKeluarga->file_kk)) {
            Storage::delete('upload/kartu_keluarga/' . $kartuKeluarga->file_kk);
        }

        $user = User::where('id', $kartuKeluarga->kepalaKeluarga->user_id);

        $remaja = AnggotaKeluarga::where('kartu_keluarga_id', $kartuKeluarga->id)
            ->where('status_hubungan_dalam_keluarga_id', 4)
            ->whereNotNull('user_id')->get();
        foreach ($remaja as $r) {
            $r->user->delete();
        }
        // $remaja->user->delete();
        $user->delete();

        $anggotaKeluarga = AnggotaKeluarga::where('kartu_keluarga_id', $kartuKeluarga->id);
        $anggotaKeluarga->delete();

        return $kartuKeluarga->delete();
    }
}
