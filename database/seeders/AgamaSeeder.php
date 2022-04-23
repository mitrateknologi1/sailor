<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'agama' => 'ISLAM',
            ],
            [
                'agama' => 'KRISTEN (PROTESTAN)',
            ],
            [
                'agama' => 'KATHOLIK',
            ],
            [
                'agama' => 'HINDU',
            ],
            [
                'agama' => 'BUDHA',
            ],
            [
                'agama' => 'KONGHUCU',
            ]
        ];

        DB::table('agama')->insert($data);


    }
}
