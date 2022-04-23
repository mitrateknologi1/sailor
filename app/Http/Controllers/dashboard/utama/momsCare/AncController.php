<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\Anc;
use App\Models\AnggotaKeluarga;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\PemeriksaanAnc;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PDO;

class AncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            $data = Anc::with('anggotaKeluarga', 'bidan', 'pemeriksaanAnc')->orderBy('created_at', 'DESC')
                ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                    if (Auth::user()->role != 'admin') {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    }
                })
                ->where(function ($query) use ($request) {
                    // $query->where(function ($query) use ($request) {
                    //     if ($request->statusValidasi) {
                    //         $query->where('is_valid', $request->statusValidasi == 'Tervalidasi' ? 1 : 0);
                    //     }

                    //     if ($request->kategori_badan) {
                    //         if ($request->kategori_badan == 'Resiko Tinggi') {
                    //             $query->where('tinggi_badan', '<=', '145');
                    //         } else {
                    //             $query->where('tinggi_badan', '>', '145');
                    //         }
                    //     }

                    //     if ($request->kategori_tekanan_darah) {
                    //         if ($request->kategori_tekanan_darah == 'Hipotensi') {
                    //             $query->where('tekanan_darah_sistolik', '<', '90');
                    //         } else if ($request->kategori_tekanan_darah == 'Normal') {
                    //             $query->where('tekanan_darah_sistolik', '>=', '90');
                    //             $query->where('tekanan_darah_sistolik', '<=', '120');
                    //         } else if ($request->kategori_tekanan_darah == 'Prahipertensi') {
                    //             $query->where('tekanan_darah_sistolik', '>=', '121');
                    //             $query->where('tekanan_darah_sistolik', '<=', '139');
                    //         } else if ($request->kategori_tekanan_darah == 'Hipertensi') {
                    //             $query->where('tekanan_darah_sistolik', '>=', '140');
                    //         }
                    //     }

                    //     if ($request->kategori_lengan_atas) {
                    //         if ($request->kategori_lengan_atas == 'Kurang Gizi (BBLR)') {
                    //             $query->where('lengan_atas', '<=', '23.5');
                    //         } else {
                    //             $query->where('lengan_atas', '>', '23.5');
                    //         }
                    //     }

                    //     if ($request->kategori_denyut_jantung) {
                    //         if ($request->kategori_denyut_jantung == 'Normal') {
                    //             $query->where('denyut_jantung_janin', '>=', '120');
                    //             $query->where('denyut_jantung_janin', '<=', '160');
                    //         } else {
                    //             $query->where('denyut_jantung_janin', '<', '120');
                    //             $query->orWhere('denyut_jantung_janin', '>', '160');
                    //         }
                    //     }

                    //     if ($request->kategori_hemoglobin_darah) {
                    //         if ($request->kategori_hemoglobin_darah == 'Normal') {
                    //             $query->where('hemoglobin_darah', '>=', '11');
                    //         } else {
                    //             $query->where('hemoglobin_darah', '<', '11');
                    //         }
                    //     }

                    //     if ($request->kategori_vaksin_sebelum_hamil) {
                    //         $query->where('vaksin_tetanus_sebelum_hamil', $request->kategori_vaksin_sebelum_hamil);
                    //     }

                    //     if ($request->kategori_vaksin_sesudah_hamil) {
                    //         $query->where('vaksin_tetanus_sesudah_hamil', $request->kategori_vaksin_sesudah_hamil);
                    //     }

                    //     if ($request->kategori_posisi_janin) {
                    //         $query->where('posisi_janin', $request->kategori_posisi_janin);
                    //     }

                    //     if ($request->kategori_minum_tablet) {
                    //         $query->where('minum_tablet', $request->kategori_minum_tablet);
                    //     }

                    //     if ($request->kategori_konseling) {
                    //         $query->where('konseling', $request->kategori_konseling);
                    //     }
                    // });

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
                })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal_dibuat', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_valid == 0) {
                        return '<span class="badge badge-danger bg-danger">Belum Divalidasi</span>';
                    } else {
                        return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                    }
                })
                ->addColumn('nama_ibu', function ($row) {
                    return $row->anggotaKeluarga->nama_lengkap;
                })
                ->addColumn('tanggal_haid_terakhir', function ($row) {
                    return Carbon::parse($row->tanggal_haid_terakhir)->translatedFormat('d F Y');
                })
                ->addColumn('kehamilan_ke', function ($row) {
                    return $row->pemeriksaanAnc->kehamilan_ke;
                })
                ->addColumn('usia_kehamilan', function ($row) {
                    return $row->usia_kehamilan . ' Minggu Lagi';
                })
                ->addColumn('tanggal_perkiraan_lahir', function ($row) {
                    return Carbon::parse($row->tanggal_perkiraan_lahir)->translatedFormat('d F Y');
                })
                ->addColumn('lengan_atas', function ($row) {
                    return $row->pemeriksaanAnc->lengan_atas;
                })
                ->addColumn('tinggi_fundus', function ($row) {
                    return $row->pemeriksaanAnc->tinggi_fundus;
                })
                ->addColumn('hemoglobin_darah', function ($row) {
                    return $row->pemeriksaanAnc->hemoglobin_darah;
                })
                ->addColumn('denyut_jantung_janin', function ($row) {
                    return $row->pemeriksaanAnc->denyut_jantung_janin;
                })
                ->addColumn('tinggi_berat_badan', function ($row) {
                    return $row->pemeriksaanAnc->tinggi_badan . ' cm / ' . $row->pemeriksaanAnc->berat_badan . ' kg';
                })
                ->addColumn('tekanan_darah', function ($row) {
                    return $row->pemeriksaanAnc->tekanan_darah_sistolik . '/' . $row->pemeriksaanAnc->tekanan_darah_diastolik;
                })
                ->addColumn('kategori_badan', function ($row) {
                    if ($row->kategori_badan == 'Resiko Tinggi') {
                        return '<span class="badge badge-danger bg-danger">Resiko Tinggi</span>';
                    } else {
                        return '<span class="badge badge-success bg-success">Normal</span>';
                    }
                })
                ->addColumn('kategori_tekanan_darah', function ($row) {
                    if ($row->kategori_tekanan_darah == 'Hipotensi') {
                        return '<span class="badge badge-primary bg-primary">Hipotensi</span>';
                    } else if ($row->kategori_tekanan_darah == 'Normal') {
                        return '<span class="badge badge-success bg-success">Normal</span>';
                    } else if ($row->kategori_tekanan_darah == 'Prahipertensi') {
                        return '<span class="badge badge-warning bg-warning">Prahipertensi</span>';
                    } else if ($row->kategori_tekanan_darah == 'Hipertensi') {
                        return '<span class="badge badge-danger bg-danger">Hipertensi</span>';
                    }
                })
                ->addColumn('kategori_lengan_atas', function ($row) {
                    if ($row->kategori_lengan_atas == 'Kurang Gizi (BBLR)') {
                        return '<span class="badge badge-danger bg-danger">Kurang Gizi (BBLR)</span>';
                    } else {
                        return '<span class="badge badge-success bg-success">Normal</span>';
                    }
                })
                ->addColumn('kategori_denyut_jantung', function ($row) {
                    if ($row->kategori_denyut_jantung == 'Normal') {
                        return '<span class="badge badge-success bg-success">Normal</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Tidak Normal</span>';
                    }
                })
                ->addColumn('kategori_hemoglobin_darah', function ($row) {
                    if ($row->kategori_hemoglobin_darah == 'Normal') {
                        return '<span class="badge badge-success bg-success">Normal</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Anemia</span>';
                    }
                })
                ->addColumn('vaksin_tetanus_sebelum_hamil', function ($row) {
                    if ($row->vaksin_tetanus_sebelum_hamil == 'Sudah') {
                        return '<span class="badge badge-success bg-success">Sudah</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Belum</span>';
                    }
                })
                ->addColumn('vaksin_tetanus_sesudah_hamil', function ($row) {
                    if ($row->vaksin_tetanus_sesudah_hamil == 'Sudah') {
                        return '<span class="badge badge-success bg-success">Sudah</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Belum</span>';
                    }
                })
                ->addColumn('posisi_janin', function ($row) {
                    if ($row->posisi_janin == 'Normal') {
                        return '<span class="badge badge-success bg-success">Normal</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Sungsang</span>';
                    }
                })
                ->addColumn('minum_tablet', function ($row) {
                    if ($row->minum_tablet == 'Sudah') {
                        return '<span class="badge badge-success bg-success">Sudah</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Belum</span>';
                    }
                })
                ->addColumn('konseling', function ($row) {
                    if ($row->konseling == 'Sudah') {
                        return '<span class="badge badge-success bg-success">Sudah</span>';
                    } else {
                        return '<span class="badge badge-danger bg-danger">Belum</span>';
                    }
                })
                ->addColumn('desa_kelurahan', function ($row) {
                    return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                })
                ->addColumn('bidan', function ($row) {
                    return $row->bidan->nama_lengkap;
                })
                ->addColumn('tanggal_validasi', function ($row) {
                    if ($row->tanggal_validasi) {
                        return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-eye"></i></button>';

                    if ($row->bidan_id == Auth::user()->profil->id || Auth::user()->role == "admin") {
                        $actionBtn .= '<a href="' . url('anc/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['status', 'nama_ibu', 'tanggal_haid_terakhir', 'kehamilan_ke', 'tinggi_berat_badan', 'tekanan_darah', 'kategori_badan', 'kategori_tinggi_badan', 'kategori_tekanan_darah', 'kategori_lengan_atas', 'kategori_denyut_jantung', 'kategori_hemoglobin_darah', 'vaksin_tetanus_sebelum_hamil', 'vaksin_tetanus_sesudah_hamil', 'posisi_janin', 'minum_tablet', 'konseling', 'desa_kelurahan', 'bidan', 'tanggal_validasi', 'action'])
                ->make(true);
        }
        return view('dashboard.pages.utama.momsCare.anc.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        return view('dashboard.pages.utama.momsCare.anc.create', compact('kartuKeluarga'));
    }

    public function cekPemeriksaan(Request $request)
    {
        $idIbu = $request->idIbu;
        if ($request->method == 'PUT') {
            $anc = Anc::where('anggota_keluarga_id', $idIbu)->where(function ($query) use ($request) {
                $query->where('id', '==', $request->idEdit);
            })->latest()->first();

            $pemeriksaanKe = $anc->pemeriksaan_ke;
        } else {
            $anc = Anc::where('anggota_keluarga_id', $idIbu)->count();
            $pemeriksaanKe = $anc + 1;
        }
        return response()->json($pemeriksaanKe);
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
                'nama_kepala_keluarga' => 'required',
                'nama_ibu' => 'required',
                'pemeriksaan_ke' => 'required',
                'tanggal_haid_terakhir' => 'required',
                'kehamilan_ke' => 'required',
                'tinggi_badan' => 'required',
                'berat_badan' => 'required',
                'tekanan_darah_sistolik' => 'required',
                'tekanan_darah_diastolik' => 'required',
                'lengan_atas' => 'required',
                'tinggi_fundus' => 'required',
                'hemoglobin_darah' => 'required',
                'denyut_jantung' => 'required',
                'vaksin_tetanus_sebelum_hamil' => 'required',
                'vaksin_tetanus_sesudah_hamil' => 'required',
                'posisi_janin' => 'required',
                'minum_tablet' => 'required',
                'konseling' => 'required',
                'nama_bidan' => Auth::user()->role == "admin" && $request->isMethod('post') ? 'required' : '',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_ibu.required' => 'Nama Ibu tidak boleh kosong',
                'pemeriksaan_ke.required' => 'Pemeriksaan Ke tidak boleh kosong',
                'tanggal_haid_terakhir.required' => 'Tanggal Haid Terakhir tidak boleh kosong',
                'kehamilan_ke.required' => 'Kehamilan Ke tidak boleh kosong',
                'tinggi_badan.required' => 'Tinggi Badan tidak boleh kosong',
                'berat_badan.required' => 'Berat Badan tidak boleh kosong',
                'tekanan_darah_sistolik.required' => 'Tekanan Darah Sistolik tidak boleh kosong',
                'tekanan_darah_diastolik.required' => 'Tekanan Darah Diastolik tidak boleh kosong',
                'lengan_atas.required' => 'Lengan Atas tidak boleh kosong',
                'tinggi_fundus.required' => 'Tinggi Fundus tidak boleh kosong',
                'hemoglobin_darah.required' => 'Hemoglobin Darah tidak boleh kosong',
                'denyut_jantung.required' => 'Denyut Jantung tidak boleh kosong',
                'vaksin_tetanus_sebelum_hamil.required' => 'Vaksin Tetanus Sebelum Hamil tidak boleh kosong',
                'vaksin_tetanus_sesudah_hamil.required' => 'Vaksin Tetanus Sesudah Hamil tidak boleh kosong',
                'posisi_janin.required' => 'Posisi Janin tidak boleh kosong',
                'minum_tablet.required' => 'Minum Tablet tidak boleh kosong',
                'konseling.required' => 'Konseling tidak boleh kosong',
                'nama_bidan.required' => 'Nama Bidan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $namaKepalaKeluarga = $request->nama_kepala_keluarga;
        $namaIbu = AnggotaKeluarga::where('id', $request->nama_ibu)->withTrashed()->first()->nama_lengkap;
        $pemeriksaanKe = $request->pemeriksaan_ke;
        $tanggalHaidTerakhir = $request->tanggal_haid_terakhir;
        $kehamilanKe = $request->kehamilan_ke;
        $tinggiBadan = $request->tinggi_badan;
        $beratBadan = $request->berat_badan;
        $tekananDarahSistolik = $request->tekanan_darah_sistolik;
        $tekananDarahDiastolik = $request->tekanan_darah_diastolik;
        $lenganAtas = $request->lengan_atas;
        $tinggiFundus = $request->tinggi_fundus;
        $denyutJantung = $request->denyut_jantung;
        $hemoglobinDarah = $request->hemoglobin_darah;
        $vaksinTetanusSebelumHamil = $request->vaksin_tetanus_sebelum_hamil;
        $vaksinTetanusSesudahHamil = $request->vaksin_tetanus_sesudah_hamil;
        $posisiJanin = $request->posisi_janin;
        $minumTablet = $request->minum_tablet;
        $konseling = $request->konseling;

        if ($tinggiBadan <= 145) {
            $kategoriTinggiBadan = 'Resiko Tinggi';
        } else {
            $kategoriTinggiBadan = 'Normal';
        }

        if ($tekananDarahSistolik < 90) {
            $kategoriTekananDarah = 'Hipotensi';
        } else if ($tekananDarahSistolik >= 90 && $tekananDarahSistolik <= 120) {
            $kategoriTekananDarah = 'Normal';
        } else if ($tekananDarahSistolik >= 121 && $tekananDarahSistolik <= 139) {
            $kategoriTekananDarah = 'Prahipertensi';
        } else if ($tekananDarahSistolik >= 140) {
            $kategoriTekananDarah = 'Hipertensi';
        }

        if ($lenganAtas <= 23.5) {
            $kategoriLenganAtas = 'Kurang Gizi (BBLR)';
        } else {
            $kategoriLenganAtas = 'Normal';
        }

        if ($denyutJantung >= 120 && $denyutJantung <= 160) {
            $kategoriDenyutJantung = 'Normal';
        } else {
            $kategoriDenyutJantung = 'Tidak Normal';
        }

        if ($hemoglobinDarah >= 11) {
            $kategoriHemoglobinDarah = 'Normal';
        } else {
            $kategoriHemoglobinDarah = 'Anemia';
        }

        $tgl = date("d", strtotime($tanggalHaidTerakhir));
        // baca bulan
        $bln = date("m", strtotime($tanggalHaidTerakhir));
        // baca tahun
        $thn = date("Y", strtotime($tanggalHaidTerakhir));

        $hpl = mktime(0, 0, 0, $bln + 9, $tgl + 7, $thn);

        $selisihHari = date_diff(Carbon::now(), Carbon::parse($hpl));
        $usiaKehamilan = intval((($selisihHari->y * 52) + ($selisihHari->m * 4) + round($selisihHari->d / 7)));
        $tanggalPerkiraanLahir = Carbon::parse($hpl);

        $data = [
            'anggota_keluarga_id' => $request->nama_ibu,
            'nama_kepala_keluarga' => $namaKepalaKeluarga,
            'nama_ibu' => $namaIbu,
            'pemeriksaan_ke' => $pemeriksaanKe,
            'tanggal_haid_terakhir' => $tanggalHaidTerakhir,
            'kehamilan_ke' => $kehamilanKe,
            'tinggi_badan' => $tinggiBadan,
            'berat_badan' => $beratBadan,
            'tekanan_darah_sistolik' => $tekananDarahSistolik,
            'tekanan_darah_diastolik' => $tekananDarahDiastolik,
            'lengan_atas' => $lenganAtas,
            'tinggi_fundus' => $tinggiFundus,
            'denyut_jantung' => $denyutJantung,
            'hemoglobin_darah' => $hemoglobinDarah,
            'vaksin_tetanus_sebelum_hamil' => $vaksinTetanusSebelumHamil,
            'vaksin_tetanus_sesudah_hamil' => $vaksinTetanusSesudahHamil,
            'posisi_janin' => $posisiJanin,
            'minum_tablet' => $minumTablet,
            'konseling' => $konseling,
            'kategori_tinggi_badan' => $kategoriTinggiBadan,
            'kategori_tekanan_darah' => $kategoriTekananDarah,
            'kategori_lengan_atas' => $kategoriLenganAtas,
            'kategori_denyut_jantung' => $kategoriDenyutJantung,
            'kategori_hemoglobin_darah' => $kategoriHemoglobinDarah,
            'usia_kehamilan' => $usiaKehamilan,
            'tanggal_perkiraan_lahir' => $tanggalPerkiraanLahir,
            'tanggal_perkiraan_lahir_sebut' => Carbon::parse($hpl)->format('d F Y'),
            'tanggal_haid_terakhir_sebut' => Carbon::parse($tanggalHaidTerakhir)->format('d F Y'),
        ];

        return $data;
    }


    public function store(Request $request)
    {
        $data = $this->proses($request);

        $role = Auth::user()->role;

        $anc = new Anc();
        $anc->anggota_keluarga_id = $data['anggota_keluarga_id'];
        $anc->pemeriksaan_ke = $data['pemeriksaan_ke'];
        $anc->kategori_badan = $data['kategori_tinggi_badan'];
        $anc->kategori_tekanan_darah = $data['kategori_tekanan_darah'];
        $anc->kategori_lengan_atas = $data['kategori_lengan_atas'];
        $anc->kategori_denyut_jantung = $data['kategori_denyut_jantung'];
        $anc->kategori_hemoglobin_darah = $data['kategori_hemoglobin_darah'];
        $anc->vaksin_tetanus_sebelum_hamil = $data['vaksin_tetanus_sebelum_hamil'];
        $anc->vaksin_tetanus_sesudah_hamil = $data['vaksin_tetanus_sesudah_hamil'];
        $anc->posisi_janin = $data['posisi_janin'];
        $anc->minum_tablet = $data['minum_tablet'];
        $anc->konseling = $data['konseling'];
        $anc->save();

        $pemeriksaanAnc = new PemeriksaanAnc();
        $pemeriksaanAnc->anc_id = $anc->id;
        $pemeriksaanAnc->tanggal_haid_terakhir = Carbon::parse($data['tanggal_haid_terakhir']);
        $pemeriksaanAnc->kehamilan_ke = $data['kehamilan_ke'];
        $pemeriksaanAnc->tinggi_badan = $data['tinggi_badan'];
        $pemeriksaanAnc->berat_badan = $data['berat_badan'];
        $pemeriksaanAnc->tekanan_darah_sistolik = $data['tekanan_darah_sistolik'];
        $pemeriksaanAnc->tekanan_darah_diastolik = $data['tekanan_darah_diastolik'];
        $pemeriksaanAnc->lengan_atas = $data['lengan_atas'];
        $pemeriksaanAnc->tinggi_fundus = $data['tinggi_fundus'];
        $pemeriksaanAnc->denyut_jantung_janin = $data['denyut_jantung'];
        $pemeriksaanAnc->hemoglobin_darah = $data['hemoglobin_darah'];
        $pemeriksaanAnc->usia_kehamilan = $data['usia_kehamilan'];
        $pemeriksaanAnc->tanggal_perkiraan_lahir = Carbon::parse($data['tanggal_perkiraan_lahir']);
        $pemeriksaanAnc->save();

        if ($role == 'bidan') {
            $anc->bidan_id = Auth::user()->profil->id;
            $anc->tanggal_validasi = Carbon::now();
            $anc->is_valid = 1;
        } else if ($role == 'admin') {
            $anc->bidan_id = $request->nama_bidan;
            $anc->tanggal_validasi = Carbon::now();
            $anc->is_valid = 1;
        }
        $anc->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function show(Anc $anc)
    {
        $namaKepalaKeluarga = $anc->nama_kepala_keluarga;
        $namaIbu = AnggotaKeluarga::where('id', $anc->anggota_keluarga_id)->first()->nama_lengkap;
        $pemeriksaanKe = $anc->pemeriksaan_ke;
        $vaksinTetanusSebelumHamil = $anc->vaksin_tetanus_sebelum_hamil;
        $vaksinTetanusSesudahHamil = $anc->vaksin_tetanus_sesudah_hamil;
        $posisiJanin = $anc->posisi_janin;
        $minumTablet = $anc->minum_tablet;
        $konseling = $anc->konseling;

        $tanggalHaidTerakhir = $anc->pemeriksaanAnc->tanggal_haid_terakhir;
        $kehamilanKe = $anc->pemeriksaanAnc->kehamilan_ke;
        $tinggiBadan = $anc->pemeriksaanAnc->tinggi_badan;
        $beratBadan = $anc->pemeriksaanAnc->berat_badan;
        $tekananDarahSistolik = $anc->pemeriksaanAnc->tekanan_darah_sistolik;
        $tekananDarahDiastolik = $anc->pemeriksaanAnc->tekanan_darah_diastolik;
        $lenganAtas = $anc->pemeriksaanAnc->lengan_atas;
        $tinggiFundus = $anc->pemeriksaanAnc->tinggi_fundus;
        $denyutJantung = $anc->pemeriksaanAnc->denyut_jantung_janin;
        $hemoglobinDarah = $anc->pemeriksaanAnc->hemoglobin_darah;


        if ($tinggiBadan <= 145) {
            $kategoriTinggiBadan = 'Resiko Tinggi';
        } else {
            $kategoriTinggiBadan = 'Normal';
        }

        if ($tekananDarahSistolik < 90) {
            $kategoriTekananDarah = 'Hipotensi';
        } else if ($tekananDarahSistolik >= 90 && $tekananDarahSistolik <= 120) {
            $kategoriTekananDarah = 'Normal';
        } else if ($tekananDarahSistolik >= 121 && $tekananDarahSistolik <= 139) {
            $kategoriTekananDarah = 'Prahipertensi';
        } else if ($tekananDarahSistolik >= 140) {
            $kategoriTekananDarah = 'Hipertensi';
        }

        if ($lenganAtas <= 23.5) {
            $kategoriLenganAtas = 'Kurang Gizi (BBLR)';
        } else {
            $kategoriLenganAtas = 'Normal';
        }

        if ($denyutJantung >= 120 && $denyutJantung <= 160) {
            $kategoriDenyutJantung = 'Normal';
        } else {
            $kategoriDenyutJantung = 'Tidak Normal';
        }

        if ($hemoglobinDarah >= 11) {
            $kategoriHemoglobinDarah = 'Normal';
        } else {
            $kategoriHemoglobinDarah = 'Anemia';
        }

        $tgl = date("d", strtotime($tanggalHaidTerakhir));
        // baca bulan
        $bln = date("m", strtotime($tanggalHaidTerakhir));
        // baca tahun
        $thn = date("Y", strtotime($tanggalHaidTerakhir));

        $hpl = mktime(0, 0, 0, $bln + 9, $tgl + 7, $thn);

        $selisihHari = date_diff(Carbon::now(), Carbon::parse($hpl));
        $usiaKehamilan = intval((($selisihHari->y * 52) + ($selisihHari->m * 4) + round($selisihHari->d / 7)));
        $tanggalPerkiraanLahir = Carbon::parse($hpl);

        $data = [
            'anggota_keluarga_id' => $anc->anggota_keluarga_id,
            'nama_kepala_keluarga' => $namaKepalaKeluarga,
            'nama_ibu' => $namaIbu,
            'pemeriksaan_ke' => $pemeriksaanKe,
            'tanggal_haid_terakhir' => $tanggalHaidTerakhir,
            'kehamilan_ke' => $kehamilanKe,
            'tinggi_badan' => $tinggiBadan,
            'berat_badan' => $beratBadan,
            'tekanan_darah_sistolik' => $tekananDarahSistolik,
            'tekanan_darah_diastolik' => $tekananDarahDiastolik,
            'lengan_atas' => $lenganAtas,
            'tinggi_fundus' => $tinggiFundus,
            'denyut_jantung' => $denyutJantung,
            'hemoglobin_darah' => $hemoglobinDarah,
            'vaksin_tetanus_sebelum_hamil' => $vaksinTetanusSebelumHamil,
            'vaksin_tetanus_sesudah_hamil' => $vaksinTetanusSesudahHamil,
            'posisi_janin' => $posisiJanin,
            'minum_tablet' => $minumTablet,
            'konseling' => $konseling,
            'kategori_tinggi_badan' => $kategoriTinggiBadan,
            'kategori_tekanan_darah' => $kategoriTekananDarah,
            'kategori_lengan_atas' => $kategoriLenganAtas,
            'kategori_denyut_jantung' => $kategoriDenyutJantung,
            'kategori_hemoglobin_darah' => $kategoriHemoglobinDarah,
            'usia_kehamilan' => $usiaKehamilan,
            'tanggal_perkiraan_lahir' => $tanggalPerkiraanLahir,
            'tanggal_perkiraan_lahir_sebut' => Carbon::parse($hpl)->translatedFormat('d F Y'),
            'tanggal_haid_terakhir_sebut' => Carbon::parse($tanggalHaidTerakhir)->translatedFormat('d F Y'),
            'bidan_id' => $anc->bidan_id,
        ];

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function edit(Anc $anc)
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        return view('dashboard.pages.utama.momsCare.anc.edit', compact('anc', 'kartuKeluarga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anc $anc)
    {
        $data = $this->proses($request);

        $role = Auth::user()->role;

        $anc->anggota_keluarga_id = $data['anggota_keluarga_id'];
        $anc->pemeriksaan_ke = $data['pemeriksaan_ke'];
        $anc->tanggal_haid_terakhir = Carbon::parse($data['tanggal_haid_terakhir']);
        $anc->kehamilan_ke = $data['kehamilan_ke'];
        $anc->tinggi_badan = $data['tinggi_badan'];
        $anc->berat_badan = $data['berat_badan'];
        $anc->tekanan_darah_sistolik = $data['tekanan_darah_sistolik'];
        $anc->tekanan_darah_diastolik = $data['tekanan_darah_diastolik'];
        $anc->lengan_atas = $data['lengan_atas'];
        $anc->tinggi_fundus = $data['tinggi_fundus'];
        $anc->denyut_jantung_janin = $data['denyut_jantung'];
        $anc->hemoglobin_darah = $data['hemoglobin_darah'];
        $anc->vaksin_tetanus_sebelum_hamil = $data['vaksin_tetanus_sebelum_hamil'];
        $anc->vaksin_tetanus_sesudah_hamil = $data['vaksin_tetanus_sesudah_hamil'];
        $anc->posisi_janin = $data['posisi_janin'];
        $anc->minum_tablet = $data['minum_tablet'];
        $anc->konseling = $data['konseling'];
        $anc->usia_kehamilan = $data['usia_kehamilan'];
        $anc->tanggal_perkiraan_lahir = Carbon::parse($data['tanggal_perkiraan_lahir']);
        $anc->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anc $anc)
    {
        $anc->delete();

        return response()->json(['status' => 'success']);
    }
}
