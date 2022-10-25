<?php

namespace Database\Seeders;

use App\Models\Agama;
use App\Models\LokasiTugas;
use App\Models\StatusHubungan;
use App\Models\SoalMencegahMalnutrisi;
use App\Models\WilayahDomisili;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use App\Models\WilayahDomisiliKK;
use Database\Seeders\AdminSeeder;
use Database\Seeders\AgamaSeeder;
use Database\Seeders\BidanSeeder;
use Database\Seeders\PenyuluhSeeder;
use Database\Seeders\PekerjaanSeeder;
use Database\Seeders\PendidikanSeeder;
use Database\Seeders\LokasiTugasSeeder;
use Database\Seeders\KartuKeluargaSeeder;
use Database\Seeders\ProvinsiTableSeeder;
use Database\Seeders\KecamatanTableSeeder;
use Database\Seeders\AnggotaKeluargaSeeder;
use Database\Seeders\PertumbuhanAnakSeeder;
use Database\Seeders\WilayahDomisiliSeeder;
use Database\Seeders\WilayahDomisiliKKSeeder;
use Database\Seeders\DesaKelurahanTableSeeder;
use Database\Seeders\KabupatenKotaTableSeeder;
use Database\Seeders\SoalDeteksiDiniTableSeeder;
use Database\Seeders\SoalIbuMelahirkanStuntingSeeder;

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
        $this->call(SoalIbuMelahirkanStuntingSeeder::class);
        $this->call(SoalDeteksiDiniTableSeeder::class);
        $this->call(PertumbuhanAnakSeeder::class);
        $this->call(PerkembanganAnakSeeder::class);
        $this->call(PekerjaanSeeder::class);
        $this->call(AgamaSeeder::class);
        $this->call(PendidikanSeeder::class);
        $this->call(GolonganDarahSeeder::class);
        $this->call(StatusPerkawinanSeeder::class);
        $this->call(StatusHubunganSeeder::class);
        $this->call(SoalMencegahMalnutrisiTableSeeder::class);
        $this->call(SoalMeningkatkanLifeSkillTableSeeder::class);
        $this->call(StuntingAnakTableSeeder::class);
        $this->call(DeteksiIbuMelahirkanStuntingTableSeeder::class);
        $this->call(JawabanDeteksiIbuMelahirkanStuntingTableSeeder::class);
        $this->call(JawabanDeteksiDiniTableSeeder::class);
        $this->call(DeteksiDiniTableSeeder::class);
        $this->call(PemeriksaanAncTableSeeder::class);
        $this->call(AncTableSeeder::class);
        $this->call(RandaKabilasaTableSeeder::class);
        $this->call(MencegahMalnutrisiTableSeeder::class);
        $this->call(JawabanMencegahMalnutrisiTableSeeder::class);
        $this->call(JawabanMeningkatkanLifeSkillTableSeeder::class);
        $this->call(MencegahPernikahanDiniTableSeeder::class);
        $this->call(PerkiraanMelahirkanTableSeeder::class);

        // Auto Generate
        // $this->call(ProductionBidanSeeder::class);
        // $this->call(ProductionPenyuluhSeeder::class);

        // Production
        // $this->call(ProductionLokasiTugasTableSeeder::class);
        // $this->call(ProductionPenyuluhTableSeeder::class);
        // $this->call(ProductionUsersTableSeeder::class);
        // $this->call(ProductionBidanTableSeeder::class);
    }
}
