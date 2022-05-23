<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JawabanMeningkatkanLifeSkillTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jawaban_meningkatkan_life_skill')->delete();
        
        \DB::table('jawaban_meningkatkan_life_skill')->insert(array (
            0 => 
            array (
                'id' => '09884149-fb7d-4c71-a074-a539fad3fc1f',
                'randa_kabilasa_id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'soal_id' => 3,
                'jawaban' => 'Ya',
                'created_at' => '2022-05-22 18:54:20',
                'updated_at' => '2022-05-22 18:54:20',
            ),
            1 => 
            array (
                'id' => '0bdacdb6-f84d-4812-a34c-70fc2304b35a',
                'randa_kabilasa_id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'soal_id' => 4,
                'jawaban' => 'Ya',
                'created_at' => '2022-05-22 18:54:20',
                'updated_at' => '2022-05-22 18:54:20',
            ),
            2 => 
            array (
                'id' => '65734d5b-8832-43f7-bb1e-d30beb8f70f1',
                'randa_kabilasa_id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'soal_id' => 2,
                'jawaban' => 'Ya',
                'created_at' => '2022-05-22 18:54:20',
                'updated_at' => '2022-05-22 18:54:20',
            ),
            3 => 
            array (
                'id' => '65763641-e93d-47e9-9e54-6f20fa415e6d',
                'randa_kabilasa_id' => 'c35a5b33-b1c6-4e73-812e-6d9c713c5cb9',
                'soal_id' => 1,
                'jawaban' => 'Ya',
                'created_at' => '2022-05-22 18:54:20',
                'updated_at' => '2022-05-22 18:54:20',
            ),
        ));
        
        
    }
}