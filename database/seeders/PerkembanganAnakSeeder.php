<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerkembanganAnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perkembangan_anak')->delete();
        
        DB::table('perkembangan_anak')->insert(array (
            0 => 
            array (
                'anggota_keluarga_id' => 10,
                'bidan_id' => 2,
                'created_at' => '2022-04-01 17:58:42',
                'deleted_at' => '2022-04-01 21:23:45',
                'id' => 1,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:23:45',
            ),
            1 => 
            array (
                'anggota_keluarga_id' => 3,
                'bidan_id' => 1,
                'created_at' => '2022-04-01 21:11:16',
                'deleted_at' => NULL,
                'id' => 2,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:11:32',
            ),
            2 => 
            array (
                'anggota_keluarga_id' => 4,
                'bidan_id' => 1,
                'created_at' => '2022-04-01 21:11:49',
                'deleted_at' => NULL,
                'id' => 3,
                'is_valid' => 1,
                'motorik_halus' => 'Keterampilan tangan mulai membaik, pada usia 3 tahun belajar menggunting kertas, belajar bernyanyi dan membuat coretan sederhana',
                'motorik_kasar' => 'Sudah pandai berlari, berolah raga, dan dapat meloncat',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:11:49',
            ),
            3 => 
            array (
                'anggota_keluarga_id' => 9,
                'bidan_id' => 1,
                'created_at' => '2022-04-01 21:12:27',
                'deleted_at' => NULL,
                'id' => 4,
                'is_valid' => 1,
                'motorik_halus' => 'Menggambar dengan pola proporsional, memakai dan mengancingkan baju, menulis, lancar membaca, sudah bisa berhitung, belajar bahasa asing, mulai belajar memainkan alat musik',
                'motorik_kasar' => 'Mampu meloncat tali setinggi 25 cm, belajar naik sepeda',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:12:27',
            ),
            4 => 
            array (
                'anggota_keluarga_id' => 10,
                'bidan_id' => 1,
                'created_at' => '2022-04-01 21:13:03',
                'deleted_at' => NULL,
                'id' => 5,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:13:03',
            ),
            5 => 
            array (
                'anggota_keluarga_id' => 11,
                'bidan_id' => 2,
                'created_at' => '2022-04-01 21:14:04',
                'deleted_at' => NULL,
                'id' => 6,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:15:57',
            ),
            6 => 
            array (
                'anggota_keluarga_id' => 5,
                'bidan_id' => 2,
                'created_at' => '2022-04-01 21:14:38',
                'deleted_at' => NULL,
                'id' => 7,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar berbicara, mempunyai ketertarikan terhadap jenis-jenis benda dan mulai muncul rasa ingin tahu',
                'motorik_kasar' => 'Belajar berjalan dan berlari, mulai bermain, dan koordinasi mata semakin baik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:14:38',
            ),
            7 => 
            array (
                'anggota_keluarga_id' => 6,
                'bidan_id' => 2,
                'created_at' => '2022-04-01 21:14:46',
                'deleted_at' => NULL,
                'id' => 8,
                'is_valid' => 1,
                'motorik_halus' => 'Mengoceh, sudah mengenal wajah seseorang, bisa membedakan suara, belajar makan dan mengunyah',
            'motorik_kasar' => 'Dapat menegakkan kepala, belajar tengkurap sampai dengan duduk (pada usia 8-9 bulan), memainkan ibu jari kaki',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:14:46',
            ),
            8 => 
            array (
                'anggota_keluarga_id' => 13,
                'bidan_id' => 2,
                'created_at' => '2022-04-01 21:17:57',
                'deleted_at' => NULL,
                'id' => 9,
                'is_valid' => 1,
                'motorik_halus' => 'Keterampilan tangan mulai membaik, pada usia 3 tahun belajar menggunting kertas, belajar bernyanyi dan membuat coretan sederhana',
                'motorik_kasar' => 'Sudah pandai berlari, berolah raga, dan dapat meloncat',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:17:57',
            ),
            9 => 
            array (
                'anggota_keluarga_id' => 11,
                'bidan_id' => 2,
                'created_at' => '2022-04-01 21:24:10',
                'deleted_at' => '2022-04-01 21:24:25',
                'id' => 10,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:24:25',
            ),
        ));
    }
}
