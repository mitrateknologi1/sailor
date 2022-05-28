<?php

namespace App\Http\Controllers\dashboard\masterData\profil;

use App\Models\User;
use App\Models\Agama;
use App\Models\Bidan;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\GolonganDarah;
use App\Models\KabupatenKota;
use App\Models\KartuKeluarga;
use App\Models\Pemberitahuan;
use App\Models\StatusHubungan;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use App\Models\WilayahDomisili;
use Illuminate\Validation\Rule;
use App\Models\StatusPerkawinan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ListController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreKartuKeluargaRequest;
use App\Http\Requests\UpdateKartuKeluargaRequest;
use Illuminate\Database\Eloquent\Builder;


class KartuKeluargaController extends Controller
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
        if (Auth::user()->role == 'keluarga') {
            $idKeluarga = \Request::segment(2);
            if ($idKeluarga != Auth::user()->profil->kartu_keluarga_id) {
                abort(404);
            }
        }

        if ($request->ajax()) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
            $data = KartuKeluarga::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan');
            if (Auth::user()->role != 'admin') {
                $data->where(function (Builder $query) use ($lokasiTugas) {
                    $query->whereIn('is_valid', [1, 2]);
                    $query->orWhere(function (Builder $query) use ($lokasiTugas) {
                        $query->where('is_valid', 0);
                        $query->whereHas('kepalaKeluarga', function (Builder $query) use ($lokasiTugas) {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                        });
                    });
                });
            }

            if (Auth::user()->role == 'penyuluh') {
                $data->where('is_valid', 1);
            }

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
            });

            $data->where(function ($query) use ($request) {
                if ($request->statusValidasiAnggota) {
                    // if (Auth::user()->role == 'admin') {
                    //     $jumlahAnggotaBelumDivalidasi = $query->anggotaKeluarga->where('is_valid', 0);
                    // } else {
                    //     if (Auth::user()->role == 'bidan') {
                    //         $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
                    //         $jumlahAnggotaBelumDivalidasi = AnggotaKeluarga::where('kartu_keluarga_id', $query->id)
                    //             ->where('is_valid', 0)
                    //             ->where(function (Builder $query) use ($lokasiTugas) {
                    //                 $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                    //             });
                    //     }
                    // }
                    if ($request->statusValidasiAnggota == 'Belum Tervalidasi') {
                        $query->whereHas('anggotaKeluarga', function (Builder $query) {
                            $query->where('is_valid', 0);
                            if (Auth::user()->role == 'bidan') {
                                $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
                                $query->where(function (Builder $query) use ($lokasiTugas) {
                                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                                });
                            }
                        });
                    }
                }
            });


            $data->where(function ($query) use ($request) {
                if ($request->desaKelurahanDomisili) {
                    $query->whereHas('kepalaKeluarga', function ($query) use ($request) {
                        $query->whereHas('wilayahDomisili', function ($query) use ($request) {
                            $query->where('desa_kelurahan_id', $request->desaKelurahanDomisili);
                        });
                    });
                }
            });

            $data->where(function ($query) use ($request) {
                if ($request->search) {
                    $query->whereHas('bidan', function ($query) use ($request) {
                        $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                    });

                    $query->orWhere('nama_kepala_keluarga', 'like', '%' . $request->search . '%');
                }
            });

            $data->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_valid == 1) {
                        return '<span class="badge rounded bg-success">Tervalidasi</span>';
                    } else if ($row->is_valid == 0) {
                        return '<span class="badge rounded bg-warning">Belum Divalidasi</span>';
                    } else {
                        return '<span class="badge rounded bg-danger text-white">Ditolak</span>';
                    }
                })

                ->addColumn('jumlah_anggota_belum_divalidasi', function ($row) {
                    if (Auth::user()->role == 'admin') {
                        $jumlahAnggotaBelumDivalidasi = $row->anggotaKeluarga->where('is_valid', 0)->count();
                        $jumlahAnggotaTervalidasi = $row->anggotaKeluarga->where('is_valid', 1)->count();
                        $jumlahAnggotaDitolak = $row->anggotaKeluarga->where('is_valid', 2)->count();
                    } else {
                        if (Auth::user()->role == 'bidan') {
                            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id);
                            $jumlahAnggotaBelumDivalidasi = $row->anggotaKeluarga()
                                ->where('is_valid', 0)
                                ->where(function (Builder $query) use ($lokasiTugas) {
                                    $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                                })
                                ->count();

                            $jumlahAnggotaTervalidasi = $row->anggotaKeluarga()
                                ->where('is_valid', 1)
                                ->count();

                            $jumlahAnggotaDitolak = $row->anggotaKeluarga()
                                ->where('is_valid', 2)
                                ->count();
                        }
                    }
                    if ($row->kepalaKeluarga->is_valid == 0) {
                        // Belum Divalidasi
                        return '<span class="badge rounded bg-warning">Belum Divalidasi</span>';
                    }
                    if ($row->is_valid == 2) {
                        return '<span class="badge rounded bg-danger text-white">Ditolak</span>';
                    } else {
                        if (Auth::user()->role != 'penyuluh') {
                            $info = '<div>';
                            if ($jumlahAnggotaBelumDivalidasi > 0) {
                                $info .= '<span class="badge rounded bg-warning">' . $jumlahAnggotaBelumDivalidasi . ' Belum Divalidasi</span>';
                            }
                            if ($jumlahAnggotaTervalidasi > 0) {
                                $info .= ' <span class="badge rounded bg-success">' . $jumlahAnggotaTervalidasi . ' Tervalidasi</span>';
                            }
                            if ($jumlahAnggotaDitolak > 0) {
                                $info .= ' <span class="badge rounded bg-danger text-white">' . $jumlahAnggotaDitolak . ' Ditolak</span>';
                            }
                            $info .= '</div>';

                            return $info;
                        }
                    }
                    // return $jumlahAnggotaBelumDivalidasi;
                })

                ->addColumn('jumlah_anggota_keluarga', function ($row) {
                    $total = $row->anggotaKeluarga->count();
                    $anggota = $total;
                    return $anggota . ' Orang';
                })

                ->addColumn('desa_kelurahan_domisili', function ($row) {
                    // return $row->wilayahDomisili->desaKelurahan->nama;
                    if ($row->kepalaKeluarga) {
                        return $row->kepalaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    }
                    // return $row->kepalaKeluarga->wilayahDomisili->desaKelurahan->nama;
                })

                ->addColumn('desa_kelurahan', function ($row) {
                    return $row->desaKelurahan->nama;
                })

                ->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan->nama;
                })

                ->addColumn('kabupaten_kota', function ($row) {
                    return $row->kabupatenKota->nama;
                })

                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama;
                })

                ->addColumn('bidan', function ($row) {
                    if ($row->bidan) {
                        return $row->bidan->nama_lengkap;
                    } else {
                        return '-';
                    }
                })

                ->addColumn('action', function ($data) {
                    $actionBtn = '
                    <div class="text-center justify-content-center text-white">';
                    if ($data->is_valid == 0) {
                        $actionBtn .= '<button id="btn-validasi" class="btn btn-primary btn-sm me-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Konfirmasi" value=' . $data->id . '><i class="fa-solid fa-lg fa-clipboard-check"></i></button>';
                    } else {
                        $actionBtn .= '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Lihat"  value=' . $data->id . '><i class="fas fa-eye"></i></button>';
                        $actionBtn .= '<a href="' . url('anggota-keluarga/' . $data->id) . '" class="btn btn-success text-white btn-sm me-1 shadow" data-toggle="tooltip" data-placement="top" title="Anggota Keluarga"><i class="fa-solid fa-people-roof"></i></a>';
                        if (Auth::user()->role != 'penyuluh') {
                            if (($data->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                if ($data->is_valid == 1) {
                                    $actionBtn .= '<a href="' . route('keluarga.edit', $data->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a> ';
                                }
                                $actionBtn .= '<button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $data->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                            }
                        }
                        $actionBtn .= '</div>';
                    }
                    return $actionBtn;
                })

                ->rawColumns([
                    'action',
                    'desa_kelurahan',
                    'kecamatan',
                    'kabupaten_kota',
                    'provinsi',
                    'status',
                    'jumlah_anggota_belum_divalidasi',
                ])
                ->make(true);
        }

        if (Auth::user()->role != 'penyuluh') {
            $kepalaKeluarga = AnggotaKeluarga::where('status_hubungan_dalam_keluarga_id', 1)->get();
        } else {
            $kepalaKeluarga = AnggotaKeluarga::where('status_hubungan_dalam_keluarga_id', 1)->valid()->get();
        }

        $wilayahDomisili = WilayahDomisili::with('desaKelurahan')
            ->whereIn('anggota_keluarga_id', $kepalaKeluarga
                ->pluck('id')->toArray())
            ->groupBy('desa_kelurahan_id')->get();
        $dataFilter = [
            'wilayahDomisili' => $wilayahDomisili,
        ];
        return view('dashboard.pages.masterData.profil.keluarga.kartuKeluarga.index', $dataFilter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (in_array(Auth::user()->role, ['admin', 'bidan'])) {
            $data = [
                'agama' => Agama::all(),
                'pendidikan' => Pendidikan::all(),
                'pekerjaan' => Pekerjaan::all(),
                'golonganDarah' => GolonganDarah::all(),
                'statusPerkawinan' => StatusPerkawinan::all(),
                'statusHubungan' => StatusHubungan::all(),
                'provinsi' => Provinsi::all(),
                'kabupatenKota' => KabupatenKota::all(),
                'kecamatan' => Kecamatan::all(),
                'desaKelurahan' => DesaKelurahan::all(),

            ];
            return view('dashboard.pages.masterData.profil.keluarga.kartuKeluarga.create', $data);
        } else {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKartuKeluargaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKartuKeluargaRequest $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KartuKeluarga  $kartuKeluarga
     * @return \Illuminate\Http\Response
     */
    public function show(KartuKeluarga $keluarga)
    {
        // $kepala_keluarag = $keluarga;
        $id = $keluarga->id;
        $keluarga = $keluarga;
        $keluarga['desa_kelurahan_nama'] = $keluarga->desaKelurahan->nama;
        $keluarga['kecamatan_nama'] = $keluarga->kecamatan->nama;
        $keluarga['kabupaten_kota_nama'] = $keluarga->kabupatenKota->nama;
        $keluarga['provinsi_nama'] = $keluarga->provinsi->nama;


        $keluarga['nama_lengkap'] = $keluarga->kepalaKeluarga->nama_lengkap;
        $keluarga['nik'] = $keluarga->kepalaKeluarga->nik;
        $keluarga['jenis_kelamin'] = $keluarga->kepalaKeluarga->jenis_kelamin;
        $keluarga['tempat_lahir'] = $keluarga->kepalaKeluarga->tempat_lahir;
        $keluarga['tanggal_lahir'] = $keluarga->kepalaKeluarga->tanggal_lahir;
        $keluarga['agama'] = $keluarga->kepalaKeluarga->agama->agama;
        $keluarga['pendidikan'] = $keluarga->kepalaKeluarga->pendidikan->pendidikan;
        $keluarga['pekerjaan'] = $keluarga->kepalaKeluarga->pekerjaan->pekerjaan;
        $keluarga['golongan_darah'] = $keluarga->kepalaKeluarga->golonganDarah->golongan_darah;
        $keluarga['status_perkawinan'] = $keluarga->kepalaKeluarga->statusPerkawinan->status_perkawinan;
        $keluarga['tanggal_perkawinan'] = $keluarga->kepalaKeluarga->tanggal_perkawinan;
        $keluarga['kewarganegaraan'] = $keluarga->kepalaKeluarga->kewarganegaraan;
        $keluarga['nomor_paspor'] = $keluarga->kepalaKeluarga->no_paspor;
        $keluarga['nomor_kitap'] = $keluarga->kepalaKeluarga->no_kitap;
        $keluarga['nama_ayah'] = $keluarga->kepalaKeluarga->nama_ayah;
        $keluarga['nama_ibu'] = $keluarga->kepalaKeluarga->nama_ibu;
        $keluarga['alamat_domisili'] = $keluarga->kepalaKeluarga->wilayahDomisili->alamat;
        $keluarga['desa_kelurahan_domisili'] = $keluarga->kepalaKeluarga->wilayahDomisili->desaKelurahan->nama;
        $keluarga['kecamatan_domisili'] = $keluarga->kepalaKeluarga->wilayahDomisili->kecamatan->nama;
        $keluarga['kabupaten_kota_domisili'] = $keluarga->kepalaKeluarga->wilayahDomisili->kabupatenKota->nama;
        $keluarga['provinsi_domisili'] = $keluarga->kepalaKeluarga->wilayahDomisili->provinsi->nama;
        $keluarga['nomor_hp'] = $keluarga->kepalaKeluarga->user->nomor_hp;
        $keluarga['surat_keterangan_domisili'] = $keluarga->kepalaKeluarga->wilayahDomisili->file_ket_domisili;
        $keluarga['foto_profil'] = $keluarga->kepalaKeluarga->foto_profil;
        if ($keluarga->bidan) {
            $keluarga['nama_bidan'] = $keluarga->bidan->nama_lengkap;
        } else {
            $keluarga['nama_bidan'] = '-';
        }

        $keluarga['bidan_konfirmasi'] = $keluarga->getBidan($id);
        return $keluarga;
    }

    public function validasi(Request $request)
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


        $updateKartuKeluarga = KartuKeluarga::where('id', $id)->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id, 'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $kepalaKeluarga = AnggotaKeluarga::where('kartu_keluarga_id', $id)->where('status_hubungan_dalam_keluarga_id', 1);

        $updateKepalaKeluarga = $kepalaKeluarga->update(['is_valid' => $request->konfirmasi, 'bidan_id' => $bidan_id,  'tanggal_validasi' => Carbon::now(), 'alasan_ditolak' => $alasan]);

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        if ($request->konfirmasi == 1) {
            $updateAkun = User::where('id', $kepalaKeluarga->first()->user_id)->update(['status' => 1]);
            $pemberitahuan = Pemberitahuan::create([
                'user_id' => $kepalaKeluarga->first()->user_id,
                'anggota_keluarga_id' => $kepalaKeluarga->first()->id,
                'judul' => 'Selamat, kartu keluarga anda telah divalidasi.',
                'isi' => 'Kartu Keluarga anda telah divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '. Silahkan menambahkan data anggota keluarga anda seperti Istri dan Anak anda pada menu Anggota Keluarga.',
                'tentang' => 'kartu_keluarga',
                'is_valid' => 1,
            ]);
        } else {
            $updateAkun = User::where('id', $kepalaKeluarga->first()->user_id)->update(['status' => 0]);
        }

        if ($updateKartuKeluarga && $updateKepalaKeluarga && $updateAkun) {
            $pemberitahuan;
            return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
        } else {
            return response()->json(['res' => 'error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KartuKeluarga  $kartuKeluarga
     * @return \Illuminate\Http\Response
     */
    public function edit(KartuKeluarga $keluarga)
    {
        if ((Auth::user()->profil->id == $keluarga->bidan_id) || (Auth::user()->role == 'admin')) {
            $data = [
                'kartuKeluarga' => $keluarga,
                'anggotaKeluarga' => $keluarga->kepalaKeluarga,
                'agama' => Agama::all(),
                'pendidikan' => Pendidikan::all(),
                'pekerjaan' => Pekerjaan::all(),
                'golonganDarah' => GolonganDarah::all(),
                'statusPerkawinan' => StatusPerkawinan::all(),
                'statusHubungan' => StatusHubungan::all(),
                'provinsi' => Provinsi::all(),
                'kabupatenKota' => KabupatenKota::where('provinsi_id', $keluarga->provinsi_id)->get(),
                'kecamatan' => Kecamatan::where('kabupaten_kota_id', $keluarga->kabupaten_kota_id)->get(),
                'desaKelurahan' => DesaKelurahan::where('kecamatan_id', $keluarga->kecamatan_id)->get(),
                'kabupatenKotaDomisili' => KabupatenKota::where('provinsi_id', $keluarga->kepalaKeluarga->wilayahDomisili->provinsi_id)->get(),
                'kecamatanDomisili' => Kecamatan::where('kabupaten_kota_id', $keluarga->kepalaKeluarga->wilayahDomisili->kabupaten_kota_id)->get(),
                'desaKelurahanDomisili' => DesaKelurahan::where('kecamatan_id', $keluarga->kepalaKeluarga->wilayahDomisili->kecamatan_id)->get(),
            ];
            return view('dashboard.pages.masterData.profil.keluarga.kartuKeluarga.edit', $data);
        } else {
            return abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKartuKeluargaRequest  $request
     * @param  \App\Models\KartuKeluarga  $kartuKeluarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KartuKeluarga $keluarga)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nomor_kk' => 'required|unique:kartu_keluarga,nomor_kk,' . $keluarga->nomor_kk . ',nomor_kk,deleted_at,NULL|digits:16',
                'nama_kepala_keluarga' => 'required',
                'alamat' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'kode_pos' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'file_kartu_keluarga' => 'mimes:jpeg,jpg,png,pdf|max:3072',
            ],
            [
                'nomor_kk.required' => 'Nomor Kartu Keluarga tidak boleh kosong',
                'nomor_kk.unique' => 'Nomor Kartu Keluarga sudah terdaftar',
                'nomor_kk.digits' => 'Nomor Kartu Keluarga harus 16 digit',
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'rt.required' => 'RT tidak boleh kosong',
                'rw.required' => 'RW tidak boleh kosong',
                'kode_pos.required' => 'Kode Pos tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'file_kartu_keluarga.mimes' => 'File Kartu Keluarga harus berupa file jpeg, jpg, png, pdf',
                'file_kartu_keluarga.max' => 'File Kartu Keluarga tidak boleh lebih dari 3 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'nomor_kk' => $request->nomor_kk,
            'nama_kepala_keluarga' => strtoupper($request->nama_kepala_keluarga),
            'alamat' => strtoupper($request->alamat),
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
        ];

        if ($request->file('file_kartu_keluarga')) {
            if (Storage::exists('upload/kartu_keluarga/' . $keluarga->file_kk)) {
                Storage::delete('upload/kartu_keluarga/' . $keluarga->file_kk);
            }
            $request->file('file_kartu_keluarga')->storeAs(
                'upload/kartu_keluarga/',
                $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension()
            );
            $data['file_kk'] = $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension();
        }

        $keluarga->update($data);

        AnggotaKeluarga::where('kartu_keluarga_id', $keluarga->id)->where('status_hubungan_dalam_keluarga_id', 1)
            ->update([
                'nama_lengkap' => strtoupper($request->nama_kepala_keluarga),
            ]);

        return response()->json(['success' => 'Berhasil', 'mes' => 'Data Kartu Keluarga berhasil perbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KartuKeluarga  $kartuKeluarga
     * @return \Illuminate\Http\Response
     */
    public function destroy(KartuKeluarga $keluarga)
    {
        if ((Auth::user()->profil->id == $keluarga->bidan_id) || (Auth::user()->role == 'admin')) {
            foreach ($keluarga->anggotaKeluarga as $anggota) {
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

            if (Storage::exists('upload/kartu_keluarga/' . $keluarga->file_kk)) {
                Storage::delete('upload/kartu_keluarga/' . $keluarga->file_kk);
            }

            $user = User::where('id', $keluarga->kepalaKeluarga->user_id);

            $remaja = AnggotaKeluarga::where('kartu_keluarga_id', $keluarga->id)
                ->where('status_hubungan_dalam_keluarga_id', 4)
                ->whereNotNull('user_id')->get();
            foreach ($remaja as $r) {
                $r->user->delete();
            }
            // $remaja->user->delete();
            $user->delete();

            $anggotaKeluarga = AnggotaKeluarga::where('kartu_keluarga_id', $keluarga->id);
            $anggotaKeluarga->delete();

            $keluarga->delete();
            return response()->json(['res' => 'success']);
        } else {
            return abort(403);
        }
    }
}
