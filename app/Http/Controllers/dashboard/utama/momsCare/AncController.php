<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\Anc;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
            $data = Anc::with(['anggotaKeluarga'])
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
                ->rawColumns(['action', 'nama_ibu', 'bidan', 'status', 'tanggal_dibuat', 'tanggal_validasi', 'tanggal_haid_terakhir', 'selisih_hari'])
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function show(Anc $anc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function edit(Anc $anc)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anc  $anc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anc $anc)
    {
        //
    }
}
