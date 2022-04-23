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
                'id' => '468aa6e4-d9a3-4c5c-ae1e-d1ae175a9c6a',
                'anggota_keluarga_id' => 8,
                'bidan_id' => 2,
                'skor' => 18,
            'kategori' => 'Kehamilan : KRST (Beresiko SANGAT TINGGI)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:09:56',
                'updated_at' => '2022-04-20 15:09:56',
            ),
            1 => 
            array (
                'id' => 'aea1b923-4fd8-4417-b65e-f255e58bc827',
                'anggota_keluarga_id' => 2,
                'bidan_id' => 1,
                'skor' => 2,
            'kategori' => 'Kehamilan : KRR (Beresiko Rendah)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:08:54',
                'updated_at' => '2022-04-20 15:08:54',
            ),
            2 => 
            array (
                'id' => 'aed7298a-7e85-4f8f-b4db-5a8e0fcf8c0a',
                'anggota_keluarga_id' => 1,
                'bidan_id' => 1,
                'skor' => 2,
            'kategori' => 'Kehamilan : KRR (Beresiko Rendah)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:08:41',
                'updated_at' => '2022-04-20 15:08:41',
            ),
            3 => 
            array (
                'id' => 'db33f765-0417-406b-9a93-6c3979ce9f0c',
                'anggota_keluarga_id' => 7,
                'bidan_id' => 2,
                'skor' => 10,
            'kategori' => 'Kehamilan : KRT (Beresiko TINGGI)',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:09:40',
                'updated_at' => '2022-04-20 15:09:40',
            ),
        ));
        
        
    }
}