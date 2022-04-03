<?php

namespace App\Http\Controllers\dashboard\utama\tumbuhKembang;

use App\Models\Bidan;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use App\Models\PerkembanganAnak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class PerkembanganAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(in_array(Auth::user()->role, ['bidan', 'penyuluh', 'admin'])){
            if ($request->ajax()) {
                $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
                
                $data = PerkembanganAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC');
                if(Auth::user()->role != 'admin'){ // bidan/penyuluh 
                    $data->whereHas('anggotaKeluarga', function (Builder $query) use($lokasiTugas) {
                        $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                    });
                }
                if(Auth::user()->role == 'bidan'){ // bidan
                    $data->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                }
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nakes', function ($row) {     
                        return 'belum_dibuat';
                    })
                    ->addColumn('status', function ($row) {   
                        if($row->is_valid == 1){
                            return '<span class="badge rounded-pill bg-success">Tervalidasi</span>';
                        }else{
                            return '<span class="badge rounded-pill bg-danger">Belum Divalidasi</span>';
                        }
                    })
    
                    ->addColumn('jenis_kelamin', function ($row) {   
                        return $row->anggotaKeluarga->jenis_kelamin;
                    })
    
                    ->addColumn('tanggal_lahir', function ($row) {   
                        return $row->anggotaKeluarga->tanggal_lahir;
                    })
    
                    ->addColumn('usia', function ($row) {   
                        $datetime1 = date_create($row->created_at);
                        $datetime2 = date_create($row->anggotaKeluarga->tanggal_lahir);
                        $interval = date_diff($datetime1, $datetime2);
                        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');
                        return $usia;
                    })
    
                    ->addColumn('nama_anak', function ($row) {     
                        return $row->anggotaKeluarga->nama_lengkap;
                    })
    
                    ->addColumn('nama_ayah', function ($row) {     
                        return $row->anggotaKeluarga->nama_ayah;
                    })
    
                    ->addColumn('nama_ibu', function ($row) {     
                        return $row->anggotaKeluarga->nama_ibu;
                    })
    
                    ->addColumn('bidan', function ($row) {   
                        return $row->bidan->nama_lengkap;
                    })
    
                    ->addColumn('desa_kelurahan', function ($row) {     
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    })
                   
                    ->addColumn('action', function ($row) {     
                        $actionBtn = '
                            <div class="text-center justify-content-center text-white">';
                        // if($row->)
                        $actionBtn .= '
                            <button class="btn btn-info btn-sm mr-1 my-1 text-white" data-toggle="tooltip" data-placement="top" title="Lihat" onclick=modalLihat('.$row->id.') ><i class="fas fa-eye"></i></button>';
                        if((Auth::user()->role != 'penyuluh')){
                            if(($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')){
                                $actionBtn .= '
                                    <a href="'.route('perkembangan-anak.edit', $row->id).'" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                $actionBtn .= '
                                    <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                            }
                        }
                        $actionBtn .= '
                        </div>';
                        return $actionBtn;
                    })
    
                    ->filter(function ($query) use ($request) {    
                        // if ($request->search != '') {
                        //     $query->whereHas('anggotaKeluarga', function ($query) use ($request) {
                        //         $query->where("nama_lengkap", "LIKE", "%$request->search%");
                        //     });
                        // }    
                                        
                        // if (!empty($request->status)) {
                        //     $query->where("is_valid", $request->status);
                        // }
    
                        // if (!empty($request->kategori)) {
                        //     $query->where("hasil", $request->kategori);
                        // }
                    })
                    ->rawColumns([
                        'action',
                        'status',
                        'hasil',
                        'bidan',
                        'nakes_id',
                        'nama_anak'
                    ])
                    ->make(true);
            }
            return view('dashboard.pages.utama.tumbuhKembang.perkembanganAnak.index');
        } // else keluarga
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
        if(Auth::user()->role != 'bidan'){
            $kartuKeluarga = KartuKeluarga::latest()->get();
        } else{
            $kartuKeluarga = KartuKeluarga::with('anggotaKeluarga')
                            ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                                $query->ofDataSesuaiLokasiTugas($lokasiTugas);
                            })->latest()->get();
        }
            
        if(in_array(Auth::user()->role, ['bidan', 'admin'])){
            $data = [
                'kartuKeluarga' => $kartuKeluarga,
                'bidan' => Bidan::with('user')->active()->get(),
            ];
            return view('dashboard.pages.utama.tumbuhKembang.perkembanganAnak.create', $data);
        } // else keluarga
        
    }


    public function proses(Request $request){
        if((Auth::user()->role == 'admin') && ($request->method == 'POST')){
            $namaBidan = 'required';
        } else{
            $namaBidan = '';
        }
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => 'required',
                'nama_anak' => 'required',
                'nama_bidan' => $namaBidan,
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_anak.required' => 'Nama Anak tidak boleh kosong',
                'nama_bidan.required' => 'Nama Bidan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $anak = AnggotaKeluarga::find($request->nama_anak);
        $tanggalLahir = $anak->tanggal_lahir;

        $tanggalProses = $request->tanggal_proses;
        $jenisKelamin = $anak->jenis_kelamin; //Laki-laki atau Perempuan

        // hitung usia dalam bulan
        $usiaBulan = round(((strtotime($tanggalProses) - strtotime($tanggalLahir))/86400)/30);
        $motorikKasar = '';
        $motorikHalus = '';


        if ($usiaBulan >= 0 && $usiaBulan < 6) {
            $motorikKasar = "Menggerakan beberapa bagian tubuh : tangan, kepala dan mulai belajar memiringkan tubuh";
            $motorikHalus = "Mulai mengenal suara, bentuk benda dan warna";
        } else if ($usiaBulan >= 6 && $usiaBulan < 12) {
            $motorikKasar = "Dapat menegakkan kepala, belajar tengkurap sampai dengan duduk (pada usia 8-9 bulan), memainkan ibu jari kaki";
            $motorikHalus = "Mengoceh, sudah mengenal wajah seseorang, bisa membedakan suara, belajar makan dan mengunyah";
        } else if ($usiaBulan >= 12 && $usiaBulan < 24) {
            $motorikKasar = "Belajar berjalan dan berlari, mulai bermain, dan koordinasi mata semakin baik";
            $motorikHalus = "Mulai belajar berbicara, mempunyai ketertarikan terhadap jenis-jenis benda dan mulai muncul rasa ingin tahu";
        } else if ($usiaBulan >= 24 && $usiaBulan < 48) {
            $motorikKasar = "Sudah pandai berlari, berolah raga, dan dapat meloncat";
            $motorikHalus = "Keterampilan tangan mulai membaik, pada usia 3 tahun belajar menggunting kertas, belajar bernyanyi dan membuat coretan sederhana";
        } else if ($usiaBulan >= 48 && $usiaBulan < 72) {
            $motorikKasar = "Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik";
            $motorikHalus = "Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik";
        } else if ($usiaBulan >= 72 && $usiaBulan < 108) {
            $motorikKasar = "Mampu meloncat tali setinggi 25 cm, belajar naik sepeda";
            $motorikHalus = "Menggambar dengan pola proporsional, memakai dan mengancingkan baju, menulis, lancar membaca, sudah bisa berhitung, belajar bahasa asing, mulai belajar memainkan alat musik";
        } else if ($usiaBulan >= 108 && $usiaBulan < 132) {
            $motorikKasar = "Dapat melakukan olahraga permainan seperti sepak bola, bulu tangkis, sudah lancar bersepeda";
            $motorikHalus = "Sudah pandai menyanyi, mulai mampu membuat karangan/cerita, mampu menyerap pelajarangan dengan optimal, sudah mulai belajar berdiskusi dan mengemukakan pendapat";
        } else {
            $motorikKasar = "Mampu melompat tali diatas 50 cm, mampu melakukan loncatan sejauh 1 meter, sudah terampil menggunakan peralatan";
            $motorikHalus = "Kemampuan melakukan konsentrasi belajar meningkat, mulai belajar bertanggung jawab, sengan berpetualang dan mempunyai rasa ingin tahu yang besar. Kemampuan menulis, membaca dan beralasan telah berkembang. Telah dapat membedakan tindakan baik dan buruk";
        }

        $datetime1 = date_create($tanggalProses);
        $datetime2 = date_create($tanggalLahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        
        $data = [
            'tanggal_proses' => $tanggalProses,
            'anggota_keluarga_id' => $request->nama_anak,
            'nama_anak' => $anak->nama_lengkap,
            'tanggal_lahir' => $tanggalLahir,
            'usia_bulan' => $usiaBulan,
            'usia_tahun' => $usia,
            'jenis_kelamin' => $jenisKelamin,
            'motorik_kasar' => $motorikKasar,
            'motorik_halus' => $motorikHalus,
        ];

        return $data;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePerkembanganAnakRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataAnak = $this->proses($request);
        if(Auth::user()->role == 'admin'){
            $bidan_id = $request->nama_bidan;
        } else if (Auth::user()->role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;  
        }
        $perkembanganAnak = [
            'anggota_keluarga_id' => $dataAnak['anggota_keluarga_id'],
            'bidan_id' => $bidan_id,
            'motorik_kasar' => $dataAnak['motorik_kasar'],
            'motorik_halus' => $dataAnak['motorik_halus'],
            'is_valid' => 1,
            'tanggal_validasi' => Carbon::now()
        ];

        PerkembanganAnak::create($perkembanganAnak);
        return response()->json([
            'res' => 'success'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerkembanganAnak  $perkembanganAnak
     * @return \Illuminate\Http\Response
     */
    public function show(PerkembanganAnak $perkembanganAnak)
    {
        $datetime1 = date_create($perkembanganAnak->created_at);
        $datetime2 = date_create($perkembanganAnak->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'tanggal_proses' => $perkembanganAnak->created_at,
            'motorik_kasar' => $perkembanganAnak->motorik_kasar,
            'motorik_halus' => $perkembanganAnak->motorik_halus,
            'nama_anak' => $perkembanganAnak->anggotaKeluarga->nama_lengkap,
            'nama_ayah' => $perkembanganAnak->anggotaKeluarga->nama_ayah,
            'nama_ibu' => $perkembanganAnak->anggotaKeluarga->nama_ibu,
            'tanggal_lahir' => $perkembanganAnak->anggotaKeluarga->tanggal_lahir,
            'usia_tahun' => $usia,
            'jenis_kelamin' => $perkembanganAnak->anggotaKeluarga->jenis_kelamin,
            'desa_kelurahan' => $perkembanganAnak->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'tanggal_validasi' => $perkembanganAnak->tanggal_validasi,
            'bidan' => $perkembanganAnak->bidan->nama_lengkap
            // 'usia_bulan' => $perkembanganAnak->anggotaKeluarga->usia_bulan,
        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerkembanganAnak  $perkembanganAnak
     * @return \Illuminate\Http\Response
     */
    public function edit(PerkembanganAnak $perkembanganAnak)
    {
        if((Auth::user()->profil->id == $perkembanganAnak->bidan_id) || (Auth::user()->role == 'admin')){
            $data = [
                'anak' => PerkembanganAnak::where('id', $perkembanganAnak->id)->first(),
                'kartuKeluarga' => KartuKeluarga::latest()->get(),
            ];
            return view('dashboard.pages.utama.tumbuhKembang.perkembanganAnak.edit', $data);
        } else{
            // 404
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerkembanganAnakRequest  $request
     * @param  \App\Models\PerkembanganAnak  $perkembanganAnak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PerkembanganAnak $perkembanganAnak)
    {
        $dataAnakBaru = $this->proses($request);
        
        $perkembanganAnakUpdate = [
            'anggota_keluarga_id' => $dataAnakBaru['anggota_keluarga_id'],
            'bidan_id' => $perkembanganAnak->bidan_id,
            'motorik_kasar' => $dataAnakBaru['motorik_kasar'],
            'motorik_halus' => $dataAnakBaru['motorik_halus'],
            'is_valid' => 1,
            'tanggal_validasi' => Carbon::now()
        ];

        PerkembanganAnak::where('id', $perkembanganAnak->id)
            ->update($perkembanganAnakUpdate);

        return response()->json([
            'res' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerkembanganAnak  $perkembanganAnak
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerkembanganAnak $perkembanganAnak)
    {
        if((Auth::user()->profil->id == $perkembanganAnak->bidan_id) || (Auth::user()->role == 'admin')){
            $perkembanganAnak->delete();
            return response()->json([
                'res' => 'success'
            ]);
        } else{
            // 404
            return abort(404);
        }
    }
}
