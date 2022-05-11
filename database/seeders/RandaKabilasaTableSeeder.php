<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RandaKabilasaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('randa_kabilasa')->delete();

        \DB::table('randa_kabilasa')->insert(array(
            0 =>
            array(
                'id' => '05c81592-c703-47a7-afa5-1d6cb4fe7d96',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120002',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Terindikasi Anemia',
                'kategori_lingkar_lengan_atas' => 'Kurang Gizi',
                'kategori_imt' => 'Sangat Kurus',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:39:21',
                'updated_at' => '2022-04-20 15:49:15',
            ),
            1 =>
            array(
                'id' => '1709b6a1-de97-49d2-9a6e-2869ec5344a7',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120006',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Anemia',
                'kategori_lingkar_lengan_atas' => 'Normal',
                'kategori_imt' => 'Gemuk',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Tidak Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:27:57',
                'updated_at' => '2022-04-20 15:48:42',
            ),
            2 =>
            array(
                'id' => '44b98ef8-f702-4fcd-a87b-f1bf0bd960a6',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120007',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Terindikasi Anemia',
                'kategori_lingkar_lengan_atas' => 'Kurang Gizi',
                'kategori_imt' => 'Sangat Gemuk',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Tidak Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:36:48',
                'updated_at' => '2022-04-20 15:48:52',
            ),
            3 =>
            array(
                'id' => '4dbaff89-0515-4c26-875c-87e083513add',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000a',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Normal',
                'kategori_lingkar_lengan_atas' => 'Kurang Gizi',
                'kategori_imt' => 'Kurus',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:38:57',
                'updated_at' => '2022-04-20 15:52:17',
            ),
            4 =>
            array(
                'id' => '6eb6f3bf-69cf-499c-bc08-ac0b2f6388b1',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120002',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Normal',
                'kategori_lingkar_lengan_atas' => 'Normal',
                'kategori_imt' => 'Sangat Gemuk',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Tidak Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:53:26',
                'updated_at' => '2022-04-20 15:53:59',
            ),
            5 =>
            array(
                'id' => '91a495b6-05a7-4d85-97ed-db43aa569dd8',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120005',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Normal',
                'kategori_lingkar_lengan_atas' => 'Normal',
                'kategori_imt' => 'Normal',
                'kategori_mencegah_malnutrisi' => 'Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:26:49',
                'updated_at' => '2022-04-20 15:48:31',
            ),
            6 =>
            array(
                'id' => '9b73f115-d9cb-48dd-a834-96dec3cffb0a',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120002',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Anemia',
                'kategori_lingkar_lengan_atas' => 'Normal',
                'kategori_imt' => 'Gemuk',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Tidak Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:40:13',
                'updated_at' => '2022-04-20 15:51:41',
            ),
            7 =>
            array(
                'id' => 'ceead75b-7e43-42ae-8244-e05348f51f32',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120002',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Normal',
                'kategori_lingkar_lengan_atas' => 'Normal',
                'kategori_imt' => 'Normal',
                'kategori_mencegah_malnutrisi' => 'Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Tidak Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:41:01',
                'updated_at' => '2022-04-20 15:49:38',
            ),
            8 =>
            array(
                'id' => 'f9296b8e-98c3-4d73-971c-85c1d8260b8a',
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120004',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'is_mencegah_malnutrisi' => 1,
                'is_mencegah_pernikahan_dini' => 1,
                'is_meningkatkan_life_skill' => 1,
                'kategori_hb' => 'Terindikasi Anemia',
                'kategori_lingkar_lengan_atas' => 'Kurang Gizi',
                'kategori_imt' => 'Sangat Kurus',
                'kategori_mencegah_malnutrisi' => 'Tidak Berpartisipasi Mencegah Stunting',
                'kategori_meningkatkan_life_skill' => 'Berpartisipasi Mencegah Stunting',
                'kategori_mencegah_pernikahan_dini' => 'Berpartisipasi Mencegah Stunting',
                'is_valid_mencegah_malnutrisi' => 1,
                'is_valid_mencegah_pernikahan_dini' => 1,
                'is_valid_meningkatkan_life_skill' => 1,
                'tanggal_validasi' => '2022-04-20',
                'created_at' => '2022-04-20 15:26:02',
                'updated_at' => '2022-04-20 15:48:20',
            ),
        ));
    }
}
