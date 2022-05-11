<?php

namespace App\Http\Controllers\dashboard\utama\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\JawabanMencegahMalnutrisi;
use App\Models\JawabanMeningkatkanLifeSkill;
use App\Models\LokasiTugas;
use App\Models\Pemberitahuan;
use App\Models\RandaKabilasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RandaKabilasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh', 'admin'])) {
            if ($request->ajax()) {
                $lokasiTugas = LokasiTugas::ofLokasiTugas(Auth::user()->profil->id); // lokasi tugas bidan/penyuluh
                $data = RandaKabilasa::with('anggotaKeluarga', 'bidan', 'mencegahMalnutrisi')->orderBy('created_at', 'DESC')
                    ->whereHas('anggotaKeluarga', function ($query) use ($lokasiTugas) {
                        if (Auth::user()->role != 'admin') {
                            $query->ofDataSesuaiLokasiTugas($lokasiTugas); // menampilkan data keluarga yang berada di lokasi tugasnya
                        }
                    })
                    ->where(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            if ($request->status_mencegah_malnutrisi) {
                                $query->where('is_valid_mencegah_malnutrisi', $request->status_mencegah_malnutrisi == 'Tervalidasi' ? 1 : 0);
                            }
                            if ($request->status_mencegah_pernikahan_dini) {
                                $query->where('is_valid_mencegah_pernikahan_dini', $request->status_mencegah_pernikahan_dini == 'Tervalidasi' ? 1 : 0);
                            }
                            if ($request->status_meningkatkan_life_skill) {
                                $query->where('is_valid_meningkatkan_life_skill', $request->status_meningkatkan_life_skill == 'Tervalidasi' ? 1 : 0);
                            }

                            if (Auth::user()->role == 'penyuluh') {
                                $query->where('is_valid_mencegah_malnutrisi', 1);
                                $query->where('is_valid_mencegah_pernikahan_dini',  1);
                                $query->where('is_valid_meningkatkan_life_skill', 1);
                            }

                            if ($request->status_asesmen) {
                                if ($request->status_asesmen == 'belum asesmen pernikahan dini') {
                                    $query->where('is_mencegah_pernikahan_dini', 0);
                                } else if ($request->status_asesmen == 'belum asesmen meningkatkan life skill') {
                                    $query->where('is_meningkatkan_life_skill', 0);
                                } else if ($request->status_asesmen == 'belum asesmen pernikahan dini dan meningkatkan life skill') {
                                    $query->where('is_mencegah_pernikahan_dini', 0);
                                    $query->where('is_meningkatkan_life_skill', 0);
                                } else {
                                    $query->where('is_mencegah_pernikahan_dini', 1);
                                    $query->where('is_meningkatkan_life_skill', 1);
                                }
                            }

                            if ($request->kategori_hb) {
                                $query->where('kategori_hb', $request->kategori_hb);
                            }

                            if ($request->kategori_lingkar_lengan_atas) {
                                $query->where('kategori_lingkar_lengan_atas', $request->kategori_lingkar_lengan_atas);
                            }

                            if ($request->kategori_indeks_masa_tubuh) {
                                $query->where('kategori_imt', $request->kategori_indeks_masa_tubuh);
                            }

                            if ($request->asesmen_mencegah_malnutrisi) {
                                $query->where('kategori_mencegah_malnutrisi', $request->asesmen_mencegah_malnutrisi);
                            }

                            if ($request->asesmen_meningkatkan_life_skill) {
                                $query->where('kategori_meningkatkan_life_skill', $request->asesmen_meningkatkan_life_skill);
                            }

                            if ($request->asesmen_mencegah_pernikahan_dini) {
                                $query->where('kategori_mencegah_pernikahan_dini', $request->asesmen_mencegah_pernikahan_dini);
                            }
                        });

                        $query->where(function ($query) use ($request) {
                            if ($request->search) {
                                $query->whereHas('bidan', function ($query) use ($request) {
                                    $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                                });

                                $query->orWhereHas('anggotaKeluarga', function ($query) use ($request) {
                                    $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
                                });
                            }
                        });
                    })
                    ->orWhere(function ($query) {
                        if (Auth::user()->role == 'bidan') { // bidan
                            $query->orWhere('bidan_id', Auth::user()->profil->id); // menampilkan data keluarga yang dibuat olehnya
                        }
                    })->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_dibuat', function ($row) {
                        return Carbon::parse($row->created_at)->format('d M Y');
                    })
                    ->addColumn('status_mencegah_malnutrisi', function ($row) {
                        if ($row->is_valid_mencegah_malnutrisi == 0) {
                            return '<span class="badge badge-danger bg-warning">Belum Divalidasi</span>';
                        } else if ($row->is_valid_mencegah_malnutrisi == 2) {
                            return '<span class="badge badge-danger bg-danger">Ditolak</span>';
                        } else {
                            return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                        }
                    })
                    ->addColumn('status_mencegah_pernikahan_dini', function ($row) {
                        if ($row->is_valid_mencegah_pernikahan_dini == 0 && $row->is_mencegah_pernikahan_dini == 0) {
                            return '<span class="badge badge-danger bg-danger">Belum Melakukan Asesmen</span>';
                        } else if ($row->is_valid_mencegah_pernikahan_dini == 0) {
                            return '<span class="badge badge-danger bg-warning">Belum Divalidasi</span>';
                        } else if ($row->is_valid_mencegah_pernikahan_dini == 2) {
                            return '<span class="badge badge-danger bg-danger">Ditolak</span>';
                        } else {
                            return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                        }
                    })
                    ->addColumn('status_meningkatkan_life_skill', function ($row) {
                        if ($row->is_valid_meningkatkan_life_skill == 0 && $row->is_meningkatkan_life_skill == 0) {
                            return '<span class="badge badge-danger bg-danger">Belum Melakukan Asesmen</span>';
                        } else if ($row->is_valid_meningkatkan_life_skill == 0) {
                            return '<span class="badge badge-danger bg-warning">Belum Divalidasi</span>';
                        } else if ($row->is_valid_meningkatkan_life_skill == 2) {
                            return '<span class="badge badge-danger bg-danger">Ditolak</span>';
                        } else {
                            return '<span class="badge badge-success bg-success">Tervalidasi</span>';
                        }
                    })
                    ->addColumn('status_asesmen', function ($row) {
                        $statusAsesmen = '';
                        if ($row->is_mencegah_pernikahan_dini == 0) {
                            $statusAsesmen .= '<span class="badge badge-danger bg-danger">Belum Asesmen Mencegah Pernikahan Dini</span><br>';
                        }
                        if ($row->is_meningkatkan_life_skill == 0) {
                            $statusAsesmen .= '<span class="badge badge-danger bg-danger">Belum Asesmen Meningkatkan Life Skill</span><br>';
                        }
                        if ($row->is_mencegah_pernikahan_dini == 1 && $row->is_meningkatkan_life_skill == 1) {
                            $statusAsesmen .= '<span class="badge badge-success bg-success">Sudah Melakukan Seluruh Asesmen</span><br>';
                        }

                        return $statusAsesmen;
                    })
                    ->addColumn('nama_remaja', function ($row) {
                        return $row->anggotaKeluarga->nama_lengkap ?? '-';
                    })
                    ->addColumn('kategori_hb', function ($row) {
                        if ($row->kategori_hb == "Normal") {
                            return '<span class="badge badge-success bg-success">Normal</span>';
                        } else if ($row->kategori_hb == "Terindikasi Anemia") {
                            return '<span class="badge badge-warning bg-warning">Terindikasi Anemia</span>';
                        } else {
                            return '<span class="badge badge-danger bg-danger">Anemia</span>';
                        }
                    })
                    ->addColumn('kategori_lingkar_lengan_atas', function ($row) {
                        if ($row->kategori_lingkar_lengan_atas == 'Kurang Gizi') {
                            return '<span class="badge badge-danger bg-danger">Kurang Gizi</span>';
                        } else {
                            return '<span class="badge badge-success bg-success">Normal</span>';
                        }
                    })
                    ->addColumn('kategori_indeks_masa_tubuh', function ($row) {
                        if ($row->kategori_imt == 'Sangat Kurus') {
                            return '<span class="badge badge-danger bg-danger">Sangat Kurus</span>';
                        } else if ($row->kategori_imt == 'Kurus') {
                            return '<span class="badge badge-warning bg-warning">Kurus</span>';
                        } else if ($row->kategori_imt == 'Normal') {
                            return '<span class="badge badge-success bg-success">Normal</span>';
                        } else if ($row->kategori_imt == 'Gemuk') {
                            return '<span class="badge badge-warning bg-warning">Gemuk</span>';
                        } else {
                            return '<span class="badge badge-danger bg-danger">Sangat Gemuk</span>';
                        }
                    })
                    ->addColumn('kategori_mencegah_malnutrisi', function ($row) {
                        if ($row->kategori_mencegah_malnutrisi == 'Tidak Berpartisipasi Mencegah Stunting') {
                            $actionBtn = '<span class="badge badge-danger bg-danger">Tidak Berpartisipasi Mencegah Stunting</span>';
                        } else {
                            $actionBtn = '<span class="badge badge-success bg-success">Berpartisipasi Mencegah Stunting</span>';
                        }

                        $actionBtn .= '<br class="mb-2">';

                        if ($row->is_valid_mencegah_malnutrisi == 0) {
                            $actionBtn .= '<a href=" ' . url('mencegah-malnutrisi' . '/' . $row->mencegahMalnutrisi->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fa-solid fa-lg fa-clipboard-check"></i></a>';
                        } else {
                            $actionBtn .= '<a href=" ' . url('mencegah-malnutrisi' . '/' . $row->mencegahMalnutrisi->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>';
                        }
                        if (in_array(Auth::user()->role, ['bidan', 'admin'])) {
                            if (($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                // if($row->is_valid == 1){
                                //     $actionBtn .= '<a href="' . route('pertumbuhan-anak.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                // }

                                if ($row->is_valid_mencegah_malnutrisi != 0) {
                                    $actionBtn .= ' <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                                }
                            }
                        }

                        $actionBtn .= '
                        </div>';
                        return $actionBtn;
                    })
                    ->addColumn('kategori_meningkatkan_life_skill', function ($row) {
                        if ($row->is_meningkatkan_life_skill == 0) {
                            return '<a href="' . url('meningkatkan-life-skill/' . $row->id . '/create') . '" id="btn-edit" class="btn btn-success btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-plus"></i></a>';
                        } else {

                            if ($row->kategori_meningkatkan_life_skill == 'Tidak Berpartisipasi Mencegah Stunting') {
                                $actionBtn = '<span class="badge badge-danger bg-danger">Tidak Berpartisipasi Mencegah Stunting</span>';
                            } else {
                                $actionBtn = '<span class="badge badge-success bg-success">Berpartisipasi Mencegah Stunting</span>';
                            }
                            $actionBtn .= '<br class="mb-2">';

                            if ($row->is_valid_meningkatkan_life_skill == 0) {
                                $actionBtn .= '<a href=" ' . url('meningkatkan-life-skill' . '/' . $row->id . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fa-solid fa-lg fa-clipboard-check"></i></a>';
                            } else {
                                $actionBtn .= '<a href=" ' . url('meningkatkan-life-skill' . '/' . $row->id . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>';
                            }
                            if (in_array(Auth::user()->role, ['bidan', 'admin'])) {
                                if (($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                    // if($row->is_valid == 1){
                                    //     $actionBtn .= '<a href="' . route('pertumbuhan-anak.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                    // }

                                    if ($row->is_valid_meningkatkan_life_skill != 0) {
                                        $actionBtn .= ' <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                                    }
                                }
                            }

                            $actionBtn .= '
                        </div>';
                            return $actionBtn;
                        }
                    })
                    ->addColumn('kategori_mencegah_pernikahan_dini', function ($row) {
                        if (!$row->mencegahPernikahanDini) {
                            return '<a href="' . url('mencegah-pernikahan-dini/' . $row->id . '/create') . '" id="btn-edit" class="btn btn-success btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-plus"></i></a>';
                        } else {

                            if ($row->kategori_mencegah_pernikahan_dini == 'Tidak Berpartisipasi Mencegah Stunting') {
                                $actionBtn = '<span class="badge badge-danger bg-danger">Tidak Berpartisipasi Mencegah Stunting</span>';
                            } else {
                                $actionBtn = '<span class="badge badge-success bg-success">Berpartisipasi Mencegah Stunting</span>';
                            }
                            $actionBtn .= '<br class="mb-2">';

                            if ($row->is_valid_mencegah_pernikahan_dini == 0) {
                                $actionBtn .= '<a href=" ' . url('mencegah-pernikahan-dini' . '/' . $row->id . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fa-solid fa-lg fa-clipboard-check"></i></a>';
                            } else {
                                $actionBtn .= '<a href=" ' . url('mencegah-pernikahan-dini' . '/' . $row->id . '/' . $row->id) .  ' " class="btn btn-primary btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>';
                            }
                            if (in_array(Auth::user()->role, ['bidan', 'admin'])) {
                                if (($row->bidan_id == Auth::user()->profil->id) || (Auth::user()->role == 'admin')) {
                                    // if($row->is_valid == 1){
                                    //     $actionBtn .= '<a href="' . route('pertumbuhan-anak.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1 text-white shadow" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>';
                                    // }

                                    if ($row->is_valid_mencegah_pernikahan_dini != 0) {
                                        $actionBtn .= ' <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 shadow" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>';
                                    }
                                }
                            }

                            $actionBtn .= '
                        </div>';
                            return $actionBtn;
                        }
                    })
                    ->addColumn('desa_kelurahan', function ($row) {
                        return $row->anggotaKeluarga->wilayahDomisili->desaKelurahan->nama ?? '-';
                    })
                    ->addColumn('bidan', function ($row) {
                        return $row->bidan->nama_lengkap ?? '-';
                    })
                    ->addColumn('tanggal_validasi', function ($row) {
                        if ($row->tanggal_validasi) {
                            return Carbon::parse($row->tanggal_validasi)->translatedFormat('d F Y');
                        } else {
                            return '-';
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        if ($row->bidan_id == Auth::user()->profil->id || Auth::user()->role == "admin") {
                            $actionBtn .= '<button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . url('randa-kabilasa/' . $row->id)  . '" ><i class="fas fa-trash"></i></button>';
                        }

                        return $actionBtn;
                    })
                    ->rawColumns(['tanggal_dibuat', 'status_mencegah_malnutrisi', 'status_mencegah_pernikahan_dini', 'status_meningkatkan_life_skill', 'status_asesmen', 'nama_remaja', 'kategori_hb', 'kategori_lingkar_lengan_atas', 'kategori_indeks_masa_tubuh', 'kategori_mencegah_malnutrisi', 'kategori_meningkatkan_life_skill', 'kategori_mencegah_pernikahan_dini', 'desa_kelurahan', 'bidan', 'tanggal_validasi', 'action'])
                    ->make(true);
            }
            return view('dashboard.pages.utama.randaKabilasa.index');
        } else {
            $kartuKeluarga = Auth::user()->profil->kartu_keluarga_id;
            $randaKabilasa = RandaKabilasa::with('anggotaKeluarga')->whereHas('anggotaKeluarga', function ($query) use ($kartuKeluarga) {
                $query->where('kartu_keluarga_id', $kartuKeluarga);
            })->latest()->get();

            return view('dashboard.pages.utama.randaKabilasa.indexKeluarga', compact(['randaKabilasa']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function show(RandaKabilasa $randaKabilasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function edit(RandaKabilasa $randaKabilasa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RandaKabilasa $randaKabilasa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RandaKabilasa  $randaKabilasa
     * @return \Illuminate\Http\Response
     */
    public function destroy(RandaKabilasa $randaKabilasa)
    {
        if ((Auth::user()->profil->id == $randaKabilasa->bidan_id) || (Auth::user()->role == 'admin')) {
            if ($randaKabilasa->mencegahMalnutrisi) {
                $randaKabilasa->mencegahMalnutrisi()->delete();
                $jawabanMencegahMalnutrisi = JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $randaKabilasa->mencegahMalnutrisi->id)->delete();
            }

            if ($randaKabilasa->mencegahPernikahanDini) {
                $randaKabilasa->mencegahPernikahanDini()->delete();
            }
            $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $randaKabilasa->id)->delete();
            $randaKabilasa->delete();

            $pemberitahuan = Pemberitahuan::where('fitur_id', $randaKabilasa->id)
                ->where('tentang', 'randa_kabilasa');

            if ($pemberitahuan) {
                $pemberitahuan->delete();
            }

            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return abort(404);
        }
    }
}
