<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahDomisiliSeeder extends Seeder
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
                'anggota_keluarga_id' => 1,
                'alamat' => 'Jl. Raya',
                'desa_kelurahan_id' => 7271031006,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_ket_domisili' => null,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'anggota_keluarga_id' => 2,
                'alamat' => 'Jl. Raya',
                'desa_kelurahan_id' => 7271031006,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_ket_domisili' => null,
                'created_at' => now(),
            ],
            /////////////////////////
            [
                'id' => 3,
                'anggota_keluarga_id' => 3,
                'alamat' => 'Jl. Raya',
                'desa_kelurahan_id' => 7271031004,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_ket_domisili' => null,
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'anggota_keluarga_id' => 4,
                'alamat' => 'Jl. Raya',
                'desa_kelurahan_id' => 7271031004,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_ket_domisili' => null,
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'anggota_keluarga_id' => 5,
                'alamat' => 'Jl. Raya',
                'desa_kelurahan_id' => 7271031004,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_ket_domisili' => null,
                'created_at' => now(),
            ],


        ];

        DB::table('wilayah_domisili')->insert($data);
    }
}