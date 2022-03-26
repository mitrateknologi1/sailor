<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoalDeteksiDiniTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('soal_deteksi_dini')->delete();

        DB::table('soal_deteksi_dini')->insert(array(
            0 =>
            array(
                'id' => 1,
                'urutan' => 1,
                'soal' => 'Apakah Anda Hamil Terlalu Muda (Kurang Dari 20 Tahun ) ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-24 21:14:46',
                'updated_at' => '2022-03-24 21:14:46',
            ),
            1 =>
            array(
                'id' => 2,
                'urutan' => 2,
                'soal' => 'Apakah Anda Terlalu lambat hamil (Usia Perkawinan Sudah Lebih 4 th) ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-24 21:15:52',
                'updated_at' => '2022-03-24 21:15:52',
            ),
            2 =>
            array(
                'id' => 3,
                'urutan' => 3,
                'soal' => 'Apakah Anda Hamil Di Usia (Lebih Dari 35 Tahun) ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-24 21:16:13',
                'updated_at' => '2022-03-24 21:16:13',
            ),
            3 =>
            array(
                'id' => 4,
                'urutan' => 4,
                'soal' => 'Apakah Jarak Kehamilan Anda (Kurang Dari 2 Tahun) ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-24 21:17:10',
                'updated_at' => '2022-03-24 21:17:10',
            ),
            4 =>
            array(
                'id' => 5,
                'urutan' => 5,
                'soal' => 'Apakah Jarak Kehamilan Anda Terlalu Lama (Lebih Dari 10 Tahun) ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-24 21:19:20',
                'updated_at' => '2022-03-24 21:19:20',
            ),
            5 =>
            array(
                'id' => 6,
                'urutan' => 6,
                'soal' => 'Apakah Anda Memiliki Anak Lebih Dari 4 ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-24 21:20:00',
                'updated_at' => '2022-03-24 21:20:00',
            ),
            6 =>
            array(
                'id' => 7,
                'urutan' => 7,
                'soal' => 'Apakah Umur Anda Lebih Dari 35 Tahun ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:14:36',
                'updated_at' => '2022-03-25 09:14:36',
            ),
            7 =>
            array(
                'id' => 8,
                'urutan' => 8,
                'soal' => 'Apakah Tinggi Badan Anda Kurang dari 145cm ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:15:04',
                'updated_at' => '2022-03-25 09:15:04',
            ),
            8 =>
            array(
                'id' => 9,
                'urutan' => 9,
                'soal' => 'Apakah Anda Pernah Mengalami Kegagalan Kehamilan ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:15:28',
                'updated_at' => '2022-03-25 09:15:28',
            ),
            9 =>
            array(
                'id' => 10,
                'urutan' => 10,
                'soal' => 'Apakah Anda Pernah Melahirkan Dengan Tarikan Tang/Vakum ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:15:46',
                'updated_at' => '2022-03-25 09:15:46',
            ),
            10 =>
            array(
                'id' => 11,
                'urutan' => 11,
                'soal' => 'Apakah Anda pernah melahirkan dengan Uri Dirogoh ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:16:02',
                'updated_at' => '2022-03-25 09:16:02',
            ),
            11 =>
            array(
                'id' => 12,
                'urutan' => 12,
                'soal' => 'Apakah Anda Pernah Melahirkan dengan Diberi Infus/Transfusi Darah ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:16:27',
                'updated_at' => '2022-03-25 09:22:19',
            ),
            12 =>
            array(
                'id' => 13,
                'urutan' => 13,
                'soal' => 'Apakah Anda Pernah Melahirkan Melalui Operasi Sesar ?',
                'skor_ya' => 8,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:16:48',
                'updated_at' => '2022-03-25 09:22:32',
            ),
            13 =>
            array(
                'id' => 14,
                'urutan' => 14,
                'soal' => 'Apakah Anda Punya Penyakit Kurang Darah ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:17:03',
                'updated_at' => '2022-03-25 09:17:03',
            ),
            14 =>
            array(
                'id' => 15,
                'urutan' => 15,
                'soal' => 'Apakah Anda Punya Penyakit TBC Paru ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:17:31',
                'updated_at' => '2022-03-25 09:17:31',
            ),
            15 =>
            array(
                'id' => 16,
                'urutan' => 16,
                'soal' => 'Apakah Anda Punya Penyakit Jantung Lemah ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:17:51',
                'updated_at' => '2022-03-25 09:17:51',
            ),
            16 =>
            array(
                'id' => 17,
                'urutan' => 17,
                'soal' => 'Apakah Anda Punya Penyakit Kencing Manis / Diabetes ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:18:10',
                'updated_at' => '2022-03-25 09:18:10',
            ),
            17 =>
            array(
                'id' => 18,
                'urutan' => 18,
                'soal' => 'Apakah Anda Punya Penyakit Menular Seksual ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:18:34',
                'updated_at' => '2022-03-25 09:18:34',
            ),
            18 =>
            array(
                'id' => 19,
                'urutan' => 19,
                'soal' => 'Apakah Anda Bengkak pada Muka/Tungkai dan Tekanan Darah Tinggi ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:18:52',
                'updated_at' => '2022-03-25 09:18:52',
            ),
            19 =>
            array(
                'id' => 20,
                'urutan' => 20,
                'soal' => 'Apakah Anda Hamil Kembar 2 Atau Lebih ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:19:10',
                'updated_at' => '2022-03-25 09:19:10',
            ),
            20 =>
            array(
                'id' => 21,
                'urutan' => 21,
                'soal' => 'Apakah Anda Hamil Kembar Air (Hydraminon) ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:19:35',
                'updated_at' => '2022-03-25 09:19:35',
            ),
            21 =>
            array(
                'id' => 22,
                'urutan' => 22,
                'soal' => 'Apakah Anda Pernah Mengalami Bayi Mati dalam Kandungan ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:20:32',
                'updated_at' => '2022-03-25 09:20:32',
            ),
            22 =>
            array(
                'id' => 23,
                'urutan' => 23,
                'soal' => 'Apakah Kehamilan Anda Kelebihan Bulan ?',
                'skor_ya' => 4,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:21:01',
                'updated_at' => '2022-03-25 09:21:01',
            ),
            23 =>
            array(
                'id' => 24,
                'urutan' => 24,
                'soal' => 'Apakah Letak Bayi Anda Sungsang ?',
                'skor_ya' => 8,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:21:18',
                'updated_at' => '2022-03-25 09:21:18',
            ),
            24 =>
            array(
                'id' => 25,
                'urutan' => 25,
                'soal' => 'Apakah Letak Bayi Anda Lintang ?',
                'skor_ya' => 8,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:21:30',
                'updated_at' => '2022-03-25 09:21:30',
            ),
            25 =>
            array(
                'id' => 26,
                'urutan' => 26,
                'soal' => 'Apakah Anda Pernah Mengalami Pendarahan Pada Kehamilan Ini ?',
                'skor_ya' => 8,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:21:48',
                'updated_at' => '2022-03-25 09:21:48',
            ),
            26 =>
            array(
                'id' => 27,
                'urutan' => 27,
                'soal' => 'Apakah Anda Pre-eklampsia berat/kejang-kejang ?',
                'skor_ya' => 8,
                'skor_tidak' => 0,
                'deleted_at' => NULL,
                'created_at' => '2022-03-25 09:22:02',
                'updated_at' => '2022-03-25 09:22:02',
            ),
        ));
    }
}
