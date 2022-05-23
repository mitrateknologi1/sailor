<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StuntingAnakTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stunting_anak')->delete();
        
        \DB::table('stunting_anak')->insert(array (
            0 => 
            array (
                'id' => '0169a03e-66db-4f47-a6c2-15cc8033759b',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120007',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tinggi_badan' => 180,
                'zscore' => 49.0,
                'kategori' => 'Tinggi',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:16:04',
                'updated_at' => '2022-05-22 18:16:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 'c15116f5-6807-4902-8bf2-14b425bea9cd',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000d',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tinggi_badan' => 90,
                'zscore' => -2.11,
            'kategori' => 'Pendek (Resiko Stunting Sedang)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:17:33',
                'updated_at' => '2022-05-22 18:17:33',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 'd19a8f59-bb9d-4097-bd0e-b43c94fbf074',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120006',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tinggi_badan' => 20,
                'zscore' => -20.55,
            'kategori' => 'Sangat Pendek (Resiko Stunting Tinggi)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:16:25',
                'updated_at' => '2022-05-22 18:16:25',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 'd9c718de-f712-42a8-bff4-956c24a13c5a',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000e',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tinggi_badan' => 90,
                'zscore' => 0.38,
                'kategori' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:17:06',
                'updated_at' => '2022-05-22 18:17:06',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}