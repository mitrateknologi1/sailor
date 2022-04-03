<?php

namespace App\Http\Controllers\dashboard\masterData\profil;

use App\Models\Bidan;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBidanRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdateBidanRequest;

class BidanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = Bidan::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas')->orderBy('created_at', 'DESC')->get();
        // $data2 = LokasiTugas::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')->orderBy('created_at', 'DESC')->get();
        //     dd($data2);
        if ($request->ajax()) {
            $data = Bidan::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas')->orderBy('created_at', 'DESC');
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
               
                // ->addColumn('bidan', function ($row) {     
                //     return $row->bidan->nama_lengkap;
                // })

                ->addColumn('desa_kelurahan', function ($row) {     
                    return $row->desaKelurahan->nama;
                })

                ->addColumn('kecamatan', function ($row) {     
                    return $row->kecamatan->nama;
                })

                ->addColumn('kabupaten_kota', function ($row) {     
                    return $row->kabupatenKota->nama;
                })

                ->addColumn('provinsi', function ($row) {     
                    return $row->provinsi->nama;
                })

                ->addColumn('lokasi_tugas', function ($row) { 
                    return $row->lokasiTugas->pluck('desaKelurahan.nama')->implode(', ');
                })
               
                ->addColumn('action', function ($row) {     
                        $actionBtn = '
                        <div class="text-center justify-content-center text-white">';
                        $actionBtn .= '
                            <button class="btn btn-info btn-sm mr-1 my-1 text-white" data-toggle="tooltip" data-placement="top" title="Lihat" onclick=modalLihat('.$row->id.') ><i class="fas fa-eye"></i></button>
                            <a href="'.route('lokasiTugasBidan', $row->id).'" id="btn-edit" class="btn btn-primary btn-sm mr-1 my-1 text-white" data-toggle="tooltip" data-placement="top" title="Lokasi"><i class="fa-solid fa-map-location-dot"></i></a>
                            <a href="'.route('bidan.edit', $row->id).'" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>';
                    return $actionBtn;
                })

                // ->filter(function ($query) use ($request) {    
                //     if ($request->search != '') {
                //         $query->whereHas('anggotaKeluarga', function ($query) use ($request) {
                //             $query->where("nama_lengkap", "LIKE", "%$request->search%");
                //         });
                //     }      
                                    
                //     // if (!empty($request->role)) {
                //     //     $query->whereHas('user', function ($query) use ($request) {
                //     //         $query->where('users.role', $request->role);                       
                //     //     });
                //     // }
                // })
                ->rawColumns([
                    'action',
                    'desa_kelurahan',
                    'kecamatan',
                    'kabupaten_kota',
                    'provinsi',
                    'lokasi_tugas',
                
                ])
                ->make(true);
        }
        return view('dashboard.pages.masterData.profil.bidan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.masterData.profil.bidan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBidanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBidanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bidan  $bidan
     * @return \Illuminate\Http\Response
     */
    public function show(Bidan $bidan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bidan  $bidan
     * @return \Illuminate\Http\Response
     */
    public function edit(Bidan $bidan)
    {
        //
    }
    

    public function getLokasiTugasBidan(Bidan $bidan)
    {
        $listProvinsi = $bidan->lokasiTugas()->get()->pluck('provinsi_id');
        $listKecamatan = $bidan->lokasiTugas()->get()->pluck('kabupaten_kota_id');
        $listDesaKelurahan = $bidan->lokasiTugas()->get()->pluck('kecamatan_id');
        $data = [
            'bidan' => $bidan,
            'provinsi' => Provinsi::all(),
            'kabupatenKota' => KabupatenKota::whereIn('provinsi_id', $listProvinsi)->get(),
            'kecamatan' => Kecamatan::whereIn('kabupaten_kota_id', $listKecamatan)->get(),
            'desaKelurahan' => DesaKelurahan::whereIn('kecamatan_id', $listDesaKelurahan)->get(),
        ];
        return view('dashboard.pages.masterData.profil.bidan.lokasiTugas', $data);
    }

    public function updateLokasiTugasBidan(Request $request, Bidan $bidan)
    {
        if($request->provinsi){
            if(in_array(null, $request->provinsi) || in_array(null, $request->kabupaten_kota) || in_array(null, $request->kecamatan) || in_array(null, $request->desa_kelurahan)){
                return response()->json([
                    'res' => 'Tidak Lengkap',
                    'msg' => 'Terdapat lokasi tugas yang tidak terisi lengkap. Silahkan lengkapi terlebih dahulu atau hapus lokasi tugas tersebut.'
                ]);
            } else{
                $bidan->lokasiTugas()->delete();
                // dd($request);
                // insert request provinsi, kabupaten_kota, kecamatan, desa_kelurahan
                foreach ($request->provinsi as $key => $value) {
                    $data = [
                        'jenis_profil' => 'bidan',
                        'profil_id' => $bidan->id,
                        'provinsi_id' => $request->provinsi[$key],
                        'kabupaten_kota_id' => $request->kabupaten_kota[$key],
                        'kecamatan_id' => $request->kecamatan[$key],
                        'desa_kelurahan_id' => $request->desa_kelurahan[$key],
                    ];

                    LokasiTugas::create($data);
                    
                }
                return response()->json([
                    'res' => 'Berhasil',
                    'msg' => 'Lokasi tugas berhasil disimpan.'
                ]);
            }
        } 
        else{
            return response()->json([
                'res' => 'Lokasi Tugas Kosong',
                'msg' => 'Lokasi tugas tidak boleh kosong. Minimal tambahkan 1 lokasi tugas untuk bidan.'
            ]);
        }
    
        // if(($request->provinsi) || ($request->provinsi_baru)){
        //     if($request->provinsi){
        //         if(in_array(null, $request->provinsi) || in_array(null, $request->kabupaten_kota) || in_array(null, $request->kecamatan) || in_array(null, $request->desa_kelurahan)){
        //             return response()->json([
        //                 'res' => 'Tidak Lengkap',
        //                 'msg' => 'Terdapat lokasi tugas yang tidak terisi lengkap. Silahkan lengkapi terlebih dahulu atau hapus lokasi tugas tersebut.'
        //             ]);
        //         } else{
        //             if($request->provinsi_baru){
        //                 if(in_array(null, $request->provinsi_baru) || in_array(null, $request->kabupaten_kota_baru) || in_array(null, $request->kecamatan_baru) || in_array(null, $request->desa_kelurahan_baru)){
        //                     return response()->json([
        //                         'res' => 'Tidak Lengkap',
        //                         'msg' => 'Terdapat lokasi tugas yang tidak terisi lengkap. Silahkan lengkapi terlebih dahulu atau hapus lokasi tugas tersebut.'
        //                     ]);
        //                 } else{
        //                     // Lokasi Lama + Lokasi Baru
        //                     return response()->json([
        //                         'res' => 'Berhasil',
        //                         'msg' => 'Lokasi tugas berhasil disimpan.'
        //                     ]);
        //                 }
        //             } else{
        //                 // Lokasi Lama
        //                 return response()->json([
        //                     'res' => 'Berhasil',
        //                     'msg' => 'Lokasi tugas berhasil disimpan.'
        //                 ]);
        //             }
        //         }
        //     } else{
        //         if($request->provinsi_baru){
        //             if(in_array(null, $request->provinsi_baru) || in_array(null, $request->kabupaten_kota_baru) || in_array(null, $request->kecamatan_baru) || in_array(null, $request->desa_kelurahan_baru)){
        //                 return 'ada yang kosong2';
        //             } else{
        //                 return 'berhasil2';
        //             }
        //         } else {
        //             return 'Tidak ada data';
        //         }
        //     }
    
        // } else{
        //     return 'Tidak ada data';
        // }
          

            // dd($request->desa_kelurahan);
            // $bidan->lokasiTugas()->delete();
            
            // return redirect()->route('bidan.index')->with('success', 'Lokasi tugas bidan berhasil diubah');
        // dump(count($request->provinsi));
        // dd($bidan);
        // $bidan->lokasiTugas()->detach();
        // $bidan->lokasiTugas()->attach($request->desa_kelurahan_id);
        // return redirect()->route('bidan.index')->with('success', 'Lokasi tugas bidan berhasil diubah');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBidanRequest  $request
     * @param  \App\Models\Bidan  $bidan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBidanRequest $request, Bidan $bidan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bidan  $bidan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bidan $bidan)
    {
        //
    }
}
