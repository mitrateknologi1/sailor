<?php

use App\Models\Penyuluh;
use App\Models\DeteksiDini;
use App\Models\KartuKeluarga;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Models\DeteksiIbuMelahirkanStunting;
use App\Http\Controllers\dashboard\utama\momsCare\AncController;
use App\Http\Controllers\dashboard\masterData\akun\UserController;

use App\Http\Controllers\dashboard\masterData\profil\AdminController;
use App\Http\Controllers\dashboard\masterData\profil\BidanController;
use App\Http\Controllers\dashboard\masterData\profil\PenyuluhController;

use App\Http\Controllers\dashboard\utama\momsCare\DeteksiDiniController;
use App\Http\Controllers\dashboard\masterData\wilayah\ProvinsiController;
use App\Http\Controllers\dashboard\masterData\wilayah\KecamatanController;
use App\Http\Controllers\dashboard\masterData\profil\KartuKeluargaController;
use App\Http\Controllers\dashboard\masterData\wilayah\DesaKelurahanController;
use App\Http\Controllers\dashboard\masterData\wilayah\KabupatenKotaController;
use App\Http\Controllers\dashboard\masterData\profil\AnggotaKeluargaController;
use App\Http\Controllers\dashboard\masterData\wilayah\WilayahDomisiliController;
use App\Http\Controllers\dashboard\masterData\randaKabilasa\SoalAssessment1Controller;
use App\Http\Controllers\dashboard\masterData\randaKabilasa\SoalMencegahMalnutrisiController;
use App\Http\Controllers\dashboard\masterData\randaKabilasa\SoalMeningkatkanLifeSkillController;
use App\Http\Controllers\dashboard\utama\deteksiStunting\DeteksiIbuMelahirkanStuntingController;
use App\Http\Controllers\dashboard\utama\petaData\MapDeteksiStuntingController;
use App\Http\Controllers\dashboard\utama\deteksiStunting\StuntingAnakController;
use App\Http\Controllers\dashboard\utama\momsCare\PerkiraanMelahirkanController;
use App\Http\Controllers\dashboard\masterData\momsCare\SoalDeteksiDiniController;
use App\Http\Controllers\dashboard\utama\tumbuhKembang\PertumbuhanAnakController;
use App\Http\Controllers\dashboard\utama\tumbuhKembang\PerkembanganAnakController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\dashboard\utama\petaData\MapMomsCareController;
use App\Http\Controllers\dashboard\utama\petaData\MapRandaKabilasaController;
use App\Http\Controllers\dashboard\utama\randaKabilasa\MencegahMalnutrisiController;
use App\Http\Controllers\dashboard\utama\randaKabilasa\MencegahPernikahanDiniController;
use App\Http\Controllers\dashboard\utama\randaKabilasa\MeningkatkanLifeSkillController;
use App\Http\Controllers\dashboard\utama\randaKabilasa\RandaKabilasaController;
use App\Http\Controllers\dashboard\utama\TesMapController;

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

Route::get('/lengkapi-profil', [AuthController::class, 'lengkapiProfil'])->name('lengkapiProfil');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/cekLogin', [AuthController::class, 'cekLogin']);

// URL resource-nya nanti sesuai url yang sekarang
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
Route::match(array('PUT', 'POST'), 'proses-anc', [AncController::class, 'proses']);
Route::get('anc-cek-pemeriksaan', [AncController::class, 'cekPemeriksaan']);
// ----------------- End Moms Care -----------------



// ----------------- Start Tumbuh Kembang -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::resource('pertumbuhan-anak', PertumbuhanAnakController::class);
Route::post('proses-pertumbuhan-anak', [PertumbuhanAnakController::class, 'proses'])->name('proses-pertumbuhan-anak');
Route::put('proses-pertumbuhan-anak', [PertumbuhanAnakController::class, 'proses'])->name('proses-pertumbuhan-anak');
Route::get('get-anak', [ListController::class, 'getAnak'])->name('getAnak');
Route::get('get-bidan', [ListController::class, 'getBidan'])->name('getBidan');
Route::get('get-bidan-anggota-keluarga', [ListController::class, 'getBidanAnggotaKeluarga'])->name('getBidanAnggotaKeluarga');
// Route::get('pertumbuhan-anak', function () {
//     return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.index');
// });

// URL resource-nya nanti sesuai url yang sekarang
Route::resource('perkembangan-anak', PerkembanganAnakController::class);
Route::post('proses-perkembangan-anak', [PerkembanganAnakController::class, 'proses'])->name('proses-perkembangan-anak');
Route::put('proses-perkembangan-anak', [PerkembanganAnakController::class, 'proses'])->name('proses-perkembangan-anak');


// ----------------- End Tumbuh Kembang -----------------



// ----------------- Start Randa Kabilasa -----------------
// URL resource-nya nanti sesuai url yang sekarang
Route::resource('randa-kabilasa', RandaKabilasaController::class);
Route::resource('mencegah-malnutrisi', MencegahMalnutrisiController::class);
Route::match(array('PUT', 'POST'), 'proses-mencegah-malnutrisi', [MencegahMalnutrisiController::class, 'proses']);

