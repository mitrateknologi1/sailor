<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeteksiDiniTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deteksi_dini')->delete();
        
        \DB::table('deteksi_dini')->insert(array (
            0 => 
            array (
                'id' => '59037f3a-4ec0-46f5-8059-6370bcfa0285',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'skor' => 2,
            'kategori' => 'Kehamilan : KRR (Beresiko Rendah)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:32:07',
                'updated_at' => '2022-05-22 18:32:07',
            ),
            1 => 
            array (
                'id' => '922a7bae-4fb8-419a-b9b0-95f0daaa7e2d',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'skor' => 130,
            'kategori' => 'Kehamilan : KRST (Beresiko SANGAT TINGGI)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:29:52',
                'updated_at' => '2022-05-22 18:29:52',
            ),
        ));
        
        
    }
}