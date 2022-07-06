<?php

use App\Http\Controllers\api\ApiAkunController;
use App\Http\Controllers\api\ApiAnggotaKeluargaController;
use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\api\ApiBidanController;
use App\Http\Controllers\api\ApiKartuKeluargaController;
use App\Http\Controllers\api\ApiLokasiTugasController;
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
    Route::put('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'update']);
    Route::delete('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'destroy']);

    Route::get('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'index']);
    Route::get('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'show']);
    Route::post('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'store']);
    Route::put('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'update']);
    Route::delete('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'destroy']);

    Route::get('/bidan', [ApiBidanController::class, 'index']);
    Route::get('/bidan/{id}', [ApiBidanController::class, 'show']);
    Route::post('/bidan', [ApiBidanController::class, 'store']);
    Route::put('/bidan/{id}', [ApiBidanController::class, 'update']);
    Route::delete('/bidan/{id}', [ApiBidanController::class, 'destroy']);

    Route::get('/lokasi_tugas', [ApiLokasiTugasController::class, 'index']);
    Route::post('/lokasi_tugas', [ApiLokasiTugasController::class, 'store']);
    Route::put('/lokasi_tugas/{id}', [ApiLokasiTugasController::class, 'update']);
    Route::delete('/lokasi_tugas', [ApiLokasiTugasController::class, 'destroy']);
});
