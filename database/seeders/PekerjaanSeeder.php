<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
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
                'pekerjaan' => 'BELUM/TIDAK BEKERJA',
            ],
            [
                'pekerjaan' => 'MENGURUS RUMAH TANGGA',
            ],
            [
                'pekerjaan' => 'PELAJAR/MAHASISWA',
            ],
            [
                'pekerjaan' => 'PENSIUNAN',
            ],
            [
                'pekerjaan' => 'PEGAWAI NEGERI SIPIL',
            ],
            [
                'pekerjaan' => 'TENTARA NASIONAL INDONESIA',
            ],
            [
                'pekerjaan' => 'KEPOLISIAN RI',
            ],
            [
                'pekerjaan' => 'PERDAGANGAN',
            ],
            [
                'pekerjaan' => 'PETANI/PEKEBUN',
            ],
            [
                'pekerjaan' => 'PETERNAK',
            ],


            [
                'pekerjaan' => 'NELAYAN/PERIKANAN',
            ],
            [
                'pekerjaan' => 'INDUSTRI',
            ],
            [
                'pekerjaan' => 'KONSTRUKSI',
            ],
            [
                'pekerjaan' => 'TRANSPORTASI',
            ],
            [
                'pekerjaan' => 'KARYAWAN SWASTA',
            ],
            [
                'pekerjaan' => 'KARYAWAN BUMN',
            ],
            [
                'pekerjaan' => 'KARYAWAN BUMD',
            ],
            [
                'pekerjaan' => 'KARYAWAN HONORER',
            ],
            [
                'pekerjaan' => 'BURUH HARIAN LEPAS',
            ],
            [
                'pekerjaan' => 'BURUH TANI/PERKEBUNAN',
            ],


            [
                'pekerjaan' => 'BURUH NELAYAN/PERIKANAN',
            ],
            [
                'pekerjaan' => 'BURUH PETERNAKAN',
            ],
            [
                'pekerjaan' => 'PEMBANTU RUMAH TANGGA',
            ],
            [
                'pekerjaan' => 'TUKANG CUKUR',
            ],
            [
                'pekerjaan' => 'TUKANG LISTRIK',
            ],
            [
                'pekerjaan' => 'TUKANG BATU',
            ],
            [
                'pekerjaan' => 'TUKANG KAYU',
            ],
            [
                'pekerjaan' => 'TUKANG SOL SEPATU',
            ],
            [
                'pekerjaan' => 'TUKANG LAS/PANDAI BESI',
            ],
            [
                'pekerjaan' => 'TUKANG JAHIT',
            ],


            [
                'pekerjaan' => 'TUKANG GIGI',
            ],
            [
                'pekerjaan' => 'PENATA RIAS',
            ],
            [
                'pekerjaan' => 'PENATA BUSANA',
            ],
            [
                'pekerjaan' => 'PENATA RAMBUT',
            ],
            [
                'pekerjaan' => 'MEKANIK',
            ],
            [
                'pekerjaan' => 'SENIMAN',
            ],
            [
                'pekerjaan' => 'TABIB',
            ],
            [
                'pekerjaan' => 'PARAJI',
            ],
            [
                'pekerjaan' => 'PERANCANG BUSANA',
            ],
            [
                'pekerjaan' => 'PENTERJEMAH',
            ],



            [
                'pekerjaan' => 'IMAM MESJID',
            ],
            [
                'pekerjaan' => 'PENDETA',
            ],
            [
                'pekerjaan' => 'PASTOR',
            ],
            [
                'pekerjaan' => 'WARTAWAN',
            ],
            [
                'pekerjaan' => 'USTADZ/MUBALIGH',
            ],
            [
                'pekerjaan' => 'JURU MASAK',
            ],
            [
                'pekerjaan' => 'PROMOTOR ACARA',
            ],
            [
                'pekerjaan' => 'ANGGOTA DPR-RI',
            ],
            [
                'pekerjaan' => 'ANGGOTA DPD',
            ],
            [
                'pekerjaan' => 'ANGGOTA BPK',
            ],



            [
                'pekerjaan' => 'PRESIDEN',
            ],
            [
                'pekerjaan' => 'WAKIL PRESIDEN',
            ],
            [
                'pekerjaan' => 'ANGGOTA MAHKAMAH KONSTITUSI',
            ],
            [
                'pekerjaan' => 'ANGGOTA KABINET/KEMENTERIAN',
            ],
            [
                'pekerjaan' => 'DUTA BESAR',
            ],
            [
                'pekerjaan' => 'GUBERNUR',
            ],
            [
                'pekerjaan' => 'WAKIL GUBERNUR',
            ],
            [
                'pekerjaan' => 'BUPATI',
            ],
            [
                'pekerjaan' => 'WAKIL BUPATI',
            ],
            [
                'pekerjaan' => 'WALIKOTA',
            ],



            [
                'pekerjaan' => 'WAKIL WALIKOTA',
            ],
            [
                'pekerjaan' => 'ANGGOTA DPRD PROVINSI',
            ],
            [
                'pekerjaan' => 'ANGGOTA DPRD KABUPATEN/KOTA',
            ],
            [
                'pekerjaan' => 'DOSEN',
            ],
            [
                'pekerjaan' => 'GURU',
            ],
            [
                'pekerjaan' => 'PILOT',
            ],
            [
                'pekerjaan' => 'PENGACARA',
            ],
            [
                'pekerjaan' => 'NOTARIS',
            ],
            [
                'pekerjaan' => 'ARSITEK',
            ],
            [
                'pekerjaan' => 'AKUNTAN',
            ],



            [
                'pekerjaan' => 'KONSULTAN',
            ],
            [
                'pekerjaan' => 'DOKTER',
            ],
            [
                'pekerjaan' => 'BIDAN',
            ],
            [
                'pekerjaan' => 'PERAWAT',
            ],
            [
                'pekerjaan' => 'APOTEKER',
            ],
            [
                'pekerjaan' => 'PSIKIATER/PSIKOLOG',
            ],
            [
                'pekerjaan' => 'PENYIAR TELEVISI',
            ],
            [
                'pekerjaan' => 'PENYIAR RADIO',
            ],
            [
                'pekerjaan' => 'PELAUT',
            ],
            [
                'pekerjaan' => 'PENELITI',
            ],



            [
                'pekerjaan' => 'SOPIR',
            ],
            [
                'pekerjaan' => 'PIALANG',
            ],
            [
                'pekerjaan' => 'PARANORMAL',
            ],
            [
                'pekerjaan' => 'PEDAGANG',
            ],
            [
                'pekerjaan' => 'PERANGKAT DESA',
            ],
            [
                'pekerjaan' => 'KEPALA DESA',
            ],
            [
                'pekerjaan' => 'BIARAWATI',
            ],
            [
                'pekerjaan' => 'WIRASWASTA',
            ],
            [
                'pekerjaan' => 'LAINNYA',
            ],
        ];

        DB::table('pekerjaan')->insert($data);
    }
}
