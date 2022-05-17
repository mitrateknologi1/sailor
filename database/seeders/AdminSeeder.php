<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
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
                'id' => 'f63782d8-c4a5-11ec-9d64-0242ac120002', //1
                'user_id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e80',
                'nik' => 1234567890123451,
                'nama_lengkap' => 'ADMIN 1',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'nomor_hp' => '081234567891',
                'email' => 'test@email.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7271031006,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => now(),
            ],
            [
                'id' => 'f63782d8-c4a5-11ec-9d64-0242ac120003', //2
                'user_id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e86',
                'nik' => 1234567890123457,
                'nama_lengkap' => 'ADMIN 2',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'nomor_hp' => '081234567897',
                'email' => 'test@email.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7271031006,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => now(),
            ],
            [
                'id' => 'f63782d8-c4a5-11ec-9d64-0242ac120004', //3
                'user_id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e87',
                'nik' => 1234567890123458,
                'nama_lengkap' => 'ADMIN 3',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'nomor_hp' => '081234567898',
                'email' => 'test@email.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7271031006,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => now(),
            ],
        ];
        DB::table('admin')->insert($data);
    }
}
