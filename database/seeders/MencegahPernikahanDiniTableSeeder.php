<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MencegahPernikahanDiniTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mencegah_pernikahan_dini')->delete();
        
        \DB::table('mencegah_pernikahan_dini')->insert(array (
            0 => 
            array (
                'id' => 1,
                'randa_kabilasa_id' => 'f9296b8e-98c3-4d73-971c-85c1d8260b8a',
                'jawaban_1' => 'Tidak',
                'jawaban_2' => 'Ya',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:48:20',
                'updated_at' => '2022-04-20 15:48:20',
            ),
            1 => 
            array (
                'id' => 2,
                'randa_kabilasa_id' => '91a495b6-05a7-4d85-97ed-db43aa569dd8',
                'jawaban_1' => 'Tidak',
                'jawaban_2' => 'Ya',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:48:31',
                'updated_at' => '2022-04-20 15:48:31',
            ),
            2 => 
            array (
                'id' => 81,
                'randa_kabilasa_id' => '9b73f115-d9cb-48dd-a834-96dec3cffb0a',
                'jawaban_1' => 'Ya',
                'jawaban_2' => 'Tidak',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:49:27',
                'updated_at' => '2022-04-20 15:49:27',
            ),
            3 => 
            array (
                'id' => 880,
                'randa_kabilasa_id' => '05c81592-c703-47a7-afa5-1d6cb4fe7d96',
                'jawaban_1' => 'Tidak',
                'jawaban_2' => 'Ya',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:49:15',
                'updated_at' => '2022-04-20 15:49:15',
            ),
            4 => 
            array (
                'id' => 4141,
                'randa_kabilasa_id' => '44b98ef8-f702-4fcd-a87b-f1bf0bd960a6',
                'jawaban_1' => 'Ya',
                'jawaban_2' => 'Tidak',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:48:52',
                'updated_at' => '2022-04-20 15:48:52',
            ),
            5 => 
            array (
                'id' => 9117,
                'randa_kabilasa_id' => '1709b6a1-de97-49d2-9a6e-2869ec5344a7',
                'jawaban_1' => 'Ya',
                'jawaban_2' => 'Tidak',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:48:42',
                'updated_at' => '2022-04-20 15:48:42',
            ),
            6 => 
            array (
                'id' => 9118,
                'randa_kabilasa_id' => '4dbaff89-0515-4c26-875c-87e083513add',
                'jawaban_1' => 'Tidak',
                'jawaban_2' => 'Ya',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:49:04',
                'updated_at' => '2022-04-20 15:49:04',
            ),
            7 => 
            array (
                'id' => 9119,
                'randa_kabilasa_id' => 'ceead75b-7e43-42ae-8244-e05348f51f32',
                'jawaban_1' => 'Ya',
                'jawaban_2' => 'Tidak',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:49:38',
                'updated_at' => '2022-04-20 15:49:38',
            ),
            8 => 
            array (
                'id' => 9120,
                'randa_kabilasa_id' => '6eb6f3bf-69cf-499c-bc08-ac0b2f6388b1',
                'jawaban_1' => 'Ya',
                'jawaban_2' => 'Tidak',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-04-20 15:53:59',
                'updated_at' => '2022-04-20 15:53:59',
            ),
        ));
        
        
    }
}