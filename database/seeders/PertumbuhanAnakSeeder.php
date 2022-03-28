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
                'id' => 1,
                'anggota_keluarga_id' => 2,
                'bidan_id' => 1,
                'berat_badan' => 3,
                'zscore' => -5.82,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:55:50',
                'updated_at' => '2022-03-28 12:55:50',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'anggota_keluarga_id' => 2,
                'bidan_id' => 1,
                'berat_badan' => 7,
                'zscore' => -2.18,
                'hasil' => 'Gizi Kurang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:56:13',
                'updated_at' => '2022-03-28 12:56:13',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'anggota_keluarga_id' => 4,
                'bidan_id' => 1,
                'berat_badan' => 3,
                'zscore' => -5.82,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:56:39',
                'updated_at' => '2022-03-28 12:56:39',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'anggota_keluarga_id' => 5,
                'bidan_id' => 1,
                'berat_badan' => 12,
                'zscore' => -1.59,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:57:00',
                'updated_at' => '2022-03-28 12:59:46',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'anggota_keluarga_id' => 4,
                'bidan_id' => 2,
                'berat_badan' => 22,
                'zscore' => 10.5,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:58:16',
                'updated_at' => '2022-03-28 13:03:04',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'anggota_keluarga_id' => 5,
                'bidan_id' => 2,
                'berat_badan' => 11,
                'zscore' => -2.18,
                'hasil' => 'Gizi Kurang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:58:29',
                'updated_at' => '2022-03-28 12:58:29',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'anggota_keluarga_id' => 2,
                'bidan_id' => -1,
                'berat_badan' => 3,
                'zscore' => -5.82,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 12:59:28',
                'updated_at' => '2022-03-28 12:59:28',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'anggota_keluarga_id' => 2,
                'bidan_id' => 2,
                'berat_badan' => 1,
                'zscore' => -7.64,
                'hasil' => 'Gizi Buruk',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 13:10:10',
                'updated_at' => '2022-03-28 13:10:10',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'anggota_keluarga_id' => 5,
                'bidan_id' => -1,
                'berat_badan' => 30,
                'zscore' => 9.0,
                'hasil' => 'Gizi Lebih',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 13:18:26',
                'updated_at' => '2022-03-28 13:18:26',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'anggota_keluarga_id' => 2,
                'bidan_id' => -1,
                'berat_badan' => 8,
                'zscore' => -1.27,
                'hasil' => 'Gizi Baik',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-03-28',
                'created_at' => '2022-03-28 13:20:10',
                'updated_at' => '2022-03-28 13:20:10',
                'deleted_at' => NULL,
            ),
        ));
        
    }
}
