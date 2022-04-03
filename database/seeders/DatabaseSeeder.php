<?php

namespace Database\Seeders;

use App\Models\LokasiTugas;
use App\Models\SoalMencegahMalnutrisi;
use App\Models\WilayahDomisili;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BidanSeeder;
use Database\Seeders\PenyuluhSeeder;
use Database\Seeders\LokasiTugasSeeder;
use Database\Seeders\KartuKeluargaSeeder;
use Database\Seeders\ProvinsiTableSeeder;
use Database\Seeders\KecamatanTableSeeder;
use Database\Seeders\AnggotaKeluargaSeeder;
use Database\Seeders\WilayahDomisiliSeeder;
use Database\Seeders\DesaKelurahanTableSeeder;
use Database\Seeders\KabupatenKotaTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KartuKeluargaSeeder::class);
        $this->call(AnggotaKeluargaSeeder::class);
        $this->call(BidanSeeder::class);
        $this->call(PenyuluhSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ProvinsiTableSeeder::class);
        $this->call(KabupatenKotaTableSeeder::class);
        $this->call(KecamatanTableSeeder::class);
        $this->call(DesaKelurahanTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LokasiTugasSeeder::class);
        $this->call(WilayahDomisiliSeeder::class);
        $this->call(PertumbuhanAnakSeeder::class);
        $this->call(SoalIbuMelahirkanStuntingSeeder::class);
        $this->call(SoalDeteksiDiniTableSeeder::class);
        $this->call(SoalMencegahMalnutrisiTableSeeder::class);
        $this->call(SoalMeningkatkanLifeSkillTableSeeder::class);
    }
}
