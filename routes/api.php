<?php

use App\Http\Controllers\api\master\ApiAkunController;
use App\Http\Controllers\api\master\ApiAnggotaKeluargaController;
use App\Http\Controllers\api\master\ApiAuthController;
use App\Http\Controllers\api\master\ApiBidanController;
use App\Http\Controllers\api\master\ApiKartuKeluargaController;
use App\Http\Controllers\api\master\ApiLokasiTugasController;
use App\Http\Controllers\api\master\ApiPenyuluhController;
use App\Http\Controllers\api\master\ApiWilayahDomisiliController;
use App\Http\Controllers\api\const\ApiAgamaController;
use App\Http\Controllers\api\const\ApiDesaKelurahanController;
use App\Http\Controllers\api\const\ApiGolonganDarahController;
use App\Http\Controllers\api\const\ApiKabupatenKotaController;
use App\Http\Controllers\api\const\ApiKecamatanController;
use App\Http\Controllers\api\const\ApiPekerjaanController;
use App\Http\Controllers\api\const\ApiPendidikanController;
use App\Http\Controllers\api\const\ApiProvinsiController;
use App\Http\Controllers\api\const\ApiStatusHubunganController;
use App\Http\Controllers\api\const\ApiStatusPerkawinanController;
use App\Http\Controllers\api\main\ApiAncController;
use App\Http\Controllers\api\main\ApiDeteksiDiniController;
use App\Http\Controllers\api\main\ApiIbuMelahirkanStuntingController;
use App\Http\Controllers\api\main\ApiPerkiraanMelahirkanController;
use App\Http\Controllers\api\main\ApiStuntingAnakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

Route::get('/agama', [ApiAgamaController::class, 'index']);
Route::get('/agama/{id}', [ApiAgamaController::class, 'show']);

Route::get('/golongan_darah', [ApiGolonganDarahController::class, 'index']);
Route::get('/golongan_darah/{id}', [ApiGolonganDarahController::class, 'show']);

Route::get('/status_hubungan', [ApiStatusHubunganController::class, 'index']);
Route::get('/status_hubungan/{id}', [ApiStatusHubunganController::class, 'show']);

Route::get('/status_perkawinan', [ApiStatusPerkawinanController::class, 'index']);
Route::get('/status_perkawinan/{id}', [ApiStatusPerkawinanController::class, 'show']);

Route::get('/pendidikan', [ApiPendidikanController::class, 'index']);
Route::get('/pendidikan/{id}', [ApiPendidikanController::class, 'show']);

Route::get('/pekerjaan', [ApiPekerjaanController::class, 'index']);
Route::get('/pekerjaan/{id}', [ApiPekerjaanController::class, 'show']);

Route::get('/desa_kelurahan', [ApiDesaKelurahanController::class, 'index']);
Route::get('/desa_kelurahan/{id}', [ApiDesaKelurahanController::class, 'show']);

Route::get('/kecamatan', [ApiKecamatanController::class, 'index']);
Route::get('/kecamatan/{id}', [ApiKecamatanController::class, 'show']);

Route::get('/kabupaten_kota', [ApiKabupatenKotaController::class, 'index']);
Route::get('/kabupaten_kota/{id}', [ApiKabupatenKotaController::class, 'show']);

