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
            0 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e42',
                'anggota_keluarga_id' => 3,
                'bidan_id' => 1,
                'berat_badan' => 1,
                'zscore' => -7.43,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:10:57',
                'updated_at' => '2022-03-30 13:10:57',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e43',
                'anggota_keluarga_id' => 3,
                'bidan_id' => 2,
                'berat_badan' => 12,
                'zscore' => -2.19,
                'hasil' => 'Gizi Kurang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:11:31',
                'updated_at' => '2022-03-30 13:11:31',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e44',
                'anggota_keluarga_id' => 4,
                'bidan_id' => 1,
                'berat_badan' => 12,
                'zscore' => -0.81,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:54:00',
                'updated_at' => '2022-03-30 13:54:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e45',
                'anggota_keluarga_id' => 4,
                'bidan_id' => 2,
                'berat_badan' => 20,
                'zscore' => 3.7199999999999998,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:54:13',
                'updated_at' => '2022-03-30 13:54:13',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e46',
                'anggota_keluarga_id' => 5,
                'bidan_id' => 1,
                'berat_badan' => 4,
                'zscore' => -5.33,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:54:32',
                'updated_at' => '2022-03-30 13:54:32',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e47',
                'anggota_keluarga_id' => 5,
                'bidan_id' => 2,
                'berat_badan' => 10,
                'zscore' => -0.32999999999999996,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 13:54:46',
                'updated_at' => '2022-03-30 13:54:46',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e48',
                'anggota_keluarga_id' => 6,
                'bidan_id' => 1,
                'berat_badan' => 30,
                'zscore' => 25.22,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:07:39',
                'updated_at' => '2022-03-30 14:07:39',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e49',
                'anggota_keluarga_id' => 6,
                'bidan_id' => 2,
                'berat_badan' => 9,
                'zscore' => 1.8900000000000001,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:08:01',
                'updated_at' => '2022-03-30 14:08:01',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e50',
                'anggota_keluarga_id' => 10,
                'bidan_id' => 1,
                'berat_badan' => 10,
                'zscore' => -3.48,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:08:26',
                'updated_at' => '2022-03-30 14:08:26',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e51',
                'anggota_keluarga_id' => 10,
                'bidan_id' => 2,
                'berat_badan' => 15,
                'zscore' => -1.1,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:08:45',
                'updated_at' => '2022-03-30 14:08:45',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e52',
                'anggota_keluarga_id' => 11,
                'bidan_id' => 1,
                'berat_badan' => 30,
                'zscore' => 5.5,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:09:03',
                'updated_at' => '2022-03-30 14:09:03',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e53',
                'anggota_keluarga_id' => 11,
                'bidan_id' => 2,
                'berat_badan' => 10,
                'zscore' => -3.4,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:09:19',
                'updated_at' => '2022-03-30 14:09:19',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e54',
                'anggota_keluarga_id' => 12,
                'bidan_id' => 1,
                'berat_badan' => 11,
                'zscore' => -2.19,
                'hasil' => 'Gizi Kurang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:09:51',
                'updated_at' => '2022-03-30 14:09:51',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e55',
                'anggota_keluarga_id' => 12,
                'bidan_id' => 2,
                'berat_badan' => 20,
                'zscore' => 3.24,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:10:10',
                'updated_at' => '2022-03-30 14:10:10',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e56',
                'anggota_keluarga_id' => 13,
                'bidan_id' => 1,
                'berat_badan' => 30,
                'zscore' => 12.71,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:10:43',
                'updated_at' => '2022-03-30 14:10:43',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e57',
                'anggota_keluarga_id' => 13,
                'bidan_id' => 2,
                'berat_badan' => 11,
                'zscore' => -0.86,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-30',
                'created_at' => '2022-03-30 14:10:58',
                'updated_at' => '2022-03-30 14:10:58',
                'deleted_at' => NULL,
            ),
        ));
    }
}
