<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertumbuhanAnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pertumbuhan_anak')->insert(array (
            4 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e46',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120006',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'berat_badan' => 4,
                'zscore' => -5.33,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:54:32',
                'updated_at' => '2022-03-30 13:54:32',    
            ),
            5 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e47',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120006',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'berat_badan' => 10,
                'zscore' => -0.32999999999999996,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:54:46',
                'updated_at' => '2022-03-30 13:54:46',    
            ),
            6 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e48',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120007',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'berat_badan' => 30,
                'zscore' => 25.22,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:07:39',
                'updated_at' => '2022-03-30 14:07:39',    
            ),
            7 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e49',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120007',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'berat_badan' => 9,
                'zscore' => 1.8900000000000001,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:08:01',
                'updated_at' => '2022-03-30 14:08:01',   
            ),
            8 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e54',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000d',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'berat_badan' => 11,
                'zscore' => -2.19,
                'hasil' => 'Gizi Kurang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:09:51',
                'updated_at' => '2022-03-30 14:09:51',   
            ),
            9 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e55',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000d',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'berat_badan' => 20,
                'zscore' => 3.24,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:10:10',
                'updated_at' => '2022-03-30 14:10:10',   
            ),
            10 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e56',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000e',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'berat_badan' => 30,
                'zscore' => 12.71,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:10:43',
                'updated_at' => '2022-03-30 14:10:43',   
            ),
            11 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e57',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000e',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'berat_badan' => 11,
                'zscore' => -0.86,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:10:58',
                'updated_at' => '2022-03-30 14:10:58',    
            ),
        ));
    }
}
