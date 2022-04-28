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
                'id' => 'de2a4fde-c4a2-11ec-9d64-0242ac120002', //1
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002', //1
                'nomor_kk' => 7206091803080165,
                'nama_kepala_keluarga' => 'KEVIN',
                'alamat' => 'JL. RAYA CIKAMPEK NO. 1',
                'rt' => '1',
                'rw' => '2',
                'kode_pos' => '81110',
                'desa_kelurahan_id' => 7271031001,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                // 'dikeluarkan_tanggal' => '2022-03-12',
                // 'dikeluarkan_oleh' => 'DIGGIE',
                'file_kk' => null,
                'is_valid' => 1,
                'tanggal_validasi' => now(),
                'alasan_ditolak' => null,
                'created_at' => now(),
            ],
            [
                'id' => 'de2a4fde-c4a2-11ec-9d64-0242ac120003', //2
                'bidan_id' =>  null,
                'nomor_kk' => 8902983209900001,
                'nama_kepala_keluarga' => 'RANGGA',
                'alamat' => 'JL. SETAPAK NO. 1',
                'rt' => '1',
                'rw' => '3',
                'kode_pos' => '81110',
                'desa_kelurahan_id' => 7271031001,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                // 'dikeluarkan_tanggal' => '2021-01-11',
                // 'dikeluarkan_oleh' => 'ROGER',
                'file_kk' => null,
                'is_valid' => 0,
                'tanggal_validasi' => null,
                'alasan_ditolak' => null,
                'created_at' => now(),
            ],
            [
                'id' => 'de2a4fde-c4a2-11ec-9d64-0242ac120004', //3
                'bidan_id' =>  null,
                'nomor_kk' => 8902983209921088,
                'nama_kepala_keluarga' => 'AHMAD',
                'alamat' => 'JL. JALAN NO. 1',
                'rt' => '1',
                'rw' => '4',
                'kode_pos' => '81110',
                'desa_kelurahan_id' => 7271031005,
                'kecamatan_id' => 7271031,
                'kabupaten_kota_id' => 7271,
                'provinsi_id' => 72,
                // 'dikeluarkan_tanggal' => '2021-01-11',
                // 'dikeluarkan_oleh' => 'ROGER',
                'file_kk' => null,
                'is_valid' => 0,
                'tanggal_validasi' => null,
                'alasan_ditolak' => null,
                'created_at' => now(),
            ],
        ];
        DB::table('kartu_keluarga')->insert($data);
    }
}