Route::resource('meningkatkan-life-skill/{randaKabilasa}', MeningkatkanLifeSkillController::class)->parameters([
    '{randaKabilasa}' => 'meningkatkanLifeSkill'
]);
Route::match(array('PUT', 'POST'), 'proses-meningkatkan-life-skill/{randaKabilasa}', [MeningkatkanLifeSkillController::class, 'proses']);

Route::resource('mencegah-pernikahan-dini/{randaKabilasa}', MencegahPernikahanDiniController::class)->parameters([
    '{randaKabilasa}' => 'meningkatkanLifeSkill'
]);
Route::match(array('PUT', 'POST'), 'proses-mencegah-pernikahan-dini/{randaKabilasa}', [MencegahPernikahanDiniController::class, 'proses']);
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

Route::resource('/masterData/soal-mencegah-malnutrisi', SoalMencegahMalnutrisiController::class);
Route::resource('/masterData/soal-meningkatkan-life-skill', SoalMeningkatkanLifeSkillController::class);

Route::get('map/kecamatan', [KecamatanController::class, 'getMapData']);
Route::get('map/desaKelurahan', [DesaKelurahanController::class, 'getMapData']);
Route::resource('provinsi', ProvinsiController::class);

Route::get('lokasi-tugas-bidan/{bidan}', [BidanController::class, 'getLokasiTugasBidan'])->name('lokasiTugasBidan');
Route::put('update-lokasi-tugas-bidan/{bidan}', [BidanController::class, 'updateLokasiTugasBidan'])->name('updateLokasiTugasBidan');

Route::get('lokasi-tugas-penyuluh/{penyuluh}', [PenyuluhController::class, 'getLokasiTugasPenyuluh'])->name('lokasiTugasPenyuluh');
Route::put('update-lokasi-tugas-penyuluh/{penyuluh}', [PenyuluhController::class, 'updateLokasiTugasPenyuluh'])->name('updateLokasiTugasPenyuluh');

Route::resource('bidan', BidanController::class);
Route::resource('penyuluh', PenyuluhController::class);
Route::resource('admin', AdminController::class);
Route::resource('keluarga', KartuKeluargaController::class);
Route::put('keluarga/validasi/{keluarga}', [KartuKeluargaController::class, 'validasi'])->name('validasiKartuKeluarga');

Route::resource('anggota-keluarga/{keluarga}', AnggotaKeluargaController::class)->parameters([
    '{keluarga}' => 'anggotaKeluarga'
]);

Route::put('anggota-keluarga/validasi/{keluarga}/{anggotaKeluarga}', [AnggotaKeluargaController::class, 'validasi']);




Route::resource('user', UserController::class);

Route::get('registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
Route::get('registrasi-ulang/{keluarga}', [AuthController::class, 'registrasiUlang']);
Route::post('registrasi', [AuthController::class, 'insertRegistrasi'])->name('insertRegistrasi');
Route::put('registrasi-ulang/{keluarga}', [AuthController::class, 'updateRegistrasi'])->name('updateRegistrasi');

// Wilayah
Route::get('/provinsi', [ListController::class, 'listProvinsi'])->name('listProvinsi');
Route::get('/kabupaten-kota', [ListController::class, 'listKabupatenKota'])->name('listKabupatenKota');
Route::get('/kecamatan', [ListController::class, 'listKecamatan'])->name('listKecamatan');
Route::get('/desa-kelurahan', [ListController::class, 'listDesaKelurahan'])->name('listDesaKelurahan');

Route::get('/map-deteksi-stunting', [MapDeteksiStuntingController::class, 'index']);
Route::get('/petaData/stuntingAnak', [MapDeteksiStuntingController::class, 'getMapDataStuntingAnak']);
Route::get('/petaData/deteksiIbuMelahirkanStunting', [MapDeteksiStuntingController::class, 'getMapDataDeteksiIbuMelahirkanStunting']);
Route::get('/petaData/detailStuntingAnak', [MapDeteksiStuntingController::class, 'getDetailDataStuntingAnak']);
Route::get('/petaData/detailIbuMelahirkanStunting', [MapDeteksiStuntingController::class, 'getDetailDataIbuMelahirkanStunting']);

Route::get('/map-moms-care', [MapMomsCareController::class, 'index']);
Route::get('/petaData/deteksiDini', [MapMomsCareController::class, 'getMapDataDeteksiDini']);
Route::get('/petaData/anc', [MapMomsCareController::class, 'getMapDataAnc']);
Route::get('/petaData/detailDeteksiDini', [MapMomsCareController::class, 'getDetailDataDeteksiDini']);
Route::get('/petaData/detailAnc', [MapMomsCareController::class, 'getDetailDataAnc']);

Route::get('/map-randa-kabilasa', [MapRandaKabilasaController::class, 'index']);
Route::get('/petaData/randaKabilasa', [MapRandaKabilasaController::class, 'getMapDataRandaKabilasa']);
Route::get('/petaData/detailRandaKabilasa', [MapRandaKabilasaController::class, 'getDetailDataRandaKabilasa']);
