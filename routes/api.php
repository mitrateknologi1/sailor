<?php

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
    Route::get('/kartu_keluarga', [ApiKartuKeluargaController::class, 'index']);

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
