<?php

namespace App\Http\Controllers\dashboard\masterData\profil;

use App\Models\User;
use App\Models\Admin;
use App\Models\Bidan;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAdminRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Agama;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->id != 1){
            abort(403, 'Oops! Access Forbidden');
        }
        if ($request->ajax()) {
            $data = Admin::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan')->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()

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

                ->addColumn('agama', function ($row) {     
                    return $row->agama->agama;
                })

                ->addColumn('action', function ($row) {     
                        $actionBtn = '
                        <div class="text-center justify-content-center text-white">';
                        $actionBtn .= '
                            <button class="btn btn-info btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Lihat" onclick=modalLihat('.$row->id.')><i class="fas fa-eye"></i></button>
                            <a href="'.route('lokasiTugasBidan', $row->id).'" id="btn-edit" class="btn btn-primary btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Lokasi Tugas"><i class="fa-solid fa-map-location-dot"></i></a>
                            <a href="'.route('admin.edit', $row->id).'" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
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
        return view('dashboard.pages.masterData.profil.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->id != 1){
            abort(403, 'Oops! Access Forbidden');
        }
        $data = [
            'users' => User::with('admin')->where('role', 'admin')
            ->whereDoesntHave('admin')
            ->get(),
            'agama' => Agama::all(),
            'provinsi' => Provinsi::all(),
        ];
        return view('dashboard.pages.masterData.profil.admin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'nik' => 'required|unique:admin,nik,NULL,id,deleted_at,NULL|digits:16',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'nomor_hp' => 'required',
                // 'email' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'foto_profil' => 'image|file|max:3072'
            ],
            [
                'user_id.required' => 'Akun tidak boleh kosong',
                'nik.required' => 'NIK tidak boleh kosong',
                'nik.unique' => 'NIK sudah terdaftar',
                'nik.digits' => 'NIK harus 16 digit',
                'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
                'agama.required' => 'Agama tidak boleh kosong',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                // 'email.required' => 'Email tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                // 'foto_profil.required' => 'Foto profil tidak boleh kosong',
                'foto_profil.image' => 'Foto profil harus berupa gambar',
                'foto_profil.max' => 'Foto profil tidak boleh lebih dari 3MB',
            
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        
        $data = [
            'user_id' => $request->user_id,
            'nik' => $request->nik,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'jenis_kelamin' => strtoupper($request->jenis_kelamin),
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'agama_id' => strtoupper($request->agama),
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
            'alamat' => strtoupper($request->alamat),
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
        ];

        if($request->file('foto_profil')){
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/admin/',
                $request->nik .
                    '.' . $request->file('foto_profil')->extension()
            );
            $data['foto_profil'] = $request->nik .
                '.' . $request->file('foto_profil')->extension();
        }

        Admin::create($data);

        User::where('id', $request->user_id)->update([
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        $admin = $admin;
        $admin['agama_'] = $admin->agama->agama;
        $admin['provinsi_nama'] = $admin->provinsi->nama;
        $admin['kabupaten_kota_nama'] = $admin->kabupatenKota->nama;
        $admin['kecamatan_nama'] = $admin->kecamatan->nama;
        $admin['desa_kelurahan_nama'] = $admin->desaKelurahan->nama;
        return $admin;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $data = [
            'admin' => Admin::select('*', DB::raw('DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") AS tanggal_lahir'))
                ->where('id', $admin->id)
                ->first(),
            'users' => User::with('admin')->where('role', 'admin')
            ->whereDoesntHave('admin')
            ->get(),
            'agama' => Agama::all(),
            'provinsi' => Provinsi::all(),
            'kabupatenKota' => KabupatenKota::where('provinsi_id', $admin->provinsi_id)->get(),
            'kecamatan' => Kecamatan::where('kabupaten_kota_id', $admin->kabupaten_kota_id)->get(),
            'desaKelurahan' => DesaKelurahan::where('kecamatan_id', $admin->kecamatan_id)->get(),
        ];
        return view('dashboard.pages.masterData.profil.admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validateFotoProfil = '';
        if($request->file('foto_profil')){
            $fileName = $request->file('foto_profil');
            if($fileName != $admin->foto_profil){
                $validateFotoProfil = 'required|image|file|max:3072';
            } 
        } 

        $validator = Validator::make(
            $request->all(),
            [
                // 'user_id' => 'required',
                'nik' => 'required|unique:admin,nik,' . $admin->nik . ',nik,deleted_at,NULL|digits:16',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'nomor_hp' => 'required',
                // 'email' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'foto_profil' => $validateFotoProfil,
            ],
            [
                // 'user_id.required' => 'Akun tidak boleh kosong',
                'nik.required' => 'NIK tidak boleh kosong',
                'nik.unique' => 'NIK sudah terdaftar',
                'nik.digits' => 'NIK harus 16 digit',
                'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
                'agama.required' => 'Agama tidak boleh kosong',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                // 'email.required' => 'Email tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'foto_profil.required' => 'Foto profil tidak boleh kosong',
                'foto_profil.image' => 'Foto profil harus berupa gambar',
                'foto_profil.max' => 'Foto profil tidak boleh lebih dari 3MB',
            
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            // 'user_id' => $request->user_id,
            'nik' => $request->nik,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'jenis_kelamin' => strtoupper($request->jenis_kelamin),
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'agama_id' => strtoupper($request->agama),
            'nomor_hp' => strtoupper($request->nomor_hp),
            'email' => $request->email,
            'alamat' => strtoupper($request->alamat),
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            // 'foto_profil' => $request->nik . '.' . $request->file('foto_profil')->extension(),
        ];

        if($request->file('foto_profil')){
            if (Storage::exists('upload/foto_profil/admin/' . $admin->foto_profil)) {
                Storage::delete('upload/foto_profil/admin/' . $admin->foto_profil);
            }
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/admin/',
                $request->nik .
                    '.' . $request->file('foto_profil')->extension()
            );
            $data['foto_profil'] = $request->nik . '.' . $request->file('foto_profil')->extension();
        }

        $admin->update($data);

        User::where('id', $admin->user_id)->update([
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if (Storage::exists('upload/foto_profil/admin/' . $admin->foto_profil)) {
            Storage::delete('upload/foto_profil/admin/' . $admin->foto_profil);
        }

        $admin->delete();

        return response()->json(['res' => 'success']);
    }
}
