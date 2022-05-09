<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Bidan;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
use App\Models\Pemberitahuan;
use App\Models\PerkiraanMelahirkan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PerkiraanMelahirkanController extends Controller
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
                $data = PerkiraanMelahirkan::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC')
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
                        });

                        if (Auth::user()->role == 'penyuluh') {
                            $query->where('is_valid', 1);
                        }

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
                        return Carbon::parse($row->created_at)->format('d M Y');
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
                    ->addColumn('nama_ibu', function ($row) {
                        return $row->anggotaKeluarga->nama_lengkap;
                    })
                    ->addColumn('tanggal_haid_terakhir', function ($row) {
                        return Carbon::parse($row->tanggal_haid_terakhir)->translatedFormat('d F Y');
                    })
                    ->addColumn('tanggal_perkiraan_lahir', function ($row) {
                        return Carbon::parse($row->tanggal_perkiraan_lahir)->translatedFormat('d F Y');
                    })
                    ->addColumn('usia_kehamilan', function ($row) {
                        $selisihHari = date_diff(Carbon::parse($row->created_at), Carbon::parse($row->tanggal_perkiraan_lahir));
                        $selisihHariSebut = $selisihHari->y . ' Tahun ' . $selisihHari->m . ' Bulan ' . $selisihHari->d . ' Hari';
                        return $selisihHariSebut;
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
                    ->rawColumns(['tanggal_dibuat', 'status', 'nama_ibu', 'tanggal_haid_terakhir', 'tanggal_perkiraan_lahir', 'usia_kehamilan', 'desa_kelurahan', 'bidan', 'tanggal_validasi', 'action'])
                    ->make(true);
            }
            return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.index');
        } else {
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $perkiraanMelahirkan = PerkiraanMelahirkan::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();

            return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.indexKeluarga', compact(['perkiraanMelahirkan']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            $kartuKeluarga = KartuKeluarga::latest()->get();
            return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.create', compact('kartuKeluarga'));
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
                'tanggal_haid_terakhir' => 'required',
                'nama_bidan' => Auth::user()->role == "admin" && $request->isMethod('post') ? 'required' : '',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_ibu.required' => 'Nama Ibu tidak boleh kosong',
                'tanggal_haid_terakhir.required' => 'Tanggal haid terakhir tidak boleh kosong',
                'nama_bidan.required' => 'Nama Bidan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // baca tanggal
        $tgl = date("d", strtotime($request->tanggal_haid_terakhir));
        // baca bulan
        $bln = date("m", strtotime($request->tanggal_haid_terakhir));
        // baca tahun
        $thn = date("Y", strtotime($request->tanggal_haid_terakhir));

        $hpl = mktime(0, 0, 0, $bln + 9, $tgl + 7, $thn);

        $tanggal_haid_terakhir = Carbon::parse($request->tanggal_haid_terakhir)->translatedFormat('d F Y');
        $tanggal_perkiraan_lahir = Carbon::parse($hpl)->translatedFormat('d F Y');

        $selisihHari = date_diff(Carbon::now(), Carbon::parse($hpl));
        $selisihHariSebut = $selisihHari->y . ' Tahun ' . $selisihHari->m . ' Bulan ' . $selisihHari->d . ' Hari';
        $ibu = AnggotaKeluarga::where('id', $request->nama_ibu)->withTrashed()->first();

        if (Carbon::parse($hpl) > Carbon::now()) {
            $status = 'Belum Lahir';
        } else {
            $status = 'Sudah Lahir';
        }

        $data = [
            'nama_ibu' => $ibu->nama_lengkap,
            'tanggal_lahir' => $ibu->tanggal_lahir,
            'tanggal_haid_terakhir' => $tanggal_haid_terakhir,
            'tanggal_perkiraan_lahir' => $tanggal_perkiraan_lahir,
            'simpan_tanggal_haid_terakhir' => Carbon::parse($request->tanggal_haid_terakhir),
            'simpan_tanggal_perkiraan_lahir' => Carbon::parse($hpl),
            'selisih_hari' => $selisihHariSebut,
            'status' => $status
        ];

        return $data;
    }

    public function store(Request $request)
    {
        $role = Auth::user()->role;
        $data = $this->proses($request);

        if ($role == 'admin') {
            $bidan_id = $request->nama_bidan;
        } else if ($role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;
        } else if ($role == 'keluarga') {
            $bidan_id = null;
        }

        $perkiraanMelahirkan = new PerkiraanMelahirkan();
        $perkiraanMelahirkan->anggota_keluarga_id = $request->nama_ibu;
        $perkiraanMelahirkan->tanggal_haid_terakhir = $data['simpan_tanggal_haid_terakhir'];
        $perkiraanMelahirkan->tanggal_perkiraan_lahir = $data['simpan_tanggal_perkiraan_lahir'];
        $perkiraanMelahirkan->bidan_id = $bidan_id;

        if ($role != 'keluarga') {
            $perkiraanMelahirkan->tanggal_validasi = Carbon::now();
            $perkiraanMelahirkan->is_valid = 1;
        } else {
            $perkiraanMelahirkan->is_valid = 0;
        }
        $perkiraanMelahirkan->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerkiraanMelahirkan  $perkiraanMelahirkan
     * @return \Illuminate\Http\Response
     */
    public function show(PerkiraanMelahirkan $perkiraanMelahirkan)
    {
        $tanggal_haid_terakhir = Carbon::parse($perkiraanMelahirkan->tanggal_haid_terakhir)->translatedFormat('d F Y');
        $tanggal_perkiraan_lahir = Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir)->translatedFormat('d F Y');

        $selisihHari = date_diff(Carbon::parse($perkiraanMelahirkan->created_at), Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir));
        $selisihHariSebut = $selisihHari->y . ' Tahun ' . $selisihHari->m . ' Bulan ' . $selisihHari->d . ' Hari';
        $ibu = AnggotaKeluarga::find($perkiraanMelahirkan->anggota_keluarga_id);

        $data = [
            'nama_ibu' => $ibu->nama_lengkap,
            'tanggal_lahir' => $ibu->tanggal_lahir,
            'tanggal_haid_terakhir' => $tanggal_haid_terakhir,
            'tanggal_perkiraan_lahir' => $tanggal_perkiraan_lahir,
            'simpan_tanggal_haid_terakhir' => Carbon::parse($perkiraanMelahirkan->tanggal_haid_terakhir),
            'simpan_tanggal_perkiraan_lahir' => Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir),
            'selisih_hari' => $selisihHariSebut,
            'is_valid' => $perkiraanMelahirkan->is_valid,
            'bidan' => $perkiraanMelahirkan->bidan->nama_lengkap ?? '-',
            'bidan_konfirmasi' => $perkiraanMelahirkan->anggotaKeluarga->getBidan($perkiraanMelahirkan->anggota_keluarga_id),
            'tanggal_validasi' => Carbon::parse($perkiraanMelahirkan->tanggal_validasi)->translatedFormat('d F Y')
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerkiraanMelahirkan  $perkiraanMelahirkan
     * @return \Illuminate\Http\Response
     */
    public function edit(PerkiraanMelahirkan $perkiraanMelahirkan)
    {
        if ((Auth::user()->profil->id == $perkiraanMelahirkan->bidan_id) || (Auth::user()->role == 'admin') || (Auth::user()->profil->kartu_keluarga_id == $perkiraanMelahirkan->anggotaKeluarga->kartu_keluarga_id)) {
            $kartuKeluarga = KartuKeluarga::latest()->get();
            return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.edit', compact('kartuKeluarga', 'perkiraanMelahirkan'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PerkiraanMelahirkan  $perkiraanMelahirkan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PerkiraanMelahirkan $perkiraanMelahirkan)
    {
        $role = 'Bidan';
        $data = $this->proses($request);

        $perkiraanMelahirkan->anggota_keluarga_id = $request->nama_ibu;
        $perkiraanMelahirkan->tanggal_haid_terakhir = $data['simpan_tanggal_haid_terakhir'];
        $perkiraanMelahirkan->tanggal_perkiraan_lahir = $data['simpan_tanggal_perkiraan_lahir'];

        if ((Auth::user()->role == 'keluarga') && ($perkiraanMelahirkan->is_valid == 2)) {
            $perkiraanMelahirkan->is_valid = 0;
            $perkiraanMelahirkan->bidan_id = null;
            $perkiraanMelahirkan->tanggal_validasi = null;
            $perkiraanMelahirkan->alasan_ditolak = null;
        }

        $perkiraanMelahirkan->save();

        $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $perkiraanMelahirkan->anggota_keluarga_id)
            ->where('tentang', 'perkiraan_melahirkan')
            ->where('fitur_id', $perkiraanMelahirkan->id);

        if ($pemberitahuan) {
            $pemberitahuan->delete();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerkiraanMelahirkan  $perkiraanMelahirkan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerkiraanMelahirkan $perkiraanMelahirkan)
    {
        if ((Auth::user()->profil->id == $perkiraanMelahirkan->bidan_id) || (Auth::user()->role == 'admin')) {
            $perkiraanMelahirkan->delete();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $perkiraanMelahirkan->id)
                ->where('tentang', 'perkiraan_melahirkan');
            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            return response()->json(['status' => 'success']);
        } else {
            return abort(404);
        }
    }

    public function validasi(Request $request, PerkiraanMelahirkan $perkiraanMelahirkan)
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

        $perkiraanMelahirkan->is_valid = $request->konfirmasi;
        $perkiraanMelahirkan->bidan_id = $bidan_id;
        $perkiraanMelahirkan->tanggal_validasi = Carbon::now();
        $perkiraanMelahirkan->alasan_ditolak = $alasan;
        $perkiraanMelahirkan->save();

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
        return response()->json(['res' => 'success', 'konfirmasi' => $request->konfirmasi]);
    }
}
