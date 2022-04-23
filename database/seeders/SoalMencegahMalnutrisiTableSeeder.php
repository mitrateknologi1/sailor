<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoalMencegahMalnutrisiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('soal_mencegah_malnutrisi')->delete();

        DB::table('soal_mencegah_malnutrisi')->insert(array(
            0 =>
            array(
                'id' => 1,
                'urutan' => 1,
                'soal' => 'Apakah Beberapa Waktu Terakhir Anda Sering Mengalami Sakit Kepala ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:08:15',
                'updated_at' => '2022-04-02 14:08:15',
            ),
            1 =>
            array(
                'id' => 2,
                'urutan' => 2,
                'soal' => 'Apakah Beberapa Waktu Terakhir Anda Susah Berkonsentrasi ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:08:29',
                'updated_at' => '2022-04-02 14:08:29',
            ),
            2 =>
            array(
                'id' => 3,
                'urutan' => 3,
                'soal' => 'Apakah Beberapa Waktu Terakhir Detak Jantung Anda Terasa Cepat ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:08:43',
                'updated_at' => '2022-04-02 14:08:43',
            ),
            3 =>
            array(
                'id' => 4,
                'urutan' => 4,
                'soal' => 'Apakah Beberapa Waktu Terakhir Anda Merasa Sesak Napas ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:08:52',
                'updated_at' => '2022-04-02 14:08:52',
            ),
            4 =>
            array(
                'id' => 5,
                'urutan' => 5,
                'soal' => 'Apakah Beberapa Waktu Terakhir Tangan Atau Kaki Anda Bengkak ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:09:01',
                'updated_at' => '2022-04-02 14:09:01',
            ),
            5 =>
            array(
                'id' => 6,
                'urutan' => 6,
                'soal' => 'Apakah Beberapa Waktu Terakhir Anda Mengalami Pusing Hingga Pingsan ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:09:18',
                'updated_at' => '2022-04-02 14:09:18',
            ),
            6 =>
            array(
                'id' => 7,
                'urutan' => 7,
                'soal' => 'Apakah Beberapa Waktu Terakhir Anda Mengalami Sakit Perut Saat Menstruasi ?',
                'skor_ya' => 1,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-04-02 14:09:35',
                'updated_at' => '2022-04-02 14:09:35',
            ),
        ));
    }
}
