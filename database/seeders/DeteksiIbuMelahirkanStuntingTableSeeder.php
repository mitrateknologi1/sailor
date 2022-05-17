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

        \DB::table('deteksi_ibu_melahirkan_stunting')->insert(array(
            0 =>
            array(
                'id' => '2e67c612-7e66-400b-8403-97f04be801a3',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'kategori' => 'Beresiko Melahirkan Stunting',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:06:12',
                'updated_at' => '2022-04-20 15:06:12',
            ),
            1 =>
            array(
                'id' => '50a28930-74e5-4792-86bd-d97ff616e471',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'kategori' => 'Tidak Beresiko Melahirkan Stunting',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:05:22',
                'updated_at' => '2022-04-20 15:05:22',
            ),
            2 =>
            array(
                'id' => 'c8f84825-3600-4d6d-b59e-07419f2eabcd',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'kategori' => 'Tidak Beresiko Melahirkan Stunting',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:03:37',
                'updated_at' => '2022-04-20 15:03:37',
            ),
            3 =>
            array(
                'id' => 'f0d7b4a0-dabc-4d4d-ae26-c04d12502bd5',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'kategori' => 'Beresiko Melahirkan Stunting',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:06:00',
                'updated_at' => '2022-04-20 15:06:00',
            ),
        ));
    }
}
