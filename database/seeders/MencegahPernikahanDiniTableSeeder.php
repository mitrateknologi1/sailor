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
                'id' => 18,
                'randa_kabilasa_id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'jawaban_1' => 'Tidak',
                'jawaban_2' => 'Ya',
                'jawaban_3' => 'Tidak',
                'created_at' => '2022-05-22 18:54:35',
                'updated_at' => '2022-05-22 18:54:35',
            ),
        ));
        
        
    }
}