<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\KartuKeluarga;
use App\Models\PerkiraanMelahirkan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PDO;

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
            $data = PerkiraanMelahirkan::with(['anggotaKeluarga'])
                // ->where('bidan_id', auth()->user()->id)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-eye"></i></button><a href="' . url('perkiraan-melahirkan/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
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
                ->addColumn('selisih_hari', function ($row) {
                    $selisihHari = date_diff(Carbon::now(), Carbon::parse($row->tanggal_perkiraan_lahir));
                    $selisihHariSebut = $selisihHari->y . ' Tahun ' . $selisihHari->m . ' Bulan ' . $selisihHari->d . ' Hari';
                    return $selisihHariSebut;
                })
                ->addColumn('bidan', function ($row) {
                    return "Belum Ada";
                })
                ->addColumn('tanggal_dibuat', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->addColumn('tanggal_validasi', function ($row) {
                    if ($row->tanggal_validasi) {
                        return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                    } else {
                        return '-';
                    }
                })
                ->addColumn('kategori', function ($row) {
                    if (Carbon::parse($row->tanggal_perkiraan_lahir) > Carbon::now()) {
                        return '<span class="badge badge-primary bg-primary">Belum Lahir</span>';
                    } else {
                        return '<span class="badge badge-success bg-success">Sudah Lahir</span>';
                    }
                })
                ->rawColumns(['action', 'nama_ibu', 'bidan', 'status', 'tanggal_dibuat', 'tanggal_validasi', 'tanggal_haid_terakhir', 'tanggal_perkiraan_lahir', 'selisih_hari', 'kategori'])
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
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_ibu.required' => 'Nama Ibu tidak boleh kosong',
                'tanggal_haid_terakhir.required' => 'Tanggal haid terakhir tidak boleh kosong',
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
        $ibu = AnggotaKeluarga::find($request->nama_ibu);

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
        $role = 'Bidan';
        $data = $this->proses($request);
        $bidan_id = 1;

        $perkiraanMelahirkan = new PerkiraanMelahirkan();
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
     * Display the specified resource.
     *
     * @param  \App\Models\PerkiraanMelahirkan  $perkiraanMelahirkan
     * @return \Illuminate\Http\Response
     */
    public function show(PerkiraanMelahirkan $perkiraanMelahirkan)
    {
        $tanggal_haid_terakhir = Carbon::parse($perkiraanMelahirkan->tanggal_haid_terakhir)->translatedFormat('d F Y');
        $tanggal_perkiraan_lahir = Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir)->translatedFormat('d F Y');

        $selisihHari = date_diff(Carbon::now(), Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir));
        $selisihHariSebut = $selisihHari->y . ' Tahun ' . $selisihHari->m . ' Bulan ' . $selisihHari->d . ' Hari';
        $ibu = AnggotaKeluarga::find($perkiraanMelahirkan->id);

        if (Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir) > Carbon::now()) {
            $status = 'Belum Lahir';
        } else {
            $status = 'Sudah Lahir';
        }

        $data = [
            'nama_ibu' => $ibu->nama_lengkap,
            'tanggal_lahir' => $ibu->tanggal_lahir,
            'tanggal_haid_terakhir' => $tanggal_haid_terakhir,
            'tanggal_perkiraan_lahir' => $tanggal_perkiraan_lahir,
            'simpan_tanggal_haid_terakhir' => Carbon::parse($perkiraanMelahirkan->tanggal_haid_terakhir),
            'simpan_tanggal_perkiraan_lahir' => Carbon::parse($perkiraanMelahirkan->tanggal_perkiraan_lahir),
            'selisih_hari' => $selisihHariSebut,
            'status' => $status
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
