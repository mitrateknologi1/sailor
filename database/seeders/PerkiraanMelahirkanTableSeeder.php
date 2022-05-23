<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PerkiraanMelahirkanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('perkiraan_melahirkan')->delete();
        
        \DB::table('perkiraan_melahirkan')->insert(array (
            0 => 
            array (
                'id' => '7c130030-8e24-43ca-afb0-401113866bf7',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'tanggal_haid_terakhir' => '2022-03-11',
                'tanggal_perkiraan_lahir' => '2022-12-17',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:26:50',
                'updated_at' => '2022-05-22 18:26:50',
            ),
            1 => 
            array (
                'id' => 'b915a497-61ae-4648-b823-d7df01e4bd7f',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'tanggal_haid_terakhir' => '2022-03-01',
                'tanggal_perkiraan_lahir' => '2022-12-07',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:26:25',
                'updated_at' => '2022-05-22 18:26:25',
            ),
        ));
        
        
    }
}