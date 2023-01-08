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
use App\Http\Controllers\api\const\ApiDashboardController;
use App\Http\Controllers\api\const\ApiPekerjaanController;
use App\Http\Controllers\api\const\ApiPendidikanController;
use App\Http\Controllers\api\const\ApiProvinsiController;
use App\Http\Controllers\api\const\ApiStatusHubunganController;
use App\Http\Controllers\api\const\ApiStatusPerkawinanController;
use App\Http\Controllers\api\main\ApiAncController;
use App\Http\Controllers\api\main\ApiDeteksiDiniController;
use App\Http\Controllers\api\main\ApiIbuMelahirkanStuntingController;
use App\Http\Controllers\api\main\ApiJawabanDeteksiDiniController;
use App\Http\Controllers\api\main\ApiJawabanIbuMelahirkanStuntingController;
use App\Http\Controllers\api\main\ApiJawabanMencegahMalnutrisiController;
use App\Http\Controllers\api\main\ApiJawabanMeningkatkanLifeSkillController;
use App\Http\Controllers\api\main\ApiMencegahMalnutrisiController;
use App\Http\Controllers\api\main\ApiMencegahPernikahanDiniController;
use App\Http\Controllers\api\main\ApiMeningkatkanLifeSkillController;
use App\Http\Controllers\api\main\ApiPemberitahuanController;
use App\Http\Controllers\api\main\ApiPerkembanganAnakController;
use App\Http\Controllers\api\main\ApiPerkiraanMelahirkanController;
use App\Http\Controllers\api\main\ApiPertumbuhanAnakController;
use App\Http\Controllers\api\main\ApiRandaKabilasaController;
use App\Http\Controllers\api\main\ApiSoalDeteksiDiniContoller;
use App\Http\Controllers\api\main\ApiSoalIbuMelahirkanStuntingController;
use App\Http\Controllers\api\main\ApiSoalMencegahMalnutrisiController;
use App\Http\Controllers\api\main\ApiSoalMeningkatkanLifeSkillController;
use App\Http\Controllers\api\main\ApiStuntingAnakController;
use App\Http\Controllers\api\main\ApiPemeriksaanAncController;
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

Route::post('/akun', [ApiAkunController::class, 'store']);
Route::delete('/akun/{id}', [ApiAkunController::class, 'destroy'])->middleware('auth.apikey');

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

