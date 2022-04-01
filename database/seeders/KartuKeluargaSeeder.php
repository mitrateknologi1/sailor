<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KartuKeluargaSeeder extends Seeder
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
                'akun_id' => '1',
                'nomor_kk' => 7206091803080165,
                'nama_kepala_keluarga' => 'KEVIN',
                'alamat' => 'JL. RAYA CIKAMPEK NO. 1',
                'rt' => '1',
                'rw' => '1',
                'kode_pos' => '81110',
                'desa_kelurahan_id' => 7373020003,
                'kecamatan_id' => 7373020,
                'kabupaten_kota_id' => 7373,
                'provinsi_id' => 73,
                'dikeluarkan_tanggal' => '2022-03-12',
                'dikeluarkan_oleh' => 'DIGGIE',
                'foto_kk' => 'example.pdf',
                'is_valid' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'akun_id' => '1',
                'nomor_kk' => 8902983209900001,
                'nama_kepala_keluarga' => 'RANGGA',
                'alamat' => 'JL. SETAPAK NO. 1',
                'rt' => '1',
                'rw' => '1',
                'kode_pos' => '81110',
                'desa_kelurahan_id' => 7373020003,
                'kecamatan_id' => 7373020,
                'kabupaten_kota_id' => 7373,
                'provinsi_id' => 73,
                'dikeluarkan_tanggal' => '2021-01-11',
                'dikeluarkan_oleh' => 'ROGER',
                'foto_kk' => 'example.pdf',
                'is_valid' => 1,
                'created_at' => now(),
            ],
        ];
        DB::table('kartu_keluarga')->insert($data);
    }
}
