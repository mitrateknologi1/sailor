<?php

namespace App\Http\Controllers\dashboard\utama\tumbuhKembang;

use App\Models\Bidan;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;

use App\Models\Pemberitahuan;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use App\Models\PertumbuhanAnak;
use Illuminate\Validation\Rule;
use App\Models\TumbuhKembangAnak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Response;
use App\Http\Controllers\ListController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class PertumbuhanAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('profil_ada');
    }

    public function index(Request $request)
    {
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh', 'admin'])) {
            if ($request->ajax()) {
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
                    });

                // Filter
                $data->where(function ($query) use ($request) {
                    if ($request->statusValidasi) {
                        if ($request->statusValidasi == 'Tervalidasi') {
                            $query->where('is_valid', 1);
                        } else if ($request->statusValidasi == 'Belum Tervalidasi') {
                            $query->where('is_valid', 0);
                        } else if ($request->statusValidasi == 'Ditolak') {
                            $query->where('is_valid', 2);
                        }
                    }

                    if ($request->kategori) {
                        $kategori = '';
                        if ($request->kategori == 'Gizi Buruk') {
                            $kategori = 'Gizi Buruk';
                        } else if ($request->kategori == 'Gizi Kurang') {
                            $kategori = 'Gizi Kurang';
                        } else if ($request->kategori == 'Gizi Baik') {
                            $kategori = 'Gizi Baik';
                        } else if ($request->kategori == 'Gizi Lebih') {
                            $kategori = 'Gizi Lebih';
                        }
                        $query->where('hasil', $kategori);
                    }
                });

                $data->where(function ($query) use ($request) {
                    if ($request->search) {
                        $query->whereHas('bidan', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });

                        $query->orWhereHas('anggotaKeluarga', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });

                        $query->orWhereHas('anggotaKeluarga', function ($query) use ($request) {
                            $query->whereHas('kartuKeluarga', function ($query2) use ($request) {
                                $query2->where('nomor_kk', 'like', '%' . $request->search . '%');
                            });
                        });
                    }
                });

                $data->whereHas('anggotaKeluarga', function ($query) use ($request) {
                    $query->whereHas('wilayahDomisili', function ($query) use ($request) {
                        if ($request->provinsi && $request->provinsi != "semua") {
                            $query->where('provinsi_id', $request->provinsi);
                        }

                        if ($request->kabupaten && $request->kabupaten != "semua") {
                            $query->where('kabupaten_kota_id', $request->kabupaten);
                        }

                        if ($request->kecamatan && $request->kecamatan != "semua") {
                            $query->where('kecamatan_id', $request->kecamatan);
                        }

                        if ($request->desa && $request->desa != "semua") {
                            $query->where('desa_kelurahan_id', $request->desa);
                        }
                    });
                });

                $data->orderBy('created_at', 'DESC');

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nakes', function ($row) {
                        return 'belum_dibuat';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->is_valid == 0) {
                            return '<span class="badge rounded bg-warning">Belum Divalidasi</span>';
                        } else if ($row->is_valid == 1) {
                            return '<span class="badge rounded bg-success">Tervalidasi</span>';
                        } else if ($row->is_valid == 2) {
                            return '<span class="badge rounded bg-danger">Ditolak</span>';
                        }
                    })

                    ->addColumn('jenis_kelamin', function ($row) {
                        return $row->anggotaKeluarga->jenis_kelamin;
                    })

                    ->addColumn('tanggal_lahir', function ($row) {
                        return $row->anggotaKeluarga->tanggal_lahir;
                    })

                    ->addColumn('usia', function ($row) {
                        $datetime1 = date_create($row->created_at);
                        $datetime2 = date_create($row->anggotaKeluarga->tanggal_lahir);
                        $interval = date_diff($datetime1, $datetime2);
                        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');
                        return $usia;
                    })

                    ->addColumn('nomor_kk', function ($row) {
                        return $row->anggotaKeluarga->kartuKeluarga->nomor_kk;
                    })

                    ->addColumn('nama_anak', function ($row) {
                        return $row->anggotaKeluarga->nama_lengkap;
                    })

                    ->addColumn('nama_ayah', function ($row) {
                        return $row->anggotaKeluarga->nama_ayah;
                    })

                    ->addColumn('nama_ibu', function ($row) {
                        return $row->anggotaKeluarga->nama_ibu;
                    })

                    ->addColumn('bidan', function ($row) {
                        return $row->bidan ? $row->bidan->nama_lengkap : '-';
                    })

                    ->addColumn('tanggal_validasi', function ($row) {
                        if ($row->tanggal_validasi == null) {
                            return '-';
                        } else {
                            return Carbon::parse($row->tanggal_validasi)->translatedFormat('j F Y');
                        }
                    })

                    ->addColumn('desa_kelurahan', function ($row) {
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    })

                    ->addColumn('hasil', function ($row) {
                        if ($row->hasil == 'Gizi Buruk') {
                            return '<span class="badge rounded bg-danger">Gizi Buruk</span>';
                        } elseif ($row->hasil == 'Gizi Kurang') {
                            return '<span class="badge rounded bg-warning">Gizi Kurang</span>';
                        } elseif ($row->hasil == 'Gizi Baik') {
                            return '<span class="badge rounded bg-success">Gizi Baik</span>';
                        } elseif ($row->hasil == 'Gizi Lebih') {
                            return '<span class="badge rounded bg-primary">Gizi Lebih</span>';
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
                                if ($row->is_valid == 1) {
                                    $actionBtn .= '<a href="' . route('pertumbuhan-anak.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                }

                                if ($row->is_valid != 0) {
                                    $actionBtn .= ' <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                                }
                            }
                        }

                        $actionBtn .= '
                        </div>';
                        return $actionBtn;
                    })

                    ->rawColumns([
                        'action',
                        'status',
                        'hasil',
                        'bidan',
                        'nakes_id',
                        'nama_anak'
                    ])
                    ->make(true);
            }
            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.index');
        } // else keluarga
        else {
            if (Auth::user()->is_remaja == 1) {
                abort(403, 'Maaf, halaman ini bukan untuk Remaja');
            }
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $pertumbuhanAnak = PertumbuhanAnak::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest();

            $data = [
                'pertumbuhanAnak' => $pertumbuhanAnak->get(),
            ];

            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.indexKeluarga', $data);
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
                    ->whereHas('anggotaKeluarga', function ($query) {
                        $query->where('status_hubungan_dalam_keluarga_id', '4');
                    })
                    ->latest()->get();
            } else if (Auth::user()->role == 'bidan') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->valid()
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        $query->where('status_hubungan_dalam_keluarga_id', '4');
                    })->latest()->get();
            } else if (Auth::user()->role == 'keluarga') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->where('id', Auth::user()->profil->kartu_keluarga_id)->latest()->get();
            }

            $data = [
                'kartuKeluarga' => $kartuKeluarga,
                'bidan' => Bidan::with('user')->active()->get(),
            ];

            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.create', $data);
        } else {
            abort(403);
        }
    }


    public function proses(Request $request)
    {
        if ((Auth::user()->role == 'admin') && ($request->method == 'POST')) {
            $namaBidanReq = 'required';
        } else {
            $namaBidanReq = '';
        }

        if (Auth::user()->role == 'keluarga') {
            $namaKepalaKeluargaReq = '';
        } else {
            $namaKepalaKeluargaReq = 'required';
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => $namaKepalaKeluargaReq,
                'nama_anak' => 'required',
                'berat_badan' => 'required',
                'nama_bidan' => $namaBidanReq,
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_anak.required' => 'Nama Anak tidak boleh kosong',
                'nama_anak.unique' => 'Nama Anak sudah ada tapi belum divalidasi',
                'berat_badan.required' => 'Berat Badan tidak boleh kosong',
                'nama_bidan.required' => 'Nama Bidan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $anak = AnggotaKeluarga::where('id', $request->nama_anak)->withTrashed()->first();
        $tanggalLahir = $anak->tanggal_lahir;

        $tanggalProses = $request->tanggal_proses;
        $jenisKelamin = $anak->jenis_kelamin; //Laki-laki atau Perempuan
        $beratBadan = $request->berat_badan; //dalam kilogram

        // hitung usia dalam bulan
        $usiaBulan = round(((strtotime($tanggalProses) - strtotime($tanggalLahir)) / 86400) / 30);


        $median = 0;
        $sd = 0;
        $sd1 = 0;

        $kategoriGizi = '';

        if ($jenisKelamin == "LAKI-LAKI") {
            if ($usiaBulan == 0) {
                $median = 3.3;
                $sd = 2.9;
                $sd1 = 3.9;
            } else if ($usiaBulan == 1) {
                $median = 4.5;
                $sd = 3.9;
                $sd1 = 5.1;
            } else if ($usiaBulan == 2) {
                $median = 5.6;
                $sd = 4.9;
                $sd1 = 6.3;
            } else if ($usiaBulan == 3) {
                $median = 6.4;
                $sd = 5.7;
                $sd1 = 7.2;
            } else if ($usiaBulan == 4) {
                $median = 7.0;
                $sd = 6.2;
                $sd1 = 7.8;
            } else if ($usiaBulan == 5) {
                $median = 7.5;
                $sd = 6.7;
                $sd1 = 8.4;
            } else if ($usiaBulan == 6) {
                $median = 7.9;
                $sd = 7.1;
                $sd1 = 8.8;
            } else if ($usiaBulan == 7) {
                $median = 8.3;
                $sd = 7.4;
                $sd1 = 9.2;
            } else if ($usiaBulan == 8) {
                $median = 8.6;
                $sd = 7.7;
                $sd1 = 9.6;
            } else if ($usiaBulan == 9) {
                $median = 8.9;
                $sd = 8.0;
                $sd1 = 9.9;
            } else if ($usiaBulan == 10) {
                $median = 9.2;
                $sd = 8.2;
                $sd1 = 10.2;
            } else if ($usiaBulan == 11) {
                $median = 9.4;
                $sd = 8.4;
                $sd1 = 10.5;
            } else if ($usiaBulan == 12) {
                $median = 9.6;
                $sd = 8.6;
                $sd1 = 10.8;
            } else if ($usiaBulan == 13) {
                $median = 9.9;
                $sd = 8.8;
                $sd1 = 11.0;
            } else if ($usiaBulan == 14) {
                $median = 10.1;
                $sd = 9.0;
                $sd1 = 11.3;
            } else if ($usiaBulan == 15) {
                $median = 10.3;
                $sd = 9.2;
                $sd1 = 11.5;
            } else if ($usiaBulan == 16) {
                $median = 10.5;
                $sd = 9.4;
                $sd1 = 11.7;
            } else if ($usiaBulan == 17) {
                $median = 10.7;
                $sd = 9.6;
                $sd1 = 12.0;
            } else if ($usiaBulan == 18) {
                $median = 10.9;
                $sd = 9.8;
                $sd1 = 12.2;
            } else if ($usiaBulan == 19) {
                $median = 11.1;
                $sd = 10.0;
                $sd1 = 12.5;
            } else if ($usiaBulan == 20) {
                $median = 11.3;
                $sd = 10.1;
                $sd1 = 12.7;
            } else if ($usiaBulan == 21) {
                $median = 11.5;
                $sd = 10.3;
                $sd1 = 12.9;
            } else if ($usiaBulan == 22) {
                $median = 11.8;
                $sd = 10.5;
                $sd1 = 13.2;
            } else if ($usiaBulan == 23) {
                $median = 12.0;
                $sd = 10.7;
                $sd1 = 13.4;
            } else if ($usiaBulan == 24) {
                $median = 12.2;
                $sd = 10.8;
                $sd1 = 13.6;
            } else if ($usiaBulan == 25) {
                $median = 12.4;
                $sd = 11.0;
                $sd1 = 13.9;
            } else if ($usiaBulan == 26) {
                $median = 12.5;
                $sd = 11.2;
                $sd1 = 14.1;
            } else if ($usiaBulan == 27) {
                $median = 12.7;
                $sd = 11.3;
                $sd1 = 14.3;
            } else if ($usiaBulan == 28) {
                $median = 12.9;
                $sd = 11.5;
                $sd1 = 14.5;
            } else if ($usiaBulan == 29) {
                $median = 13.1;
                $sd = 11.7;
                $sd1 = 14.8;
            } else if ($usiaBulan == 30) {
                $median = 13.3;
                $sd = 11.8;
                $sd1 = 15.0;
            } else if ($usiaBulan == 31) {
                $median = 13.5;
                $sd = 12.0;
                $sd1 = 15.2;
            } else if ($usiaBulan == 32) {
                $median = 13.7;
                $sd = 12.1;
                $sd1 = 15.4;
            } else if ($usiaBulan == 33) {
                $median = 13.8;
                $sd = 12.3;
                $sd1 = 15.6;
            } else if ($usiaBulan == 34) {
                $median = 14.0;
                $sd = 12.4;
                $sd1 = 15.8;
            } else if ($usiaBulan == 35) {
                $median = 14.2;
                $sd = 12.6;
                $sd1 = 16.0;
            } else if ($usiaBulan == 36) {
                $median = 14.3;
                $sd = 12.7;
                $sd1 = 16.2;
            } else if ($usiaBulan == 37) {
                $median = 14.5;
                $sd = 12.9;
                $sd1 = 16.2;
            } else if ($usiaBulan == 38) {
                $median = 14.7;
                $sd = 13.0;
                $sd1 = 16.4;
            } else if ($usiaBulan == 39) {
                $median = 14.8;
                $sd = 13.1;
                $sd1 = 16.6;
            } else if ($usiaBulan == 40) {
                $median = 15.0;
                $sd = 13.3;
                $sd1 = 16.8;
            } else if ($usiaBulan == 41) {
                $median = 15.2;
                $sd = 13.4;
                $sd1 = 17.0;
            } else if ($usiaBulan == 42) {
                $median = 15.3;
                $sd = 13.6;
                $sd1 = 17.2;
            } else if ($usiaBulan == 43) {
                $median = 15.5;
                $sd = 13.7;
                $sd1 = 17.4;
            } else if ($usiaBulan == 44) {
                $median = 15.7;
                $sd = 13.8;
                $sd1 = 17.8;
            } else if ($usiaBulan == 45) {
                $median = 15.8;
                $sd = 14.0;
                $sd1 = 18.0;
            } else if ($usiaBulan == 46) {
                $median = 16.0;
                $sd = 14.1;
                $sd1 = 18.2;
            } else if ($usiaBulan == 47) {
                $median = 16.2;
                $sd = 14.3;
                $sd1 = 18.4;
            } else if ($usiaBulan == 48) {
                $median = 16.3;
                $sd = 14.4;
                $sd1 = 18.6;
            } else if ($usiaBulan == 49) {
                $median = 16.5;
                $sd = 14.5;
                $sd1 = 18.8;
            } else if ($usiaBulan == 50) {
                $median = 16.7;
                $sd = 14.7;
                $sd1 = 19.0;
            } else if ($usiaBulan == 51) {
                $median = 16.8;
                $sd = 14.8;
                $sd1 = 19.2;
            } else if ($usiaBulan == 52) {
                $median = 17.0;
                $sd = 15.0;
                $sd1 = 19.4;
            } else if ($usiaBulan == 53) {
                $median = 17.2;
                $sd = 15.1;
                $sd1 = 19.6;
            } else if ($usiaBulan == 54) {
                $median = 17.3;
                $sd = 15.2;
                $sd1 = 19.8;
            } else if ($usiaBulan == 55) {
                $median = 17.5;
                $sd = 15.4;
                $sd1 = 20.0;
            } else if ($usiaBulan == 56) {
                $median = 17.7;
                $sd = 15.5;
                $sd1 = 20.2;
            } else if ($usiaBulan == 57) {
                $median = 17.8;
                $sd = 15.6;
                $sd1 = 20.4;
            } else if ($usiaBulan == 58) {
                $median = 18.0;
                $sd = 15.8;
                $sd1 = 20.6;
            } else if ($usiaBulan == 59) {
                $median = 18.2;
                $sd = 15.9;
                $sd1 = 20.8;
            } else {
                $median = 18.3;
                $sd = 16.0;
                $sd1 = 21.0;
            }
        }
        if ($jenisKelamin == "PEREMPUAN") {
            if ($usiaBulan == 0) {
                $median = 3.2;
                $sd = 2.8;
                $sd1 = 3.7;
            } else if ($usiaBulan == 1) {
                $median = 4.2;
                $sd = 3.6;
                $sd1 = 4.8;
            } else if ($usiaBulan == 2) {
                $median = 5.1;
                $sd = 4.5;
                $sd1 = 5.8;
            } else if ($usiaBulan == 3) {
                $median = 5.8;
                $sd = 5.2;
                $sd1 = 6.6;
            } else if ($usiaBulan == 4) {
                $median = 6.4;
                $sd = 5.7;
                $sd1 = 7.3;
            } else if ($usiaBulan == 5) {
                $median = 6.9;
                $sd = 6.1;
                $sd1 = 7.8;
            } else if ($usiaBulan == 6) {
                $median = 7.3;
                $sd = 6.5;
                $sd1 = 8.2;
            } else if ($usiaBulan == 7) {
                $median = 7.6;
                $sd = 6.8;
                $sd1 = 8.6;
            } else if ($usiaBulan == 8) {
                $median = 7.9;
                $sd = 7.0;
                $sd1 = 9.0;
            } else if ($usiaBulan == 9) {
                $median = 8.2;
                $sd = 7.3;
                $sd1 = 9.3;
            } else if ($usiaBulan == 10) {
                $median = 8.5;
                $sd = 7.5;
                $sd1 = 9.6;
            } else if ($usiaBulan == 11) {
                $median = 8.7;
                $sd = 7.7;
                $sd1 = 9.9;
            } else if ($usiaBulan == 12) {
                $median = 8.9;
                $sd = 7.9;
                $sd1 = 10.1;
            } else if ($usiaBulan == 13) {
                $median = 9.2;
                $sd = 8.1;
                $sd1 = 10.4;
            } else if ($usiaBulan == 14) {
                $median = 9.4;
                $sd = 8.3;
                $sd1 = 10.6;
            } else if ($usiaBulan == 15) {
                $median = 9.6;
                $sd = 8.5;
                $sd1 = 10.9;
            } else if ($usiaBulan == 16) {
                $median = 9.8;
                $sd = 8.7;
                $sd1 = 11.1;
            } else if ($usiaBulan == 17) {
                $median = 10.0;
                $sd = 8.9;
                $sd1 = 11.4;
            } else if ($usiaBulan == 18) {
                $median = 10.2;
                $sd = 9.1;
                $sd1 = 11.6;
            } else if ($usiaBulan == 19) {
                $median = 10.4;
                $sd = 9.2;
                $sd1 = 11.8;
            } else if ($usiaBulan == 20) {
                $median = 10.6;
                $sd = 9.4;
                $sd1 = 12.1;
            } else if ($usiaBulan == 21) {
                $median = 10.9;
                $sd = 9.6;
                $sd1 = 12.3;
            } else if ($usiaBulan == 22) {
                $median = 11.1;
                $sd = 9.8;
                $sd1 = 12.5;
            } else if ($usiaBulan == 23) {
                $median = 11.3;
                $sd = 10.0;
                $sd1 = 12.8;
            } else if ($usiaBulan == 24) {
                $median = 11.5;
                $sd = 10.2;
                $sd1 = 13.0;
            } else if ($usiaBulan == 25) {
                $median = 11.7;
                $sd = 10.3;
                $sd1 = 13.3;
            } else if ($usiaBulan == 26) {
                $median = 11.9;
                $sd = 10.5;
                $sd1 = 13.5;
            } else if ($usiaBulan == 27) {
                $median = 12.1;
                $sd = 10.7;
                $sd1 = 13.7;
            } else if ($usiaBulan == 28) {
                $median = 12.3;
                $sd = 10.9;
                $sd1 = 14.0;
            } else if ($usiaBulan == 29) {
                $median = 12.5;
                $sd = 11.1;
                $sd1 = 14.2;
            } else if ($usiaBulan == 30) {
                $median = 12.7;
                $sd = 11.2;
                $sd1 = 14.4;
            } else if ($usiaBulan == 31) {
                $median = 12.9;
                $sd = 11.4;
                $sd1 = 14.7;
            } else if ($usiaBulan == 32) {
                $median = 13.1;
                $sd = 11.6;
                $sd1 = 14.9;
            } else if ($usiaBulan == 33) {
                $median = 13.3;
                $sd = 11.7;
                $sd1 = 15.1;
            } else if ($usiaBulan == 34) {
                $median = 13.5;
                $sd = 11.9;
                $sd1 = 15.4;
            } else if ($usiaBulan == 35) {
                $median = 13.7;
                $sd = 12.0;
                $sd1 = 15.6;
            } else if ($usiaBulan == 36) {
                $median = 13.9;
                $sd = 12.2;
                $sd1 = 15.8;
            } else if ($usiaBulan == 37) {
                $median = 14.0;
                $sd = 12.4;
                $sd1 = 16.0;
            } else if ($usiaBulan == 38) {
                $median = 14.2;
                $sd = 12.5;
                $sd1 = 16.3;
            } else if ($usiaBulan == 39) {
                $median = 14.4;
                $sd = 12.7;
                $sd1 = 16.5;
            } else if ($usiaBulan == 40) {
                $median = 14.6;
                $sd = 12.8;
                $sd1 = 16.7;
            } else if ($usiaBulan == 41) {
                $median = 14.8;
                $sd = 13.0;
                $sd1 = 16.9;
            } else if ($usiaBulan == 42) {
                $median = 15.0;
                $sd = 13.1;
                $sd1 = 17.2;
            } else if ($usiaBulan == 43) {
                $median = 15.2;
                $sd = 13.3;
                $sd1 = 17.4;
            } else if ($usiaBulan == 44) {
                $median = 15.3;
                $sd = 13.4;
                $sd1 = 17.6;
            } else if ($usiaBulan == 45) {
                $median = 15.5;
                $sd = 13.6;
                $sd1 = 17.8;
            } else if ($usiaBulan == 46) {
                $median = 15.7;
                $sd = 13.7;
                $sd1 = 18.1;
            } else if ($usiaBulan == 47) {
                $median = 15.9;
                $sd = 13.9;
                $sd1 = 18.3;
            } else if ($usiaBulan == 48) {
                $median = 16.1;
                $sd = 14.0;
                $sd1 = 18.5;
            } else if ($usiaBulan == 49) {
                $median = 16.3;
                $sd = 14.2;
                $sd1 = 18.8;
            } else if ($usiaBulan == 50) {
                $median = 16.4;
                $sd = 14.3;
                $sd1 = 19.0;
            } else if ($usiaBulan == 51) {
                $median = 16.6;
                $sd = 14.5;
                $sd1 = 19.2;
            } else if ($usiaBulan == 52) {
                $median = 16.8;
                $sd = 14.6;
                $sd1 = 19.4;
            } else if ($usiaBulan == 53) {
                $median = 17.0;
                $sd = 14.8;
                $sd1 = 19.7;
            } else if ($usiaBulan == 54) {
                $median = 17.2;
                $sd = 14.9;
                $sd1 = 19.9;
            } else if ($usiaBulan == 55) {
                $median = 17.3;
                $sd = 15.1;
                $sd1 = 20.1;
            } else if ($usiaBulan == 56) {
                $median = 17.5;
                $sd = 15.2;
                $sd1 = 20.3;
            } else if ($usiaBulan == 57) {
                $median = 17.7;
                $sd = 15.3;
                $sd1 = 20.6;
            } else if ($usiaBulan == 58) {
                $median = 17.9;
                $sd = 15.5;
                $sd1 = 20.8;
            } else if ($usiaBulan == 59) {
                $median = 18.0;
                $sd = 15.6;
                $sd1 = 21.0;
            } else {
                $median = 18.2;
                $sd = 15.8;
                $sd1 = 21.2;
            }
        }

        if ($beratBadan > $median) {
            $ZScore = ($beratBadan - $median) / ($sd1 - $median);
        } else if ($beratBadan < $median) {
            $ZScore = ($beratBadan - $median) / ($median - $sd);
        } else if ($beratBadan == $median) {
            $ZScore = ($beratBadan - $median) / $median;
        }

        if ($ZScore < -3) {
            $kategoriGizi = "Gizi Buruk";
        } else if ($ZScore < -3 || $ZScore <= -2) {
            $kategoriGizi = "Gizi Kurang";
        } else if ($ZScore < -2 || $ZScore <= 2) {
            $kategoriGizi = "Gizi Baik";
        } else if ($ZScore > 2) {
            $kategoriGizi = "Gizi Lebih";
        }


        $datetime1 = date_create($tanggalProses);
        $datetime2 = date_create($tanggalLahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'tanggal_proses' => $tanggalProses,
            'anggota_keluarga_id' => $request->nama_anak,
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => $tanggalLahir,
            'usia_bulan' => $usiaBulan,
            'usia_tahun' => $usia,
            'berat_badan' => $beratBadan,
            'jenis_kelamin' => $jenisKelamin,
            'zscore' =>  number_format($ZScore, 2, '.', ''),
            'kategori' => $kategoriGizi
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePertumbuhanAnakRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataAnak = $this->proses($request);
        if (Auth::user()->role == 'admin') {
            $bidan_id = $request->nama_bidan;
        } else if (Auth::user()->role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;
        } else if (Auth::user()->role == 'keluarga') {
            $bidan_id = null;
        }

        $pertumbuhanAnak = [
            'anggota_keluarga_id' => $dataAnak['anggota_keluarga_id'],
            'bidan_id' => $bidan_id,
            'berat_badan' => $dataAnak['berat_badan'],
            'zscore' => $dataAnak['zscore'],
            'hasil' => $dataAnak['kategori'],
        ];

        $terdapatDataBelumValidasi = PertumbuhanAnak::where('anggota_keluarga_id', $dataAnak['anggota_keluarga_id'])->where('is_valid', '!=', 1);

        $anak = AnggotaKeluarga::find($dataAnak['anggota_keluarga_id']);

        if (Auth::user()->role != 'keluarga') {
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat menambahkan data  pertumbuhan anak ' . $anak->nama_lengkap . ', dikarenakan masih terdapat data pertumbuhannya yang berstatus belum divalidasi/ditolak.',
                ]);
            }
            $pertumbuhanAnak['is_valid'] = 1;
            $pertumbuhanAnak['tanggal_validasi'] = Carbon::now();
        } else {
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat mengirim data  pertumbuhan anak ' . $anak->nama_lengkap . ', dikarenakan masih terdapat data pertumbuhannya yang berstatus belum divalidasi/ditolak. Silahkan Perbarui Data pertumbuhan anak tersebut apabila statusnya ditolak.',
                ]);
            }
            $pertumbuhanAnak['is_valid'] = 0;
            $pertumbuhanAnak['tanggal_validasi'] = null;
        }

        PertumbuhanAnak::create($pertumbuhanAnak);
        return response()->json([
            'res' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function show(PertumbuhanAnak $pertumbuhanAnak)
    {
        $datetime1 = date_create($pertumbuhanAnak->created_at);
        $datetime2 = date_create($pertumbuhanAnak->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'tanggal_proses' => $pertumbuhanAnak->created_at,
            'nama_anak' => $pertumbuhanAnak->anggotaKeluarga->nama_lengkap,
            'nama_ayah' => $pertumbuhanAnak->anggotaKeluarga->nama_ayah,
            'nama_ibu' => $pertumbuhanAnak->anggotaKeluarga->nama_ibu,
            'tanggal_lahir' => $pertumbuhanAnak->anggotaKeluarga->tanggal_lahir,
            'usia_tahun' => $usia,
            'berat_badan' => $pertumbuhanAnak->berat_badan,
            'jenis_kelamin' => $pertumbuhanAnak->anggotaKeluarga->jenis_kelamin,
            'zscore' =>  $pertumbuhanAnak->zscore,
            'kategori' => $pertumbuhanAnak->hasil,
            'desa_kelurahan' => $pertumbuhanAnak->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'tanggal_validasi' => $pertumbuhanAnak->tanggal_validasi,
            'bidan' => $pertumbuhanAnak->bidan ? $pertumbuhanAnak->bidan->nama_lengkap : '-',
            'is_valid' => $pertumbuhanAnak->is_valid,
            'bidan_konfirmasi' => $pertumbuhanAnak->anggotaKeluarga->getBidan($pertumbuhanAnak->anggota_keluarga_id)

        ];

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function edit(PertumbuhanAnak $pertumbuhanAnak)
    {
        if (Auth::user()->is_remaja == 1) {
            abort(403, 'Maaf, halaman ini bukan untuk Remaja');
        }
        if ((Auth::user()->profil->id == $pertumbuhanAnak->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $pertumbuhanAnak->anggotaKeluarga->kartu_keluarga_id)) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            if (Auth::user()->role == 'admin') {
                $kartuKeluarga = KartuKeluarga::valid()
                    ->latest()->get();
            } else if (Auth::user()->role == 'bidan') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->valid()
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        $query->where('status_hubungan_dalam_keluarga_id', 4);
                    })
                    ->orWhereHas('anggotaKeluarga', function ($query) use ($pertumbuhanAnak) {
                        $query->where('id', $pertumbuhanAnak->anggota_keluarga_id);
                        $query->where('status_hubungan_dalam_keluarga_id', 4);
                    })
                    ->latest()->get();
            } else if (Auth::user()->role == 'keluarga') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->where('id', Auth::user()->profil->kartu_keluarga_id)->latest()->get();
            }
            $data = [
                'anak' => PertumbuhanAnak::where('id', $pertumbuhanAnak->id)->first(),
                // 'kartuKeluarga' => KartuKeluarga::latest()->get(),
                'kartuKeluarga' => $kartuKeluarga,
            ];
            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.edit', $data);
        } else {
            return abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePertumbuhanAnakRequest  $request
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PertumbuhanAnak $pertumbuhanAnak)
    {
        $dataAnakBaru = $this->proses($request);

        $pertumbuhanAnakUpdate = [
            'anggota_keluarga_id' => $dataAnakBaru['anggota_keluarga_id'],
            'bidan_id' => $pertumbuhanAnak->bidan_id,
            'berat_badan' => $dataAnakBaru['berat_badan'],
            'zscore' => $dataAnakBaru['zscore'],
            'hasil' => $dataAnakBaru['kategori'],
            'is_valid' => 1,
            'tanggal_validasi' => Carbon::now()
        ];

        if ((Auth::user()->role == 'keluarga') && ($pertumbuhanAnak->is_valid == 2)) {
            $pertumbuhanAnakUpdate['bidan_id'] = null;
            $pertumbuhanAnakUpdate['is_valid'] = 0;
            $pertumbuhanAnakUpdate['tanggal_validasi'] = null;
            $pertumbuhanAnakUpdate['alasan_ditolak'] = null;
        }

        PertumbuhanAnak::where('id', $pertumbuhanAnak->id)
            ->update($pertumbuhanAnakUpdate);

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $pertumbuhanAnak->anggota_keluarga_id)
            ->where('tentang', 'pertumbuhan_anak')
            ->where('fitur_id', $pertumbuhanAnak->id)
            ->first();

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response()->json([
            'res' => 'success'
        ]);
    }

    public function validasi(Request $request, PertumbuhanAnak $pertumbuhanAnak)
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
            return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
        } else {
            return response()->json(['res' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function destroy(PertumbuhanAnak $pertumbuhanAnak)
    {
        if ((Auth::user()->profil->id == $pertumbuhanAnak->bidan_id) || (Auth::user()->role == 'admin')) {
            $pemberitahuan = Pemberitahuan::where('fitur_id', $pertumbuhanAnak->id)
                ->where('tentang', 'pertumbuhan_anak');
            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            $pertumbuhanAnak->delete();
            return response()->json([
                'res' => 'success'
            ]);
        } else {
            return abort(403);
        }
    }
}
