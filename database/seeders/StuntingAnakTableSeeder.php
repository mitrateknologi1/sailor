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

        \DB::table('stunting_anak')->insert(array(
            0 =>
            array(
                'id' => 1,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120004',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tinggi_badan' => 20,
                'zscore' => -19.32,
                'kategori' => 'Sangat Pendek (Resiko Stunting Tinggi)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:56:15',
                'updated_at' => '2022-04-22 13:56:15',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120005',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tinggi_badan' => 85,
                'zscore' => -2.32,
                'kategori' => 'Pendek (Resiko Stunting Sedang)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:56:53',
                'updated_at' => '2022-04-22 13:56:53',
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120006',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tinggi_badan' => 80,
                'zscore' => -0.9,
                'kategori' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:57:10',
                'updated_at' => '2022-04-22 13:57:10',
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120007',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tinggi_badan' => 100,
                'zscore' => 14.91,
                'kategori' => 'Tinggi',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:57:25',
                'updated_at' => '2022-04-22 13:57:25',
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000b',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tinggi_badan' => 10,
                'zscore' => -22.09,
                'kategori' => 'Sangat Pendek (Resiko Stunting Tinggi)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:57:55',
                'updated_at' => '2022-04-22 13:57:55',
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000c',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tinggi_badan' => 95,
                'zscore' => -2.41,
                'kategori' => 'Pendek (Resiko Stunting Sedang)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:58:26',
                'updated_at' => '2022-04-22 13:58:26',
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000d',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tinggi_badan' => 100,
                'zscore' => 0.68,
                'kategori' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:58:39',
                'updated_at' => '2022-04-22 13:58:39',
                'deleted_at' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000e',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tinggi_badan' => 140,
                'zscore' => 16.77,
                'kategori' => 'Tinggi',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-22',
                'created_at' => '2022-04-22 13:58:52',
                'updated_at' => '2022-04-22 13:58:52',
                'deleted_at' => NULL,
            ),
        ));
    }
}
