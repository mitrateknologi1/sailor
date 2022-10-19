<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
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
        $relation = $request->relation;
        $pageSize = $request->page_size ?? 20;
        $pertumbuhanAnak = new PertumbuhanAnak;

        if ($relation) {
            $pertumbuhanAnak = PertumbuhanAnak::with('bidan', 'anggotaKeluarga');
        }

        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        $data = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')
            ->where(function (Builder $query) use ($lokasiTugas) {
                if (Auth::user()->role != 'admin') { // bidan/penyuluh
                    $query->whereHas('anggotaKeluarga', function (Builder $query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });

                    if (Auth::user()->role == 'bidan') { // bidan
                        $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                    }

                    if (Auth::user()->role == 'penyuluh') { // penyuluh
                        $query->valid();
                    }
                }
            })->orderBy('created_at', 'DESC')->get();
        
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

        // return $pertumbuhanAnak->orderBy('updated_at', 'desc')->paginate($pageSize);
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
            "berat_badan" => 'required',
            "zscore" => 'required',
            "hasil" => 'required',
            "is_valid" => 'nullable|in:0,1',
            "tanggal_validasi" => 'nullable',
            "alasan_ditolak" => 'nullable',
        ]);

        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
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
