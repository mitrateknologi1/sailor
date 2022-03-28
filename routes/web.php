<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\dashboard\utama\tumbuhKembang\PertumbuhanAnakController;
use App\Http\Controllers\dashboard\masterData\wilayah\ProvinsiController;
use App\Http\Controllers\dashboard\masterData\wilayah\KecamatanController;

use App\Http\Controllers\dashboard\masterData\wilayah\DesaKelurahanController;
use App\Http\Controllers\dashboard\masterData\wilayah\KabupatenKotaController;
use App\Http\Controllers\dashboard\masterData\wilayah\WilayahDomisiliController;

use App\Http\Controllers\dashboard\masterData\profil\BidanController;
use App\Http\Controllers\dashboard\masterData\profil\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can registerπ web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard.pages.login');
})->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/cekLogin', [AuthController::class, 'cekLogin']);

// URL resource-nya nanti sesuai url yang sekarang
Route::get('dashboard', function () {
    return view('dashboard.pages.utama.dashboard.admin');
});



// -------------- Start Deteksi Stunting --------------
// URL resource-nya nanti sesuai url yang sekarang
Route::get('stunting-anak', function () {
    return view('dashboard.pages.utama.deteksiStunting.stuntingAnak.index');
});

// URL resource-nya nanti sesuai url yang sekarang
Route::get('ibu-melahirkan-stunting', function () {
    return view('dashboard.pages.utama.deteksiStunting.ibuMelahirkanStunting.index');
});
// -------------- End Deteksi Stunting --------------



// ----------------- Start Moms Care -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::get('perkiraan-melahirkan', function () {
    return view('dashboard.pages.utama.momsCare.perkiraanMelahirkan.index');
});

// URL resource-nya nanti sesuai url yang sekarang
Route::get('deteksi-dini', function () {
    return view('dashboard.pages.utama.momsCare.deteksiDini.index');
});

// URL resource-nya nanti sesuai url yang sekarang
Route::get('anc', function () {
    return view('dashboard.pages.utama.momsCare.anc.index');
});
// ----------------- End Moms Care -----------------



// ----------------- Start Tumbuh Kembang -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::resource('pertumbuhan-anak', PertumbuhanAnakController::class);
Route::post('proses-pertumbuhan-anak', [PertumbuhanAnakController::class, 'proses'])->name('proses-pertumbuhan-anak');
Route::put('proses-pertumbuhan-anak', [PertumbuhanAnakController::class, 'proses'])->name('proses-pertumbuhan-anak');
Route::get('get-anak', [ListController::class, 'getAnak'])->name('getAnak');
// Route::get('pertumbuhan-anak', function () {
//     return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.index');
// });

// URL resource-nya nanti sesuai url yang sekarang
Route::get('perkembangan-anak', function () {
    return view('dashboard.pages.utama.tumbuhKembang.perkembanganAnak.index');
});
// ----------------- End Tumbuh Kembang -----------------



// ----------------- Start Randa Kabilasa -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::get('mencegah-malnutrisi', function () {
    return view('dashboard.pages.utama.randaKabilasa.mencegahMalnutrisi.index');
});

// URL resource-nya nanti sesuai url yang sekarang
Route::get('mencegah-pernikahan-dini', function () {
    return view('dashboard.pages.utama.randaKabilasa.mencegahPernikahanDini.index');
});

// URL resource-nya nanti sesuai url yang sekarang
Route::get('meningkatkan-life-skill', function () {
    return view('dashboard.pages.utama.randaKabilasa.meningkatkanLifeSkill.index');
});

// ----------------- Start Master -----------------
Route::resource('desa-kelurahan/{kecamatan}', DesaKelurahanController::class)->parameters([
    '{kecamatan}' => 'kelurahan'
]);

Route::resource('kabupatenKota/{provinsi}', KabupatenKotaController::class)->parameters([
    '{provinsi}' => 'kabupatenKota'
]);

Route::resource('kecamatan/{kabupatenKota}', KecamatanController::class)->parameters([
    '{kabupatenKota}' => 'kecamatan'
]);

Route::resource('desaKelurahan/{kecamatan}', DesaKelurahanController::class)->parameters([
    '{kecamatan}' => 'desaKelurahan'
]);

Route::get('map/kecamatan', [KecamatanController::class, 'getMapData']);
Route::get('map/desaKelurahan', [DesaKelurahanController::class, 'getMapData']);

Route::resource('provinsi', ProvinsiController::class);

Route::get('lokasi-tugas-bidan/{bidan}', [BidanController::class, 'getLokasiTugasBidan'])->name('lokasiTugasBidan');
Route::put('update-lokasi-tugas/{bidan}', [BidanController::class, 'updateLokasiTugasBidan'])->name('updateLokasiTugasBidan');

Route::resource('bidan', BidanController::class);

// Wilayah
Route::get('/provinsi', [ListController::class, 'listProvinsi'])->name('listProvinsi');
Route::get('/kabupaten-kota', [ListController::class, 'listKabupatenKota'])->name('listKabupatenKota');
Route::get('/kecamatan', [ListController::class, 'listKecamatan'])->name('listKecamatan');
Route::get('/desa-kelurahan', [ListController::class, 'listDesaKelurahan'])->name('listDesaKelurahan');
