<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPerkawinanSeeder extends Seeder
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
                'status_perkawinan' => 'BELUM KAWIN',
            ],
            [
                'status_perkawinan' => 'KAWIN BELUM TERCATAT',
            ],
            [
                'status_perkawinan' => 'KAWIN TERCATAT',
            ],
            [
                'status_perkawinan' => 'CERAI HIDUP',
            ],
            [
                'status_perkawinan' => 'CERAI MATI',
            ],
          
        ];

        DB::table('status_perkawinan')->insert($data);
    }
}
