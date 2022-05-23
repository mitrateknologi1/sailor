<?php

namespace App\Http\Controllers\dashboard\utama\deteksiStunting;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\JawabanDeteksiIbuMelahirkanStunting;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\Pemberitahuan;
use App\Models\SoalIbuMelahirkanStunting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeteksiIbuMelahirkanStuntingController extends Controller
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
                $data = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
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
                            $query->valid();
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
                                if ($request->kategori == 'beresiko') {
                                    $kategori = 'Beresiko Melahirkan Stunting';
                                } else if ($request->kategori == 'tidak_beresiko') {
                                    $kategori = 'Tidak Beresiko Melahirkan Stunting';
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
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_dibuat', function ($row) {
                        return Carbon::parse($row->created_at)->translatedFormat('d F Y');
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
                    ->addColumn('nama_ibu', function ($row) {
                        return $row->anggotaKeluarga->nama_lengkap ?? '-';
                    })
                    ->addColumn('kategori', function ($row) {
                        if ($row->kategori == 'Tidak Beresiko Melahirkan Stunting') {
                            return '<span class="badge badge-success bg-success">' . $row->kategori . '</span>';
                        } else {
                            return '<span class="badge badge-danger bg-danger">' . $row->kategori . '</span>';
                        }
                    })
                    ->addColumn('desa_kelurahan', function ($row) {
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    })
                    ->addColumn('bidan', function ($row) {
                        return $row->bidan->nama_lengkap ?? '-';
                    })
                    ->addColumn('tanggal_validasi', function ($row) {
                        return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '
                            <div class="text-center justify-content-center text-white">';
                        if ($row->is_valid == 0) {
                            $actionBtn = '<a href=" ' . url('deteksi-ibu-melahirkan-stunting' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fa-solid fa-lg fa-clipboard-check"></i></a>';
                        } else {
                            $actionBtn = '<a href=" ' . url('deteksi-ibu-melahirkan-stunting' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>';
                        }
                        if (in_array(Auth::user()->role, ['bidan', 'admin'])) {
                            if (($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                if ($row->is_valid == 1) {
                                    $actionBtn .= '<a href="' . url('deteksi-ibu-melahirkan-stunting/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
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
                    ->rawColumns(['action', 'nama_ibu', 'nakes', 'status', 'kategori', 'tanggal_dibuat', 'tanggal_validasi'])
                    ->make(true);
            }
            return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.index');
        } else {
            if (Auth::user()->is_remaja == 1) {
                abort(403, 'Maaf, halaman ini bukan untuk Remaja');
            }
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $deteksiIbuMelahirkanStunting = DeteksiIbuMelahirkanStunting::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();

            return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.indexKeluarga', compact(['deteksiIbuMelahirkanStunting']));
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
            $daftarSoal = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->get();
            if (count($daftarSoal) > 0) {
                return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.create', compact('kartuKeluarga', 'daftarSoal'));
            } else {
                return redirect(url('deteksi-ibu-melahirkan-stunting'))->with('error', 'soal_tidak_ada');
            }
        } else {
            return abort(404);
        }
    }

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
        $totalSoal = SoalIbuMelahirkanStunting::count();

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

        // Cek Jawaban
        $jawabanYa = 0;
        for ($i = 0; $i < $totalSoal; $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            if ($request->$jawaban[0] == "Ya") {
                $jawabanYa++;
            }
        }

        $kategori = '';
        if ($jawabanYa > 0) {
            $kategori = 'Beresiko Melahirkan Stunting';
        } else {
            $kategori = 'Tidak Beresiko Melahirkan Stunting';
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
            'kategori' => $kategori
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
        $data = $this->proses($request);

        $terdapatDataBelumValidasi = DeteksiIbuMelahirkanStunting::where('anggota_keluarga_id', $request->nama_ibu)->where('is_valid', '!=', 1);
        $ibu = AnggotaKeluarga::find($request->nama_ibu);

        if ($role == 'admin') {
            $bidan_id = $request->nama_bidan;
        } else if ($role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;
        } else if ($role == 'keluarga') {
            $bidan_id = null;
        }

        $deteksiIbuMelahirkanStunting = new DeteksiIbuMelahirkanStunting();
        $deteksiIbuMelahirkanStunting->anggota_keluarga_id = $request->nama_ibu;
        $deteksiIbuMelahirkanStunting->kategori = $data['kategori'];
        $deteksiIbuMelahirkanStunting->bidan_id = $bidan_id;
        if ($role != 'keluarga') {
            $deteksiIbuMelahirkanStunting->tanggal_validasi = Carbon::now();
            $deteksiIbuMelahirkanStunting->is_valid = 1;
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat menambahkan deteksi ibu melahirkan stunting ' . $ibu->nama_lengkap . ', dikarenakan masih terdapat data yang berstatus belum divalidasi/ditolak.',
                ]);
            }
        } else {
            $deteksiIbuMelahirkanStunting->is_valid = 0;
            if ($terdapatDataBelumValidasi->count() > 0) {
                return response()->json([
                    'res' => 'sudah_ada_tapi_belum_divalidasi',
                    'mes' => 'Maaf, tidak dapat mengirim deteksi ibu melahirkan stunting ' . $ibu->nama_lengkap . ', dikarenakan masih terdapat data yang berstatus belum divalidasi/ditolak. Silahkan Perbarui Data tersebut apabila statusnya ditolak.',
                ]);
            }
        }

        $deteksiIbuMelahirkanStunting->save();

        for ($i = 0; $i < count($request->soal_id); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanDeteksiIbuMelahirkanStunting = new JawabanDeteksiIbuMelahirkanStunting();
            $jawabanDeteksiIbuMelahirkanStunting->deteksi_ibu_melahirkan_stunting_id = $deteksiIbuMelahirkanStunting->id;
            $jawabanDeteksiIbuMelahirkanStunting->soal_id = $request->soal_id[$i];
            $jawabanDeteksiIbuMelahirkanStunting->jawaban = $request->$jawaban[0];
            $jawabanDeteksiIbuMelahirkanStunting->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeteksiIbuMelahirkanStunting  $deteksiIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function show(DeteksiIbuMelahirkanStunting $deteksiIbuMelahirkanStunting)
    {
        $tanggalLahir = Carbon::parse($deteksiIbuMelahirkanStunting->AnggotaKeluarga->tanggal_lahir)->translatedFormat('d F Y');
        if ($deteksiIbuMelahirkanStunting->tanggal_validasi) {
            $tanggalValidasi = Carbon::parse($deteksiIbuMelahirkanStunting->tanggal_validasi)->translatedFormat('d F Y');
        }
        $tanggalProses = Carbon::parse($deteksiIbuMelahirkanStunting->created_at)->translatedFormat('d F Y');

        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($deteksiIbuMelahirkanStunting->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $namaAyah = AnggotaKeluarga::where('kartu_keluarga_id', $deteksiIbuMelahirkanStunting->AnggotaKeluarga->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga_id', '2')->first();
        $data = [
            'id' => $deteksiIbuMelahirkanStunting->id,
            'nama_ibu' => $deteksiIbuMelahirkanStunting->anggotaKeluarga->nama_lengkap ?? '-',
            'tanggal_lahir' => $tanggalLahir,
            'usia' => $usia,
            'tanggal_validasi' => $tanggalValidasi ?? '-',
            'desa_kelurahan' => $deteksiIbuMelahirkanStunting->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'bidan' => $deteksiIbuMelahirkanStunting->bidan->nama_lengkap ?? '-',
            'kategori' => $deteksiIbuMelahirkanStunting->kategori,
            'tanggal_proses' => $tanggalProses,
            'is_valid' => $deteksiIbuMelahirkanStunting->is_valid,
            'bidan_konfirmasi' => $deteksiIbuMelahirkanStunting->anggotaKeluarga->getBidan($deteksiIbuMelahirkanStunting->anggota_keluarga_id)
        ];

        $daftarSoal = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->withTrashed()->get();
        return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.show', compact('deteksiIbuMelahirkanStunting', 'data', 'daftarSoal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeteksiIbuMelahirkanStunting  $deteksiIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function edit(DeteksiIbuMelahirkanStunting $deteksiIbuMelahirkanStunting)
    {
        if (Auth::user()->is_remaja == 1) {
            abort(403, 'Maaf, halaman ini bukan untuk Remaja');
        }
        if ((Auth::user()->profil->id == $deteksiIbuMelahirkanStunting->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $deteksiIbuMelahirkanStunting->anggotaKeluarga->kartu_keluarga_id)) {
            $kartuKeluarga = KartuKeluarga::latest()->get();
            $daftarSoal = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->get();
            if (count($daftarSoal) > 0) {
                return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.edit', compact('kartuKeluarga', 'daftarSoal', 'deteksiIbuMelahirkanStunting'));
            } else {
                return redirect(url('deteksi-ibu-melahirkan-stunting'))->with('error', 'soal_tidak_ada');
            }
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeteksiIbuMelahirkanStunting  $deteksiIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeteksiIbuMelahirkanStunting $deteksiIbuMelahirkanStunting)
    {
        $data = $this->proses($request);

        $deteksiIbuMelahirkanStunting->anggota_keluarga_id = $request->nama_ibu;
        $deteksiIbuMelahirkanStunting->kategori = $data['kategori'];

        if ((Auth::user()->role == 'keluarga') && ($deteksiIbuMelahirkanStunting->is_valid == 2)) {
            $deteksiIbuMelahirkanStunting->is_valid = 0;
            $deteksiIbuMelahirkanStunting->bidan_id = null;
            $deteksiIbuMelahirkanStunting->tanggal_validasi = null;
            $deteksiIbuMelahirkanStunting->alasan_ditolak = null;
        }

        $deteksiIbuMelahirkanStunting->save();

        $jawabanDeteksiIbuMelahirkanStunting = JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $deteksiIbuMelahirkanStunting->id)->delete();

        for ($i = 0; $i < count($request->soal_id); $i++) {
            $jawaban = "jawaban-" . ($i + 1);
            $jawabanDeteksiIbuMelahirkanStunting = new JawabanDeteksiIbuMelahirkanStunting();
            $jawabanDeteksiIbuMelahirkanStunting->deteksi_ibu_melahirkan_stunting_id = $deteksiIbuMelahirkanStunting->id;
            $jawabanDeteksiIbuMelahirkanStunting->soal_id = $request->soal_id[$i];
            $jawabanDeteksiIbuMelahirkanStunting->jawaban = $request->$jawaban[0];
            $jawabanDeteksiIbuMelahirkanStunting->save();
        }

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $deteksiIbuMelahirkanStunting->anggota_keluarga_id)
            ->where('tentang', 'deteksi_ibu_melahirkan_stunting')
            ->where('fitur_id', $deteksiIbuMelahirkanStunting->id);

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
     * @param  \App\Models\DeteksiIbuMelahirkanStunting  $deteksiIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeteksiIbuMelahirkanStunting $deteksiIbuMelahirkanStunting)
    {
        if ((Auth::user()->profil->id == $deteksiIbuMelahirkanStunting->bidan_id) || (Auth::user()->role == 'admin')) {
            $deteksiIbuMelahirkanStunting->delete();

            $jawabanDeteksiIbuMelahirkanStunting = JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $deteksiIbuMelahirkanStunting->id)->delete();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $deteksiIbuMelahirkanStunting->id)
                ->where('tentang', 'deteksi_ibu_melahirkan_stunting');

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return abort(404);
        }
    }

    public function validasi(Request $request, DeteksiIbuMelahirkanStunting $deteksiIbuMelahirkanStunting)
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

        $deteksiIbuMelahirkanStunting->is_valid = $request->konfirmasi;
        $deteksiIbuMelahirkanStunting->bidan_id = $bidan_id;
        $deteksiIbuMelahirkanStunting->tanggal_validasi = Carbon::now();
        $deteksiIbuMelahirkanStunting->alasan_ditolak = $alasan;
        $deteksiIbuMelahirkanStunting->save();

        $namaBidan = Bidan::where('id', $bidan_id)->first();

        $pemberitahuan = new Pemberitahuan();
        $pemberitahuan->user_id = $deteksiIbuMelahirkanStunting->anggotaKeluarga->kartuKeluarga->kepalaKeluarga->user_id;
        $pemberitahuan->fitur_id = $deteksiIbuMelahirkanStunting->id;
        $pemberitahuan->anggota_keluarga_id = $deteksiIbuMelahirkanStunting->anggota_keluarga_id;
        $pemberitahuan->tentang = 'deteksi_ibu_melahirkan_stunting';

        if ($request->konfirmasi == 1) {
            $pemberitahuan->judul = 'Selamat, data deteksi ibu melahirkan stunting anda telah divalidasi.';
            $pemberitahuan->isi = 'Data deteksi ibu melahirkan stunting anda (' . ucwords(strtolower($deteksiIbuMelahirkanStunting->anggotaKeluarga->nama_lengkap)) . ') divalidasi oleh bidan ' . $namaBidan->nama_lengkap . '.';
        } else {
            $pemberitahuan->judul = 'Maaf, data deteksi ibu melahirkan stunting anda' . ' (' . ucwords(strtolower($deteksiIbuMelahirkanStunting->anggotaKeluarga->nama_lengkap)) . ') ditolak.';
            $pemberitahuan->isi = 'Silahkan perbarui data untuk melihat alasan data deteksi ibu melahirkan stunting ditolak dan mengirim ulang data. Terima Kasih.';
        }

        $pemberitahuan->save();
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
