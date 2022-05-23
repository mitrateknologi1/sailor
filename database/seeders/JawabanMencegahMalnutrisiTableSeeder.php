<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JawabanMencegahMalnutrisiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jawaban_mencegah_malnutrisi')->delete();
        
        \DB::table('jawaban_mencegah_malnutrisi')->insert(array (
            0 => 
            array (
                'id' => '1184e7b7-5b9b-4fea-8e57-272a24d0fce2',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 5,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
            1 => 
            array (
                'id' => '305b4258-7310-48b8-b919-4d9472de452b',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 6,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
            2 => 
            array (
                'id' => '5a1d97f2-b280-4c21-8d22-3641c6e884f4',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 3,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
            3 => 
            array (
                'id' => '8d043e09-7cc8-434f-b1a0-8a22c63031a7',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 7,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
            4 => 
            array (
                'id' => 'a162ab84-53cd-436b-94e9-ef230031aa9c',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 1,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
            5 => 
            array (
                'id' => 'a217edf3-b308-489d-9af4-889fd52515a4',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 2,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
            6 => 
            array (
                'id' => 'eb3cac27-7cc3-4712-a848-f6c2f2a1efdd',
                'mencegah_malnutrisi_id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'soal_id' => 4,
                'jawaban' => 'Tidak',
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
        ));
        
        
    }
}