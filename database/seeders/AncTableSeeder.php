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

        \DB::table('anc')->insert(array(
            0 =>
            array(
                'id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e42',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'pemeriksaan_ke' => 1,
                'kategori_badan' => 'Resiko Tinggi',
                'kategori_tekanan_darah' => 'Normal',
                'kategori_lengan_atas' => 'Kurang Gizi (BBLR)',
                'kategori_denyut_jantung' => 'Tidak Normal',
                'kategori_hemoglobin_darah' => 'Anemia',
                'vaksin_tetanus_sebelum_hamil' => 'Belum',
                'vaksin_tetanus_sesudah_hamil' => 'Belum',
                'minum_tablet' => 'Belum',
                'konseling' => 'Belum',
                'posisi_janin' => 'Sungsang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:18:09',
                'updated_at' => '2022-04-20 15:18:09',
            ),
            1 =>
            array(
                'id' => '5ccf390e-c741-4bf2-8ae5-deb286e68e44',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120003',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'pemeriksaan_ke' => 1,
                'kategori_badan' => 'Resiko Tinggi',
                'kategori_tekanan_darah' => 'Hipotensi',
                'kategori_lengan_atas' => 'Kurang Gizi (BBLR)',
                'kategori_denyut_jantung' => 'Tidak Normal',
                'kategori_hemoglobin_darah' => 'Anemia',
                'vaksin_tetanus_sebelum_hamil' => 'Belum',
                'vaksin_tetanus_sesudah_hamil' => 'Belum',
                'minum_tablet' => 'Belum',
                'konseling' => 'Belum',
                'posisi_janin' => 'Sungsang',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:15:27',
                'updated_at' => '2022-04-20 15:15:27',
            ),
            2 =>
            array(
                'id' => 'cd8ed0dc-fb33-49fd-99a6-571fa7ba06f1',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'pemeriksaan_ke' => 1,
                'kategori_badan' => 'Normal',
                'kategori_tekanan_darah' => 'Prahipertensi',
                'kategori_lengan_atas' => 'Normal',
                'kategori_denyut_jantung' => 'Normal',
                'kategori_hemoglobin_darah' => 'Normal',
                'vaksin_tetanus_sebelum_hamil' => 'Sudah',
                'vaksin_tetanus_sesudah_hamil' => 'Sudah',
                'minum_tablet' => 'Sudah',
                'konseling' => 'Sudah',
                'posisi_janin' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:19:54',
                'updated_at' => '2022-04-20 15:19:54',
            ),
            3 =>
            array(
                'id' => 'd347808d-79b3-4795-8b8c-93017ce657ea',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120009',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'pemeriksaan_ke' => 1,
                'kategori_badan' => 'Normal',
                'kategori_tekanan_darah' => 'Hipertensi',
                'kategori_lengan_atas' => 'Normal',
                'kategori_denyut_jantung' => 'Normal',
                'kategori_hemoglobin_darah' => 'Normal',
                'vaksin_tetanus_sebelum_hamil' => 'Sudah',
                'vaksin_tetanus_sesudah_hamil' => 'Sudah',
                'minum_tablet' => 'Sudah',
                'konseling' => 'Sudah',
                'posisi_janin' => 'Normal',
                'is_valid' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:20:37',
                'updated_at' => '2022-04-20 15:20:37',
            ),
        ));
    }
}
