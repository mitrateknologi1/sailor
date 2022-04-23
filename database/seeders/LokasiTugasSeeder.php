<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiTugasSeeder extends Seeder
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
                'id' => 1,
                'jenis_profil' => 'bidan',
                'profil_id' => 1,
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'created_at' => now(),
            ],

            // [
            //     'id' => 2,
            //     'jenis_profil' => 'bidan',
            //     'profil_id' => 2,
            //     'desa_kelurahan_id' => 7271031006,
            //     'kecamatan_id' => 7271031,
            //     'kabupaten_kota_id' => 7271,
            //     'provinsi_id' => 72,
            //     'created_at' => now(),
            // ],
            [
                'id' => 2,
                'jenis_profil' => 'bidan',
                'profil_id' => 2,
                'desa_kelurahan_id' => 7210110011,
                'kecamatan_id' => 7210110,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'jenis_profil' => 'penyuluh',
                'profil_id' => 1,
                'desa_kelurahan_id' => 7271031004,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'created_at' => now(),
            ],

        ];

        DB::table('lokasi_tugas')->insert($data);
    }
}
