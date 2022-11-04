<?php

namespace App\Http\Controllers\dashboard\masterData\profil;

use App\Models\User;
use App\Models\Agama;
use App\Models\Penyuluh;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\LokasiTugas;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePenyuluhRequest;
use App\Http\Requests\UpdatePenyuluhRequest;

class PenyuluhController extends Controller
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
        if (in_array(Auth::user()->role, ['admin', 'bidan', 'penyuluh'])) {
            if ($request->ajax()) {
                $data = Penyuluh::with('provinsi', 'kabupatenKota', 'kecamatan', 'desaKelurahan', 'lokasiTugas', 'agama');

                // Filter
                $data->where(function ($query) use ($request) {
                    if ($request->lokasiTugas) {
                        if ($request->lokasiTugas != '-') {
                            $query->whereHas('lokasiTugas', function ($query) use ($request) {
                                $query->where('jenis_profil', 'penyuluh');
                                $query->where('desa_kelurahan_id', $request->lokasiTugas);
                            });
                        } else {
                            $query->whereDoesntHave('lokasiTugas', function ($query) use ($request) {
                                $query->where('jenis_profil', 'penyuluh');
                            });
                        }
                    }
                });

                $data->where(function ($query) use ($request) {
                    if ($request->search) {
                        $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                    }
                });

                $data->orderBy('created_at', 'DESC');
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

                    ->addColumn('lokasi_tugas', function ($row) {
                        if ($row->lokasiTugas->pluck('desaKelurahan.nama')->implode(', ') == null) {
                            if (Auth::user()->role == 'admin') {
                                return '<a href="' . route('lokasiTugasPenyuluh', $row->id) . '" class="btn btn-sm btn-primary text-white shadow"><i class="fa-solid fa-map-location-dot"></i> Tentukan Lokasi Tugas</a>';
                            } else {
                                return '<span class="badge rounded bg-danger">Lokasi Tugas Belum Ditentukan</span';
                            }
                        } else {
                            return $row->lokasiTugas->pluck('desaKelurahan.nama')->implode(', ');
                        }
                    })

                    ->addColumn('action', function ($row) {
                        $actionBtn = '<div class="text-center justify-content-center text-white">';
                        $actionBtn .= '<button id="btn-lihat" class="btn btn-primary btn-sm me-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Lihat" value="' . $row->id . '"><i class="fas fa-eye"></i></button>';
                        if (Auth::user()->role == 'admin') {
                            $actionBtn .= '<a href="' . route('lokasiTugasPenyuluh', $row->id) . '" id="btn-edit" class="btn btn-primary btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Lokasi Tugas"><i class="fa-solid fa-map-location-dot"></i></a> <a href="' . route('penyuluh.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a> <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" data-toggle="tooltip" data-placement="top" title="Hapus" value="' . $row->id . '"><i class="fas fa-trash"></i></button>';
                        }
                        $actionBtn .= '</div>';
                        return $actionBtn;
                    })

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

            $dataFilter = [
                'lokasiTugas' => LokasiTugas::with('desaKelurahan')
                    ->where('jenis_profil', 'penyuluh')
                    ->groupBy('desa_kelurahan_id')
                    ->get(),
            ];

            return view('dashboard.pages.masterData.profil.penyuluh.index', $dataFilter);
        } else {
            abort(403, 'Anda tidak memiliki akses');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $data = [
            'users' => User::with('penyuluh', 'penyuluh')->where('role', 'penyuluh')
                ->whereDoesntHave('penyuluh')
                ->get(),
            'agama' => Agama::all(),
            'provinsi' => Provinsi::orderBy('nama', 'ASC')->get(),
        ];
        return view('dashboard.pages.masterData.profil.penyuluh.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenyuluhRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'nik' => 'required|unique:penyuluh,nik,NULL,id,deleted_at,NULL|digits:16',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'tujuh_angka_terakhir_str' => 'required|min:7',
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
                'tujuh_angka_terakhir_str.required' => 'Tujuh angka terakhir STR tidak boleh kosong',
                'tujuh_angka_terakhir_str.min' => 'Tujuh angka terakhir STR tidak boleh kurang dari 7 digit',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                'nomor_hp.unique' => 'Nomor HP sudah terdaftar',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 13 digit',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'foto_profil.image' => 'Foto profil harus berupa gambar',
                'foto_profil.max' => 'Foto profil tidak boleh lebih dari 3MB',

            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user = User::find($request->user_id);

        $data = [
            'user_id' => $request->user_id,
            'nik' => $request->nik,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'jenis_kelamin' => strtoupper($request->jenis_kelamin),
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'agama_id' => $request->agama,
            'tujuh_angka_terakhir_str' => $request->tujuh_angka_terakhir_str,
            'nomor_hp' => $user->nomor_hp,
            'email' => $request->email,
            'alamat' => strtoupper($request->alamat),
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
        ];

        if ($request->file('foto_profil')) {
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/penyuluh/',
                $request->nik .
                    '.' . $request->file('foto_profil')->extension()
            );
            $data['foto_profil'] = $request->nik .
                '.' . $request->file('foto_profil')->extension();
        }

        Penyuluh::create($data);

        User::where('id', $request->user_id)->update([
            'nik' => $request->nik,
            'nomor_hp' => $user->nomor_hp,
        ]);

        $new_penyuluh_id = Penyuluh::latest()->first()->id;
        return response()->json(['success' => 'Berhasil', 'new_penyuluh_id' => $new_penyuluh_id]);
    }

    public function getLokasiTugasPenyuluh(Penyuluh $penyuluh)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $listProvinsi = $penyuluh->lokasiTugas()->get()->pluck('provinsi_id');
        $listKecamatan = $penyuluh->lokasiTugas()->get()->pluck('kabupaten_kota_id');
        $listDesaKelurahan = $penyuluh->lokasiTugas()->get()->pluck('kecamatan_id');
        $data = [
            'penyuluh' => $penyuluh,
            'provinsi' => Provinsi::orderBy('nama', 'ASC')->get(),
            'kabupatenKota' => KabupatenKota::whereIn('provinsi_id', $listProvinsi)->get(),
            'kecamatan' => Kecamatan::whereIn('kabupaten_kota_id', $listKecamatan)->get(),
            'desaKelurahan' => DesaKelurahan::whereIn('kecamatan_id', $listDesaKelurahan)->get(),
        ];
        return view('dashboard.pages.masterData.profil.penyuluh.lokasiTugas', $data);
    }

    public function updateLokasiTugasPenyuluh(Request $request, Penyuluh $penyuluh)
    {
        if ($request->provinsi) {
            if (in_array(null, $request->provinsi) || in_array(null, $request->kabupaten_kota) || in_array(null, $request->kecamatan) || in_array(null, $request->desa_kelurahan)) {
                return response()->json([
                    'res' => 'Tidak Lengkap',
                    'msg' => 'Terdapat lokasi tugas yang tidak terisi lengkap. Silahkan lengkapi terlebih dahulu atau hapus lokasi tugas tersebut.'
                ]);
            } else {
                $penyuluh->lokasiTugas()->delete();
                foreach ($request->provinsi as $key => $value) {
                    $data = [
                        'jenis_profil' => 'penyuluh',
                        'profil_id' => $penyuluh->id,
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
        } else {
            $penyuluh->lokasiTugas()->delete();

            return response()->json([
                'res' => 'Lokasi Tugas Kosong',
                'msg' => 'Lokasi tugas penyuluh dikosongkan',
                'data' => $request,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function show(Penyuluh $penyuluh)
    {
        $penyuluh = $penyuluh;
        $penyuluh['agama_'] = $penyuluh->agama->agama;
        $penyuluh['lokasiTugas'] = $penyuluh->lokasiTugas->pluck('desaKelurahan.nama')->implode(', ');
        $penyuluh['provinsi_nama'] = $penyuluh->provinsi->nama;
        $penyuluh['kabupaten_kota_nama'] = $penyuluh->kabupatenKota->nama;
        $penyuluh['kecamatan_nama'] = $penyuluh->kecamatan->nama;
        $penyuluh['desa_kelurahan_nama'] = $penyuluh->desaKelurahan->nama;
        return $penyuluh;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyuluh $penyuluh)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $data = [
            'penyuluh' => Penyuluh::select('*', DB::raw('DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") AS tanggal_lahir'))
                ->where('id', $penyuluh->id)
                ->first(),
            'users' => User::with('penyuluh')->where('role', 'penyuluh')
                ->whereDoesntHave('penyuluh')
                ->get(),
            'agama' => Agama::all(),
            'provinsi' => Provinsi::orderBy('nama', 'ASC')->get(),
            'kabupatenKota' => KabupatenKota::where('provinsi_id', $penyuluh->provinsi_id)->get(),
            'kecamatan' => Kecamatan::where('kabupaten_kota_id', $penyuluh->kabupaten_kota_id)->get(),
            'desaKelurahan' => DesaKelurahan::where('kecamatan_id', $penyuluh->kecamatan_id)->get(),
        ];
        return view('dashboard.pages.masterData.profil.penyuluh.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenyuluhRequest  $request
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penyuluh $penyuluh)
    {
        $validateFotoProfil = '';
        if ($request->file('foto_profil')) {
            $fileName = $request->file('foto_profil');
            if ($fileName != $penyuluh->foto_profil) {
                $validateFotoProfil = 'required|image|file|max:3072';
            }
        }

        $validator = Validator::make(
            $request->all(),
            [
                // 'user_id' => 'required',
                'nik' => 'required|unique:penyuluh,nik,' . $penyuluh->nik . ',nik,deleted_at,NULL|digits:16',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'tujuh_angka_terakhir_str' => 'required|min:7',
                'nomor_hp' => ['required', 'max:13', Rule::unique('users')->where(function ($query) use ($penyuluh) {
                    return $query->where('role', 'penyuluh')->whereNull('deleted_at');
                })->ignore($penyuluh->user->id)],
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
                'tujuh_angka_terakhir_str.required' => 'Tujuh angka terakhir STR tidak boleh kosong',
                'tujuh_angka_terakhir_str.min' => 'Tujuh angka terakhir STR tidak boleh kurang dari 7 digit',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 13 digit',
                'nomor_hp.unique' => 'Nomor HP sudah terdaftar',
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
            'agama_id' => $request->agama,
            'tujuh_angka_terakhir_str' => $request->tujuh_angka_terakhir_str,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
            'alamat' => strtoupper($request->alamat),
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            // 'foto_profil' => $request->nik . '.' . $request->file('foto_profil')->extension(),
        ];

        if ($request->file('foto_profil')) {
            if (Storage::exists('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil)) {
                Storage::delete('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil);
            }
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/penyuluh/',
                $request->nik .
                    '.' . $request->file('foto_profil')->extension()
            );
            $data['foto_profil'] = $request->nik . '.' . $request->file('foto_profil')->extension();
        }

        $penyuluh->update($data);

        User::where('id', $penyuluh->user_id)->update([
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyuluh $penyuluh)
    {
        if (Auth::user()->role != 'admin') {
            return abort(403, 'Anda tidak memiliki akses');
        }

        if (Storage::exists('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil)) {
            Storage::delete('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil);
        }
        $penyuluh->lokasiTugas()->delete();
        $penyuluh->delete();

        return response()->json(['res' => 'success']);
    }
}
