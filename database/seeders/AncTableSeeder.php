<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AncTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('anc')->delete();
        
        \DB::table('anc')->insert(array (
            0 => 
            array (
                'id' => 'ddeebd85-dafa-4c9a-a9a3-06b07c0eb9e6',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'pemeriksaan_ke' => 1,
                'kategori_badan' => 'Resiko Tinggi',
                'kategori_tekanan_darah' => 'Hipotensi',
            'kategori_lengan_atas' => 'Kurang Gizi (BBLR)',
                'kategori_denyut_jantung' => 'Tidak Normal',
                'kategori_hemoglobin_darah' => 'Anemia',
                'vaksin_tetanus_sebelum_hamil' => 'Sudah',
                'vaksin_tetanus_sesudah_hamil' => 'Sudah',
                'minum_tablet' => 'Sudah',
                'konseling' => 'Sudah',
                'posisi_janin' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:47:42',
                'updated_at' => '2022-05-22 18:47:42',
            ),
            1 => 
            array (
                'id' => 'e1b5c712-b4e7-4af6-87e1-17985d4e039e',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'pemeriksaan_ke' => 1,
                'kategori_badan' => 'Normal',
                'kategori_tekanan_darah' => 'Normal',
                'kategori_lengan_atas' => 'Normal',
                'kategori_denyut_jantung' => 'Normal',
                'kategori_hemoglobin_darah' => 'Normal',
                'vaksin_tetanus_sebelum_hamil' => 'Sudah',
                'vaksin_tetanus_sesudah_hamil' => 'Sudah',
                'minum_tablet' => 'Sudah',
                'konseling' => 'Sudah',
                'posisi_janin' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-05-22',
                'alasan_ditolak' => NULL,
                'created_at' => '2022-05-22 18:37:03',
                'updated_at' => '2022-05-22 18:37:03',
            ),
        ));
        
        
    }
}