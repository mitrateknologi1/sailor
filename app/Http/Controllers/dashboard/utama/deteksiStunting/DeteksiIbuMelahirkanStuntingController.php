<?php

namespace App\Http\Controllers\dashboard\utama\deteksiStunting;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Models\JawabanDeteksiIbuMelahirkanStunting;
use App\Models\KartuKeluarga;
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DeteksiIbuMelahirkanStunting::with(['anggotaKeluarga'])
                // ->where('bidan_id', auth()->user()->id)
                ->get();
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
                    return $row->bidan->nama_lengkap;
                })
                ->addColumn('tanggal_validasi', function ($row) {
                    return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href=" ' . url('deteksi-ibu-melahirkan-stunting' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>';

                    if ($row->bidan_id == Auth::user()->profil->id || Auth::user()->role == "admin") {
                        $actionBtn .= '<a href="' . url('deteksi-ibu-melahirkan-stunting/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    }

                    return $actionBtn;

                    $actionBtn = '<a href=" ' . url('deteksi-ibu-melahirkan-stunting' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a><a href="' . url('deteksi-ibu-melahirkan-stunting/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'nama_ibu', 'nakes', 'status', 'kategori', 'tanggal_dibuat', 'tanggal_validasi'])
                ->make(true);
        }
        return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        $daftarSoal = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.create', compact('kartuKeluarga', 'daftarSoal'));
    }

    public function proses(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => 'required',
                'nama_ibu' => 'required',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_ibu.required' => 'Nama Ibu Tidak Boleh Kosong',
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

        $deteksiIbuMelahirkanStunting = new DeteksiIbuMelahirkanStunting();
        $deteksiIbuMelahirkanStunting->anggota_keluarga_id = $request->nama_ibu;
        $deteksiIbuMelahirkanStunting->kategori = $data['kategori'];
        if ($role == 'bidan') {
            $deteksiIbuMelahirkanStunting->bidan_id = Auth::user()->profil->id;
            $deteksiIbuMelahirkanStunting->tanggal_validasi = Carbon::now();
            $deteksiIbuMelahirkanStunting->is_valid = 1;
        } else if ($role == 'admin') {
            $deteksiIbuMelahirkanStunting->bidan_id = $request->nama_bidan;
            $deteksiIbuMelahirkanStunting->tanggal_validasi = Carbon::now();
            $deteksiIbuMelahirkanStunting->is_valid = 1;
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

        $namaAyah = AnggotaKeluarga::where('kartu_keluarga_id', $deteksiIbuMelahirkanStunting->AnggotaKeluarga->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga', 'SUAMI')->first();
        $data = [
            'nama_ibu' => $deteksiIbuMelahirkanStunting->anggotaKeluarga->nama_lengkap ?? '-',
            'tanggal_lahir' => $tanggalLahir,
            'usia' => $usia,
            'tanggal_validasi' => $tanggalValidasi ?? '-',
            'desa_kelurahan' => $deteksiIbuMelahirkanStunting->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'bidan' => $deteksiIbuMelahirkanStunting->bidan->nama_lengkap,
            'kategori' => $deteksiIbuMelahirkanStunting->kategori,
            'tanggal_proses' => $tanggalProses
        ];

        $daftarSoal = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->get();
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
        $kartuKeluarga = KartuKeluarga::latest()->get();
        $daftarSoal = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.edit', compact('kartuKeluarga', 'daftarSoal', 'deteksiIbuMelahirkanStunting'));
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
        //
        $deteksiIbuMelahirkanStunting->delete();

        $jawabanDeteksiIbuMelahirkanStunting = JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $deteksiIbuMelahirkanStunting->id)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
