<?php

namespace App\Http\Controllers\dashboard\utama\deteksiStunting;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\Pemberitahuan;
use App\Models\StuntingAnak;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StuntingAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh', 'admin'])) {
            if ($request->ajax()) {
                $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
                $data = StuntingAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        if (Auth::user()->role != 'admin') {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                        }
                    })
                    ->where(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            if ($request->statusValidasi) {
                                $query->where('is_valid', $request->statusValidasi == 'Tervalidasi' ? 1 : 0);
                            }

                            if (Auth::user()->role == 'penyuluh') {
                                $query->where('is_valid', 1);
                            }

                            if ($request->kategori) {
                                $kategori = '';
                                if ($request->kategori == 'sangat_pendek') {
                                    $kategori = 'Sangat Pendek (Resiko Stunting Tinggi)';
                                } else if ($request->kategori == 'pendek') {
                                    $kategori = 'Pendek (Resiko Stunting Sedang)';
                                } else if ($request->kategori == 'normal') {
                                    $kategori = 'Normal';
                                } else if ($request->kategori == 'tinggi') {
                                    $kategori = 'Tinggi';
                                }
                                $query->where('kategori', $kategori);
                            }
                        });

                        $query->where(function ($query) use ($request) {
                            if ($request->search) {
                                $query->whereHas('bidan', function ($query) use ($request) {
                                    $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                                });

                                $query->orWhereHas('anggotaKeluarga', function ($query) use ($request) {
                                    $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                                });
                            }
                        });
                    })
                    ->orWhere(function ($query) {
                        if (Auth::user()->role == 'bidan') { // bidan
                            $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                        }
                    })
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_dibuat', function ($row) {
                        return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->is_valid == 0) {
                            return '<span class="badge badge-danger bg-danger">Belum Divalidasi</span>';
                        } else if ($row->is_valid == 2) {
                            return '<span class="badge badge-danger bg-danger">Ditolak</span>';
                        } else {
                            return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                        }
                    })
                    ->addColumn('nama_anak', function ($row) {
                        return $row->anggotaKeluarga->nama_lengkap;
                    })
                    ->addColumn('kategori', function ($row) {
                        if ($row->kategori == 'Sangat Pendek (Resiko Stunting Tinggi)') {
                            return '<span class="badge rounded-pill bg-danger">' . $row->kategori . '</span>';
                        } elseif ($row->kategori == 'Pendek (Resiko Stunting Sedang)') {
                            return '<span class="badge rounded-pill bg-warning">' . $row->kategori . '</span>';
                        } elseif ($row->kategori == 'Normal') {
                            return '<span class="badge rounded-pill bg-success">' . $row->kategori .  ' </span>';
                        } elseif ($row->kategori == 'Tinggi') {
                            return '<span class="badge rounded-pill bg-primary">' . $row->kategori . '</span>';
                        }
                    })
                    ->addColumn('desa_kelurahan', function ($row) {
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    })
                    ->addColumn('bidan', function ($row) {
                        return $row->bidan->nama_lengkap ?? '-';
                    })
                    ->addColumn('tanggal_validasi', function ($row) {
                        if ($row->tanggal_validasi) {
                            return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                        } else {
                            return '-';
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '
                            <div class="text-center justify-content-center text-white">';
                        if ($row->is_valid == 0) {
                            $actionBtn .= '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white" data-toggle="tooltip" data-placement="top" title="Konfirmasi" value="' . $row->id . '" ><i class="fa-solid fa-lg fa-clipboard-check"></i></button>';
                        } else {
                            $actionBtn .= '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Lihat" value="' . $row->id . '" ><i class="fas fa-eye"></i></button>';
                        }
                        if (in_array(Auth::user()->role, ['bidan', 'admin'])) {
                            if (($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                // if($row->is_valid == 1){
                                //     $actionBtn .= '<a href="' . route('pertumbuhan-anak.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                // }

                                if ($row->is_valid != 0) {
                                    $actionBtn .= ' <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                                }
                            }
                        }

                        $actionBtn .= '
                        </div>';
                        return $actionBtn;
                    })
                    ->rawColumns(['tanggal_dibuat', 'status', 'nama_anak', 'kategori', 'desa_kelurahan', 'bidan', 'tanggal_validasi', 'action'])
                    ->make(true);
            }
            return view('dashboard.pages.utama.deteksiStunting.stuntingAnak.index');
        } else {
            if (Auth::user()->is_remaja == 1) {
                abort(403, 'Maaf, halaman ini bukan untuk Remaja');
            }
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $stuntingAnak = StuntingAnak::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();

            return view('dashboard.pages.utama.deteksiStunting.stuntingAnak.indexKeluarga', compact(['stuntingAnak']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->is_remaja == 1) {
            abort(403, 'Maaf, halaman ini bukan untuk Remaja');
        }
        if (in_array(Auth::user()->role, ['admin', 'bidan', 'keluarga'])) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            if (Auth::user()->role == 'admin') {
                $kartuKeluarga = KartuKeluarga::valid()
                    ->latest()->get();
            } else if (Auth::user()->role == 'bidan') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->valid()
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    })->latest()->get();
            } else if (Auth::user()->role == 'keluarga') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->where('id', Auth::user()->profil->kartu_keluarga_id)->latest()->get();
            }

            return view('dashboard.pages.utama.deteksiStunting.stuntingAnak.create', compact('kartuKeluarga'));
        } else {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function proses(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => Auth::user()->role == 'keluarga' ? 'nullable' : 'required',
                'nama_anak' => 'required',
                'tinggi_badan' => 'required',
                'nama_bidan' => Auth::user()->role == "admin" && $request->isMethod('post') ? 'required' : '',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_anak.required' => 'Nama Anak tidak boleh kosong',
                'tinggi_badan.required' => 'Tinggi Badan tidak boleh kosong',
                'nama_bidan.required' => 'Nama Bidan Tidak Boleh Kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $anak = AnggotaKeluarga::where('id', $request->nama_anak)->withTrashed()->first();
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
            'anggota_keluarga_id' => $request->nama_anak,
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => $tanggalLahir,
            'usia_bulan' => $usiaBulan,
            'usia_tahun' => $usia,
            'tinggi_badan' => $tinggiBadan,
            'jenis_kelamin' => $jenisKelamin,
            'zscore' =>  number_format($ZScore, 2, '.', ''),
            'kategori' => $kategoriTinggi
        ];
        return $data;
    }

    public function store(Request $request)
    {
        $kategori = $this->proses($request);
        $role = Auth::user()->role;

        if ($role == 'admin') {
            $bidan_id = $request->nama_bidan;
        } else if ($role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;
        } else if ($role == 'keluarga') {
            $bidan_id = null;
        }

        $stuntingAnak = new StuntingAnak();
        $stuntingAnak->anggota_keluarga_id = $request->nama_anak;
        $stuntingAnak->tinggi_badan = $request->tinggi_badan;
        $stuntingAnak->zscore = $kategori['zscore'];
        $stuntingAnak->kategori = $kategori['kategori'];
        $stuntingAnak->bidan_id = $bidan_id;

        if ($role != 'keluarga') {
            $stuntingAnak->tanggal_validasi = Carbon::now();
            $stuntingAnak->is_valid = 1;
        } else {
            $stuntingAnak->is_valid = 0;
        }
        $stuntingAnak->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StuntingAnak  $stuntingAnak
     * @return \Illuminate\Http\Response
     */
    public function show(StuntingAnak $stuntingAnak)
    {
        $tanggalLahir = Carbon::parse($stuntingAnak->AnggotaKeluarga->tanggal_lahir)->translatedFormat('d F Y');
        if ($stuntingAnak->tanggal_validasi) {
            $tanggalValidasi = Carbon::parse($stuntingAnak->tanggal_validasi)->translatedFormat('d F Y');
        }
        $tanggalProses = Carbon::parse($stuntingAnak->created_at)->translatedFormat('d F Y');

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($stuntingAnak->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $namaIbu = AnggotaKeluarga::where('kartu_keluarga_id', $stuntingAnak->AnggotaKeluarga->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga_id', 3)->first();
        $data = [
            'nama_anak' => $stuntingAnak->AnggotaKeluarga->nama_lengkap,
            'nama_ayah' => $namaIbu->nama_ayah ?? '-',
            'nama_ibu' => $namaIbu->nama_lengkap ?? '-',
            'jenis_kelamin' => $stuntingAnak->AnggotaKeluarga->jenis_kelamin,
            'tanggal_lahir' => $tanggalLahir,
            'usia' => $usia,
            'tinggi_badan' => $stuntingAnak->tinggi_badan,
            'tanggal_validasi' => $tanggalValidasi ?? '-',
            'desa_kelurahan' => $stuntingAnak->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'bidan' => $stuntingAnak->bidan->nama_lengkap ?? '-',
            'kategori' => $stuntingAnak->kategori,
            'zscore' => $stuntingAnak->zscore,
            'tanggal_proses' => $tanggalProses,
            'is_valid' => $stuntingAnak->is_valid,
            'bidan_konfirmasi' => $stuntingAnak->anggotaKeluarga->getBidan($stuntingAnak->anggota_keluarga_id)
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StuntingAnak  $stuntingAnak
     * @return \Illuminate\Http\Response
     */
    public function edit(StuntingAnak $stuntingAnak)
    {
        if (Auth::user()->is_remaja == 1) {
            abort(403, 'Maaf, halaman ini bukan untuk Remaja');
        }
        if ((Auth::user()->profil->id == $stuntingAnak->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $stuntingAnak->anggotaKeluarga->kartu_keluarga_id)) {
            $kartuKeluarga = KartuKeluarga::latest()->get();
            return view('dashboard.pages.utama.deteksiStunting.stuntingAnak.edit', compact('kartuKeluarga', 'stuntingAnak'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StuntingAnak  $stuntingAnak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StuntingAnak $stuntingAnak)
    {
        $kategori = $this->proses($request);

        $stuntingAnak->anggota_keluarga_id = $request->nama_anak;
        $stuntingAnak->tinggi_badan = $request->tinggi_badan;
        $stuntingAnak->zscore = $kategori['zscore'];
        $stuntingAnak->kategori = $kategori['kategori'];

        if ((Auth::user()->role == 'keluarga') && ($stuntingAnak->is_valid == 2)) {
            $stuntingAnak->is_valid = 0;
            $stuntingAnak->bidan_id = null;
            $stuntingAnak->tanggal_validasi = null;
            $stuntingAnak->alasan_ditolak = null;
        }

        $stuntingAnak->save();

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $stuntingAnak->anggota_keluarga_id)
            ->where('tentang', 'stunting_anak')
            ->where('fitur_id', $stuntingAnak->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StuntingAnak  $stuntingAnak
     * @return \Illuminate\Http\Response
     */
    public function destroy(StuntingAnak $stuntingAnak)
    {
        if ((Auth::user()->profil->id == $stuntingAnak->bidan_id) || (Auth::user()->role == 'admin')) {
            $stuntingAnak->delete();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $stuntingAnak->id)
                ->where('tentang', 'stunting_anak');

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            return response()->json(['status' => 'success']);
        } else {
            return abort(404);
        }
    }

    public function validasi(Request $request, StuntingAnak $stuntingAnak)
    {
        $id = $request->id;

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

        $stuntingAnak->is_valid = $request->konfirmasi;
        $stuntingAnak->bidan_id = $bidan_id;
        $stuntingAnak->tanggal_validasi = Carbon::now();
        $stuntingAnak->alasan_ditolak = $alasan;
        $stuntingAnak->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $stuntingAnak->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $stuntingAnak->id;
        $pemberitahuan->anggota_keluarga_id = $stuntingAnak->anggota_keluarga_id;
        $pemberitahuan->tentang = 'stunting_anak';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data stunting anak anda telah divalidasi.';
            $pemberitahuan->isi = 'Data stunting anak anda (' . ucwords(strtolower($stuntingAnak->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data stunting anak anda' . ' (' . ucwords(strtolower($stuntingAnak->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data stunting anak ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
