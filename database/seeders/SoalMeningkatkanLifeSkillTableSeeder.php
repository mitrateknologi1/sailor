<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoalMeningkatkanLifeSkillTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('soal_meningkatkan_life_skill')->delete();

        DB::table('soal_meningkatkan_life_skill')->insert(array(
            0 =>
            array(
                'id' => 1,
                'urutan' => 1,
                'soal' => 'Apakah Anda sudah punya usaha / peluang usaha ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 15:03:19',
                'updated_at' => '2022-04-02 15:03:19',
            ),
            1 =>
            array(
                'id' => 2,
                'urutan' => 2,
                'soal' => 'Apakah Anda ingin melanjutkan pendidikan ke tingkat yang lebih tinggi ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 15:03:30',
                'updated_at' => '2022-04-02 15:03:30',
            ),
            2 =>
            array(
                'id' => 3,
                'urutan' => 3,
                'soal' => 'Apakah Anda Saat ini giat meningkatkan potensi diri sesuai hobi anda ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 15:03:39',
                'updated_at' => '2022-04-02 15:03:39',
            ),
            3 =>
            array(
                'id' => 4,
                'urutan' => 4,
                'soal' => 'Apakah Anda Saat ini aktif berkegiatan Extrakurikuler disekolah atau di perguruan tinggi ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 15:03:48',
                'updated_at' => '2022-04-02 15:03:48',
            ),
        ));
    }
}