Route::get('/provinsi', [ApiProvinsiController::class, 'index']);
Route::get('/provinsi/{id}', [ApiProvinsiController::class, 'show']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::get('/akun', [ApiAkunController::class, 'index'])->middleware('notKeluarga');
    Route::get('/akun/{id}', [ApiAkunController::class, 'show'])->middleware('notKeluarga');
    Route::post('/akun', [ApiAkunController::class, 'store'])->middleware('notKeluarga');
    Route::put('/akun/{id}', [ApiAkunController::class, 'update'])->middleware('notKeluarga');
    Route::delete('/akun/{id}', [ApiAkunController::class, 'destroy'])->middleware('notKeluarga');

    Route::get('/kartu_keluarga', [ApiKartuKeluargaController::class, 'index']);
    Route::get('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'show']);
    Route::post('/kartu_keluarga', [ApiKartuKeluargaController::class, 'store']);
    Route::post('/kartu_keluarga/upload/{id}', [ApiKartuKeluargaController::class, 'upload']);
    Route::put('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'update']);
    Route::delete('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'destroy']);

    Route::get('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'index']);
    Route::get('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'show']);
    Route::post('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'store']);
    Route::post('/anggota_keluarga/upload/{id}', [ApiAnggotaKeluargaController::class, 'upload']);
    Route::put('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'update']);
    Route::delete('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'destroy']);

    Route::get('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'index']);
    Route::get('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'show']);
    Route::post('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'store']);
    Route::post('/wilayah_domisili/upload/{id}', [ApiWilayahDomisiliController::class, 'update']);
    Route::put('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'update']);
    Route::delete('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'destroy']);

    Route::get('/bidan', [ApiBidanController::class, 'index'])->middleware('notKeluarga');
    Route::get('/bidan/{id}', [ApiBidanController::class, 'show']);
    Route::post('/bidan', [ApiBidanController::class, 'store'])->middleware('notKeluarga');
    Route::post('/bidan/upload/{id}', [ApiBidanController::class, 'upload'])->middleware('notKeluarga');
    Route::put('/bidan/{id}', [ApiBidanController::class, 'update'])->middleware('notKeluarga');
    Route::delete('/bidan/{id}', [ApiBidanController::class, 'destroy'])->middleware('notKeluarga');

    Route::get('/penyuluh', [ApiPenyuluhController::class, 'index'])->middleware('notKeluarga');
    Route::get('/penyuluh/{id}', [ApiPenyuluhController::class, 'show']);
    Route::post('/penyuluh', [ApiPenyuluhController::class, 'store'])->middleware('notKeluarga');
    Route::post('/penyuluh/upload/{id}', [ApiPenyuluhController::class, 'upload'])->middleware('notKeluarga');
    Route::put('/penyuluh/{id}', [ApiPenyuluhController::class, 'update'])->middleware('notKeluarga');
    Route::delete('/penyuluh/{id}', [ApiPenyuluhController::class, 'destroy'])->middleware('notKeluarga');

    Route::get('/lokasi_tugas', [ApiLokasiTugasController::class, 'index']);
    Route::post('/lokasi_tugas', [ApiLokasiTugasController::class, 'store']);
    Route::put('/lokasi_tugas/{id}', [ApiLokasiTugasController::class, 'update']);
    Route::delete('/lokasi_tugas', [ApiLokasiTugasController::class, 'destroy']);

    Route::get('/stunting_anak', [ApiStuntingAnakController::class, 'index']);
    Route::get('/stunting_anak/{id}', [ApiStuntingAnakController::class, 'show']);
    Route::post('/stunting_anak', [ApiStuntingAnakController::class, 'store']);
    Route::put('/stunting_anak/{id}', [ApiStuntingAnakController::class, 'update']);
    Route::delete('/stunting_anak/{id}', [ApiStuntingAnakController::class, 'destroy']);

    Route::get('/ibu_melahirkan_stunting', [ApiIbuMelahirkanStuntingController::class, 'index']);
    Route::get('/ibu_melahirkan_stunting/{id}', [ApiIbuMelahirkanStuntingController::class, 'show']);
    Route::post('/ibu_melahirkan_stunting', [ApiIbuMelahirkanStuntingController::class, 'store']);
    Route::put('/ibu_melahirkan_stunting/{id}', [ApiIbuMelahirkanStuntingController::class, 'update']);
    Route::delete('/ibu_melahirkan_stunting/{id}', [ApiIbuMelahirkanStuntingController::class, 'destroy']);

    Route::get('/perkiraan_melahirkan', [ApiPerkiraanMelahirkanController::class, 'index']);
    Route::get('/perkiraan_melahirkan/{id}', [ApiPerkiraanMelahirkanController::class, 'show']);
    Route::post('/perkiraan_melahirkan', [ApiPerkiraanMelahirkanController::class, 'store']);
    Route::put('/perkiraan_melahirkan/{id}', [ApiPerkiraanMelahirkanController::class, 'update']);
    Route::delete('/perkiraan_melahirkan/{id}', [ApiPerkiraanMelahirkanController::class, 'destroy']);

    Route::get('/deteksi_dini', [ApiDeteksiDiniController::class, 'index']);
    Route::get('/deteksi_dini/{id}', [ApiDeteksiDiniController::class, 'show']);
    Route::post('/deteksi_dini', [ApiDeteksiDiniController::class, 'store']);
    Route::put('/deteksi_dini/{id}', [ApiDeteksiDiniController::class, 'update']);
    Route::delete('/deteksi_dini/{id}', [ApiDeteksiDiniController::class, 'destroy']);

    Route::get('/anc', [ApiAncController::class, 'index']);
    Route::get('/anc/{id}', [ApiAncController::class, 'show']);
    Route::post('/anc', [ApiAncController::class, 'store']);
    Route::put('/anc/{id}', [ApiAncController::class, 'update']);
    Route::delete('/anc/{id}', [ApiAncController::class, 'destroy']);
});
