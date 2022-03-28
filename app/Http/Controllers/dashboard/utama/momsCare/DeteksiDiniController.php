<?php

namespace App\Http\Controllers\dashboard\utama\momsCare;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\DeteksiDini;
use App\Models\JawabanDeteksiDini;
use App\Models\KartuKeluarga;
use App\Models\SoalDeteksiDini;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DeteksiDiniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DeteksiDini::with(['anggotaKeluarga'])
                // ->where('bidan_id', auth()->user()->id)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href=" ' . url('deteksi-dini' . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a><a href="' . url('deteksi-dini/' . $row->id . '/edit') . '" id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></a><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
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
                ->addColumn('nakes', function ($row) {
                    return "Belum Ada";
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kartuKeluarga = KartuKeluarga::latest()->get();
        $daftarSoal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.momsCare.deteksiDini.create', compact('kartuKeluarga', 'daftarSoal'));
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

        $ibu = AnggotaKeluarga::find($request->nama_ibu);

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
        $role = 'Nakes';
        $data = $this->proses($request);

        $deteksiDini = new DeteksiDini();
        $deteksiDini->anggota_keluarga_id = $request->nama_ibu;
        $deteksiDini->bidan_id = 1;
        $deteksiDini->kategori = $data['kategori'];
        $deteksiDini->skor = $data['total_skor'];
        if ($role == 'Nakes') {
            $deteksiDini->is_valid = 1;
            $deteksiDini->tanggal_validasi = Carbon::now();
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

        $namaAyah = AnggotaKeluarga::where('kartu_keluarga_id', $deteksiDini->AnggotaKeluarga->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga', 'SUAMI')->first();
        $data = [
            'nama_ibu' => $deteksiDini->anggotaKeluarga->nama_lengkap ?? '-',
            'tanggal_lahir' => $tanggalLahir,
            'usia' => $usia,
            'desa_kelurahan' => '-',
            'tanggal_validasi' => $tanggalValidasi ?? '-',
            'bidan' => '-',
            'kategori' => $deteksiDini->kategori,
            'total_skor' => $deteksiDini->skor,
            'tanggal_proses' => $tanggalProses
        ];

        $daftarSoal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();
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
        $kartuKeluarga = KartuKeluarga::latest()->get();
        $daftarSoal = SoalDeteksiDini::orderBy('urutan', 'asc')->get();
        return view('dashboard.pages.utama.momsCare.deteksiDini.edit', compact('deteksiDini', 'daftarSoal', 'kartuKeluarga'));
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
        $role = 'Nakes';
        $data = $this->proses($request);

        $deteksiDini->anggota_keluarga_id = $request->nama_ibu;
        $deteksiDini->bidan_id = 1;
        $deteksiDini->kategori = $data['kategori'];
        $deteksiDini->skor = $data['total_skor'];
        if ($role == 'Nakes') {
            $deteksiDini->is_valid = 1;
            $deteksiDini->tanggal_validasi = Carbon::now();
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
        $deteksiDini->delete();

        $jawabanDeteksiDini = JawabanDeteksiDini::where('deteksi_dini_id', $deteksiDini->id)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
