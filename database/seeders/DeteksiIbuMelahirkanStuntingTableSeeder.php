<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeteksiIbuMelahirkanStuntingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deteksi_ibu_melahirkan_stunting')->delete();
        
        \DB::table('deteksi_ibu_melahirkan_stunting')->insert(array (
            0 => 
            array (
                'id' => '3769cde2-62c1-4fd7-bb53-6d90fc0cd4e9',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'kategori' => 'Tidak Beresiko Melahirkan Stunting',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:20:06',
                'updated_at' => '2022-05-22 18:20:06',
            ),
            1 => 
            array (
                'id' => '7170425e-d27e-46ee-b25c-593f7d411715',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'kategori' => 'Beresiko Melahirkan Stunting',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:19:24',
                'updated_at' => '2022-05-22 18:19:24',
            ),
        ));
        
        
    }
}