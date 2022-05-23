<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Agama;
use App\Models\Bidan;
use App\Models\Penyuluh;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use App\Models\DesaKelurahan;
use App\Models\GolonganDarah;
use App\Models\KabupatenKota;
use App\Models\KartuKeluarga;
use App\Models\StatusHubungan;
use Illuminate\Support\Carbon;
use App\Models\AnggotaKeluarga;
use App\Models\WilayahDomisili;
use Illuminate\Validation\Rule;
use App\Models\StatusPerkawinan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function cekLogin(Request $request)
    {
        if (($request->nomor_hp == '') || ($request->password == '')) {
            return response()->json([
                'res' => 'inputan_tidak_lengkap',
            ]);
        }

        $credentials = [
            'nomor_hp' => $request->nomor_hp,
            'password' => $request->password,
            'role' => $request->role
        ];

        $credentials2 = [
            'nik' => $request->nomor_hp,
            'password' => $request->password,
            'role' => $request->role
        ];

        if (Auth::attempt($credentials) || Auth::attempt($credentials2)) {
            if (Auth::user()->role == 'keluarga') {
                if (Auth::user()->profil->kartuKeluarga->is_valid == 0) {
                    Auth::logout();
                    return response()->json([
                        'res' => 'tidak_valid',
                        'mes' => 'Mohon maaf, data anda masih menunggu proses Validasi, silahkan coba lagi nanti. Terima Kasih.',
                    ]);
                }
                if (Auth::user()->profil->kartuKeluarga->is_valid == 2) {
                    $id = Auth::user()->profil->kartuKeluarga->id;
                    Auth::logout();
                    return response()->json([
                        'res' => 'ditolak',
                        'id' => $id,
                        'mes' => 'Mohon maaf data anda ditolak, silahkan klik tombol "Perbarui Data" untuk melihat alasan data anda ditolak dan mengirim ulang data. Terima Kasih.',
                    ]);
                }
            }

            if (Auth::user()->status == 1) {
                if (!Auth::user()->profil) {
                    return response()->json([
                        'res' => 'tidak_ada_profil',
                    ]);
                }
                $request->session()->regenerate();
                return response()->json([
                    'res' => 'berhasil',
                ]);
            } else {
                Auth::logout();
                return response()->json([
                    'res' => 'tidak_aktif',
                    'mes' => 'Akun anda dinonaktifkan, silahkan hubungi admin untuk informasi lebih lanjut.'
                ]);
            }
        }
        return response()->json([
            'res' => 'gagal',
            'mes' => 'Nomor HP / NIK beserta kata sandi yang dimasukkan tidak cocok. Silahkan cek kembali inputan anda atau klik Lupa Kata Sandi, apabila lupa kata sandi anda.',
            'data' => $credentials,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function cekRemaja()
    {
        $remaja = AnggotaKeluarga::with('user')->where('status_hubungan_dalam_keluarga_id', 4)
            ->where('tanggal_lahir', '<', Carbon::now()->subYears(10))
            ->whereDoesntHave('user')
            ->get();

        foreach ($remaja as $r) {
            $user = User::create([
                'nik' => $r->nik,
                'password' => Hash::make('12345678'),
                'role' => 'keluarga',
                'is_remaja' => 1,
                'status' => 1,
            ]);

            $r->update([
                'user_id' => $user->id,
            ]);
        }
        return $remaja;

        return Carbon::parse(now())->isoFormat('YYYY-MM-DD');
    }

    public function lengkapiProfil()
    {
        if (Auth::user()->profil) {
            return redirect('/dashboard');
        }
        $user = Auth::user();
        $data = [
            'user' => $user,
            'agama' => Agama::all(),
            'provinsi' => Provinsi::all(),
        ];
        return view('dashboard.pages.masterData.profil.lengkapiProfil.index', $data);
    }

    public function tambahProfil(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 'admin') {
            $validateSTR = 'required|min:7';
        } else {
            $validateSTR = '';
        }
        $validator = Validator::make(
            $request->all(),
            [
                'nik' => 'required|unique:bidan,nik,NULL,id,deleted_at,NULL|digits:16',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'tujuh_angka_terakhir_str' => $validateSTR,
                'nomor_hp' => ['required', 'max:13', Rule::unique('users')->where(function ($query) use ($user) {
                    return $query->where('role', $user->role)->whereNull('deleted_at');
                })->ignore($user->id)],
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'foto_profil' => 'image|file|max:3072'
            ],
            [
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
                'nomor_hp.unique' => 'Nomor HP sudah digunakan pada ' . $user->role . ' lain',
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


        $dataProfil = [
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'jenis_kelamin' => strtoupper($request->jenis_kelamin),
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'agama_id' => $request->agama,
            'nomor_hp' => $user->nomor_hp,
            'email' => $request->email,
            'alamat' => strtoupper($request->alamat),
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
        ];

        if ($user->role != 'admin') {
            $dataProfil['tujuh_angka_terakhir_str'] = $request->tujuh_angka_terakhir_str;
        }

        if ($request->file('foto_profil')) {
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/' . $user->role . '/',
                $request->nik .
                    '.' . $request->file('foto_profil')->extension()
            );
            $dataProfil['foto_profil'] = $request->nik .
                '.' . $request->file('foto_profil')->extension();
        }

        if ($user->role == 'admin') {
            Admin::create($dataProfil);
        } else if ($user->role == 'bidan') {
            Bidan::create($dataProfil);
        } else if ($user->role == 'penyuluh') {
            Penyuluh::create($dataProfil);
        }

        $dataAkun = [
            'nomor_hp' => $request->nomor_hp,
            'nik' => $request->nik,
        ];

        User::where('id', $user->id)->update($dataAkun);

        return response()->json(['success' => 'Berhasil menambahkan profil']);
    }

    public function registrasi()
    {
        $data = [
            'agama' => Agama::all(),
            'pendidikan' => Pendidikan::all(),
            'pekerjaan' => Pekerjaan::all(),
            'golonganDarah' => GolonganDarah::all(),
            'statusPerkawinan' => StatusPerkawinan::all(),
            'statusHubungan' => StatusHubungan::all(),
            'provinsi' => Provinsi::all(),
            'kabupatenKota' => KabupatenKota::all(),
            'kecamatan' => Kecamatan::all(),
            'desaKelurahan' => DesaKelurahan::all(),

        ];
        return view('dashboard.pages.guest.register', $data);
    }

    public function insertRegistrasi(Request $request)
    {
        if ($request->status_perkawinan != 1) {
            $tanggal_perkawinan_req = 'required';
        } else {
            $tanggal_perkawinan_req = '';
        }

        if ((Auth::check()) && (in_array(Auth::user()->role, ['admin']))) {
            $namaBidanReq = 'required';
        } else {
            $namaBidanReq = '';
        }

        $validator = Validator::make(
            $request->all(),
            [
                'nomor_kk' => 'required|unique:kartu_keluarga,nomor_kk,NULL,id,deleted_at,NULL|digits:16',
                'nama_kepala_keluarga' => 'required',
                'alamat' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'kode_pos' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'file_kartu_keluarga' => 'mimes:jpeg,jpg,png,pdf|max:3072',
                'nama_lengkap' => 'required',
                'nik' => 'required|unique:anggota_keluarga,nik,NULL,id,deleted_at,NULL|digits:16',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'pendidikan' => 'required',
                'pekerjaan' => 'required',
                'golongan_darah' => 'required',
                'status_perkawinan' => 'required',
                'tanggal_perkawinan' => $tanggal_perkawinan_req,
                // 'status_hubungan' => 'required',
                'kewarganegaraan' => 'required',
                'nomor_paspor' => 'required',
                'nomor_kitap' => 'required',
                'ayah' => 'required',
                'ibu' => 'required',
                'foto_profil' => 'mimes:jpeg,jpg,png|max:3072',
                'alamat_domisili' => 'required',
                'provinsi_domisili' => 'required',
                'kabupaten_kota_domisili' => 'required',
                'kecamatan_domisili' => 'required',
                'desa_kelurahan_domisili' => 'required',
                'file_domisili' => 'mimes:jpeg,jpg,png,pdf|max:3072',
                'nomor_hp' => ['required', Rule::unique('users')->where(function ($query) {
                    return $query->where('role', 'keluarga')->whereNull('deleted_at');
                })],
                'kata_sandi' => 'required',
                'ulangi_kata_sandi' => 'required|same:kata_sandi',
                'nama_bidan' => $namaBidanReq,
            ],
            [
                'nomor_kk.required' => 'Nomor Kartu Keluarga tidak boleh kosong',
                'nomor_kk.unique' => 'Nomor Kartu Keluarga sudah terdaftar',
                'nomor_kk.digits' => 'Nomor Kartu Keluarga harus 16 digit',
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'rt.required' => 'RT tidak boleh kosong',
                'rw.required' => 'RW tidak boleh kosong',
                'kode_pos.required' => 'Kode Pos tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'file_kartu_keluarga.mimes' => 'File Kartu Keluarga harus berupa file jpeg, jpg, png, pdf',
                'file_kartu_keluarga.max' => 'File Kartu Keluarga tidak boleh lebih dari 3 MB',
                'nama_lengkap.required' => 'Nama Lengkap tidak boleh kosong',
                'nik.required' => 'NIK tidak boleh kosong',
                'nik.unique' => 'NIK sudah terdaftar',
                'nik.digits' => 'NIK harus 16 digit',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'agama.required' => 'Agama tidak boleh kosong',
                'pendidikan.required' => 'Pendidikan tidak boleh kosong',
                'pekerjaan.required' => 'Pekerjaan tidak boleh kosong',
                'golongan_darah.required' => 'Golongan Darah tidak boleh kosong',
                'status_perkawinan.required' => 'Status Perkawinan tidak boleh kosong',
                'tanggal_perkawinan.required' => 'Tanggal Perkawinan tidak boleh kosong',
                // 'status_hubungan.required' => 'Status Hubungan tidak boleh kosong',
                'kewarganegaraan.required' => 'Kewarganegaraan tidak boleh kosong',
                'nomor_paspor.required' => 'Nomor Paspor tidak boleh kosong',
                'nomor_kitap.required' => 'Nomor KITAP tidak boleh kosong',
                'ayah.required' => 'Nama Ayah tidak boleh kosong',
                'ibu.required' => 'Nama Ibu tidak boleh kosong',
                'foto_profil.mimes' => 'Foto Profil harus berupa file jpeg, jpg, png',
                'foto_profil.max' => 'Foto Profil tidak boleh lebih dari 3 MB',
                'alamat_domisili.required' => 'Alamat Domisili tidak boleh kosong',
                'provinsi_domisili.required' => 'Provinsi Domisili tidak boleh kosong',
                'kabupaten_kota_domisili.required' => 'Kabupaten/Kota Domisili tidak boleh kosong',
                'kecamatan_domisili.required' => 'Kecamatan Domisili tidak boleh kosong',
                'desa_kelurahan_domisili.required' => 'Desa/Kelurahan Domisili tidak boleh kosong',
                'file_domisili.mimes' => 'File Surat Keterangan Domisili harus berupa file jpeg, jpg, png, pdf',
                'file_domisili.max' => 'File Surat Keterangan Domisili tidak boleh lebih dari 3 MB',
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 13 digit',
                'nomor_hp.unique' => 'Nomor HP sudah terdaftar',
                'kata_sandi.required' => 'Kata Sandi tidak boleh kosong',
                'ulangi_kata_sandi.required' => 'Ulangi Kata Sandi tidak boleh kosong',
                'ulangi_kata_sandi.same' => 'Kata Sandi tidak sama',
                'nama_bidan.required' => 'Nama Bidan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $dataKartuKeluarga = [
            'nomor_kk' => $request->nomor_kk,
            'nama_kepala_keluarga' => strtoupper($request->nama_kepala_keluarga),
            'alamat' => strtoupper($request->alamat),
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            'kecamatan_id' => $request->kecamatan,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'provinsi_id' => $request->provinsi,
        ];

        if ((Auth::check()) && (in_array(Auth::user()->role, ['admin', 'bidan']))) {
            if (Auth::user()->role == 'bidan') {
                $dataKartuKeluarga['bidan_id'] = Auth::user()->profil->id;
            } else {
                $dataKartuKeluarga['bidan_id'] = $request->nama_bidan;
            }
            $dataKartuKeluarga['is_valid'] = 1;
            $dataKartuKeluarga['tanggal_validasi'] = Carbon::now();
        }

        if ($request->file('file_kartu_keluarga')) {
            $request->file('file_kartu_keluarga')->storeAs(
                'upload/kartu_keluarga/',
                $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension()
            );
            $dataKartuKeluarga['file_kk'] = $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension();
        }

        KartuKeluarga::create($dataKartuKeluarga);
        $maxIdKK = KartuKeluarga::latest()->pluck('id')->first();

        $dataAkun = [
            'nomor_hp' => $request->nomor_hp,
            'nik' => $request->nik,
            'password' => Hash::make($request->kata_sandi),
            'role' => 'keluarga',
        ];

        if ((Auth::check()) && (in_array(Auth::user()->role, ['admin', 'bidan']))) {
            $dataAkun['status'] = 1;
        }

        User::create($dataAkun);
        $maxIdUser = User::latest()->pluck('id')->first();

        $dataKepalaKeluarga = [
            'kartu_keluarga_id' => $maxIdKK,
            'user_id' => $maxIdUser,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'agama_id' => $request->agama,
            'pendidikan_id' => $request->pendidikan,
            'jenis_pekerjaan_id' => $request->pekerjaan,
            'golongan_darah_id' => $request->golongan_darah,
            'status_perkawinan_id' => $request->status_perkawinan,
            'status_hubungan_dalam_keluarga_id' => 1,
            'kewarganegaraan' => $request->kewarganegaraan,
            'no_paspor' => $request->nomor_paspor,
            'no_kitap' => $request->nomor_kitap,
            'nama_ayah' => strtoupper($request->ayah),
            'nama_ibu' => strtoupper($request->ibu),
        ];

        if ($request->status_perkawinan != 1) {
            $dataKepalaKeluarga['tanggal_perkawinan'] = date("Y-m-d", strtotime($request->tanggal_perkawinan));
        }

        if ((Auth::check()) && (in_array(Auth::user()->role, ['admin', 'bidan']))) {
            if (Auth::user()->role == 'bidan') {
                $dataKepalaKeluarga['bidan_id'] = Auth::user()->profil->id;
            } else {
                $dataKepalaKeluarga['bidan_id'] = $request->nama_bidan;
            }
            $dataKepalaKeluarga['is_valid'] = 1;
            $dataKepalaKeluarga['tanggal_validasi'] = Carbon::now();
        }

        if ($request->file('foto_profil')) {
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/keluarga/',
                $request->nik . '.' . $request->file('foto_profil')->extension()
            );
            $dataKepalaKeluarga['foto_profil'] = $request->nik . '.' . $request->file('foto_profil')->extension();
        }

        AnggotaKeluarga::create($dataKepalaKeluarga);
        $maxAnggotaKeluarga = AnggotaKeluarga::latest()->pluck('id')->first();


        $dataWilayahDomisili = [
            'anggota_keluarga_id' => $maxAnggotaKeluarga,
            'alamat' => strtoupper($request->alamat_domisili),
            'desa_kelurahan_id' => $request->desa_kelurahan_domisili,
            'kecamatan_id' => $request->kecamatan_domisili,
            'kabupaten_kota_id' => $request->kabupaten_kota_domisili,
            'provinsi_id' => $request->provinsi_domisili,

        ];

        if ($request->file('file_domisili')) {
            $request->file('file_domisili')->storeAs(
                'upload/surat_keterangan_domisili/',
                $request->nik . '.' . $request->file('file_domisili')->extension()
            );
            $dataWilayahDomisili['file_ket_domisili'] = $request->nik . '.' . $request->file('file_domisili')->extension();
        }

        WilayahDomisili::create($dataWilayahDomisili);

        return response()->json(['success' => 'Berhasil', 'mes' => 'Registrasi berhasil, data anda menunggu proses Validasi. Silahkan login secara berkala menggunakan Nomor HP/NIK beserta kata sandi yang anda telah anda inputkan sebelumnya.']);
    }

    public function registrasiUlang(KartuKeluarga $keluarga)
    {
        if ($keluarga->is_valid == 2) {
            $data = [
                'kartuKeluarga' => $keluarga,
                'anggotaKeluarga' => $keluarga->kepalaKeluarga,
                'agama' => Agama::all(),
                'pendidikan' => Pendidikan::all(),
                'pekerjaan' => Pekerjaan::all(),
                'golonganDarah' => GolonganDarah::all(),
                'statusPerkawinan' => StatusPerkawinan::all(),
                'statusHubungan' => StatusHubungan::all(),
                'provinsi' => Provinsi::all(),
                'kabupatenKota' => KabupatenKota::where('provinsi_id', $keluarga->provinsi_id)->get(),
                'kecamatan' => Kecamatan::where('kabupaten_kota_id', $keluarga->kabupaten_kota_id)->get(),
                'desaKelurahan' => DesaKelurahan::where('kecamatan_id', $keluarga->kecamatan_id)->get(),
                'kabupatenKotaDomisili' => KabupatenKota::where('provinsi_id', $keluarga->kepalaKeluarga->wilayahDomisili->provinsi_id)->get(),
                'kecamatanDomisili' => Kecamatan::where('kabupaten_kota_id', $keluarga->kepalaKeluarga->wilayahDomisili->kabupaten_kota_id)->get(),
                'desaKelurahanDomisili' => DesaKelurahan::where('kecamatan_id', $keluarga->kepalaKeluarga->wilayahDomisili->kecamatan_id)->get(),
                'provinsiKK' => $keluarga->provinsi_id,
                'kabupatenKotaKK' => $keluarga->kabupaten_kota_id,
                'kecamatanKK' => $keluarga->kecamatan_id,
                'desaKelurahanKK' => $keluarga->desa_kelurahan_id,
                'alamatKK' => $keluarga->alamat,
            ];
            return view('dashboard.pages.guest.register', $data);
        } else {
            abort(404);
        }
    }

    public function updateRegistrasi(KartuKeluarga $keluarga, Request $request)
    {
        if ($request->status_perkawinan != 1) {
            $tanggal_perkawinan_req = 'required';
        } else {
            $tanggal_perkawinan_req = '';
        }
        $validator = Validator::make(
            $request->all(),
            [
                'nomor_kk' => 'required|unique:kartu_keluarga,nomor_kk,' . $keluarga->nomor_kk . ',nomor_kk,deleted_at,NULL|digits:16',
                'nama_kepala_keluarga' => 'required',
                'alamat' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'kode_pos' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'file_kartu_keluarga' => 'mimes:jpeg,jpg,png,pdf|max:3072',
                'nama_lengkap' => 'required',
                'nik' => 'required|unique:anggota_keluarga,nik,' . $keluarga->kepalaKeluarga->nik . ',nik,deleted_at,NULL|digits:16',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'pendidikan' => 'required',
                'pekerjaan' => 'required',
                'golongan_darah' => 'required',
                'status_perkawinan' => 'required',
                'tanggal_perkawinan' => $tanggal_perkawinan_req,
                // 'status_hubungan' => 'required',
                'kewarganegaraan' => 'required',
                'nomor_paspor' => 'required',
                'nomor_kitap' => 'required',
                'ayah' => 'required',
                'ibu' => 'required',
                'foto_profil' => 'mimes:jpeg,jpg,png|max:3072',
                'alamat_domisili' => 'required',
                'provinsi_domisili' => 'required',
                'kabupaten_kota_domisili' => 'required',
                'kecamatan_domisili' => 'required',
                'desa_kelurahan_domisili' => 'required',
                'file_domisili' => 'mimes:jpeg,jpg,png,pdf|max:3072',
            ],
            [
                'nomor_kk.required' => 'Nomor Kartu Keluarga tidak boleh kosong',
                'nomor_kk.unique' => 'Nomor Kartu Keluarga sudah terdaftar',
                'nomor_kk.digits' => 'Nomor Kartu Keluarga harus 16 digit',
                'nama_kepala_keluarga.required' => 'Nama Kepala Keluarga tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'rt.required' => 'RT tidak boleh kosong',
                'rw.required' => 'RW tidak boleh kosong',
                'kode_pos.required' => 'Kode Pos tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'file_kartu_keluarga.mimes' => 'File Kartu Keluarga harus berupa file jpeg, jpg, png, pdf',
                'file_kartu_keluarga.max' => 'File Kartu Keluarga tidak boleh lebih dari 3 MB',
                'nama_lengkap.required' => 'Nama Lengkap tidak boleh kosong',
                'nik.required' => 'NIK tidak boleh kosong',
                'nik.unique' => 'NIK sudah terdaftar',
                'nik.digits' => 'NIK harus 16 digit',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'agama.required' => 'Agama tidak boleh kosong',
                'pendidikan.required' => 'Pendidikan tidak boleh kosong',
                'pekerjaan.required' => 'Pekerjaan tidak boleh kosong',
                'golongan_darah.required' => 'Golongan Darah tidak boleh kosong',
                'status_perkawinan.required' => 'Status Perkawinan tidak boleh kosong',
                'tanggal_perkawinan.required' => 'Tanggal Perkawinan tidak boleh kosong',
                // 'status_hubungan.required' => 'Status Hubungan tidak boleh kosong',
                'kewarganegaraan.required' => 'Kewarganegaraan tidak boleh kosong',
                'nomor_paspor.required' => 'Nomor Paspor tidak boleh kosong',
                'nomor_kitap.required' => 'Nomor KITAP tidak boleh kosong',
                'ayah.required' => 'Nama Ayah tidak boleh kosong',
                'ibu.required' => 'Nama Ibu tidak boleh kosong',
                'foto_profil.mimes' => 'Foto Profil harus berupa file jpeg, jpg, png',
                'foto_profil.max' => 'Foto Profil tidak boleh lebih dari 3 MB',
                'alamat_domisili.required' => 'Alamat Domisili tidak boleh kosong',
                'provinsi_domisili.required' => 'Provinsi Domisili tidak boleh kosong',
                'kabupaten_kota_domisili.required' => 'Kabupaten/Kota Domisili tidak boleh kosong',
                'kecamatan_domisili.required' => 'Kecamatan Domisili tidak boleh kosong',
                'desa_kelurahan_domisili.required' => 'Desa/Kelurahan Domisili tidak boleh kosong',
                'file_domisili.mimes' => 'File Surat Keterangan Domisili harus berupa file jpeg, jpg, png, pdf',
                'file_domisili.max' => 'File Surat Keterangan Domisili tidak boleh lebih dari 3 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $dataKartuKeluarga = [
            'bidan_id' => null,
            'nomor_kk' => $request->nomor_kk,
            'nama_kepala_keluarga' => strtoupper($request->nama_kepala_keluarga),
            'alamat' => strtoupper($request->alamat),
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            'kecamatan_id' => $request->kecamatan,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'provinsi_id' => $request->provinsi,
            'is_valid' => 0,
            'tanggal_validasi' => null,
            'alasan_ditolak' => null
        ];

        if ($request->file('file_kartu_keluarga')) {
            if (Storage::exists('upload/kartu_keluarga/' . $keluarga->file_kk)) {
                Storage::delete('upload/kartu_keluarga/' . $keluarga->file_kk);
            }
            $request->file('file_kartu_keluarga')->storeAs(
                'upload/kartu_keluarga/',
                $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension()
            );
            $dataKartuKeluarga['file_kk'] = $request->nomor_kk . '.' . $request->file('file_kartu_keluarga')->extension();
        }

        $keluarga->update($dataKartuKeluarga);

        $dataKepalaKeluarga = [
            'kartu_keluarga_id' => $keluarga->id,
            'user_id' => $keluarga->kepalaKeluarga->user_id,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => strtoupper($request->tempat_lahir),
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'agama_id' => $request->agama,
            'pendidikan_id' => $request->pendidikan,
            'jenis_pekerjaan_id' => $request->pekerjaan,
            'golongan_darah_id' => $request->golongan_darah,
            'status_perkawinan_id' => $request->status_perkawinan,
            'status_hubungan_dalam_keluarga_id' => 1,
            'kewarganegaraan' => $request->kewarganegaraan,
            'no_paspor' => $request->nomor_paspor,
            'no_kitap' => $request->nomor_kitap,
            'nama_ayah' => strtoupper($request->ayah),
            'nama_ibu' => strtoupper($request->ibu),
            'is_valid' => 0,
            'tanggal_validasi' => null,
            'alasan_ditolak' => null
        ];

        if ($request->status_perkawinan != 1) {
            $dataKepalaKeluarga['tanggal_perkawinan'] = date("Y-m-d", strtotime($request->tanggal_perkawinan));
        } else {
            $dataKepalaKeluarga['tanggal_perkawinan'] = null;
        }

        if ($request->file('foto_profil')) {
            if (Storage::exists('upload/foto_profil/keluarga/' . $keluarga->kepalaKeluarga->foto_profil)) {
                Storage::delete('upload/foto_profil/keluarga/' . $keluarga->kepalaKeluarga->foto_profil);
            }
            $request->file('foto_profil')->storeAs(
                'upload/foto_profil/keluarga/',
                $request->nik . '.' . $request->file('foto_profil')->extension()
            );
            $dataKepalaKeluarga['foto_profil'] = $request->nik . '.' . $request->file('foto_profil')->extension();
        }

        $keluarga->kepalaKeluarga->update($dataKepalaKeluarga);
        $keluarga->kepalaKeluarga->user->update(['nik' => $request->nik]);


        $dataWilayahDomisili = [
            'anggota_keluarga_id' => $keluarga->kepalaKeluarga->id,
            'alamat' => strtoupper($request->alamat_domisili),
            'desa_kelurahan_id' => $request->desa_kelurahan_domisili,
            'kecamatan_id' => $request->kecamatan_domisili,
            'kabupaten_kota_id' => $request->kabupaten_kota_domisili,
            'provinsi_id' => $request->provinsi_domisili,

        ];

        if ($request->file('file_domisili')) {
            if (Storage::exists('upload/surat_keterangan_domisili/' . $keluarga->kepalaKeluarga->wilayahDomisili->file_ket_domisili)) {
                Storage::delete('upload/surat_keterangan_domisili/' . $keluarga->kepalaKeluarga->wilayahDomisili->file_ket_domisili);
            }
            $request->file('file_domisili')->storeAs(
                'upload/surat_keterangan_domisili/',
                $request->nik . '.' . $request->file('file_domisili')->extension()
            );
            $dataWilayahDomisili['file_ket_domisili'] = $request->nik . '.' . $request->file('file_domisili')->extension();
        }

        $keluarga->kepalaKeluarga->wilayahDomisili->update($dataWilayahDomisili);

        return response()->json(['success' => 'Berhasil', 'mes' => 'Data Keluarga berhasil diperbarui, silahkan login secara berkala untuk mengetahui status data anda.']);
    }
}
