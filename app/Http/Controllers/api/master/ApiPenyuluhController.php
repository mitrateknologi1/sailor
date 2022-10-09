<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiPenyuluhController extends Controller
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
        $search = $request->search;
        $lokasiTugasKelurahanId = $request->lokasi_tugas_desa_kelurahan_id;
        $penyuluh = new Penyuluh;

        $penyuluh = Penyuluh::with('user', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama',);
        if ($relation) {
            $penyuluh = Penyuluh::with('user', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama',);
        }

        if ($search) {
            return $penyuluh->search($search)->orderBy("updated_at", "desc")->paginate($pageSize);
        }

        if ($lokasiTugasKelurahanId) {
            if (!$relation) {
                $penyuluh = Penyuluh::with('lokasiTugas');
            }
            $penyuluh->whereHas('lokasiTugas',  function ($query) use ($lokasiTugasKelurahanId) {
                $query->where('desa_kelurahan_id', $lokasiTugasKelurahanId);
            });
        }

        // return $penyuluh->orderBy('updated_at', 'desc')->paginate($pageSize);
        $data = $penyuluh->orderBy('updated_at', 'desc')->get();
        $response = [];
        foreach ($data as $d) {
            array_push($response, $d);
            if(count($d->lokasiTugas) > 0){
                $d->lokasiTugas[0]->desa_kelurahan = $d->lokasiTugas[0]->desaKelurahan;
            }
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
        $request->validate([
            "user_id" => 'required|exists:users,id',
            "nik" => 'required|numeric|unique:penyuluh,nik',
            "nama_lengkap" => 'required|string',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|numeric',
            "tujuh_angka_terakhir_str" => 'required|string',
            "nomor_hp" => 'required|string|unique:bidan,nomor_hp',
            "email" => "required|string",
            "alamat" => 'required|string',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);
        return Penyuluh::create($request->all());
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
            return Penyuluh::with('user', 'provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama')->where('id', $id)->first();
        }
        return Penyuluh::where('id', $id)->first();
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
            "nik" => "required|unique:penyuluh,nik,$id",
            "file_foto_profil" => 'required|mimes:jpeg,jpg,png|max:3072',
        ]);

        $fileName = $request->nik . '.' . $request->file('file_foto_profil')->extension();
        $path = 'upload/foto_profil/penyuluh/';

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
            "user_id" => 'required|exists:users,id',
            "nik" => "required|numeric|unique:penyuluh,nik,$id",
            "nama_lengkap" => 'required|string',
            "jenis_kelamin" => 'required|in:PEREMPUAN,LAKI-LAKI',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|string',
            "agama_id" => 'required|numeric',
            "tujuh_angka_terakhir_str" => 'required|string',
            "nomor_hp" => "required|string|unique:bidan,nomor_hp,$id",
            "email" => "required|string",
            "alamat" => 'required|string',
            "desa_kelurahan_id" => "required|exists:desa_kelurahan,id",
            "kecamatan_id" => "required|exists:kecamatan,id",
            "kabupaten_kota_id" => "required|exists:kabupaten_kota,id",
            "provinsi_id" => "required|exists:provinsi,id",
        ]);

        $penyuluh = Penyuluh::find($id);
        if ($penyuluh) {
            $penyuluh->update($request->all());
            return $penyuluh;
        }

        return response([
            'message' => "Penyuluh with id $id doesn't exist"
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
        $penyuluh = Penyuluh::find($id);

        if (!$penyuluh) {
            return response([
                'message' => "Anggota Keluarga with id $id doesn't exist"
            ], 400);
        }

        if (Storage::exists('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil)) {
            Storage::delete('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil);
        }

        $penyuluh->lokasiTugas()->delete();
        return $penyuluh->delete();
    }
}
