<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\DeteksiDini;
use App\Models\JawabanDeteksiDini;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\Pemberitahuan;
use App\Models\SoalDeteksiDini;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeteksiDiniController extends Controller
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
                $data = DeteksiDini::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
                    ->where(function ($query) use ($lokasiTugas) {
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
                                if ($request->kategori == 'resiko_rendah') {
                                    $kategori = 'Kehamilan : KRR (Beresiko Rendah)';
                                } else if ($request->kategori == 'resiko_tinggi') {
                                    $kategori = 'Kehamilan : KRT (Beresiko TINGGI)';
                                } else if ($request->kategori == 'resiko_sangat_tinggi') {
                                    $kategori = 'Kehamilan : KRST (Beresiko SANGAT TINGGI)';
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

                                $query->orWhereHas('anggotaKeluarga', function ($query) use ($request) {
                                    $query->whereHas('kartuKeluarga', function ($query2) use ($request) {
                                        $query2->where('nomor_kk', 'like', '%' . $request->search . '%');
                                    });
                                });
                            }
                        });
                    })
                    ->whereHas('anggotaKeluarga', function ($query) use ($request) {
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
                    })
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '
                            <div class="text-center justify-content-center text-white">';
                        if ($row->is_valid == 0) {
                            $actionBtn = '<a href=" ' . url('deteksi-dini' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fa-solid fa-lg fa-clipboard-check"></i></a>';
                        } else {
                            $actionBtn = '<a href=" ' . url('deteksi-dini' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>';
                        }
                        if (in_array(Auth::user()->role, ['bidan', 'admin'])) {
                            if (($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                if ($row->is_valid == 1) {
                                    $actionBtn .= '<a href="' . url('deteksi-dini/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
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
                    ->addColumn('status', function ($row) {
                        if ($row->is_valid == 0) {
                            return '<span class="badge badge-warning bg-warning">Belum Divalidasi</span>';
                        } else if ($row->is_valid == 2) {
                            return '<span class="badge badge-danger bg-danger">Ditolak</span>';
                        } else {
                            return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                        }
                    })
                    ->addColumn('nomor_kk', function ($row) {
                        return $row->anggotaKeluarga->kartuKeluarga->nomor_kk;
                    })
                    ->addColumn('nama_ibu', function ($row) {
                        return $row->anggotaKeluarga->nama_lengkap ?? '-';
                    })
                    ->addColumn('desa_kelurahan', function ($row) {
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    })
                    ->addColumn('bidan', function ($row) {
                        return $row->bidan->nama_lengkap ?? '-';
                    })
                    ->addColumn('tanggal_dibuat', function ($row) {
                        return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                    })
                    ->addColumn('tanggal_validasi', function ($row) {
                        return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                    })
                    ->addColumn('kategori', function ($row) {
                        if ($row->kategori == 'Kehamilan : KRST (Beresiko SANGAT TINGGI)') {
                            return '<span class="badge badge-danger bg-danger">' . $row->kategori . '</span>';
                        } else if ($row->kategori == 'Kehamilan : KRT (Beresiko TINGGI)') {
                            return '<span class="badge badge-warning bg-warning">' . $row->kategori . '</span>';
                        } else {
                            return '<span class="badge badge-primary bg-primary">' . $row->kategori . '</span>';
                        }
                    })
                    ->rawColumns(['action', 'nama_ibu', 'nakes', 'status', 'kategori', 'tanggal_dibuat', 'tanggal_validasi'])
                    ->make(true);
            }
            return view('dashboard.pages.utama.momsCare.deteksiDini.index');
        } else {
            if (Auth::user()->is_remaja == 1) {
                abort(403, 'Maaf, halaman ini bukan untuk Remaja');
            }
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $deteksiDini = DeteksiDini::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();

            return view('dashboard.pages.utama.momsCare.deteksiDini.indexKeluarga', compact(['deteksiDini']));
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
                        $query->where('status_hubungan_dalam_keluarga_id', 3);
                    })
                    ->latest()->get();
            } else if (Auth::user()->role == 'bidan') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->valid()
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        $query->where('status_hubungan_dalam_keluarga_id', 3);
                    })->latest()->get();
            } else if (Auth::user()->role == 'keluarga') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')
                    ->where('id', Auth::user()->profil->kartu_keluarga_id)->latest()->get();
            }
            $daftarSoal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();
            if (count($daftarSoal) > 0) {
                return view('dashboard.pages.utama.momsCare.deteksiDini.create', compact('kartuKeluarga', 'daftarSoal'));
            } else {
                return redirect(url('deteksi-dini'))->with('error', 'soal_tidak_ada');
            }
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
                'nama_ibu' => 'required',
                'nama_bidan' => Auth::user()->role == "admin" && $request->isMethod('post') ? 'required' : '',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_ibu.required' => 'Nama Ibu Tidak Boleh Kosong',
                'nama_bidan.required' => 'Nama Bidan Tidak Boleh Kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $pesanError = [];
        $totalSoal = SoalDeteksiDini::count();

        for ($i = 0; $i < $totalSoal; $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            if ($request->$jawaban == null) {
                $pesanError['jawaban-' . ($i + 1)] = 'Jawaban Tidak Boleh Kosong';
            }
        }

        if (!empty($pesanError)) {
            return response()->json([
                'error' => $pesanError
            ]);
        }

        $soalDeteksiDini = SoalDeteksiDini::orderBy('urutan', 'asc')->get();

        // Cek Jawaban
        $skor = 0;
        for ($i = 0; $i < $totalSoal; $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            if ($request->$jawaban[0] == "Tidak") {
                $skor += $soalDeteksiDini[$i]->skor_tidak;
            } else {
                $skor += $soalDeteksiDini[$i]->skor_ya;
            }
        }

        $totalSkor = 2 + $skor;

        if ($totalSkor <= 5) {
            $kategori = 'Kehamilan : KRR (Beresiko Rendah)';
        } else if ($totalSkor <= 10) {
            $kategori = 'Kehamilan : KRT (Beresiko TINGGI)';
        } else {
            $kategori = 'Kehamilan : KRST (Beresiko SANGAT TINGGI)';
        }

        $ibu = AnggotaKeluarga::where('id', $request->nama_ibu)->withTrashed()->first();

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($ibu->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'anggota_keluarga_id' => $request->nama_ibu,
            'nama_ibu' => $ibu->nama_lengkap,
            'tanggal_lahir' => $ibu->tanggal_lahir,
            'usia_tahun' => $usia,
            'total_skor' => $totalSkor,
            'kategori' => $kategori
        ];
        return $data;
    }

    public function store(Request $request)
    {
        $role = Auth::user()->role;
        $data = $this->proses($request);

        $terdapatDataBelumValidasi = DeteksiDini::where('anggota_keluarga_id', $request->nama_ibu)->where('is_valid', '!=', 1);

        $ibu = AnggotaKeluarga::find($request->nama_ibu);

        if ($role == 'admin') {
            $bidan_id = $request->nama_bidan;
        } else if ($role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;
        } else if ($role == 'keluarga') {
            $bidan_id = null;
        }

        $deteksiDini = new DeteksiDini();
        $deteksiDini->anggota_keluarga_id = $request->nama_ibu;
        $deteksiDini->kategori = $data['kategori'];
        $deteksiDini->skor = $data['total_skor'];
        $deteksiDini->bidan_id = $bidan_id;

        if ($role != 'keluarga') {
            $deteksiDini->tanggal_validasi = Carbon::now();
            $deteksiDini->is_valid = 1;
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat menambahkan deteksi dini ' . $ibu->nama_lengkap . ', dikarenakan masih terdapat data yang berstatus belum divalidasi/ditolak.',
                ]);
            }
        } else {
            $deteksiDini->is_valid = 0;
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat mengirim deteksi dini ' . $ibu->nama_lengkap . ', dikarenakan masih terdapat data yang berstatus belum divalidasi/ditolak. Silahkan Perbarui Data tersebut apabila statusnya ditolak.',
                ]);
            }
        }

        $deteksiDini->save();

        $soal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();

        for ($i = 0; $i < count($soal); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanDeteksiDini = new JawabanDeteksiDini();
            $jawabanDeteksiDini->deteksi_dini_id = $deteksiDini->id;
            $jawabanDeteksiDini->soal_id = $soal[$i]->id;
            $jawabanDeteksiDini->jawaban = $request->$jawaban[0];
            $jawabanDeteksiDini->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeteksiDini  $deteksiDini
     * @return \Illuminate\Http\Response
     */
    public function show(DeteksiDini $deteksiDini)
    {
        $tanggalLahir = Carbon::parse($deteksiDini->AnggotaKeluarga->tanggal_lahir)->translatedFormat('d F Y');
        if ($deteksiDini->tanggal_validasi) {
            $tanggalValidasi = Carbon::parse($deteksiDini->tanggal_validasi)->translatedFormat('d F Y');
        }
        $tanggalProses = Carbon::parse($deteksiDini->created_at)->translatedFormat('d F Y');

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($deteksiDini->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $namaAyah = AnggotaKeluarga::where('kartu_keluarga_id', $deteksiDini->AnggotaKeluarga->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga_id', 2)->first();
        $data = [
            'id' => $deteksiDini->id,
            'nama_ibu' => $deteksiDini->anggotaKeluarga->nama_lengkap ?? '-',
            'tanggal_lahir' => $tanggalLahir,
            'usia' => $usia,
            'desa_kelurahan' => $deteksiDini->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'bidan' => $deteksiDini->bidan->nama_lengkap ?? '-',
            'tanggal_validasi' => $tanggalValidasi ?? '-',
            'kategori' => $deteksiDini->kategori,
            'total_skor' => $deteksiDini->skor,
            'tanggal_proses' => $tanggalProses,
            'is_valid' => $deteksiDini->is_valid,
            'bidan_konfirmasi' => $deteksiDini->anggotaKeluarga->getBidan($deteksiDini->anggota_keluarga_id)
        ];

        $daftarSoal = SoalDeteksiDini::orderBy('urutan', 'asc')->withTrashed()->get();
        return view('dashboard.pages.utama.momsCare.deteksiDini.show', compact('deteksiDini', 'data', 'daftarSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeteksiDini  $deteksiDini
     * @return \Illuminate\Http\Response
     */
    public function edit(DeteksiDini $deteksiDini)
    {
        if (Auth::user()->is_remaja == 1) {
            abort(403, 'Maaf, halaman ini bukan untuk Remaja');
        }
        if ((Auth::user()->profil->id == $deteksiDini->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $deteksiDini->anggotaKeluarga->kartu_keluarga_id)) {
            $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
            if (Auth::user()->role == 'admin') {
                $kartuKeluarga = KartuKeluarga::valid()
                    ->whereHas('anggotaKeluarga', function ($query) {
                        $query->where('status_hubungan_dalam_keluarga_id', 3);
                    })
                    ->latest()->get();
            } else if (Auth::user()->role == 'bidan') {
                $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')->valid()
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                        $query->where('status_hubungan_dalam_keluarga_id', 3);
                    })
                    ->orWhereHas('anggotaKeluarga', function ($query) use ($deteksiDini) {
                        $query->where('id', $deteksiDini->anggota_keluarga_id);
                        $query->where('status_hubungan_dalam_keluarga_id', 3);
                    })
                    ->latest()->get();
            }
            $daftarSoal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();
            if (count($daftarSoal) > 0) {
                return view('dashboard.pages.utama.momsCare.deteksiDini.edit', compact('deteksiDini', 'daftarSoal', 'kartuKeluarga'));
            } else {
                return redirect(url('deteksi-dini'))->with('error', 'soal_tidak_ada');
            }
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeteksiDini  $deteksiDini
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeteksiDini $deteksiDini)
    {
        $data = $this->proses($request);

        $deteksiDini->anggota_keluarga_id = $request->nama_ibu;
        $deteksiDini->bidan_id = $deteksiDini->bidan_id;
        $deteksiDini->kategori = $data['kategori'];
        $deteksiDini->skor = $data['total_skor'];

        if ((Auth::user()->role == 'keluarga') && ($deteksiDini->is_valid == 2)) {
            $deteksiDini->is_valid = 0;
            $deteksiDini->bidan_id = null;
            $deteksiDini->tanggal_validasi = null;
            $deteksiDini->alasan_ditolak = null;
        }
        $deteksiDini->save();

        $soal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();

        $jawabanDeteksiDini = JawabanDeteksiDini::where('deteksi_dini_id', $deteksiDini->id)->delete();

        for ($i = 0; $i < count($soal); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanDeteksiDini = new JawabanDeteksiDini();
            $jawabanDeteksiDini->deteksi_dini_id = $deteksiDini->id;
            $jawabanDeteksiDini->soal_id = $soal[$i]->id;
            $jawabanDeteksiDini->jawaban = $request->$jawaban[0];
            $jawabanDeteksiDini->save();
        }

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $deteksiDini->anggota_keluarga_id)
            ->where('tentang', 'deteksi_dini')
            ->where('fitur_id', $deteksiDini->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeteksiDini  $deteksiDini
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeteksiDini $deteksiDini)
    {
        if ((Auth::user()->profil->id == $deteksiDini->bidan_id) || (Auth::user()->role == 'admin')) {
            $deteksiDini->delete();

            $jawabanDeteksiDini = JawabanDeteksiDini::where('deteksi_dini_id', $deteksiDini->id)->delete();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $deteksiDini->id)
                ->where('tentang', 'deteksi_dini');
            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            return response()->json([
                'status' => 'success'
            ]);
        }
    }

    public function validasi(Request $request, DeteksiDini $deteksiDini)
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

        $deteksiDini->is_valid = $request->konfirmasi;
        $deteksiDini->bidan_id = $bidan_id;
        $deteksiDini->tanggal_validasi = Carbon::now();
        $deteksiDini->alasan_ditolak = $alasan;
        $deteksiDini->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $deteksiDini->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $deteksiDini->id;
        $pemberitahuan->anggota_keluarga_id = $deteksiDini->anggota_keluarga_id;
        $pemberitahuan->tentang = 'deteksi_dini';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data deteksi dini anda telah divalidasi.';
            $pemberitahuan->isi = 'Data deteksi dini anda (' . ucwords(strtolower($deteksiDini->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data deteksi dini anda' . ' (' . ucwords(strtolower($deteksiDini->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data deteksi dini ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
