<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\PerkiraanMelahirkan;
use Illuminate\Http\Request;
use App\Models\LokasiTugas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Pemberitahuan;
use App\Models\Bidan;

class ApiPerkiraanMelahirkanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $pageSize = $request->page_size ?? 20;
        $perikiraanMelahirkan = new PerkiraanMelahirkan;

        if(Auth::user()->role== "keluarga"){
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            return PerkiraanMelahirkan::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();
        }

        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
        $data = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    });
                }
                if (Auth::user()->role == 'bidan') { // bidan
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

        $perikiraanMelahirkan = PerkiraanMelahirkan::with('bidan', 'anggotaKeluarga');
        if ($relation) {
            $perikiraanMelahirkan = PerkiraanMelahirkan::with('bidan', 'anggotaKeluarga');
        }
        // return $perikiraanMelahirkan->orderBy('updated_at', 'desc')->paginate($pageSize);
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
        $bidanRule = $role == "bidan" ? 'nullable|exists:bidan,id' : 'required|exists:bidan,id';

        $request->validate([
            'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id',
            'bidan_id' => $bidanRule,
            'tanggal_haid_terakhir' => 'required',
            'tanggal_perkiraan_lahir' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
            'tanggal_haid_terakhir' => $request->tanggal_haid_terakhir,
            'tanggal_perkiraan_lahir' => $request->tanggal_perkiraan_lahir,
            'is_valid' => $role == "bidan" ? 1 : 0,
            'tanggal_validasi' => $role == "bidan" ? Carbon::now() : null,
            'alasan_ditolak' => null,
        ];

        return PerkiraanMelahirkan::create($data);
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
            return PerkiraanMelahirkan::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return PerkiraanMelahirkan::where('id', $id)->first();
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
        $bidanId = $role != "bidan" ? 'required|exists:bidan,id' : '';
        $request->validate([
            'anggota_keluarga_id' => 'nullable|exists:anggota_keluarga,id',
            'bidan_id' => $bidanId,
            'tanggal_haid_terakhir' => 'nullable',
            'tanggal_perkiraan_lahir' => 'nullable',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $perikiraanMelahirkan = PerkiraanMelahirkan::find($id);

        if ($perikiraanMelahirkan) {
            $data = [
                'anggota_keluarga_id' => $request->anggota_keluarga_id,
                'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
                'tanggal_haid_terakhir' => $request->tanggal_haid_terakhir,
                'tanggal_perkiraan_lahir' => $request->tanggal_perkiraan_lahir,
                'is_valid' => $role == "bidan" ? 1 : 0,
                'tanggal_validasi' => $role == "bidan" ? Carbon::now() : null,
                'alasan_ditolak' => $request->is_valid == 2 ? $request->alasan_dtolak : null,
            ];
            $perikiraanMelahirkan->update($data);
            return $perikiraanMelahirkan;
        }

        return response([
            'message' => "Perkiraan Melahirkan with id $id doesn't exist"
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
        $perkiraanMelahirkan = PerkiraanMelahirkan::find($id);

        if (!$perkiraanMelahirkan) {
            return response([
                'message' => "Perkiraan Melahirkan with id $id doesn't exist"
            ], 404);
        }

        return $perkiraanMelahirkan->delete();
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

        $perkiraanMelahirkan = PerkiraanMelahirkan::find($id);
        if(!$perkiraanMelahirkan){
            return response([
                'message' => "Data Perkiraan Melahirkan with id $id not found!",
            ], 404);
        }

        $perkiraanMelahirkan->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $perkiraanMelahirkan->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $perkiraanMelahirkan->id;
        $pemberitahuan->anggota_keluarga_id = $perkiraanMelahirkan->anggota_keluarga_id;
        $pemberitahuan->tentang = 'perkiraan_melahirkan';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data perkiraan melahirkan anda telah divalidasi.';
            $pemberitahuan->isi = 'Data perkiraan melahirkan anda (' . ucwords(strtolower($perkiraanMelahirkan->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data perkiraan melahirkan anda' . ' (' . ucwords(strtolower($perkiraanMelahirkan->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data perkiraan melahirkan ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();

        return response([
            'message' => "Data Perkiraan Melahirkan validated!",
        ], 200);
    }
}
