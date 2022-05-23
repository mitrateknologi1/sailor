<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PemeriksaanAncTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pemeriksaan_anc')->delete();
        
        \DB::table('pemeriksaan_anc')->insert(array (
            0 => 
            array (
                'id' => 'c4b188a1-74d7-4aca-bb89-d2045a3553cb',
                'anc_id' => 'e1b5c712-b4e7-4af6-87e1-17985d4e039e',
                'kehamilan_ke' => 1,
                'tanggal_haid_terakhir' => '2022-02-02',
                'tinggi_badan' => 180.0,
                'berat_badan' => 80.0,
                'tekanan_darah_sistolik' => 110.0,
                'tekanan_darah_diastolik' => 80.0,
                'lengan_atas' => 180.0,
                'tinggi_fundus' => 80.0,
                'denyut_jantung_janin' => 130.0,
                'hemoglobin_darah' => 180.0,
                'tanggal_perkiraan_lahir' => '2022-11-08',
                'usia_kehamilan' => 22,
                'created_at' => '2022-05-22 18:37:03',
                'updated_at' => '2022-05-22 18:37:03',
            ),
            1 => 
            array (
                'id' => 'f08138de-cbc4-4aa8-910e-0eb1c842a6ad',
                'anc_id' => 'ddeebd85-dafa-4c9a-a9a3-06b07c0eb9e6',
                'kehamilan_ke' => 1,
                'tanggal_haid_terakhir' => '2022-02-03',
                'tinggi_badan' => 120.0,
                'berat_badan' => 80.0,
                'tekanan_darah_sistolik' => 70.0,
                'tekanan_darah_diastolik' => 90.0,
                'lengan_atas' => 19.0,
                'tinggi_fundus' => 100.0,
                'denyut_jantung_janin' => 110.0,
                'hemoglobin_darah' => 9.0,
                'tanggal_perkiraan_lahir' => '2022-11-09',
                'usia_kehamilan' => 23,
                'created_at' => '2022-05-22 18:47:42',
                'updated_at' => '2022-05-22 18:47:42',
            ),
        ));
        
        
    }
}