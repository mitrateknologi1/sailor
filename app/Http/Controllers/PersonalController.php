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

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('profil_ada');
    }

    public function index()
    {
        $user = User::with('profil')->find(Auth::user()->id);
        if (Storage::exists('upload/foto_profil/' . $user->role . '/' . $user->profil->foto_profil)) {
            $foto_profil = Storage::url('upload/foto_profil/' . $user->role . '/' . $user->profil->foto_profil);
        } else {
            $foto_profil = asset('assets/dashboard/images/avatar.png');
        }
        if (in_array(Auth::user()->role, ['bidan', 'penyuluh', 'admin'])) {
            $data = [
                'user' => $user,
                'profil' => $user->profil,
                'agama' => Agama::all(),
                'provinsi' => Provinsi::all(),
                'kabupatenKota' => KabupatenKota::where('provinsi_id', $user->profil->provinsi_id)->get(),
                'kecamatan' => Kecamatan::where('kabupaten_kota_id', $user->profil->kabupaten_kota_id)->get(),
                'desaKelurahan' => DesaKelurahan::where('kecamatan_id', $user->profil->kecamatan_id)->get(),
                'foto_profil' => $foto_profil,

            ];
            return view('dashboard.pages.personal.selainKeluarga', $data);
        } else {
            $data = [
                'anggotaKeluarga' => $user->profil->kartuKeluarga->anggotaKeluarga,
                'user' => $user,
                'profil' => $user->profil,
                'agama' => Agama::all(),
                'pendidikan' => Pendidikan::all(),
                'pekerjaan' => Pekerjaan::all(),
                'golonganDarah' => GolonganDarah::all(),
                'statusPerkawinan' => StatusPerkawinan::all(),
                'provinsi' => Provinsi::all(),
                'kabupatenKotaDomisili' => KabupatenKota::where('provinsi_id', $user->profil->wilayahDomisili->provinsi_id)->get(),
                'kecamatanDomisili' => Kecamatan::where('kabupaten_kota_id', $user->profil->wilayahDomisili->kabupaten_kota_id)->get(),
                'desaKelurahanDomisili' => DesaKelurahan::where('kecamatan_id', $user->profil->wilayahDomisili->kecamatan_id)->get(),
                'provinsiKK' => $user->profil->kartuKeluarga->provinsi_id,
                'kabupatenKotaKK' => $user->profil->kartuKeluarga->kabupaten_kota_id,
                'kecamatanKK' => $user->profil->kartuKeluarga->kecamatan_id,
                'desaKelurahanKK' => $user->profil->kartuKeluarga->desa_kelurahan_id,
                'alamatKK' => $user->profil->kartuKeluarga->alamat,
                'foto_profil' => $foto_profil,
            ];
            if ($user->profil->status_hubungan_dalam_keluarga_id == 1) {
                $data['statusHubungan'] = StatusHubungan::all();
            } else {
                $data['statusHubungan'] = StatusHubungan::all()->skip(1);
            }
            return view('dashboard.pages.personal.keluarga', $data);
        }
    }

    public function profilAnggotaKeluarga(Request $request)
    {
        $profil = AnggotaKeluarga::find($request->id);
        if (Storage::exists('upload/foto_profil/keluarga/' . $profil->foto_profil)) {
            $foto_profil = Storage::url('upload/foto_profil/keluarga/' . $profil->foto_profil);
        } else {
            $foto_profil = asset('assets/dashboard/images/avatar.png');
        }

        $data = [
            'anggotaKeluarga' => $profil->kartuKeluarga->anggotaKeluarga,
            'profil' => $profil,
            'agama' => Agama::all(),
            'pendidikan' => Pendidikan::all(),
            'pekerjaan' => Pekerjaan::all(),
            'golonganDarah' => GolonganDarah::all(),
            'statusPerkawinan' => StatusPerkawinan::all(),
            'provinsi' => Provinsi::all(),
            'kabupatenKotaDomisili' => KabupatenKota::where('provinsi_id', $profil->wilayahDomisili->provinsi_id)->get(),
            'kecamatanDomisili' => Kecamatan::where('kabupaten_kota_id', $profil->wilayahDomisili->kabupaten_kota_id)->get(),
            'desaKelurahanDomisili' => DesaKelurahan::where('kecamatan_id', $profil->wilayahDomisili->kecamatan_id)->get(),
            'provinsiKK' => $profil->kartuKeluarga->provinsi_id,
            'kabupatenKotaKK' => $profil->kartuKeluarga->kabupaten_kota_id,
            'kecamatanKK' => $profil->kartuKeluarga->kecamatan_id,
            'desaKelurahanKK' => $profil->kartuKeluarga->desa_kelurahan_id,
            'alamatKK' => $profil->kartuKeluarga->alamat,
            'wilayahDomisili' => $profil->wilayahDomisili,
            'foto_profil' => $foto_profil,
            'titleSubmit' => 'Perbarui',

        ];
        if ($profil->status_hubungan_dalam_keluarga_id == 1) {
            $data['statusHubungan'] = StatusHubungan::all();
        } else {
            $data['statusHubungan'] = StatusHubungan::all()->skip(1);
        }

        return view("dashboard.components.forms.personal.profilKeluarga")->with($data)
            ->render();

        return $data;
    }

    public function perbaruiProfil(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user->role != 'keluarga') {
            $profil = $user->profil;

            $validateFotoProfil = '';
            if ($request->file('foto_profil')) {
                $fileName = $request->file('foto_profil');
                if ($fileName != $profil->foto_profil) {
                    $validateFotoProfil = 'required|image|file|max:3072';
                }
            }

            if ($user->role != 'admin') {
                $validateSTR = 'required|min:7';
            } else {
                $validateSTR = '';
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'nik' => 'required|unique:' . $user->role . ',nik,' . $profil->nik . ',nik,deleted_at,NULL|digits:16',
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
                    'foto_profil' => $validateFotoProfil,
                ],
                [
                    'nik.required' => 'NIK tidak boleh kosong',
                    'nik.unique' => 'NIK sudah digunakan pada ' . $user->role . ' lain',
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
                    'foto_profil.required' => 'Foto profil tidak boleh kosong',
                    'foto_profil.image' => 'Foto profil harus berupa gambar',
                    'foto_profil.max' => 'Foto profil tidak boleh lebih dari 3MB',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

            $data = [
                'nik' => $request->nik,
                'nama_lengkap' => strtoupper($request->nama_lengkap),
                'jenis_kelamin' => strtoupper($request->jenis_kelamin),
                'tempat_lahir' => strtoupper($request->tempat_lahir),
                'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
                'agama_id' => $request->agama,
                'nomor_hp' => $request->nomor_hp,
                'email' => $request->email,
                'alamat' => strtoupper($request->alamat),
                'provinsi_id' => $request->provinsi,
                'kabupaten_kota_id' => $request->kabupaten_kota,
                'kecamatan_id' => $request->kecamatan,
                'desa_kelurahan_id' => $request->desa_kelurahan,
            ];

            if ($user->role != 'admin') {
                $data['tujuh_angka_terakhir_str'] = $request->tujuh_angka_terakhir_str;
            }

            if ($request->file('foto_profil')) {
                if (Storage::exists('upload/foto_profil/' . $user->role . '/' . $profil->foto_profil)) {
                    Storage::delete('upload/foto_profil/' . $user->role . '/' . $profil->foto_profil);
                }
                $request->file('foto_profil')->storeAs(
                    'upload/foto_profil/' . $user->role . '/',
                    $request->nik .
                        '.' . $request->file('foto_profil')->extension()
                );
                $data['foto_profil'] = $request->nik . '.' . $request->file('foto_profil')->extension();
            }

            $profil->update($data);
            $user->update([
                'nik' => $request->nik,
                'nomor_hp' => $request->nomor_hp,
            ]);
            return response()->json(['success' => 'Berhasil']);
        } else {
            if ($user->is_remaja == 0) {
                $profil = AnggotaKeluarga::with('wilayahDomisili', 'user')->find($request->profil);
            } else { // Remaja
                $profil = AnggotaKeluarga::with('wilayahDomisili', 'user')->find(Auth::user()->profil->id);
            }


            if ($request->status_perkawinan != 1) {
                $tanggal_perkawinan_req = 'required';
            } else {
                $tanggal_perkawinan_req = '';
            }

            // if ($profil->status_hubungan_dalam_keluarga_id != 1) {
            // $status_hubungan_dalam_keluarga_req = 'required';
            //     $status_hubungan_dalam_keluarga_val = $request->status_hubungan;
            // } else {
            // $status_hubungan_dalam_keluarga_req = '';
            //     $status_hubungan_dalam_keluarga_val = 1;
            // }
            $validator = Validator::make(
                $request->all(),
                [
                    'nama_lengkap' => 'required',
                    'nik' => 'required|unique:anggota_keluarga,nik,' . $profil->nik . ',nik,deleted_at,NULL|digits:16',
                    'jenis_kelamin' => 'required',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'agama' => 'required',
                    'pendidikan' => 'required',
                    'pekerjaan' => 'required',
                    'golongan_darah' => 'required',
                    'status_perkawinan' => 'required',
                    'tanggal_perkawinan' => $tanggal_perkawinan_req,
                    // 'status_hubungan' => $status_hubungan_dalam_keluarga_req,
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

            if ($request->desa_kelurahan_domisili != $profil->wilayahDomisili->desa_kelurahan_id) {
                $terakhirDiUbah = Carbon::parse($profil->wilayahDomisili->updated_at)->translatedFormat('j F Y');
                $terakhirDiUbahFormat3Month = strtotime("+3 months", strtotime($profil->wilayahDomisili->updated_at));
                $dapatDiubah = Carbon::parse($terakhirDiUbahFormat3Month)->translatedFormat('j F Y');
                if (strtotime("+1 days", strtotime(date("Y-m-d"))) < $terakhirDiUbahFormat3Month) {
                    return response()->json(['belum_tiga_bulan' => 'Belum 3 bulan', 'terakhir_diubah' => $terakhirDiUbah, 'dapat_diubah' => $dapatDiubah]);
                }
            }

            $dataDomisili = [
                'alamat' => strtoupper($request->alamat_domisili),
                'provinsi_id' => $request->provinsi_domisili,
                'kabupaten_kota_id' => $request->kabupaten_kota_domisili,
                'kecamatan_id' => $request->kecamatan_domisili,
                'desa_kelurahan_id' => $request->desa_kelurahan_domisili,
            ];

            if ($request->file('file_domisili')) {
                if (Storage::exists('upload/surat_keterangan_domisili/' . $profil->wilayahDomisili->file_ket_domisili)) {
                    Storage::delete('upload/surat_keterangan_domisili/' . $profil->wilayahDomisili->file_ket_domisili);
                }
                $request->file('file_domisili')->storeAs(
                    'upload/surat_keterangan_domisili/',
                    $profil->nik . '.' . $request->file('file_domisili')->extension()
                );
                $dataDomisili['file_ket_domisili'] = $profil->nik . '.' . $request->file('file_domisili')->extension();
            }

            $dataProfil = [
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
                'kewarganegaraan' => $request->kewarganegaraan,
                'no_paspor' => $request->nomor_paspor,
                'no_kitap' => $request->nomor_kitap,
                'nama_ayah' => strtoupper($request->ayah),
                'nama_ibu' => strtoupper($request->ibu),

                'alamat_domisili' => $request->alamat_domisili,
                'provinsi_domisili' => $request->provinsi_domisili,
                'kabupaten_kota_domisili' => $request->kabupaten_kota_domisili,
                'kecamatan_domisili' => $request->kecamatan_domisili,
                'desa_kelurahan_domisili' => $request->desa_kelurahan_domisili,
                'file_domisili' => $request->file_domisili,

            ];
            // $dataProfil['status_hubungan_dalam_keluarga_id'] = $status_hubungan_dalam_keluarga_val;

            if ($request->status_perkawinan != 1) {
                $dataProfil['tanggal_perkawinan'] = date("Y-m-d", strtotime($request->tanggal_perkawinan));
            } else {
                $dataProfil['tanggal_perkawinan'] = null;
            }

            if ($request->file('foto_profil')) {
                if (Storage::exists('upload/foto_profil/keluarga/' . $profil->foto_profil)) {
                    Storage::delete('upload/foto_profil/keluarga/' . $profil->foto_profil);
                }
                $request->file('foto_profil')->storeAs(
                    'upload/foto_profil/keluarga/',
                    $profil->nik . '.' . $request->file('foto_profil')->extension()
                );
                $dataProfil['foto_profil'] = $profil->nik . '.' . $request->file('foto_profil')->extension();
            }

            if ($dataProfil) {
                $profil->update($dataProfil);
            }

            if (($profil->wilayahDomisili->desa_kelurahan_id != $request->desa_kelurahan_domisili) || ($request->file('file_domisili'))) {
                $profil->wilayahDomisili->update($dataDomisili);
            }

            return response()->json(['success' => 'Berhasil']);
        }
    }

    public function perbaruiAkun(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validator = Validator::make(
            $request->all(),
            [
                'nomor_hp' => ['required', 'max:13', Rule::unique('users')->where(function ($query) use ($user) {
                    return $query->where('role', $user->role)->whereNull('deleted_at');
                })->ignore($user->id)],
                // 'kata_sandi' => 'min:6',
                'ulangi_kata_sandi' => 'same:kata_sandi',
            ],
            [
                'nomor_hp.required' => 'Nomor HP tidak boleh kosong',
                'nomor_hp.unique' => 'Nomor HP sudah digunakan pada ' . $user->role . ' lain',
                'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 13 karakter',
                'kata_sandi.min' => 'Kata Sandi minimal 6 karakter',
                'ulangi_kata_sandi.same' => 'Kata Sandi tidak sama',
            ]
        );


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'nomor_hp' => $request->nomor_hp,
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

        return response()->json(['res' => 'success']);
    }
}