Route::post('/kartu_keluarga/upload', [ApiKartuKeluargaController::class, 'upload']);
Route::post('/kartu_keluarga', [ApiKartuKeluargaController::class, 'store']);
Route::post('/wilayah_domisili/upload', [ApiWilayahDomisiliController::class, 'upload']);
Route::post('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'store']);
Route::put('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'update']);
Route::delete('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'destroy'])->middleware('auth.apikey');
Route::post('/anggota_keluarga/upload', [ApiAnggotaKeluargaController::class, 'upload']);
Route::post('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'store']);
Route::put('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'update']);
Route::delete('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'destroy'])->middleware('auth.apikey');
//get bidan by kelurahan (open only for registration keluarga to check is bidan available at kelurahan x)
Route::get('/lokasi_tugas/cek_domisili', [ApiLokasiTugasController::class, 'cekDomisiliBidan']);

Route::get('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'show']);
Route::put('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'update']);
Route::delete('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'destroy'])->middleware('auth.apikey');

Route::get('/bidan', [ApiBidanController::class, 'index'])->middleware('auth.apikey');

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/profile', [ApiAuthController::class, 'profile']);
    Route::get('/dashboard', [ApiDashboardController::class, 'index']);

    // Route::get('/akun', [ApiAkunController::class, 'index'])->middleware('notKeluarga');
    Route::get('/akun', [ApiAkunController::class, 'index']);
    Route::get('/akun/{id}', [ApiAkunController::class, 'show'])->middleware('notKeluarga');
    // Route::post('/akun', [ApiAkunController::class, 'store'])->middleware('notKeluarga');
    Route::put('/akun/{id}', [ApiAkunController::class, 'update'])->middleware('notKeluarga');
    // Route::delete('/akun/{id}', [ApiAkunController::class, 'destroy'])->middleware('notKeluarga');

    Route::get('/kartu_keluarga', [ApiKartuKeluargaController::class, 'index']);
    // Route::get('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'show']);
    // Route::post('/kartu_keluarga', [ApiKartuKeluargaController::class, 'store']);
    // Route::post('/kartu_keluarga/upload/{id}', [ApiKartuKeluargaController::class, 'upload']);
    // Route::put('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'update']);
    // Route::delete('/kartu_keluarga/{id}', [ApiKartuKeluargaController::class, 'destroy']);
    Route::post('/kartu_keluarga/validasi', [ApiKartuKeluargaController::class, 'validasi'])->middleware('notKeluarga');

    Route::get('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'index']);
    Route::get('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'show']);
    // Route::post('/anggota_keluarga', [ApiAnggotaKeluargaController::class, 'store']);
    // Route::post('/anggota_keluarga/upload/{id}', [ApiAnggotaKeluargaController::class, 'upload']);
    // Route::put('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'update']);
    // Route::delete('/anggota_keluarga/{id}', [ApiAnggotaKeluargaController::class, 'destroy']);
    Route::post('/anggota_keluarga/validasi', [ApiAnggotaKeluargaController::class, 'validasi'])->middleware('notKeluarga');

    Route::get('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'index']);
    Route::get('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'show']);
    // Route::post('/wilayah_domisili', [ApiWilayahDomisiliController::class, 'store']);
    // Route::post('/wilayah_domisili/upload/{id}', [ApiWilayahDomisiliController::class, 'upload']);
    // Route::put('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'update']);
    // Route::delete('/wilayah_domisili/{id}', [ApiWilayahDomisiliController::class, 'destroy']);

    // Route::get('/bidan', [ApiBidanController::class, 'index'])->middleware('notKeluarga');
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
    Route::post('/stunting_anak/validasi', [ApiStuntingAnakController::class, 'validasi']);
    Route::put('/stunting_anak/{id}', [ApiStuntingAnakController::class, 'update']);
    Route::delete('/stunting_anak/{id}', [ApiStuntingAnakController::class, 'destroy']);

    Route::get('/ibu_melahirkan_stunting', [ApiIbuMelahirkanStuntingController::class, 'index']);
    Route::get('/ibu_melahirkan_stunting/{id}', [ApiIbuMelahirkanStuntingController::class, 'show']);
    Route::post('/ibu_melahirkan_stunting', [ApiIbuMelahirkanStuntingController::class, 'store']);
    Route::post('/ibu_melahirkan_stunting/validasi', [ApiIbuMelahirkanStuntingController::class, 'validasi']);
    Route::put('/ibu_melahirkan_stunting/{id}', [ApiIbuMelahirkanStuntingController::class, 'update']);
    Route::delete('/ibu_melahirkan_stunting/{id}', [ApiIbuMelahirkanStuntingController::class, 'destroy']);

    Route::get('/soal_ibu_melahirkan_stunting', [ApiSoalIbuMelahirkanStuntingController::class, 'index']);

    Route::get('/jawaban_ibu_melahirkan_stunting', [ApiJawabanIbuMelahirkanStuntingController::class, 'index']);
    Route::get('/jawaban_ibu_melahirkan_stunting/{id}', [ApiJawabanIbuMelahirkanStuntingController::class, 'show']);
    Route::post('/jawaban_ibu_melahirkan_stunting', [ApiJawabanIbuMelahirkanStuntingController::class, 'store']);
    Route::put('/jawaban_ibu_melahirkan_stunting/{id}', [ApiJawabanIbuMelahirkanStuntingController::class, 'update']);
    Route::delete('/jawaban_ibu_melahirkan_stunting/{id}', [ApiJawabanIbuMelahirkanStuntingController::class, 'destroy']);

    Route::get('/perkiraan_melahirkan', [ApiPerkiraanMelahirkanController::class, 'index']);
    Route::get('/perkiraan_melahirkan/{id}', [ApiPerkiraanMelahirkanController::class, 'show']);
    Route::post('/perkiraan_melahirkan', [ApiPerkiraanMelahirkanController::class, 'store']);
    Route::post('/perkiraan_melahirkan/validasi', [ApiPerkiraanMelahirkanController::class, 'validasi']);
    Route::put('/perkiraan_melahirkan/{id}', [ApiPerkiraanMelahirkanController::class, 'update']);
    Route::delete('/perkiraan_melahirkan/{id}', [ApiPerkiraanMelahirkanController::class, 'destroy']);

    Route::get('/deteksi_dini', [ApiDeteksiDiniController::class, 'index']);
    Route::get('/deteksi_dini/{id}', [ApiDeteksiDiniController::class, 'show']);
    Route::post('/deteksi_dini', [ApiDeteksiDiniController::class, 'store']);
    Route::post('/deteksi_dini/validasi', [ApiDeteksiDiniController::class, 'validasi']);
    Route::put('/deteksi_dini/{id}', [ApiDeteksiDiniController::class, 'update']);
    Route::delete('/deteksi_dini/{id}', [ApiDeteksiDiniController::class, 'destroy']);

    Route::get('/soal_deteksi_dini', [ApiSoalDeteksiDiniContoller::class, 'index']);

    Route::get('/jawaban_deteksi_dini', [ApiJawabanDeteksiDiniController::class, 'index']);
    Route::get('/jawaban_deteksi_dini/{id}', [ApiJawabanDeteksiDiniController::class, 'show']);
    Route::post('/jawaban_deteksi_dini', [ApiJawabanDeteksiDiniController::class, 'store']);
    Route::put('/jawaban_deteksi_dini/{id}', [ApiJawabanDeteksiDiniController::class, 'update']);
    Route::delete('/jawaban_deteksi_dini/{id}', [ApiJawabanDeteksiDiniController::class, 'destroy']);

    Route::get('/anc', [ApiAncController::class, 'index']);
    Route::get('/anc/{id}', [ApiAncController::class, 'show']);
    Route::post('/anc', [ApiAncController::class, 'store']);
    Route::post('/anc/validasi', [ApiAncController::class, 'validasi']);
    Route::put('/anc/{id}', [ApiAncController::class, 'update']);
    Route::delete('/anc/{id}', [ApiAncController::class, 'destroy']);

    Route::post('/pemeriksaan_anc', [ApiPemeriksaanAncController::class, 'store']);
    Route::put('/pemeriksaan_anc/{id}', [ApiPemeriksaanAncController::class, 'update']);

    Route::get('/pertumbuhan_anak', [ApiPertumbuhanAnakController::class, 'index']);
    Route::get('/pertumbuhan_anak/{id}', [ApiPertumbuhanAnakController::class, 'show']);
    Route::post('/pertumbuhan_anak', [ApiPertumbuhanAnakController::class, 'store']);
    Route::post('/pertumbuhan_anak/validasi', [ApiPertumbuhanAnakController::class, 'validasi']);
    Route::put('/pertumbuhan_anak/{id}', [ApiPertumbuhanAnakController::class, 'update']);
    Route::delete('/pertumbuhan_anak/{id}', [ApiPertumbuhanAnakController::class, 'destroy']);

    Route::get('/perkembangan_anak', [ApiPerkembanganAnakController::class, 'index']);
    Route::get('/perkembangan_anak/{id}', [ApiPerkembanganAnakController::class, 'show']);
    Route::post('/perkembangan_anak', [ApiPerkembanganAnakController::class, 'store']);
    Route::post('/perkembangan_anak/validasi', [ApiPerkembanganAnakController::class, 'validasi']);
    Route::put('/perkembangan_anak/{id}', [ApiPerkembanganAnakController::class, 'update']);
    Route::delete('/perkembangan_anak/{id}', [ApiPerkembanganAnakController::class, 'destroy']);

    Route::get('/randa_kabilasa', [ApiRandaKabilasaController::class, 'index']);
    Route::get('/randa_kabilasa/{id}', [ApiRandaKabilasaController::class, 'show']);
    Route::post('/randa_kabilasa', [ApiRandaKabilasaController::class, 'store']);
    Route::put('/randa_kabilasa/{id}', [ApiRandaKabilasaController::class, 'update']);
    Route::delete('/randa_kabilasa/{id}', [ApiRandaKabilasaController::class, 'destroy']);

    Route::get('/mencegah_malnutrisi', [ApiMencegahMalnutrisiController::class, 'index']);
    Route::get('/mencegah_malnutrisi/{id}', [ApiMencegahMalnutrisiController::class, 'show']);
    Route::post('/mencegah_malnutrisi', [ApiMencegahMalnutrisiController::class, 'store']);
    Route::post('/mencegah_malnutrisi/validasi', [ApiMencegahMalnutrisiController::class, 'validasi']);
    Route::put('/mencegah_malnutrisi/{id}', [ApiMencegahMalnutrisiController::class, 'update']);
    Route::delete('/mencegah_malnutrisi/{id}', [ApiMencegahMalnutrisiController::class, 'destroy']);

    Route::get('/jawaban_mencegah_malnutrisi', [ApiJawabanMencegahMalnutrisiController::class, 'index']);
    Route::get('/jawaban_mencegah_malnutrisi/{id}', [ApiJawabanMencegahMalnutrisiController::class, 'show']);
    Route::post('/jawaban_mencegah_malnutrisi', [ApiJawabanMencegahMalnutrisiController::class, 'store']);
    Route::put('/jawaban_mencegah_malnutrisi/{id}', [ApiJawabanMencegahMalnutrisiController::class, 'update']);
    Route::delete('/jawaban_mencegah_malnutrisi', [ApiJawabanMencegahMalnutrisiController::class, 'destroy']);

    Route::get('/soal_mencegah_malnutrisi', [ApiSoalMencegahMalnutrisiController::class, 'index']);

    Route::post('/meningkatkan_life_skill', [ApiMeningkatkanLifeSkillController::class, 'store']);
    Route::post('/meningkatkan_life_skill/validasi', [ApiMeningkatkanLifeSkillController::class, 'validasi']);
    Route::put('/meningkatkan_life_skill/{id}', [ApiMeningkatkanLifeSkillController::class, 'update']);
    Route::delete('/meningkatkan_life_skill/{id}', [ApiMeningkatkanLifeSkillController::class, 'destroy']);
    
    Route::get('/jawaban_meningkatkan_life_skill', [ApiJawabanMeningkatkanLifeSkillController::class, 'index']);
    Route::get('/jawaban_meningkatkan_life_skill/{id}', [ApiJawabanMeningkatkanLifeSkillController::class, 'show']);
    Route::post('/jawaban_meningkatkan_life_skill', [ApiJawabanMeningkatkanLifeSkillController::class, 'store']);
    Route::put('/jawaban_meningkatkan_life_skill/{id}', [ApiJawabanMeningkatkanLifeSkillController::class, 'update']);
    Route::delete('/jawaban_meningkatkan_life_skill', [ApiJawabanMeningkatkanLifeSkillController::class, 'destroy']);

    Route::get('/soal_meningkatkan_life_skill', [ApiSoalMeningkatkanLifeSkillController::class, 'index']);

    Route::get('/mencegah_pernikahan_dini', [ApiMencegahPernikahanDiniController::class, 'index']);
    Route::get('/mencegah_pernikahan_dini/{id}', [ApiMencegahPernikahanDiniController::class, 'show']);
    Route::post('/mencegah_pernikahan_dini', [ApiMencegahPernikahanDiniController::class, 'store']);
    Route::post('/mencegah_pernikahan_dini/validasi', [ApiMencegahPernikahanDiniController::class, 'validasi']);
    Route::put('/mencegah_pernikahan_dini/{id}', [ApiMencegahPernikahanDiniController::class, 'update']);
    Route::delete('/mencegah_pernikahan_dini/{id}', [ApiMencegahPernikahanDiniController::class, 'destroy']);

    Route::get('/pemberitahuan', [ApiPemberitahuanController::class, 'index']);
    Route::get('/pemberitahuan/{id}', [ApiPemberitahuanController::class, 'show']);
    Route::post('/pemberitahuan', [ApiPemberitahuanController::class, 'store']);
    Route::put('/pemberitahuan/{id}', [ApiPemberitahuanController::class, 'update']);
    Route::delete('/pemberitahuan/{id}', [ApiPemberitahuanController::class, 'destroy']);
});
