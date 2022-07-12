<?php

use App\Http\Controllers\api\ApiAkunController;
use App\Http\Controllers\api\ApiAnggotaKeluargaController;
use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\api\ApiBidanController;
use App\Http\Controllers\api\ApiKartuKeluargaController;
use App\Http\Controllers\api\ApiLokasiTugasController;
use App\Http\Controllers\api\ApiPenyuluhController;
use App\Http\Controllers\api\ApiWilayahDomisiliController;
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
    Route::put('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'update']);
    Route::delete('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'destroy']);

    Route::get('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'index']);
    Route::get('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'show']);
    Route::post('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'store']);
    Route::put('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'update']);
    Route::delete('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'destroy']);

    Route::get('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'index']);
    Route::get('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'show']);
    Route::post('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'store']);
    Route::put('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'update']);
    Route::delete('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'destroy']);

    Route::get('/bidan', [ApiBidanController::class, 'index'])->middleware('notKeluarga');
    Route::get('/bidan/{id}', [ApiBidanController::class, 'show']);
    Route::post('/bidan', [ApiBidanController::class, 'store'])->middleware('notKeluarga');
    Route::put('/bidan/{id}', [ApiBidanController::class, 'update'])->middleware('notKeluarga');
    Route::delete('/bidan/{id}', [ApiBidanController::class, 'destroy'])->middleware('notKeluarga');

    Route::get('/penyuluh', [ApiPenyuluhController::class, 'index'])->middleware('notKeluarga');
    Route::get('/penyuluh/{id}', [ApiPenyuluhController::class, 'show']);
    Route::post('/penyuluh', [ApiPenyuluhController::class, 'store'])->middleware('notKeluarga');
    Route::put('/penyuluh/{id}', [ApiPenyuluhController::class, 'update'])->middleware('notKeluarga');
    Route::delete('/penyuluh/{id}', [ApiPenyuluhController::class, 'destroy'])->middleware('notKeluarga');

    Route::get('/lokasi_tugas', [ApiLokasiTugasController::class, 'index']);
    Route::post('/lokasi_tugas', [ApiLokasiTugasController::class, 'store']);
    Route::put('/lokasi_tugas/{id}', [ApiLokasiTugasController::class, 'update']);
    Route::delete('/lokasi_tugas', [ApiLokasiTugasController::class, 'destroy']);
});
