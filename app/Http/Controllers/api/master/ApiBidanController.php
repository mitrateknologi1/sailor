<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Bidan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiBidanController extends Controller
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
        $lokasiTugasKelurahanId = $request->lokasi_tugas_desa_kelurahan_id;
        $bidan = new Bidan;

        if ($relation) {
            $bidan = Bidan::with('user', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama');
        }

        if ($lokasiTugasKelurahanId) {
            if (!$relation) {
                $bidan = Bidan::with('lokasiTugas');
            }
            $bidan->whereHas('lokasiTugas',  function ($query) use ($lokasiTugasKelurahanId) {
                $query->where('desa_kelurahan_id', $lokasiTugasKelurahanId);
            });
        }

        return $bidan->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "user_id" => 'required|exists:users,id',
            "nik" => 'required|unique:bidan,nik',
            "nama_lengkap" => 'required|string',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|numeric',
            "tujuh_angka_terakhir_str" => 'required|string',
            "nomor_hp" => 'required|string|unique:bidan,nomor_hp',
            "alamat" => 'required',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);
        return Bidan::create($request->all());
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
            return Bidan::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama')->where('id', $id)->first();
        }
        return Bidan::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            "nik" => "required|unique:bidan,nik,$id",
            "file_foto_profil" => 'required|mimes:jpeg,jpg,png|max:3072',
        ]);

        $fileName = $request->nik . '.' . $request->file('file_foto_profil')->extension();
        $path = 'upload/foto_profil/bidan/';

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
        $request->validate([
            "user_id" => 'exists:users,id',
            "nik" => "unique:bidan,nik,$id",
            "nomor_hp" => "unique:bidan,nomor_hp,$id",
            "desa_kelurahan_id" => "exists:desa_kelurahan,id",
            "kecamatan_id" => "exists:kecamatan,id",
            "kabupaten_kota_id" => "exists:kabupaten_kota,id",
            "provinsi_id" => "exists:provinsi,id",
        ]);
        $bidan = Bidan::find($id);

        if ($bidan) {
            $bidan->update($request->all());
            return $bidan;
        }

        return response([
            'message' => "Bidan with id $id doesn't exist"
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
        $bidan = Bidan::find($id);

        if (!$bidan) {
            return response([
                'message' => "Bidan with id $id doesn't exist"
            ], 400);
        }


        if (Storage::exists('upload/foto_profil/bidan/' . $bidan->foto_profil)) {
            Storage::delete('upload/foto_profil/bidan/' . $bidan->foto_profil);
        }

        $bidan->lokasiTugas()->delete();
        return $bidan->delete();
    }
}
