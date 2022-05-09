<?php

namespace App\Http\Controllers\dashboard\masterData\akun;

use App\Models\User;
use App\Models\Admin;
use App\Models\Bidan;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use App\Models\AnggotaKeluarga;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('bidan', 'penyuluh', 'admin', 'keluarga')
                ->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_lengkap', function ($row) {
                    if ($row->role == 'keluarga') {
                        if ($row->keluarga) {
                            return $row->keluarga->nama_lengkap;
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Belum Ada Profil</span>';
                        }
                        // return '<span class="badge rounded-pill bg-danger">Belum Ada Profil</span>';
                    } else if ($row->role == 'bidan') {
                        if ($row->bidan) {
                            return $row->bidan->nama_lengkap;
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Belum Ada Profil</span>';
                        }
                    } else if ($row->role == 'penyuluh') {
                        if ($row->penyuluh) {
                            return $row->penyuluh->nama_lengkap;
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Belum Ada Profil</span>';
                        }
                    } else if ($row->role == 'admin') {
                        if (isset($row->admin)) {
                            return $row->admin->nama_lengkap;
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Belum Ada Profil</span>';
                        }
                    }
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge rounded-pill bg-success">Aktif</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-danger">Tidak Aktif</span>';
                    }
                })

                ->addColumn('role', function ($data) {
                    if ($data->role == 'admin') {
                        return '<span class="badge rounded-pill bg-danger">Admin</span>';
                    } else if ($data->role == 'bidan') {
                        return '<span class="badge rounded-pill bg-primary">Bidan</span>';
                    } else if ($data->role == 'penyuluh') {
                        return '<span class="badge rounded-pill text-white bg-info">Penyuluh KB</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-success">Keluarga</span>';
                    }
                })

                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="text-center justify-content-center text-white">';
                    if (Auth::user()->id == 1) {
                        $actionBtn .= '
                            <a href="' . route('user.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                        if ($row->id != 1) {
                            $actionBtn .= '
                                <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                        }
                    } else {
                        if ($row->role != 'admin') {
                            $actionBtn .= '
                                    <a href="' . route('user.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                            $actionBtn .= '
                                    <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                        } else {
                            if (($row->id == Auth::user()->id)) {
                                $actionBtn .= '
                                    <a href="' . route('user.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                            }
                        }
                    }

                    $actionBtn .= '
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
                    'nama_lengkap',
                    'status',
                    'role',
                    'action'
                ])
                ->make(true);
        }
        return view('dashboard.pages.masterData.akun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.masterData.akun.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nomor_hp' => ['required', 'max:13', Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('role', $request->role)->whereNull('deleted_at');
                })],
                'kata_sandi' => 'required|min:6',
                'ulangi_kata_sandi' => 'required|same:kata_sandi',
                'role' => 'required',
                'status' => 'required',
            ],
            [
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                'nomor_hp.unique' => 'Nomor HP sudah terdaftar',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 13 karakter',
                'kata_sandi.required' => 'Kata Sandi tidak boleh kosong',
                'kata_sandi.min' => 'Kata Sandi minimal 6 karakter',
                'ulangi_kata_sandi.required' => 'Ulangi Kata Sandi tidak boleh kosong',
                'ulangi_kata_sandi.same' => 'Kata Sandi tidak sama',
                'role.required' => 'Role tidak boleh kosong',
                'status.required' => 'Status tidak boleh kosong',
            ]
        );


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'nomor_hp' => $request->nomor_hp,
            'password' => Hash::make($request->kata_sandi),
            'role' => $request->role,
            'status' => $request->status,
        ];

        User::create($data);

        return response()->json(['success' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('dashboard.pages.masterData.akun.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->id != 1) {
            if ($user->role != 'admin') {
                return view('dashboard.pages.masterData.akun.edit', compact('user'));
            } else {
                if (($user->id == Auth::user()->id)) {
                    return view('dashboard.pages.masterData.akun.edit', compact('user'));
                } else {
                    return abort(403, 'Oops! Access Forbidden');
                }
            }
        } else {
            return view('dashboard.pages.masterData.akun.edit', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nomor_hp' => ['required', 'max:13', Rule::unique('users')->where(function ($query) use ($user) {
                    return $query->where('role', $user->role)->whereNull('deleted_at');
                })->ignore($user->id)],
                // 'kata_sandi' => 'min:6',
                'ulangi_kata_sandi' => 'same:kata_sandi',
                // 'role' => 'required',
                'status' => 'required',
            ],
            [
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                'nomor_hp.unique' => 'Nomor HP sudah terdaftar',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 13 karakter',
                // 'kata_sandi.min' => 'Kata Sandi minimal 6 karakter',
                'ulangi_kata_sandi.same' => 'Kata Sandi tidak sama',
                // 'role.required' => 'Role tidak boleh kosong',
                'status.required' => 'Status tidak boleh kosong',
            ]
        );


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'nomor_hp' => $request->nomor_hp,
            // 'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->kata_sandi != '') {
            $data['password'] = Hash::make($request->kata_sandi);
        }

        User::where('id', $user->id)->update($data);

        if ($user->role == 'admin') {
            Admin::where('user_id', $user->id)->update([
                'nomor_hp' => $request->nomor_hp,
            ]);
        } else if ($user->role == 'bidan') {
            Bidan::where('user_id', $user->id)->update([
                'nomor_hp' => $request->nomor_hp,
            ]);
        } else if ($user->role == 'penyuluh') {
            Penyuluh::where('user_id', $user->id)->update([
                'nomor_hp' => $request->nomor_hp,
            ]);
        }
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        if ($user->role == 'bidan') {
            if ($user->bidan) {
                if (Storage::exists('upload/foto_profil/bidan/' . $user->bidan->foto_profil)) {
                    Storage::delete('upload/foto_profil/bidan/' . $user->bidan->foto_profil);
                }
                $user->bidan->lokasiTugas()->delete();
                $user->bidan->delete();
            }
        } else if ($user->role == 'penyuluh') {
            if ($user->penyuluh) {
                if (Storage::exists('upload/foto_profil/penyuluh/' . $user->penyuluh->foto_profil)) {
                    Storage::delete('upload/foto_profil/penyuluh/' . $user->penyuluh->foto_profil);
                }
                $user->penyuluh->lokasiTugas()->delete();
                $user->penyuluh->delete();
            }
        } else if ($user->role == 'admin') {
            if (Storage::exists('upload/foto_profil/admin/' . $user->admin->foto_profil)) {
                Storage::delete('upload/foto_profil/admin/' . $user->admin->foto_profil);
            }
            if ($user->admin) {
                $user->admin->delete();
            }
        }



        return response()->json(['res' => 'success']);
    }
}
