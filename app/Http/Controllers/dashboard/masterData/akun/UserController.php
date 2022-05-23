<?php

namespace App\Http\Controllers\dashboard\masterData\akun;

use App\Models\User;
use App\Models\Admin;
use App\Models\Bidan;
use App\Models\Penyuluh;
use Illuminate\Http\Request;
use App\Models\Pemberitahuan;
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
    public function __construct()
    {
        $this->middleware('profil_ada');
    }


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::with('bidan', 'penyuluh', 'admin', 'keluarga')
                ->where(function ($query) use ($request) {
                    if (Auth::user()->role == 'bidan') {
                        $query->where('role', 'keluarga');
                    }
                });

            // Filter
            $data->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->where('status', $request->status == 'aktif' ? 1 : 0);
                }
            });

            $data->where(function ($query) use ($request) {

                if ($request->role) {
                    $role = $request->role;
                    if (($request->role == 'kepala_keluarga') || ($request->role == 'remaja')) {
                        $role = 'keluarga';
                        if ($request->role == 'kepala_keluarga') {
                            $is_remaja = 0;
                        } else {
                            $is_remaja = 1;
                        }
                    } else {
                        $is_remaja = 0;
                    }

                    $query->where('role', $role)->where('is_remaja', $is_remaja);
                }
            });

            $data->where(function ($query) use ($request, $data) {
                if ($request->search) {
                    if (Auth::user()->role == 'admin') {
                        $query->whereHas('bidan', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });
                        $query->orWhereHas('penyuluh', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });
                        $query->orWhereHas('admin', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });
                        $query->orWhereHas('keluarga', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });
                    } else {
                        $query->whereHas('keluarga', function ($query) use ($request) {
                            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                        });
                    }
                    $query->orWhere('nomor_hp', 'like', '%' . $request->search . '%');
                }
            });

            $data->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_lengkap', function ($row) {
                    if ($row->role == 'keluarga') {
                        if ($row->keluarga) {
                            return $row->keluarga->nama_lengkap;
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Belum Ada Profil</span>';
                        }
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
                        if ($row->admin) {
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

                ->addColumn('nomor_hp', function ($data) {
                    if ($data->nomor_hp != null) {
                        return $data->nomor_hp;
                    }
                    return '-';
                })

                ->addColumn('role', function ($data) {
                    if ($data->role == 'admin') {
                        if ($data->id == '5gf9ba91-4778-404c-aa7f-5fd327e87e80') {
                            return '<span class="badge rounded-pill bg-danger">Super Admin</span>';
                        }
                        return '<span class="badge rounded-pill bg-warning">Admin</span>';
                    } else if ($data->role == 'bidan') {
                        return '<span class="badge rounded-pill bg-primary">Bidan</span>';
                    } else if ($data->role == 'penyuluh') {
                        return '<span class="badge rounded-pill text-white bg-info">Penyuluh</span>';
                    } else if ($data->role == 'keluarga') {
                        if ($data->is_remaja == 0) {
                            return '<span class="badge rounded-pill bg-success">Kepala Keluarga</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-success">Remaja</span>';
                        }
                    }
                })

                ->addColumn('bidan', function ($data) {
                    if ($data->role == 'keluarga') {
                        if ($data->keluarga->bidan) {
                            return $data->keluarga->bidan->nama_lengkap;
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Profil Belum Dikonfirmasi</span>';
                        }
                    } else {
                        return '-';
                    }
                })

                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="text-center justify-content-center text-white">';
                    if (Auth::user()->id == '5gf9ba91-4778-404c-aa7f-5fd327e87e80') {
                        $actionBtn .= '
                            <a href="' . route('user.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                        if ($row->id != '5gf9ba91-4778-404c-aa7f-5fd327e87e80') {
                            $actionBtn .= '
                                <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                        }
                    } else {
                        if ($row->role != 'admin') {
                            if (Auth::user()->role == 'bidan') {
                                if ($row->role == 'keluarga') {
                                    if ($row->keluarga->bidan_id == Auth::user()->bidan->id) {
                                        $actionBtn .= '
                                        <a href="' . route('user.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                        $actionBtn .= '
                                        <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                                    }
                                }
                            } else {
                                $actionBtn .= '
                                        <a href="' . route('user.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                $actionBtn .= '
                                        <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                            }
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
                ->rawColumns([
                    'nama_lengkap',
                    'status',
                    'role',
                    'bidan',
                    'nomor_hp',
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
        if (Auth::user()->role != 'admin') {
            abort(403, 'Oops! Anda tidak memiliki hak akses');
        }
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
        if (Auth::user()->id != '5gf9ba91-4778-404c-aa7f-5fd327e87e80') {
            if ($user->role != 'admin') {
                if ($user->role != 'keluarga') {
                    abort(403, 'Oops! Anda tidak memiliki hak akses');
                }
                return view('dashboard.pages.masterData.akun.edit', compact('user'));
            } else {
                if (($user->id == Auth::user()->id)) {
                    return view('dashboard.pages.masterData.akun.edit', compact('user'));
                } else {
                    return abort(403);
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
        if ($user->role == 'bidan') {
            if ($user->bidan) {
                if (Storage::exists('upload/foto_profil/bidan/' . $user->bidan->foto_profil)) {
                    Storage::delete('upload/foto_profil/bidan/' . $user->bidan->foto_profil);
                }
                $user->bidan->lokasiTugas()->delete();
                $user->bidan->delete();
            }
            $user->delete();
        } else if ($user->role == 'penyuluh') {
            if ($user->penyuluh) {
                if (Storage::exists('upload/foto_profil/penyuluh/' . $user->penyuluh->foto_profil)) {
                    Storage::delete('upload/foto_profil/penyuluh/' . $user->penyuluh->foto_profil);
                }
                $user->penyuluh->lokasiTugas()->delete();
                $user->penyuluh->delete();
            }
            $user->delete();
        } else if ($user->role == 'admin') {
            if ($user->admin) {
                if (Storage::exists('upload/foto_profil/admin/' . $user->admin->foto_profil)) {
                    Storage::delete('upload/foto_profil/admin/' . $user->admin->foto_profil);
                }
                $user->admin->delete();
            }
            $user->delete();
        } else if ($user->role == 'keluarga') {
            if ($user->is_remaja == 0) { //kepala keluarga\
                if (Storage::exists('upload/kartu_keluarga/' . $user->kepalaKeluarga->kartuKeluarga->file_kk)) {
                    Storage::delete('upload/kartu_keluarga/' . $user->kepalaKeluarga->kartuKeluarga->file_kk);
                }

                foreach ($user->kepalaKeluarga->kartuKeluarga->anggotaKeluarga as $anggota) {
                    if (Storage::exists('upload/foto_profil/keluarga/' . $anggota->foto_profil)) {
                        Storage::delete('upload/foto_profil/keluarga/' . $anggota->foto_profil);
                    }
                    if (Storage::exists('upload/surat_keterangan_domisili/' . $anggota->wilayahDomisili->file_ket_domisili)) {
                        Storage::delete('upload/surat_keterangan_domisili/' . $anggota->wilayahDomisili->file_ket_domisili);
                    }

                    $pemberitahuan = Pemberitahuan::where('anggota_keluarga_id', $anggota->id);

                    if ($anggota->wilayahDomisili) {
                        $anggota->wilayahDomisili->delete();
                    }

                    if ($anggota->user) {
                        $anggota->user->delete();
                    }

                    if ($pemberitahuan) {
                        $pemberitahuan->delete();
                    }


                    $anggota->delete();
                }

                $user->kepalaKeluarga->kartuKeluarga->delete();
            } else if ($user->is_remaja == 1) { //remaja

            }
        }







        return response()->json(['res' => 'success']);
    }
}
