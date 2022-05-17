<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e80', //1 // JANGAN DIUBAH ATAU DIHAPUS
                'nomor_hp' => '081234567891',
                'nik' => '1234567890123451',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e81', //2
                'nomor_hp' => '081234567892',
                'nik' => '1234567890123452',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e82', //3
                'nomor_hp' => '081234567893',
                'nik' => '1234567890123453',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e83', //4
                'nomor_hp' => '081234567894',
                'nik' => null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e84', //5
                'nomor_hp' => '081234567895',
                'nik' => null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e85', //6
                'nomor_hp' => '081234567896',
                'nik' => '1234567890123456',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'penyuluh',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e86', //7
                'nomor_hp' => '081234567897',
                'nik' => '1234567890123457',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e87', //8
                'nomor_hp' => '081234567898',
                'nik' => '1234567890123458',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e88', //9
                'nomor_hp' => '081234567899',
                'nik' => '1234567890123459',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'penyuluh',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e89', //10
                'nomor_hp' => '081234567890',
                'nik' => null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'penyuluh',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e90', //11
                'nomor_hp' => '081234567881',
                'nik' => '1234567890123441',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e91', //12
                'nomor_hp' => '081234567882',
                'nik' => '1234567890123442',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'is_remaja' => 0,
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e92', //13
                'nomor_hp' => '081234567883',
                'nik' => '1234567890123443',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'is_remaja' => 0,
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e93', //14
                'nomor_hp' => '081234567884',
                'nik' => null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'is_remaja' => 0,
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e94', //14
                'nomor_hp' => null,
                'nik' => 1234567890123445,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'is_remaja' => 1,
                'status' => 1,
                'created_at' => now(),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
