<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoalIbuMelahirkanStuntingSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('soal_ibu_melahirkan_stunting')->delete();

        DB::table('soal_ibu_melahirkan_stunting')->insert(array(
            0 =>
            array(
                'id' => 1,
                'urutan' => 1,
                'soal' => 'Umur ibu kurang dari 20 tahun dan lebih dari 35 tahun ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:01:10',
                'updated_at' => '2022-03-17 02:01:10',
            ),
            1 =>
            array(
                'id' => 2,
                'urutan' => 2,
                'soal' => 'Tinggi badan kurang dari 145 cm ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:02:09',
                'updated_at' => '2022-03-17 02:02:09',
            ),
            2 =>
            array(
                'id' => 3,
                'urutan' => 3,
                'soal' => 'Ukuran lingkar lengan atas kurang dari 23.5 cm ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:02:24',
                'updated_at' => '2022-03-17 02:02:24',
            ),
            3 =>
            array(
                'id' => 4,
                'urutan' => 4,
                'soal' => 'Kadar Hb kurang dari 11 Mg/dl ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:02:38',
                'updated_at' => '2022-03-17 02:02:38',
            ),
            4 =>
            array(
                'id' => 5,
                'urutan' => 5,
                'soal' => 'Mengkonsumsi kurang dari 90 butir table Fe selama kehamilan ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:03:05',
                'updated_at' => '2022-03-17 02:03:05',
            ),
            5 =>
            array(
                'id' => 6,
                'urutan' => 6,
                'soal' => 'Jarak kehamilan anak kurang dari 2 tahun atau lebih dari sama dengan 10 tahun ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:03:25',
                'updated_at' => '2022-03-17 02:03:25',
            ),
            6 =>
            array(
                'id' => 7,
                'urutan' => 7,
                'soal' => 'Paritas lebih sama dengan 4 orang ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:03:37',
                'updated_at' => '2022-03-17 02:03:37',
            ),
            7 =>
            array(
                'id' => 8,
                'urutan' => 8,
                'soal' => 'Tekanan darah ibu sama dengan 140/149 mmHg ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:04:00',
                'updated_at' => '2022-03-17 02:04:00',
            ),
            8 =>
            array(
                'id' => 9,
                'urutan' => 9,
                'soal' => 'Jarak kelahiran kurang dari 2 tahun ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:04:13',
                'updated_at' => '2022-03-17 02:04:13',
            ),
            9 =>
            array(
                'id' => 10,
                'urutan' => 10,
                'soal' => 'Memiliki penyakit DM, Hipertensi, Asma, Malaria, TBC dan PMS ?',
                'deleted_at' => NULL,
                'created_at' => '2022-03-17 02:04:42',
                'updated_at' => '2022-03-17 02:04:42',
            ),
        ));
    }
}
