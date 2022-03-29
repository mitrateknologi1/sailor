<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\masterData\deteksiStunting\SoalIbuMelahirkanStuntingController;
use App\Http\Controllers\dashboard\masterData\momsCare\SoalDeteksiDiniController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\dashboard\utama\tumbuhKembang\PertumbuhanAnakController;
use App\Http\Controllers\dashboard\masterData\wilayah\ProvinsiController;
use App\Http\Controllers\dashboard\masterData\wilayah\KecamatanController;

use App\Http\Controllers\dashboard\masterData\wilayah\DesaKelurahanController;
use App\Http\Controllers\dashboard\masterData\wilayah\KabupatenKotaController;
use App\Http\Controllers\dashboard\masterData\wilayah\WilayahDomisiliController;

use App\Http\Controllers\dashboard\masterData\profil\BidanController;
use App\Http\Controllers\dashboard\masterData\profil\AdminController;
use App\Http\Controllers\dashboard\utama\deteksiStunting\DeteksiIbuMelahirkanStuntingController;

use App\Http\Controllers\dashboard\utama\deteksiStunting\StuntingAnakController;
use App\Http\Controllers\dashboard\utama\momsCare\AncController;
use App\Http\Controllers\dashboard\utama\momsCare\DeteksiDiniController;
use App\Http\Controllers\dashboard\utama\momsCare\PerkiraanMelahirkanController;
use App\Models\DeteksiDini;
use App\Models\DeteksiIbuMelahirkanStunting;

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
Route::match(array('PUT', 'POST'), 'proses-stunting-anak', [StuntingAnakController::class, 'proses']);


// -------------- Start Deteksi Stunting --------------
// URL resource-nya nanti sesuai url yang sekarang
Route::resource('stunting-anak', StuntingAnakController::class);

// URL resource-nya nanti sesuai url yang sekarang
Route::resource('deteksi-ibu-melahirkan-stunting', DeteksiIbuMelahirkanStuntingController::class);
Route::match(array('PUT', 'POST'), 'proses-deteksi-ibu-melahirkan-stunting', [DeteksiIbuMelahirkanStuntingController::class, 'proses']);
Route::get('get-ibu', [ListController::class, 'getIbu']);
// -------------- End Deteksi Stunting --------------



// ----------------- Start Moms Care -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::resource('perkiraan-melahirkan', PerkiraanMelahirkanController::class);
Route::match(array('PUT', 'POST'), 'proses-perkiraan-melahirkan', [PerkiraanMelahirkanController::class, 'proses']);

// URL resource-nya nanti sesuai url yang sekarang
Route::resource('deteksi-dini', DeteksiDiniController::class);
Route::match(array('PUT', 'POST'), 'proses-deteksi-dini', [DeteksiDiniController::class, 'proses']);

// URL resource-nya nanti sesuai url yang sekarang
Route::resource('anc', AncController::class);
// ----------------- End Moms Care -----------------



// ----------------- Start Tumbuh Kembang -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::resource('pertumbuhan-anak', PertumbuhanAnakController::class);
Route::post('proses-pertumbuhan-anak', [PertumbuhanAnakController::class, 'proses'])->name('proses-pertumbuhan-anak');
Route::put('proses-pertumbuhan-anak', [PertumbuhanAnakController::class, 'proses'])->name('proses-pertumbuhan-anak');
Route::get('get-anak', [ListController::class, 'getAnak'])->name('getAnak');
Route::get('get-bidan', [ListController::class, 'getBidan'])->name('getBidan');
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
Route::resource('masterData/desa-kelurahan/{kecamatan}', DesaKelurahanController::class)->parameters([
    '{kecamatan}' => 'kelurahan'
]);

Route::resource('masterData/kabupatenKota/{provinsi}', KabupatenKotaController::class)->parameters([
    '{provinsi}' => 'kabupatenKota'
]);

Route::resource('masterData/kecamatan/{kabupatenKota}', KecamatanController::class)->parameters([
    '{kabupatenKota}' => 'kecamatan'
]);

Route::resource('masterData/desaKelurahan/{kecamatan}', DesaKelurahanController::class)->parameters([
    '{kecamatan}' => 'desaKelurahan'
]);
Route::resource('/masterData/provinsi', ProvinsiController::class);
Route::resource('/masterData/soal-ibu-melahirkan-stunting', SoalIbuMelahirkanStuntingController::class);
Route::resource('/masterData/soal-deteksi-dini', SoalDeteksiDiniController::class);

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
