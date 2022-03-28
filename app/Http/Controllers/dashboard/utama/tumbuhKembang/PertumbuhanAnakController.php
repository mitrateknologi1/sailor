<?php

namespace App\Http\Controllers\dashboard\utama\tumbuhKembang;

use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use App\Models\PertumbuhanAnak;
use App\Models\TumbuhKembangAnak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Response;
use App\Http\Controllers\ListController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class PertumbuhanAnakController extends Controller
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
                
                $data = PertumbuhanAnak::with('anggotaKeluarga', 'bidan')->orderBy('created_at', 'DESC');
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
                        if($row->bidan_id == -1){
                            return '<span class="badge rounded-pill bg-danger">ADMIN</span>';  
                        } else{
                        return $row->bidan->nama_lengkap;
                        }
                    })
    
                    ->addColumn('desa_kelurahan', function ($row) {     
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama;
                    })
                    
                    ->addColumn('hasil', function ($row) {  
                        if($row->hasil == 'Gizi Buruk'){
                            return '<span class="badge rounded-pill bg-danger">Gizi Buruk</span>';
                        }elseif($row->hasil == 'Gizi Kurang'){
                            return '<span class="badge rounded-pill bg-warning">Gizi Kurang</span>';
                        }elseif($row->hasil == 'Gizi Baik'){
                            return '<span class="badge rounded-pill bg-success">Gizi Baik</span>';
                        }elseif($row->hasil == 'Gizi Lebih'){
                            return '<span class="badge rounded-pill bg-primary">Gizi Lebih</span>';
                        }
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
                                    <a href="'.route('pertumbuhan-anak.edit', $row->id).'" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
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
            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.index');
        } // else keluarga
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(in_array(Auth::user()->role, ['bidan', 'admin'])){
            $data = [
                'kartuKeluarga' => KartuKeluarga::latest()->get(),
            ];
            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.create', $data);
        } // else keluarga
    }

    public function proses(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kepala_keluarga' => 'required',
                'nama_anak' => 'required',
                'berat_badan' => 'required',
            ],
            [
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'nama_anak.required' => 'Nama Anak tidak boleh kosong',
                'berat_badan.required' => 'Berat Badan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $anak = AnggotaKeluarga::find($request->nama_anak);
        $tanggalLahir = $anak->tanggal_lahir;
        $tanggalProses = $request->tanggal_proses;
        $jenisKelamin = $anak->jenis_kelamin; //Laki-laki atau Perempuan
        $beratBadan = $request->berat_badan; //dalam kilogram

        // hitung usia dalam bulan
        $usiaBulan = round(((strtotime($tanggalProses) - strtotime($tanggalLahir))/86400)/30);

        $median = 0;
        $sd = 0;
        $sd1 = 0;

        $kategoriGizi = '';

        
        if ($jenisKelamin == "LAKI-LAKI") {
            if ($usiaBulan == 0) {
                $median = 3.3;
                $sd = 2.9;
                $sd1 = 3.9;
            } else if ($usiaBulan == 1) {
                $median = 4.5;
                $sd = 3.9;
                $sd1 = 5.1;
            } else if ($usiaBulan == 2) {
                $median = 5.6;
                $sd = 4.9;
                $sd1 = 6.3;
            } else if ($usiaBulan == 3) {
                $median = 6.4;
                $sd = 5.7;
                $sd1 = 7.2;
            } else if ($usiaBulan == 4) {
                $median = 7.0;
                $sd = 6.2;
                $sd1 = 7.8;
            } else if ($usiaBulan == 5) {
                $median = 7.5;
                $sd = 6.7;
                $sd1 = 8.4;
            } else if ($usiaBulan == 6) {
                $median = 7.9;
                $sd = 7.1;
                $sd1 = 8.8;
            } else if ($usiaBulan == 7) {
                $median = 8.3;
                $sd = 7.4;
                $sd1 = 9.2;
            } else if ($usiaBulan == 8) {
                $median = 8.6;
                $sd = 7.7;
                $sd1 = 9.6;
            } else if ($usiaBulan == 9) {
                $median = 8.9;
                $sd = 8.0;
                $sd1 = 9.9;
            } else if ($usiaBulan == 10) {
                $median = 9.2;
                $sd = 8.2;
                $sd1 = 10.2;
            } else if ($usiaBulan == 11) {
                $median = 9.4;
                $sd = 8.4;
                $sd1 = 10.5;
            } else if ($usiaBulan == 12) {
                $median = 9.6;
                $sd = 8.6;
                $sd1 = 10.8;
            } else if ($usiaBulan == 13) {
                $median = 9.9;
                $sd = 8.8;
                $sd1 = 11.0;
            } else if ($usiaBulan == 14) {
                $median = 10.1;
                $sd = 9.0;
                $sd1 = 11.3;
            } else if ($usiaBulan == 15) {
                $median = 10.3;
                $sd = 9.2;
                $sd1 = 11.5;
            } else if ($usiaBulan == 16) {
                $median = 10.5;
                $sd = 9.4;
                $sd1 = 11.7;
            } else if ($usiaBulan == 17) {
                $median = 10.7;
                $sd = 9.6;
                $sd1 = 12.0;
            } else if ($usiaBulan == 18) {
                $median = 10.9;
                $sd = 9.8;
                $sd1 = 12.2;
            } else if ($usiaBulan == 19) {
                $median = 11.1;
                $sd = 10.0;
                $sd1 = 12.5;
            } else if ($usiaBulan == 20) {
                $median = 11.3;
                $sd = 10.1;
                $sd1 = 12.7;
            } else if ($usiaBulan == 21) {
                $median = 11.5;
                $sd = 10.3;
                $sd1 = 12.9;
            } else if ($usiaBulan == 22) {
                $median = 11.8;
                $sd = 10.5;
                $sd1 = 13.2;
            } else if ($usiaBulan == 23) {
                $median = 12.0;
                $sd = 10.7;
                $sd1 = 13.4;
            } else if ($usiaBulan == 24) {
                $median = 12.2;
                $sd = 10.8;
                $sd1 = 13.6;
            } else if ($usiaBulan == 25) {
                $median = 12.4;
                $sd = 11.0;
                $sd1 = 13.9;
            } else if ($usiaBulan == 26) {
                $median = 12.5;
                $sd = 11.2;
                $sd1 = 14.1;
            } else if ($usiaBulan == 27) {
                $median = 12.7;
                $sd = 11.3;
                $sd1 = 14.3;
            } else if ($usiaBulan == 28) {
                $median = 12.9;
                $sd = 11.5;
                $sd1 = 14.5;
            } else if ($usiaBulan == 29) {
                $median = 13.1;
                $sd = 11.7;
                $sd1 = 14.8;
            } else if ($usiaBulan == 30) {
                $median = 13.3;
                $sd = 11.8;
                $sd1 = 15.0;
            } else if ($usiaBulan == 31) {
                $median = 13.5;
                $sd = 12.0;
                $sd1 = 15.2;
            } else if ($usiaBulan == 32) {
                $median = 13.7;
                $sd = 12.1;
                $sd1 = 15.4;
            } else if ($usiaBulan == 33) {
                $median = 13.8;
                $sd = 12.3;
                $sd1 = 15.6;
            } else if ($usiaBulan == 34) {
                $median = 14.0;
                $sd = 12.4;
                $sd1 = 15.8;
            } else if ($usiaBulan == 35) {
                $median = 14.2;
                $sd = 12.6;
                $sd1 = 16.0;
            } else if ($usiaBulan == 36) {
                $median = 14.3;
                $sd = 12.7;
                $sd1 = 16.2;
            } else if ($usiaBulan == 37) {
                $median = 14.5;
                $sd = 12.9;
                $sd1 = 16.2;
            } else if ($usiaBulan == 38) {
                $median = 14.7;
                $sd = 13.0;
                $sd1 = 16.4;
            } else if ($usiaBulan == 39) {
                $median = 14.8;
                $sd = 13.1;
                $sd1 = 16.6;
            } else if ($usiaBulan == 40) {
                $median = 15.0;
                $sd = 13.3;
                $sd1 = 16.8;
            } else if ($usiaBulan == 41) {
                $median = 15.2;
                $sd = 13.4;
                $sd1 = 17.0;
            } else if ($usiaBulan == 42) {
                $median = 15.3;
                $sd = 13.6;
                $sd1 = 17.2;
            } else if ($usiaBulan == 43) {
                $median = 15.5;
                $sd = 13.7;
                $sd1 = 17.4;
            } else if ($usiaBulan == 44) {
                $median = 15.7;
                $sd = 13.8;
                $sd1 = 17.8;
            } else if ($usiaBulan == 45) {
                $median = 15.8;
                $sd = 14.0;
                $sd1 = 18.0;
            } else if ($usiaBulan == 46) {
                $median = 16.0;
                $sd = 14.1;
                $sd1 = 18.2;
            } else if ($usiaBulan == 47) {
                $median = 16.2;
                $sd = 14.3;
                $sd1 = 18.4;
            } else if ($usiaBulan == 48) {
                $median = 16.3;
                $sd = 14.4;
                $sd1 = 18.6;
            } else if ($usiaBulan == 49) {
                $median = 16.5;
                $sd = 14.5;
                $sd1 = 18.8;
            } else if ($usiaBulan == 50) {
                $median = 16.7;
                $sd = 14.7;
                $sd1 = 19.0;
            } else if ($usiaBulan == 51) {
                $median = 16.8;
                $sd = 14.8;
                $sd1 = 19.2;
            } else if ($usiaBulan == 52) {
                $median = 17.0;
                $sd = 15.0;
                $sd1 = 19.4;
            } else if ($usiaBulan == 53) {
                $median = 17.2;
                $sd = 15.1;
                $sd1 = 19.6;
            } else if ($usiaBulan == 54) {
                $median = 17.3;
                $sd = 15.2;
                $sd1 = 19.8;
            } else if ($usiaBulan == 55) {
                $median = 17.5;
                $sd = 15.4;
                $sd1 = 20.0;
            } else if ($usiaBulan == 56) {
                $median = 17.7;
                $sd = 15.5;
                $sd1 = 20.2;
            } else if ($usiaBulan == 57) {
                $median = 17.8;
                $sd = 15.6;
                $sd1 = 20.4;
            } else if ($usiaBulan == 58) {
                $median = 18.0;
                $sd = 15.8;
                $sd1 = 20.6;
            } else if ($usiaBulan == 59) {
                $median = 18.2;
                $sd = 15.9;
                $sd1 = 20.8;
            } else {
                $median = 18.3;
                $sd = 16.0;
                $sd1 = 21.0;
            }
        }
        if ($jenisKelamin == "PEREMPUAN") {
            if ($usiaBulan == 0) {
                $median = 3.2;
                $sd = 2.8;
                $sd1 = 3.7;
            } else if ($usiaBulan == 1) {
                $median = 4.2;
                $sd = 3.6;
                $sd1 = 4.8;
            } else if ($usiaBulan == 2) {
                $median = 5.1;
                $sd = 4.5;
                $sd1 = 5.8;
            } else if ($usiaBulan == 3) {
                $median = 5.8;
                $sd = 5.2;
                $sd1 = 6.6;
            } else if ($usiaBulan == 4) {
                $median = 6.4;
                $sd = 5.7;
                $sd1 = 7.3;
            } else if ($usiaBulan == 5) {
                $median = 6.9;
                $sd = 6.1;
                $sd1 = 7.8;
            } else if ($usiaBulan == 6) {
                $median = 7.3;
                $sd = 6.5;
                $sd1 = 8.2;
            } else if ($usiaBulan == 7) {
                $median = 7.6;
                $sd = 6.8;
                $sd1 = 8.6;
            } else if ($usiaBulan == 8) {
                $median = 7.9;
                $sd = 7.0;
                $sd1 = 9.0;
            } else if ($usiaBulan == 9) {
                $median = 8.2;
                $sd = 7.3;
                $sd1 = 9.3;
            } else if ($usiaBulan == 10) {
                $median = 8.5;
                $sd = 7.5;
                $sd1 = 9.6;
            } else if ($usiaBulan == 11) {
                $median = 8.7;
                $sd = 7.7;
                $sd1 = 9.9;
            } else if ($usiaBulan == 12) {
                $median = 8.9;
                $sd = 7.9;
                $sd1 = 10.1;
            } else if ($usiaBulan == 13) {
                $median = 9.2;
                $sd = 8.1;
                $sd1 = 10.4;
            } else if ($usiaBulan == 14) {
                $median = 9.4;
                $sd = 8.3;
                $sd1 = 10.6;
            } else if ($usiaBulan == 15) {
                $median = 9.6;
                $sd = 8.5;
                $sd1 = 10.9;
            } else if ($usiaBulan == 16) {
                $median = 9.8;
                $sd = 8.7;
                $sd1 = 11.1;
            } else if ($usiaBulan == 17) {
                $median = 10.0;
                $sd = 8.9;
                $sd1 = 11.4;
            } else if ($usiaBulan == 18) {
                $median = 10.2;
                $sd = 9.1;
                $sd1 = 11.6;
            } else if ($usiaBulan == 19) {
                $median = 10.4;
                $sd = 9.2;
                $sd1 = 11.8;
            } else if ($usiaBulan == 20) {
                $median = 10.6;
                $sd = 9.4;
                $sd1 = 12.1;
            } else if ($usiaBulan == 21) {
                $median = 10.9;
                $sd = 9.6;
                $sd1 = 12.3;
            } else if ($usiaBulan == 22) {
                $median = 11.1;
                $sd = 9.8;
                $sd1 = 12.5;
            } else if ($usiaBulan == 23) {
                $median = 11.3;
                $sd = 10.0;
                $sd1 = 12.8;
            } else if ($usiaBulan == 24) {
                $median = 11.5;
                $sd = 10.2;
                $sd1 = 13.0;
            } else if ($usiaBulan == 25) {
                $median = 11.7;
                $sd = 10.3;
                $sd1 = 13.3;
            } else if ($usiaBulan == 26) {
                $median = 11.9;
                $sd = 10.5;
                $sd1 = 13.5;
            } else if ($usiaBulan == 27) {
                $median = 12.1;
                $sd = 10.7;
                $sd1 = 13.7;
            } else if ($usiaBulan == 28) {
                $median = 12.3;
                $sd = 10.9;
                $sd1 = 14.0;
            } else if ($usiaBulan == 29) {
                $median = 12.5;
                $sd = 11.1;
                $sd1 = 14.2;
            } else if ($usiaBulan == 30) {
                $median = 12.7;
                $sd = 11.2;
                $sd1 = 14.4;
            } else if ($usiaBulan == 31) {
                $median = 12.9;
                $sd = 11.4;
                $sd1 = 14.7;
            } else if ($usiaBulan == 32) {
                $median = 13.1;
                $sd = 11.6;
                $sd1 = 14.9;
            } else if ($usiaBulan == 33) {
                $median = 13.3;
                $sd = 11.7;
                $sd1 = 15.1;
            } else if ($usiaBulan == 34) {
                $median = 13.5;
                $sd = 11.9;
                $sd1 = 15.4;
            } else if ($usiaBulan == 35) {
                $median = 13.7;
                $sd = 12.0;
                $sd1 = 15.6;
            } else if ($usiaBulan == 36) {
                $median = 13.9;
                $sd = 12.2;
                $sd1 = 15.8;
            } else if ($usiaBulan == 37) {
                $median = 14.0;
                $sd = 12.4;
                $sd1 = 16.0;
            } else if ($usiaBulan == 38) {
                $median = 14.2;
                $sd = 12.5;
                $sd1 = 16.3;
            } else if ($usiaBulan == 39) {
                $median = 14.4;
                $sd = 12.7;
                $sd1 = 16.5;
            } else if ($usiaBulan == 40) {
                $median = 14.6;
                $sd = 12.8;
                $sd1 = 16.7;
            } else if ($usiaBulan == 41) {
                $median = 14.8;
                $sd = 13.0;
                $sd1 = 16.9;
            } else if ($usiaBulan == 42) {
                $median = 15.0;
                $sd = 13.1;
                $sd1 = 17.2;
            } else if ($usiaBulan == 43) {
                $median = 15.2;
                $sd = 13.3;
                $sd1 = 17.4;
            } else if ($usiaBulan == 44) {
                $median = 15.3;
                $sd = 13.4;
                $sd1 = 17.6;
            } else if ($usiaBulan == 45) {
                $median = 15.5;
                $sd = 13.6;
                $sd1 = 17.8;
            } else if ($usiaBulan == 46) {
                $median = 15.7;
                $sd = 13.7;
                $sd1 = 18.1;
            } else if ($usiaBulan == 47) {
                $median = 15.9;
                $sd = 13.9;
                $sd1 = 18.3;
            } else if ($usiaBulan == 48) {
                $median = 16.1;
                $sd = 14.0;
                $sd1 = 18.5;
            } else if ($usiaBulan == 49) {
                $median = 16.3;
                $sd = 14.2;
                $sd1 = 18.8;
            } else if ($usiaBulan == 50) {
                $median = 16.4;
                $sd = 14.3;
                $sd1 = 19.0;
            } else if ($usiaBulan == 51) {
                $median = 16.6;
                $sd = 14.5;
                $sd1 = 19.2;
            } else if ($usiaBulan == 52) {
                $median = 16.8;
                $sd = 14.6;
                $sd1 = 19.4;
            } else if ($usiaBulan == 53) {
                $median = 17.0;
                $sd = 14.8;
                $sd1 = 19.7;
            } else if ($usiaBulan == 54) {
                $median = 17.2;
                $sd = 14.9;
                $sd1 = 19.9;
            } else if ($usiaBulan == 55) {
                $median = 17.3;
                $sd = 15.1;
                $sd1 = 20.1;
            } else if ($usiaBulan == 56) {
                $median = 17.5;
                $sd = 15.2;
                $sd1 = 20.3;
            } else if ($usiaBulan == 57) {
                $median = 17.7;
                $sd = 15.3;
                $sd1 = 20.6;
            } else if ($usiaBulan == 58) {
                $median = 17.9;
                $sd = 15.5;
                $sd1 = 20.8;
            } else if ($usiaBulan == 59) {
                $median = 18.0;
                $sd = 15.6;
                $sd1 = 21.0;
            } else {
                $median = 18.2;
                $sd = 15.8;
                $sd1 = 21.2;
            }
        }

        if ($beratBadan > $median) {
            $ZScore = ($beratBadan - $median) / ($sd1 - $median);
        } else if ($beratBadan < $median) {
            $ZScore = ($beratBadan - $median) / ($median - $sd);
        } else if ($beratBadan == $median) {
            $ZScore = ($beratBadan - $median) / $median;
        }

        if ($ZScore < -3) {
            $kategoriGizi = "Gizi Buruk";
        } else if ($ZScore < -3 || $ZScore <= -2) {
            $kategoriGizi = "Gizi Kurang";
        } else if ($ZScore < -2 || $ZScore <= 2) {
            $kategoriGizi = "Gizi Baik";
        } else if ($ZScore > 2) {
            $kategoriGizi = "Gizi Lebih";
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
            'berat_badan' => $beratBadan,
            'jenis_kelamin' => $jenisKelamin,
            'zscore' =>  number_format($ZScore, 2, '.', ''),
            'kategori' => $kategoriGizi
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePertumbuhanAnakRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataAnak = $this->proses($request);
        if(Auth::user()->role == 'admin'){
            $bidan_id = -1;
        } else if (Auth::user()->role == 'bidan') {
            $bidan_id = Auth::user()->profil->id;  
        }
        $pertumbuhanAnak = [
            'anggota_keluarga_id' => $dataAnak['anggota_keluarga_id'],
            'bidan_id' => $bidan_id,
            'berat_badan' => $dataAnak['berat_badan'],
            'zscore' => $dataAnak['zscore'],
            'hasil' => $dataAnak['kategori'],
            'is_valid' => 1,
            'tanggal_validasi' => Carbon::now()
        ];

        PertumbuhanAnak::create($pertumbuhanAnak);
        return response()->json([
            'res' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function show(PertumbuhanAnak $pertumbuhanAnak)
    {
        $datetime1 = date_create($pertumbuhanAnak->created_at);
        $datetime2 = date_create($pertumbuhanAnak->anggotaKeluarga->tanggal_lahir);
        $interval = date_diff($datetime1, $datetime2);
        $usia =  $interval->format('%y Tahun %m Bulan %d Hari');

        $data = [
            'tanggal_proses' => $pertumbuhanAnak->created_at,
            'nama_anak' => $pertumbuhanAnak->anggotaKeluarga->nama_lengkap,
            'nama_ayah' => $pertumbuhanAnak->anggotaKeluarga->nama_ayah,
            'nama_ibu' => $pertumbuhanAnak->anggotaKeluarga->nama_ibu,
            'tanggal_lahir' => $pertumbuhanAnak->anggotaKeluarga->tanggal_lahir,
            'usia_tahun' => $usia,
            'berat_badan' => $pertumbuhanAnak->berat_badan,
            'jenis_kelamin' => $pertumbuhanAnak->anggotaKeluarga->jenis_kelamin,
            'zscore' =>  $pertumbuhanAnak->zscore,
            'kategori' => $pertumbuhanAnak->hasil,
            'desa_kelurahan' => $pertumbuhanAnak->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama,
            'tanggal_validasi' => $pertumbuhanAnak->tanggal_validasi,
            'bidan' => $pertumbuhanAnak->bidan->nama_lengkap

            // 'usia_bulan' => $pertumbuhanAnak->anggotaKeluarga->usia_bulan,

        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function edit(PertumbuhanAnak $pertumbuhanAnak)
    {

        if((Auth::user()->profil->id == $pertumbuhanAnak->bidan_id) || (Auth::user()->role == 'admin')){
            $data = [
                'anak' => PertumbuhanAnak::where('id', $pertumbuhanAnak->id)->first(),
                'kartuKeluarga' => KartuKeluarga::latest()->get(),
            ];
            return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.edit', $data);
        } else{
            // 404
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePertumbuhanAnakRequest  $request
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PertumbuhanAnak $pertumbuhanAnak)
    {
        $dataAnakBaru = $this->proses($request);
        
        $pertumbuhanAnakUpdate = [
            'anggota_keluarga_id' => $dataAnakBaru['anggota_keluarga_id'],
            'bidan_id' => $pertumbuhanAnak->bidan_id,
            'berat_badan' => $dataAnakBaru['berat_badan'],
            'zscore' => $dataAnakBaru['zscore'],
            'hasil' => $dataAnakBaru['kategori'],
            'is_valid' => 1,
            'tanggal_validasi' => Carbon::now()
        ];

        PertumbuhanAnak::where('id', $pertumbuhanAnak->id)
            ->update($pertumbuhanAnakUpdate);

        return response()->json([
            'res' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function destroy(PertumbuhanAnak $pertumbuhanAnak)
    {
        if((Auth::user()->profil->id == $pertumbuhanAnak->bidan_id) || (Auth::user()->role == 'admin')){
            $pertumbuhanAnak->delete();
            return response()->json([
                'res' => 'success'
            ]);
        } else{
            // 404
            return abort(404);
        }
    }
}
