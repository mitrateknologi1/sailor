<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\StuntingAnak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiTugas;
use Carbon\Carbon;
use App\Models\AnggotaKeluarga;
use Illuminate\Support\Facades\Validator;
use App\Models\Bidan;
use App\Models\Pemberitahuan;

class ApiStuntingAnakController extends Controller
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
        // $stuntingAnak = new StuntingAnak;

        // if ($relation) {
        //     $stuntingAnak = StuntingAnak::with('bidan', 'anggotaKeluarga');
        // }
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
            $stuntingAnak = StuntingAnak::with('bidan', 'anggotaKeluarga')->where(function ($query) use ($lokasiTugas) {
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
            });

            $data = $stuntingAnak->orderBy('updated_at', 'desc')->get();
            foreach ($data as $d) {
                $d->anggotaKeluarga->kartu_keluarga = $d->anggotaKeluarga->kartuKeluarga;
                
                $d->anggotaKeluarga->wilayahDomisili->provinsi = $d->anggotaKeluarga->wilayahDomisili->provinsi;
                $d->anggotaKeluarga->wilayahDomisili->kabupatenKota = $d->anggotaKeluarga->wilayahDomisili->kabupatenKota;
                $d->anggotaKeluarga->wilayahDomisili->kecamatan = $d->anggotaKeluarga->wilayahDomisili->kecamatan;
                $d->anggotaKeluarga->wilayahDomisili->desaKelurahan = $d->anggotaKeluarga->wilayahDomisili->desaKelurahan;
            }
            return $data;
        }else{
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $stuntingAnak = StuntingAnak::with('anggotaKeluarga', 'bidan')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();
            
            foreach ($stuntingAnak as $d) {
                $d->anggotaKeluarga->kartu_keluarga = $d->anggotaKeluarga->kartuKeluarga;
                
                $d->anggotaKeluarga->wilayahDomisili->provinsi = $d->anggotaKeluarga->wilayahDomisili->provinsi;
                $d->anggotaKeluarga->wilayahDomisili->kabupatenKota = $d->anggotaKeluarga->wilayahDomisili->kabupatenKota;
                $d->anggotaKeluarga->wilayahDomisili->kecamatan = $d->anggotaKeluarga->wilayahDomisili->kecamatan;
                $d->anggotaKeluarga->wilayahDomisili->desaKelurahan = $d->anggotaKeluarga->wilayahDomisili->desaKelurahan;
            }
            return $stuntingAnak;
        }

        // return $stuntingAnak->orderBy('updated_at', 'desc')->paginate($pageSize);
    }

    public function proses(Request $request)
    {
        $anak = AnggotaKeluarga::where('id', $request->anggota_keluarga_id)->withTrashed()->first();
        $tanggalLahir = $anak->tanggal_lahir;
        $tanggalSekarang = date('Y-m-d');

        // hitung usia dalam bulan
        $usiaBulan = round(((strtotime($tanggalSekarang) - strtotime($tanggalLahir)) / 86400) / 30);

        $jenisKelamin = $anak->jenis_kelamin; //Laki-laki atau Perempuan
        $tinggiBadan = $request->tinggi_badan; //dalam CM

        $median = 0;
        $sd = 0;
        $sd1 = 0;

        $kategoriTinggi = '';

        if ($jenisKelamin  == "LAKI-LAKI") {
            if ($usiaBulan == 0) {
                $median = 49.9;
                $sd = 48.0;
                $sd1 = 51.8;
            } else if ($usiaBulan == 1) {
                $median = 54.7;
                $sd = 52.8;
                $sd1 = 56.7;
            } else if ($usiaBulan == 2) {
                $median = 58.4;
                $sd = 56.4;
                $sd1 = 60.4;
            } else if ($usiaBulan == 3) {
                $median = 61.4;
                $sd = 59.4;
                $sd1 = 63.5;
            } else if ($usiaBulan == 4) {
                $median = 63.9;
                $sd = 61.8;
                $sd1 = 66.0;
            } else if ($usiaBulan == 5) {
                $median = 65.9;
                $sd = 63.8;
                $sd1 = 68.0;
            } else if ($usiaBulan == 6) {
                $median = 67.6;
                $sd = 65.5;
                $sd1 = 69.8;
            } else if ($usiaBulan == 7) {
                $median = 69.2;
                $sd = 67.0;
                $sd1 = 71.3;
            } else if ($usiaBulan == 8) {
                $median = 70.6;
                $sd = 68.4;
                $sd1 = 72.8;
            } else if ($usiaBulan == 9) {
                $median = 72.0;
                $sd = 69.7;
                $sd1 = 74.2;
            } else if ($usiaBulan == 10) {
                $median = 73.3;
                $sd = 71.0;
                $sd1 = 75.6;
            } else if ($usiaBulan == 11) {
                $median = 74.5;
                $sd = 72.2;
                $sd1 = 76.9;
            } else if ($usiaBulan == 12) {
                $median = 75.7;
                $sd = 73.4;
                $sd1 = 78.1;
            } else if ($usiaBulan == 13) {
                $median = 76.9;
                $sd = 74.5;
                $sd1 = 79.3;
            } else if ($usiaBulan == 14) {
                $median = 78.0;
                $sd = 75.6;
                $sd1 = 80.5;
            } else if ($usiaBulan == 15) {
                $median = 79.1;
                $sd = 76.6;
                $sd1 = 81.7;
            } else if ($usiaBulan == 16) {
                $median = 80.2;
                $sd = 77.6;
                $sd1 = 82.8;
            } else if ($usiaBulan == 17) {
                $median = 81.2;
                $sd = 78.6;
                $sd1 = 83.9;
            } else if ($usiaBulan == 18) {
                $median = 82.3;
                $sd = 79.6;
                $sd1 = 85.0;
            } else if ($usiaBulan == 19) {
                $median = 83.2;
                $sd = 79.6;
                $sd1 = 85.0;
            } else if ($usiaBulan == 20) {
                $median = 84.2;
                $sd = 81.4;
                $sd1 = 87.0;
            } else if ($usiaBulan == 21) {
                $median = 85.1;
                $sd = 82.3;
                $sd1 = 88.0;
            } else if ($usiaBulan == 22) {
                $median = 86.0;
                $sd = 83.1;
                $sd1 = 89.0;
            } else if ($usiaBulan == 23) {
                $median = 86.9;
                $sd = 83.9;
                $sd1 = 89.9;
            } else if ($usiaBulan == 24) {
                $median = 87.8;
                $sd = 84.8;
                $sd1 = 90.9;
            } else if ($usiaBulan == 25) {
                $median = 88.0;
                $sd = 84.9;
                $sd1 = 91.1;
            } else if ($usiaBulan == 26) {
                $median = 88.8;
                $sd = 85.6;
                $sd1 = 92.0;
            } else if ($usiaBulan == 27) {
                $median = 89.6;
                $sd = 86.4;
                $sd1 = 92.9;
            } else if ($usiaBulan == 28) {
                $median = 90.4;
                $sd = 87.1;
                $sd1 = 93.7;
            } else if ($usiaBulan == 29) {
                $median = 91.2;
                $sd = 87.8;
                $sd1 = 94.5;
            } else if ($usiaBulan == 30) {
                $median = 91.9;
                $sd = 88.5;
                $sd1 = 95.3;
            } else if ($usiaBulan == 31) {
                $median = 92.7;
                $sd = 89.2;
                $sd1 = 96.1;
            } else if ($usiaBulan == 32) {
                $median = 93.4;
                $sd = 89.9;
                $sd1 = 96.9;
            } else if ($usiaBulan == 33) {
                $median = 94.1;
                $sd = 90.5;
                $sd1 = 97.6;
            } else if ($usiaBulan == 34) {
                $median = 94.8;
                $sd = 91.1;
                $sd1 = 98.4;
            } else if ($usiaBulan == 35) {
                $median = 95.4;
                $sd = 91.8;
                $sd1 = 99.1;
            } else if ($usiaBulan == 36) {
                $median = 96.1;
                $sd = 92.4;
                $sd1 = 99.8;
            } else if ($usiaBulan == 37) {
                $median = 96.7;
                $sd = 93.0;
                $sd1 = 100.5;
            } else if ($usiaBulan == 38) {
                $median = 97.4;
                $sd = 93.6;
                $sd1 = 101.2;
            } else if ($usiaBulan == 39) {
                $median = 98.0;
                $sd = 94.2;
                $sd1 = 101.8;
            } else if ($usiaBulan == 40) {
                $median = 98.6;
                $sd = 94.7;
                $sd1 = 102.5;
            } else if ($usiaBulan == 41) {
                $median = 99.2;
                $sd = 95.3;
                $sd1 = 103.2;
            } else if ($usiaBulan == 42) {
                $median = 99.9;
                $sd = 95.9;
                $sd1 = 103.8;
            } else if ($usiaBulan == 43) {
                $median = 100.4;
                $sd = 96.4;
                $sd1 = 104.5;
            } else if ($usiaBulan == 44) {
                $median = 101.0;
                $sd = 97.0;
                $sd1 = 105.1;
            } else if ($usiaBulan == 45) {
                $median = 101.6;
                $sd = 97.5;
                $sd1 = 105.7;
            } else if ($usiaBulan == 46) {
                $median = 102.2;
                $sd = 98.1;
                $sd1 = 106.3;
            } else if ($usiaBulan == 47) {
                $median = 102.8;
                $sd = 98.6;
                $sd1 = 106.9;
            } else if ($usiaBulan == 48) {
                $median = 103.3;
                $sd = 99.1;
                $sd1 = 107.5;
            } else if ($usiaBulan == 49) {
                $median = 103.9;
                $sd = 99.7;
                $sd1 = 108.1;
            } else if ($usiaBulan == 50) {
                $median = 104.4;
                $sd = 100.2;
                $sd1 = 108.7;
            } else if ($usiaBulan == 51) {
                $median = 105.0;
                $sd = 100.7;
                $sd1 = 109.3;
            } else if ($usiaBulan == 52) {
                $median = 105.6;
                $sd = 101.2;
                $sd1 = 109.9;
            } else if ($usiaBulan == 53) {
                $median = 106.1;
                $sd = 101.7;
                $sd1 = 110.5;
            } else if ($usiaBulan == 54) {
                $median = 106.7;
                $sd = 102.3;
                $sd1 = 111.1;
            } else if ($usiaBulan == 55) {
                $median = 107.2;
                $sd = 102.8;
                $sd1 = 111.7;
            } else if ($usiaBulan == 56) {
                $median = 107.8;
                $sd = 103.3;
                $sd1 = 112.3;
            } else if ($usiaBulan == 57) {
                $median = 108.3;
                $sd = 103.8;
                $sd1 = 112.8;
            } else if ($usiaBulan == 58) {
                $median = 108.9;
                $sd = 104.3;
                $sd1 = 113.4;
            } else if ($usiaBulan == 59) {
                $median = 109.4;
                $sd = 104.8;
                $sd1 = 114.0;
            } else {
                $median = 110.0;
                $sd = 105.3;
                $sd1 = 114.6;
            }
        }
        if ($jenisKelamin  == "PEREMPUAN") {
            if ($usiaBulan == 0) {
                $median = 49.1;
                $sd = 47.3;
                $sd1 = 51.0;
            } else if ($usiaBulan == 1) {
                $median = 53.7;
                $sd = 51.7;
                $sd1 = 55.6;
            } else if ($usiaBulan == 2) {
                $median = 57.1;
                $sd = 55.0;
                $sd1 = 59.1;
            } else if ($usiaBulan == 3) {
                $median = 59.8;
                $sd = 57.7;
                $sd1 = 61.9;
            } else if ($usiaBulan == 4) {
                $median = 62.1;
                $sd = 59.9;
                $sd1 = 64.3;
            } else if ($usiaBulan == 5) {
                $median = 64.0;
                $sd = 61.8;
                $sd1 = 66.2;
            } else if ($usiaBulan == 6) {
                $median = 65.7;
                $sd = 63.5;
                $sd1 = 68.0;
            } else if ($usiaBulan == 7) {
                $median = 67.3;
                $sd = 65.0;
                $sd1 = 69.6;
            } else if ($usiaBulan == 8) {
                $median = 68.7;
                $sd = 66.4;
                $sd1 = 71.1;
            } else if ($usiaBulan == 9) {
                $median = 70.1;
                $sd = 67.7;
                $sd1 = 72.6;
            } else if ($usiaBulan == 10) {
                $median = 71.5;
                $sd = 69.0;
                $sd1 = 73.9;
            } else if ($usiaBulan == 11) {
                $median = 72.8;
                $sd = 70.3;
                $sd1 = 75.3;
            } else if ($usiaBulan == 12) {
                $median = 74.0;
                $sd = 71.4;
                $sd1 = 76.6;
            } else if ($usiaBulan == 13) {
                $median = 75.2;
                $sd = 72.6;
                $sd1 = 77.8;
            } else if ($usiaBulan == 14) {
                $median = 76.4;
                $sd = 73.7;
                $sd1 = 79.1;
            } else if ($usiaBulan == 15) {
                $median = 77.5;
                $sd = 74.8;
                $sd1 = 80.2;
            } else if ($usiaBulan == 16) {
                $median = 78.6;
                $sd = 75.8;
                $sd1 = 81.4;
            } else if ($usiaBulan == 17) {
                $median = 79.7;
                $sd = 76.8;
                $sd1 = 82.5;
            } else if ($usiaBulan == 18) {
                $median = 80.7;
                $sd = 77.8;
                $sd1 = 83.6;
            } else if ($usiaBulan == 19) {
                $median = 81.7;
                $sd = 78.8;
                $sd1 = 84.7;
            } else if ($usiaBulan == 20) {
                $median = 82.7;
                $sd = 79.7;
                $sd1 = 85.7;
            } else if ($usiaBulan == 21) {
                $median = 83.7;
                $sd = 80.6;
                $sd1 = 86.7;
            } else if ($usiaBulan == 22) {
                $median = 84.6;
                $sd = 81.5;
                $sd1 = 87.7;
            } else if ($usiaBulan == 23) {
                $median = 85.5;
                $sd = 82.3;
                $sd1 = 88.7;
            } else if ($usiaBulan == 24) {
                $median = 86.4;
                $sd = 83.2;
                $sd1 = 89.6;
            } else if ($usiaBulan == 25) {
                $median = 86.6;
                $sd = 83.3;
                $sd1 = 89.9;
            } else if ($usiaBulan == 26) {
                $median = 87.4;
                $sd = 84.1;
                $sd1 = 90.8;
            } else if ($usiaBulan == 27) {
                $median = 88.3;
                $sd = 84.9;
                $sd1 = 91.7;
            } else if ($usiaBulan == 28) {
                $median = 89.1;
                $sd = 85.7;
                $sd1 = 92.5;
            } else if ($usiaBulan == 29) {
                $median = 89.9;
                $sd = 86.4;
                $sd1 = 93.4;
            } else if ($usiaBulan == 30) {
                $median = 90.7;
                $sd = 87.1;
                $sd1 = 94.2;
            } else if ($usiaBulan == 31) {
                $median = 91.4;
                $sd = 87.9;
                $sd1 = 95.0;
            } else if ($usiaBulan == 32) {
                $median = 92.2;
                $sd = 88.6;
                $sd1 = 95.8;
            } else if ($usiaBulan == 33) {
                $median = 92.9;
                $sd = 89.3;
                $sd1 = 96.6;
            } else if ($usiaBulan == 34) {
                $median = 93.6;
                $sd = 89.9;
                $sd1 = 97.4;
            } else if ($usiaBulan == 35) {
                $median = 94.4;
                $sd = 90.6;
                $sd1 = 98.1;
            } else if ($usiaBulan == 36) {
                $median = 95.1;
                $sd = 91.2;
                $sd1 = 98.9;
            } else if ($usiaBulan == 37) {
                $median = 95.7;
                $sd = 91.9;
                $sd1 = 99.6;
            } else if ($usiaBulan == 38) {
                $median = 96.4;
                $sd = 92.5;
                $sd1 = 100.3;
            } else if ($usiaBulan == 39) {
                $median = 97.1;
                $sd = 93.1;
                $sd1 = 101.0;
            } else if ($usiaBulan == 40) {
                $median = 97.7;
                $sd = 93.8;
                $sd1 = 101.7;
            } else if ($usiaBulan == 41) {
                $median = 98.4;
                $sd = 94.4;
                $sd1 = 102.4;
            } else if ($usiaBulan == 42) {
                $median = 99.0;
                $sd = 95.0;
                $sd1 = 103.1;
            } else if ($usiaBulan == 43) {
                $median = 99.7;
                $sd = 95.6;
                $sd1 = 103.8;
            } else if ($usiaBulan == 44) {
                $median = 100.3;
                $sd = 96.2;
                $sd1 = 104.5;
            } else if ($usiaBulan == 45) {
                $median = 100.9;
                $sd = 96.7;
                $sd1 = 105.1;
            } else if ($usiaBulan == 46) {
                $median = 101.5;
                $sd = 97.3;
                $sd1 = 105.8;
            } else if ($usiaBulan == 47) {
                $median = 102.1;
                $sd = 97.9;
                $sd1 = 106.4;
            } else if ($usiaBulan == 48) {
                $median = 102.7;
                $sd = 98.4;
                $sd1 = 107.0;
            } else if ($usiaBulan == 49) {
                $median = 103.3;
                $sd = 99.0;
                $sd1 = 107.7;
            } else if ($usiaBulan == 50) {
                $median = 103.9;
                $sd = 99.5;
                $sd1 = 108.3;
            } else if ($usiaBulan == 51) {
                $median = 104.5;
                $sd = 100.1;
                $sd1 = 108.9;
            } else if ($usiaBulan == 52) {
                $median = 105.0;
                $sd = 100.6;
                $sd1 = 109.5;
            } else if ($usiaBulan == 53) {
                $median = 105.6;
                $sd = 101.1;
                $sd1 = 110.1;
            } else if ($usiaBulan == 54) {
                $median = 106.2;
                $sd = 101.6;
                $sd1 = 110.7;
            } else if ($usiaBulan == 55) {
                $median = 106.7;
                $sd = 102.2;
                $sd1 = 111.3;
            } else if ($usiaBulan == 56) {
                $median = 107.3;
                $sd = 102.7;
                $sd1 = 111.9;
            } else if ($usiaBulan == 57) {
                $median = 107.8;
                $sd = 103.2;
                $sd1 = 112.5;
            } else if ($usiaBulan == 58) {
                $median = 108.4;
                $sd = 103.7;
                $sd1 = 113.0;
            } else if ($usiaBulan == 59) {
                $median = 108.9;
                $sd = 104.2;
                $sd1 = 115.6;
            } else {
                $median = 109.4;
                $sd = 104.7;
                $sd1 = 114.2;
            }
        }

        if ($tinggiBadan > $median) {
            $ZScore = ($tinggiBadan - $median) / ($sd1 - $median);
        } else if ($tinggiBadan < $median) {
            $ZScore = ($tinggiBadan - $median) / ($median - $sd);
        } else if ($tinggiBadan == $median) {
            $ZScore = ($tinggiBadan - $median) / $median;
        }

        if ($ZScore < -3) {
            $kategoriTinggi = "Sangat Pendek (Resiko Stunting Tinggi)";
        } else if ($ZScore < -3 || $ZScore <= -2) {
            $kategoriTinggi = "Pendek (Resiko Stunting Sedang)";
        } else if ($ZScore < -2 || $ZScore <= 2) {
            $kategoriTinggi = "Normal";
        } else if ($ZScore > 2) {
            $kategoriTinggi = "Tinggi";
        }

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($tanggalLahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'zscore' =>  number_format($ZScore, 2, '.', ''),
            'kategori' => $kategoriTinggi
        ];
        return $data;
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
            'tinggi_badan' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);
        $unValidatedData = StuntingAnak::where('anggota_keluarga_id', $request->anggota_keluarga_id)->where('is_valid', '!=', 1);
        $anak = AnggotaKeluarga::find($request->anggota_keluarga_id);
        if($unValidatedData->count() > 0){
            return response([
                'message' => "Terdapat Data Stunting Anak atas nama $anak->nama_lengkap yang belum divalidasi!"
            ], 407);
        }

        $result = $this->proses($request);
        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? Auth::user()->profil->id : $request->bidan_id,
            'tinggi_badan' => $request->tinggi_badan,
            'zscore' => $result['zscore'],
            'kategori' => $result['kategori'],
            'is_valid' => $role == "bidan" ? 1 : 0,
            'tanggal_validasi' => $role == "bidan" ? Carbon::now() : null,
            'alasan_ditolak' => null,
        ];

        return StuntingAnak::create($data);
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
            return StuntingAnak::with('bidan', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return StuntingAnak::where('id', $id)->first();
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
            'tinggi_badan' => 'required',
            'is_valid' => 'nullable|in:0,1',
            'tanggal_validasi' => 'nullable',
            'alasan_ditolak' => 'nullable',
        ]);

        $result = $this->proses($request);
        $data = [
            'anggota_keluarga_id' => $request->anggota_keluarga_id,
            'bidan_id' => $role == "bidan" ? $request->bidan_id : null,
            'tinggi_badan' => $request->tinggi_badan,
            'zscore' => $result['zscore'],
            'kategori' => $result['kategori'],
            'is_valid' => $role == "bidan" ? 1 : 0,
            'tanggal_validasi' => $role == "bidan" ? Carbon::now() : null,
            'alasan_ditolak' => null,
        ];

        $stuntingAnak = StuntingAnak::find($id);

        if ($stuntingAnak) {
            $stuntingAnak->update($data);
            return $stuntingAnak;
        }

        return response([
            'message' => "Stunting Anak with id $id doesn't exist"
        ], 404);
    }

    public function validasi(Request $request)
    {
        $id = $request->id;
        if($id == null){
            return response([
                'message' => "provide an id!"
            ], 400);
        }

        if ($request->konfirmasi == 1) {
            $alasan_req = '';
            $alasan = null;
        } else {
            $alasan_req = 'required';
            $alasan = $request->alasan;
        }

        $bidan_id_req = '';
        $bidan_id = Auth::user()->profil->id;
        $anggotaKeluargaId = $request->anggota_keluarga_id;

        $validator = Validator::make(
            $request->all(),
            [
                'anggota_keluarga_id' => 'required',
                'bidan_id' => $bidan_id_req,
                'konfirmasi' => 'required',
                'alasan' => $alasan_req,
            ],
            [
                'anggota_keluarga_id.required' => 'Anggota Keluarga harus diisi',
                'bidan_id.required' => 'Bidan harus diisi',
                'konfirmasi.required' => 'Konfirmasi harus diisi',
                'alasan.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response([
                'Error' => $validator->errors()
            ], 400);
            return response()->json(['error' => $validator->errors()]);
        }
        $updateStuntingAnak = StuntingAnak::where('id', $id)->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);
        $anggotaKeluarga = AnggotaKeluarga::where('id', $anggotaKeluargaId)->first();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $id;
        $pemberitahuan->anggota_keluarga_id = $anggotaKeluargaId;
        $pemberitahuan->tentang = 'stunting_anak';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data stunting anak anda telah divalidasi.';
            $pemberitahuan->isi = 'Data stunting anak anda (' . ucwords(strtolower($anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data stunting anak anda' . ' (' . ucwords(strtolower($anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data stunting anak ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        
        if($updateStuntingAnak && $pemberitahuan){
            return response([
                'message' => "data stunting anak updated"
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stuntingAnak = StuntingAnak::find($id);

        if (!$stuntingAnak) {
            return response([
                'message' => "Stunting Anak with id $id doesn't exist"
            ], 404);
        }

        return $stuntingAnak->delete();
    }
}
