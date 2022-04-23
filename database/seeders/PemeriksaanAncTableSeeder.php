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
                'id' => '55b27c8f-4807-4267-a24f-9304d3a6aad5',
                'anc_id' => 'd347808d-79b3-4795-8b8c-93017ce657ea',
                'kehamilan_ke' => 1,
                'tanggal_haid_terakhir' => '2021-12-12',
                'tinggi_badan' => 146.0,
                'berat_badan' => 80.0,
                'tekanan_darah_sistolik' => 145.0,
                'tekanan_darah_diastolik' => 90.0,
                'lengan_atas' => 24.0,
                'tinggi_fundus' => 24.0,
                'denyut_jantung_janin' => 122.0,
                'hemoglobin_darah' => 15.0,
                'tanggal_perkiraan_lahir' => '2022-09-18',
                'usia_kehamilan' => 20,
                'created_at' => '2022-04-20 15:20:37',
                'updated_at' => '2022-04-20 15:20:37',
            ),
            1 => 
            array (
                'id' => 'cb04c019-063c-4d06-9fbd-3594cd245da1',
                'anc_id' => '4ff9ba91-4778-404c-aa7f-5fd327e87e42',
                'kehamilan_ke' => 1,
                'tanggal_haid_terakhir' => '2021-12-12',
                'tinggi_badan' => 130.0,
                'berat_badan' => 80.0,
                'tekanan_darah_sistolik' => 100.0,
                'tekanan_darah_diastolik' => 90.0,
                'lengan_atas' => 21.0,
                'tinggi_fundus' => 10.0,
                'denyut_jantung_janin' => 100.0,
                'hemoglobin_darah' => 10.0,
                'tanggal_perkiraan_lahir' => '2022-09-18',
                'usia_kehamilan' => 20,
                'created_at' => '2022-04-20 15:18:09',
                'updated_at' => '2022-04-20 15:18:09',
            ),
            2 => 
            array (
                'id' => 'd9db6ba5-7a9d-47d8-a171-dd31d35dd20f',
                'anc_id' => '5ccf390e-c741-4bf2-8ae5-deb286e68e44',
                'kehamilan_ke' => 1,
                'tanggal_haid_terakhir' => '2021-12-12',
                'tinggi_badan' => 130.0,
                'berat_badan' => 80.0,
                'tekanan_darah_sistolik' => 80.0,
                'tekanan_darah_diastolik' => 90.0,
                'lengan_atas' => 21.0,
                'tinggi_fundus' => 10.0,
                'denyut_jantung_janin' => 100.0,
                'hemoglobin_darah' => 10.0,
                'tanggal_perkiraan_lahir' => '2022-09-18',
                'usia_kehamilan' => 20,
                'created_at' => '2022-04-20 15:15:27',
                'updated_at' => '2022-04-20 15:15:27',
            ),
            3 => 
            array (
                'id' => 'eff1a20e-e9bd-4a08-bb57-80d7f083f6e4',
                'anc_id' => 'cd8ed0dc-fb33-49fd-99a6-571fa7ba06f1',
                'kehamilan_ke' => 1,
                'tanggal_haid_terakhir' => '2021-12-12',
                'tinggi_badan' => 146.0,
                'berat_badan' => 80.0,
                'tekanan_darah_sistolik' => 122.0,
                'tekanan_darah_diastolik' => 90.0,
                'lengan_atas' => 24.0,
                'tinggi_fundus' => 24.0,
                'denyut_jantung_janin' => 122.0,
                'hemoglobin_darah' => 15.0,
                'tanggal_perkiraan_lahir' => '2022-09-18',
                'usia_kehamilan' => 20,
                'created_at' => '2022-04-20 15:19:54',
                'updated_at' => '2022-04-20 15:19:54',
            ),
        ));
        
        
    }
}