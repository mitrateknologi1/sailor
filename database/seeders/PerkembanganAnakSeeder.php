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
        DB::table('perkembangan_anak')->insert(array(
            0 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120002', //1
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000b',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'created_at' => '2022-04-01 17:58:42',
                'id' => 1,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:23:45',
            ),
            1 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120003', //2
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120004',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'created_at' => '2022-04-01 21:11:16',
                'id' => 2,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:11:32',
            ),
            2 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120004', //3
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120005',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'created_at' => '2022-04-01 21:11:49',
                'id' => 3,
                'is_valid' => 1,
                'motorik_halus' => 'Keterampilan tangan mulai membaik, pada usia 3 tahun belajar menggunting kertas, belajar bernyanyi dan membuat coretan sederhana',
                'motorik_kasar' => 'Sudah pandai berlari, berolah raga, dan dapat meloncat',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:11:49',
            ),
            3 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120005', //4
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000a',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'created_at' => '2022-04-01 21:12:27',
                'id' => 4,
                'is_valid' => 1,
                'motorik_halus' => 'Menggambar dengan pola proporsional, memakai dan mengancingkan baju, menulis, lancar membaca, sudah bisa berhitung, belajar bahasa asing, mulai belajar memainkan alat musik',
                'motorik_kasar' => 'Mampu meloncat tali setinggi 25 cm, belajar naik sepeda',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:12:27',
            ),
            4 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120006', //5
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000b',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120002',
                'created_at' => '2022-04-01 21:13:03',
                'id' => 5,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:13:03',
            ),
            5 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120007', //6
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000c',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'created_at' => '2022-04-01 21:14:04',
                'id' => 6,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar membaca berhitung, menggambar, mewarnai dan merangkai kalimat dengan baik',
                'motorik_kasar' => 'Dapat berdiri satu kaki, mulai dapat menari, melakukan gerakan olah tubuh, keseimbangan tubuh mulai membaik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:15:57',
            ),
            6 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120008', //7
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120006',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'created_at' => '2022-04-01 21:14:38',
                'id' => 7,
                'is_valid' => 1,
                'motorik_halus' => 'Mulai belajar berbicara, mempunyai ketertarikan terhadap jenis-jenis benda dan mulai muncul rasa ingin tahu',
                'motorik_kasar' => 'Belajar berjalan dan berlari, mulai bermain, dan koordinasi mata semakin baik',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:14:38',
            ),
            7 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120009', //8
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac120007',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'created_at' => '2022-04-01 21:14:46',
                'id' => 8,
                'is_valid' => 1,
                'motorik_halus' => 'Mengoceh, sudah mengenal wajah seseorang, bisa membedakan suara, belajar makan dan mengunyah',
                'motorik_kasar' => 'Dapat menegakkan kepala, belajar tengkurap sampai dengan duduk (pada usia 8-9 bulan), memainkan ibu jari kaki',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:14:46',
            ),
            8 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120010', //9
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000e',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'created_at' => '2022-04-01 21:17:57',
                'id' => 9,
                'is_valid' => 1,
                'motorik_halus' => 'Keterampilan tangan mulai membaik, pada usia 3 tahun belajar menggunting kertas, belajar bernyanyi dan membuat coretan sederhana',
                'motorik_kasar' => 'Sudah pandai berlari, berolah raga, dan dapat meloncat',
                'tanggal_validasi' => '2022-04-01',
                'updated_at' => '2022-04-01 21:17:57',
            ),
            9 =>
            array(
                'id' => 'e66ebfd4-c4a4-11ec-9d64-0242ac120011', //10
                'anggota_keluarga_id' => '674085d6-c4a3-11ec-9d64-0242ac12000c',
                'bidan_id' => '9b6120ac-c4a1-11ec-9d64-0242ac120003',
                'created_at' => '2022-04-01 21:24:10',
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
