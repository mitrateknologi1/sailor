<?php

use App\Http\Controllers\ListController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\utama\PertumbuhanAnakController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard.pages.utama.dashboard.admin');
});


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


