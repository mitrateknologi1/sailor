<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->call(ProvinsiTableSeeder::class);
        $this->call(KabupatenKotaTableSeeder::class);
        $this->call(KecamatanTableSeeder::class);
        $this->call(DesaKelurahanTableSeeder::class);
        $this->call(SoalIbuMelahirkanStuntingSeeder::class);
        $this->call(SoalDeteksiDiniTableSeeder::class);
    }
}
