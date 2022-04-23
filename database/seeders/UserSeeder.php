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
                'id' => 1,
                'nomor_hp' => '081234567891',
                'nik' => '1234567890123451',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'nomor_hp' => '081234567892',
                'nik' => '1234567890123452',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'nomor_hp' => '081234567893',
                'nik' => '1234567890123453',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'nomor_hp' => '081234567894',
                'nik' => '1234567890123454',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'nomor_hp' => '081234567895',
                'nik' => '1234567890123455',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'bidan',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'nomor_hp' => '081234567896',
                'nik' => '1234567890123456',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'penyuluh',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 7,
                'nomor_hp' => '081234567897',
                'nik' => '1234567890123457',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 8,
                'nomor_hp' => '081234567898',
                'nik' => '1234567890123458',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 9,
                'nomor_hp' => '081234567899',
                'nik' => '1234567890123459',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'penyuluh',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 10,
                'nomor_hp' => '081234567890',
                'nik' => '1234567890123450',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'penyuluh',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 11,
                'nomor_hp' => '081234567881',
                'nik' => '1234567890123441',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'nomor_hp' => '081234567882',
                'nik' => '1234567890123442',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'id' => 13,
                'nomor_hp' => '081234567883',
                'nik' => '1234567890123443',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'keluarga',
                'status' => 1,
                'created_at' => now(),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
