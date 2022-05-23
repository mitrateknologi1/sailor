<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MencegahMalnutrisiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mencegah_malnutrisi')->delete();
        
        \DB::table('mencegah_malnutrisi')->insert(array (
            0 => 
            array (
                'id' => '2174ccf1-992d-40b3-a283-e00b538c8700',
                'randa_kabilasa_id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'lingkar_lengan_atas' => 180.0,
                'tinggi_badan' => 180.0,
                'berat_badan' => 76.0,
                'created_at' => '2022-05-22 18:53:38',
                'updated_at' => '2022-05-22 18:53:38',
            ),
        ));
        
        
    }
}