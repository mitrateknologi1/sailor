<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\KartuKeluarga;
use App\Models\LokasiTugas;
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
                        $actionBtn .= '<a href="' . url('perkiraan-melahirkan/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['tanggal_dibuat', 'status', 'nama_ibu', 'tanggal_haid_terakhir', 'tanggal_perkiraan_lahir', 'usia_kehamilan', 'desa_kelurahan', 'bidan', 'tanggal_validasi', 'action'])
                ->make(true);
        }
        return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.create', compact('kartuKeluarga'));
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

        $perkiraanMelahirkan = new PerkiraanMelahirkan();
        $perkiraanMelahirkan->anggota_keluarga_id = $request->nama_ibu;
        $perkiraanMelahirkan->tanggal_haid_terakhir = $data['simpan_tanggal_haid_terakhir'];
        $perkiraanMelahirkan->tanggal_perkiraan_lahir = $data['simpan_tanggal_perkiraan_lahir'];
        if ($role == 'bidan') {
            $perkiraanMelahirkan->bidan_id = Auth::user()->profil->id;
            $perkiraanMelahirkan->tanggal_validasi = Carbon::now();
            $perkiraanMelahirkan->is_valid = 1;
        } else if ($role == 'admin') {
            $perkiraanMelahirkan->bidan_id = $request->nama_bidan;
            $perkiraanMelahirkan->tanggal_validasi = Carbon::now();
            $perkiraanMelahirkan->is_valid = 1;
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
        $ibu = AnggotaKeluarga::find($perkiraanMelahirkan->id);

        $data = [
            'nama_ibu' => $ibu->nama_lengkap,
            'tanggal_lahir' => $ibu->tanggal_lahir,
            'tanggal_haid_terakhir' => $tanggal_haid_terakhir,
            'tanggal_perkiraan_lahir' => $tanggal_perkiraan_lahir,
            'simpan_tanggal_haid_terakhir' => Carbon::parse($perkiraanMelahirkan->tanggal_haid_terakhir),
            'simpan_tanggal_perkiraan_lahir' => Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir),
            'selisih_hari' => $selisihHariSebut,
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
        $kartuKeluarga = KartuKeluarga::latest()->get();
        return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.edit', compact('kartuKeluarga', 'perkiraanMelahirkan'));
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
        $bidan_id = 1;

        $perkiraanMelahirkan->anggota_keluarga_id = $request->nama_ibu;
        $perkiraanMelahirkan->bidan_id = $bidan_id;
        $perkiraanMelahirkan->tanggal_haid_terakhir = $data['simpan_tanggal_haid_terakhir'];
        $perkiraanMelahirkan->tanggal_perkiraan_lahir = $data['simpan_tanggal_perkiraan_lahir'];
        if ($role == 'Bidan') {
            $perkiraanMelahirkan->is_valid = 1;
            $perkiraanMelahirkan->tanggal_validasi = Carbon::now();
        }
        $perkiraanMelahirkan->save();

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
        //
        $perkiraanMelahirkan->delete();
        return response()->json(['status' => 'success']);
    }
}
