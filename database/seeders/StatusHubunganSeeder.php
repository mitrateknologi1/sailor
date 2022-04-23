<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusHubunganSeeder extends Seeder
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
                'status_hubungan' => 'KEPALA KELUARGA',
            ],
            [
                'status_hubungan' => 'SUAMI',
            ],
            [
                'status_hubungan' => 'ISTRI',
            ],
            [
                'status_hubungan' => 'ANAK',
            ],
            [
                'status_hubungan' => 'MENANTU',
            ],
            [
                'status_hubungan' => 'CUCU',
            ],
            [
                'status_hubungan' => 'ORANG TUA',
            ],
            [
                'status_hubungan' => 'MERTUA',
            ],
            [
                'status_hubungan' => 'FAMILI LAIN',
            ],
            [
                'status_hubungan' => 'PEMBANTU',
            ],
            [
                'status_hubungan' => 'LAINNYA',
            ],

          
        ];

        DB::table('status_hubungan')->insert($data);
    }
}
