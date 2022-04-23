<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
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
                'pendidikan' => 'TIDAK/BELUM SEKOLAH',
            ],
            [
                'pendidikan' => 'BELUM TAMAT SD/SEDERAJAT',
            ],
            [
                'pendidikan' => 'TAMAT SD/SEDERAJAT',
            ],
            [
                'pendidikan' => 'SLTP/SEDERAJAT',
            ],
            [
                'pendidikan' => 'SLTA/SEDERAJAT',
            ],
            [
                'pendidikan' => 'DIPLOMA I/II',
            ],
            [
                'pendidikan' => 'AKADEMI/DIPLOMA III/S. MUDA',
            ],
            [
                'pendidikan' => 'DIPLOMA IV/STRATA I',
            ],
            [
                'pendidikan' => 'STRATA II',
            ],
            [
                'pendidikan' => 'STRATA III',
            ]
        ];

        DB::table('pendidikan')->insert($data);
    }
}
