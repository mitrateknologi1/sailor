<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RandaKabilasaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('randa_kabilasa')->delete();
        
        \DB::table('randa_kabilasa')->insert(array (
            0 => 
            array (
                'id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120044',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Normal',
                'kategori_lingkar_lengan_atas' => 'Normal',
                'kategori_imt' => 'Normal',
                'kategori_mencegah_malnutrisi' => 'Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak_mencegah_malnutrisi' => NULL,
                'alasan_ditolak_mencegah_pernikahan_dini' => NULL,
                'alasan_ditolak_meningkatkan_life_skill' => NULL,
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:54:35',
            ),
        ));
        
        
    }
}