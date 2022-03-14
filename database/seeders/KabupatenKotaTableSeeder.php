<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenKotaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('kabupaten_kota')->delete();
        
        DB::table('kabupaten_kota')->insert(array (
            0 => 
            array (
                'id' => 1101,
                'nama' => 'KABUPATEN SIMEULUE',
                'provinsi_id' => 11,
            ),
            1 => 
            array (
                'id' => 1102,
                'nama' => 'KABUPATEN ACEH SINGKIL',
                'provinsi_id' => 11,
            ),
            2 => 
            array (
                'id' => 1103,
                'nama' => 'KABUPATEN ACEH SELATAN',
                'provinsi_id' => 11,
            ),
            3 => 
            array (
                'id' => 1104,
                'nama' => 'KABUPATEN ACEH TENGGARA',
                'provinsi_id' => 11,
            ),
            4 => 
            array (
                'id' => 1105,
                'nama' => 'KABUPATEN ACEH TIMUR',
                'provinsi_id' => 11,
            ),
            5 => 
            array (
                'id' => 1106,
                'nama' => 'KABUPATEN ACEH TENGAH',
                'provinsi_id' => 11,
            ),
            6 => 
            array (
                'id' => 1107,
                'nama' => 'KABUPATEN ACEH BARAT',
                'provinsi_id' => 11,
            ),
            7 => 
            array (
                'id' => 1108,
                'nama' => 'KABUPATEN ACEH BESAR',
                'provinsi_id' => 11,
            ),
            8 => 
            array (
                'id' => 1109,
                'nama' => 'KABUPATEN PIDIE',
                'provinsi_id' => 11,
            ),
            9 => 
            array (
                'id' => 1110,
                'nama' => 'KABUPATEN BIREUEN',
                'provinsi_id' => 11,
            ),
            10 => 
            array (
                'id' => 1111,
                'nama' => 'KABUPATEN ACEH UTARA',
                'provinsi_id' => 11,
            ),
            11 => 
            array (
                'id' => 1112,
                'nama' => 'KABUPATEN ACEH BARAT DAYA',
                'provinsi_id' => 11,
            ),
            12 => 
            array (
                'id' => 1113,
                'nama' => 'KABUPATEN GAYO LUES',
                'provinsi_id' => 11,
            ),
            13 => 
            array (
                'id' => 1114,
                'nama' => 'KABUPATEN ACEH TAMIANG',
                'provinsi_id' => 11,
            ),
            14 => 
            array (
                'id' => 1115,
                'nama' => 'KABUPATEN NAGAN RAYA',
                'provinsi_id' => 11,
            ),
            15 => 
            array (
                'id' => 1116,
                'nama' => 'KABUPATEN ACEH JAYA',
                'provinsi_id' => 11,
            ),
            16 => 
            array (
                'id' => 1117,
                'nama' => 'KABUPATEN BENER MERIAH',
                'provinsi_id' => 11,
            ),
            17 => 
            array (
                'id' => 1118,
                'nama' => 'KABUPATEN PIDIE JAYA',
                'provinsi_id' => 11,
            ),
            18 => 
            array (
                'id' => 1171,
                'nama' => 'KOTA BANDA ACEH',
                'provinsi_id' => 11,
            ),
            19 => 
            array (
                'id' => 1172,
                'nama' => 'KOTA SABANG',
                'provinsi_id' => 11,
            ),
            20 => 
            array (
                'id' => 1173,
                'nama' => 'KOTA LANGSA',
                'provinsi_id' => 11,
            ),
            21 => 
            array (
                'id' => 1174,
                'nama' => 'KOTA LHOKSEUMAWE',
                'provinsi_id' => 11,
            ),
            22 => 
            array (
                'id' => 1175,
                'nama' => 'KOTA SUBULUSSALAM',
                'provinsi_id' => 11,
            ),
            23 => 
            array (
                'id' => 1201,
                'nama' => 'KABUPATEN NIAS',
                'provinsi_id' => 12,
            ),
            24 => 
            array (
                'id' => 1202,
                'nama' => 'KABUPATEN MANDAILING NATAL',
                'provinsi_id' => 12,
            ),
            25 => 
            array (
                'id' => 1203,
                'nama' => 'KABUPATEN TAPANULI SELATAN',
                'provinsi_id' => 12,
            ),
            26 => 
            array (
                'id' => 1204,
                'nama' => 'KABUPATEN TAPANULI TENGAH',
                'provinsi_id' => 12,
            ),
            27 => 
            array (
                'id' => 1205,
                'nama' => 'KABUPATEN TAPANULI UTARA',
                'provinsi_id' => 12,
            ),
            28 => 
            array (
                'id' => 1206,
                'nama' => 'KABUPATEN TOBA SAMOSIR',
                'provinsi_id' => 12,
            ),
            29 => 
            array (
                'id' => 1207,
                'nama' => 'KABUPATEN LABUHAN BATU',
                'provinsi_id' => 12,
            ),
            30 => 
            array (
                'id' => 1208,
                'nama' => 'KABUPATEN ASAHAN',
                'provinsi_id' => 12,
            ),
            31 => 
            array (
                'id' => 1209,
                'nama' => 'KABUPATEN SIMALUNGUN',
                'provinsi_id' => 12,
            ),
            32 => 
            array (
                'id' => 1210,
                'nama' => 'KABUPATEN DAIRI',
                'provinsi_id' => 12,
            ),
            33 => 
            array (
                'id' => 1211,
                'nama' => 'KABUPATEN KARO',
                'provinsi_id' => 12,
            ),
            34 => 
            array (
                'id' => 1212,
                'nama' => 'KABUPATEN DELI SERDANG',
                'provinsi_id' => 12,
            ),
            35 => 
            array (
                'id' => 1213,
                'nama' => 'KABUPATEN LANGKAT',
                'provinsi_id' => 12,
            ),
            36 => 
            array (
                'id' => 1214,
                'nama' => 'KABUPATEN NIAS SELATAN',
                'provinsi_id' => 12,
            ),
            37 => 
            array (
                'id' => 1215,
                'nama' => 'KABUPATEN HUMBANG HASUNDUTAN',
                'provinsi_id' => 12,
            ),
            38 => 
            array (
                'id' => 1216,
                'nama' => 'KABUPATEN PAKPAK BHARAT',
                'provinsi_id' => 12,
            ),
            39 => 
            array (
                'id' => 1217,
                'nama' => 'KABUPATEN SAMOSIR',
                'provinsi_id' => 12,
            ),
            40 => 
            array (
                'id' => 1218,
                'nama' => 'KABUPATEN SERDANG BEDAGAI',
                'provinsi_id' => 12,
            ),
            41 => 
            array (
                'id' => 1219,
                'nama' => 'KABUPATEN BATU BARA',
                'provinsi_id' => 12,
            ),
            42 => 
            array (
                'id' => 1220,
                'nama' => 'KABUPATEN PADANG LAWAS UTARA',
                'provinsi_id' => 12,
            ),
            43 => 
            array (
                'id' => 1221,
                'nama' => 'KABUPATEN PADANG LAWAS',
                'provinsi_id' => 12,
            ),
            44 => 
            array (
                'id' => 1222,
                'nama' => 'KABUPATEN LABUHAN BATU SELATAN',
                'provinsi_id' => 12,
            ),
            45 => 
            array (
                'id' => 1223,
                'nama' => 'KABUPATEN LABUHAN BATU UTARA',
                'provinsi_id' => 12,
            ),
            46 => 
            array (
                'id' => 1224,
                'nama' => 'KABUPATEN NIAS UTARA',
                'provinsi_id' => 12,
            ),
            47 => 
            array (
                'id' => 1225,
                'nama' => 'KABUPATEN NIAS BARAT',
                'provinsi_id' => 12,
            ),
            48 => 
            array (
                'id' => 1271,
                'nama' => 'KOTA SIBOLGA',
                'provinsi_id' => 12,
            ),
            49 => 
            array (
                'id' => 1272,
                'nama' => 'KOTA TANJUNG BALAI',
                'provinsi_id' => 12,
            ),
            50 => 
            array (
                'id' => 1273,
                'nama' => 'KOTA PEMATANG SIANTAR',
                'provinsi_id' => 12,
            ),
            51 => 
            array (
                'id' => 1274,
                'nama' => 'KOTA TEBING TINGGI',
                'provinsi_id' => 12,
            ),
            52 => 
            array (
                'id' => 1275,
                'nama' => 'KOTA MEDAN',
                'provinsi_id' => 12,
            ),
            53 => 
            array (
                'id' => 1276,
                'nama' => 'KOTA BINJAI',
                'provinsi_id' => 12,
            ),
            54 => 
            array (
                'id' => 1277,
                'nama' => 'KOTA PADANGSIDIMPUAN',
                'provinsi_id' => 12,
            ),
            55 => 
            array (
                'id' => 1278,
                'nama' => 'KOTA GUNUNGSITOLI',
                'provinsi_id' => 12,
            ),
            56 => 
            array (
                'id' => 1301,
                'nama' => 'KABUPATEN KEPULAUAN MENTAWAI',
                'provinsi_id' => 13,
            ),
            57 => 
            array (
                'id' => 1302,
                'nama' => 'KABUPATEN PESISIR SELATAN',
                'provinsi_id' => 13,
            ),
            58 => 
            array (
                'id' => 1303,
                'nama' => 'KABUPATEN SOLOK',
                'provinsi_id' => 13,
            ),
            59 => 
            array (
                'id' => 1304,
                'nama' => 'KABUPATEN SIJUNJUNG',
                'provinsi_id' => 13,
            ),
            60 => 
            array (
                'id' => 1305,
                'nama' => 'KABUPATEN TANAH DATAR',
                'provinsi_id' => 13,
            ),
            61 => 
            array (
                'id' => 1306,
                'nama' => 'KABUPATEN PADANG PARIAMAN',
                'provinsi_id' => 13,
            ),
            62 => 
            array (
                'id' => 1307,
                'nama' => 'KABUPATEN AGAM',
                'provinsi_id' => 13,
            ),
            63 => 
            array (
                'id' => 1308,
                'nama' => 'KABUPATEN LIMA PULUH KOTA',
                'provinsi_id' => 13,
            ),
            64 => 
            array (
                'id' => 1309,
                'nama' => 'KABUPATEN PASAMAN',
                'provinsi_id' => 13,
            ),
            65 => 
            array (
                'id' => 1310,
                'nama' => 'KABUPATEN SOLOK SELATAN',
                'provinsi_id' => 13,
            ),
            66 => 
            array (
                'id' => 1311,
                'nama' => 'KABUPATEN DHARMASRAYA',
                'provinsi_id' => 13,
            ),
            67 => 
            array (
                'id' => 1312,
                'nama' => 'KABUPATEN PASAMAN BARAT',
                'provinsi_id' => 13,
            ),
            68 => 
            array (
                'id' => 1371,
                'nama' => 'KOTA PADANG',
                'provinsi_id' => 13,
            ),
            69 => 
            array (
                'id' => 1372,
                'nama' => 'KOTA SOLOK',
                'provinsi_id' => 13,
            ),
            70 => 
            array (
                'id' => 1373,
                'nama' => 'KOTA SAWAH LUNTO',
                'provinsi_id' => 13,
            ),
            71 => 
            array (
                'id' => 1374,
                'nama' => 'KOTA PADANG PANJANG',
                'provinsi_id' => 13,
            ),
            72 => 
            array (
                'id' => 1375,
                'nama' => 'KOTA BUKITTINGGI',
                'provinsi_id' => 13,
            ),
            73 => 
            array (
                'id' => 1376,
                'nama' => 'KOTA PAYAKUMBUH',
                'provinsi_id' => 13,
            ),
            74 => 
            array (
                'id' => 1377,
                'nama' => 'KOTA PARIAMAN',
                'provinsi_id' => 13,
            ),
            75 => 
            array (
                'id' => 1401,
                'nama' => 'KABUPATEN KUANTAN SINGINGI',
                'provinsi_id' => 14,
            ),
            76 => 
            array (
                'id' => 1402,
                'nama' => 'KABUPATEN INDRAGIRI HULU',
                'provinsi_id' => 14,
            ),
            77 => 
            array (
                'id' => 1403,
                'nama' => 'KABUPATEN INDRAGIRI HILIR',
                'provinsi_id' => 14,
            ),
            78 => 
            array (
                'id' => 1404,
                'nama' => 'KABUPATEN PELALAWAN',
                'provinsi_id' => 14,
            ),
            79 => 
            array (
                'id' => 1405,
                'nama' => 'KABUPATEN S I A K',
                'provinsi_id' => 14,
            ),
            80 => 
            array (
                'id' => 1406,
                'nama' => 'KABUPATEN KAMPAR',
                'provinsi_id' => 14,
            ),
            81 => 
            array (
                'id' => 1407,
                'nama' => 'KABUPATEN ROKAN HULU',
                'provinsi_id' => 14,
            ),
            82 => 
            array (
                'id' => 1408,
                'nama' => 'KABUPATEN BENGKALIS',
                'provinsi_id' => 14,
            ),
            83 => 
            array (
                'id' => 1409,
                'nama' => 'KABUPATEN ROKAN HILIR',
                'provinsi_id' => 14,
            ),
            84 => 
            array (
                'id' => 1410,
                'nama' => 'KABUPATEN KEPULAUAN MERANTI',
                'provinsi_id' => 14,
            ),
            85 => 
            array (
                'id' => 1471,
                'nama' => 'KOTA PEKANBARU',
                'provinsi_id' => 14,
            ),
            86 => 
            array (
                'id' => 1473,
                'nama' => 'KOTA D U M A I',
                'provinsi_id' => 14,
            ),
            87 => 
            array (
                'id' => 1501,
                'nama' => 'KABUPATEN KERINCI',
                'provinsi_id' => 15,
            ),
            88 => 
            array (
                'id' => 1502,
                'nama' => 'KABUPATEN MERANGIN',
                'provinsi_id' => 15,
            ),
            89 => 
            array (
                'id' => 1503,
                'nama' => 'KABUPATEN SAROLANGUN',
                'provinsi_id' => 15,
            ),
            90 => 
            array (
                'id' => 1504,
                'nama' => 'KABUPATEN BATANG HARI',
                'provinsi_id' => 15,
            ),
            91 => 
            array (
                'id' => 1505,
                'nama' => 'KABUPATEN MUARO JAMBI',
                'provinsi_id' => 15,
            ),
            92 => 
            array (
                'id' => 1506,
                'nama' => 'KABUPATEN TANJUNG JABUNG TIMUR',
                'provinsi_id' => 15,
            ),
            93 => 
            array (
                'id' => 1507,
                'nama' => 'KABUPATEN TANJUNG JABUNG BARAT',
                'provinsi_id' => 15,
            ),
            94 => 
            array (
                'id' => 1508,
                'nama' => 'KABUPATEN TEBO',
                'provinsi_id' => 15,
            ),
            95 => 
            array (
                'id' => 1509,
                'nama' => 'KABUPATEN BUNGO',
                'provinsi_id' => 15,
            ),
            96 => 
            array (
                'id' => 1571,
                'nama' => 'KOTA JAMBI',
                'provinsi_id' => 15,
            ),
            97 => 
            array (
                'id' => 1572,
                'nama' => 'KOTA SUNGAI PENUH',
                'provinsi_id' => 15,
            ),
            98 => 
            array (
                'id' => 1601,
                'nama' => 'KABUPATEN OGAN KOMERING ULU',
                'provinsi_id' => 16,
            ),
            99 => 
            array (
                'id' => 1602,
                'nama' => 'KABUPATEN OGAN KOMERING ILIR',
                'provinsi_id' => 16,
            ),
            100 => 
            array (
                'id' => 1603,
                'nama' => 'KABUPATEN MUARA ENIM',
                'provinsi_id' => 16,
            ),
            101 => 
            array (
                'id' => 1604,
                'nama' => 'KABUPATEN LAHAT',
                'provinsi_id' => 16,
            ),
            102 => 
            array (
                'id' => 1605,
                'nama' => 'KABUPATEN MUSI RAWAS',
                'provinsi_id' => 16,
            ),
            103 => 
            array (
                'id' => 1606,
                'nama' => 'KABUPATEN MUSI BANYUASIN',
                'provinsi_id' => 16,
            ),
            104 => 
            array (
                'id' => 1607,
                'nama' => 'KABUPATEN BANYU ASIN',
                'provinsi_id' => 16,
            ),
            105 => 
            array (
                'id' => 1608,
                'nama' => 'KABUPATEN OGAN KOMERING ULU SELATAN',
                'provinsi_id' => 16,
            ),
            106 => 
            array (
                'id' => 1609,
                'nama' => 'KABUPATEN OGAN KOMERING ULU TIMUR',
                'provinsi_id' => 16,
            ),
            107 => 
            array (
                'id' => 1610,
                'nama' => 'KABUPATEN OGAN ILIR',
                'provinsi_id' => 16,
            ),
            108 => 
            array (
                'id' => 1611,
                'nama' => 'KABUPATEN EMPAT LAWANG',
                'provinsi_id' => 16,
            ),
            109 => 
            array (
                'id' => 1612,
                'nama' => 'KABUPATEN PENUKAL ABAB LEMATANG ILIR',
                'provinsi_id' => 16,
            ),
            110 => 
            array (
                'id' => 1613,
                'nama' => 'KABUPATEN MUSI RAWAS UTARA',
                'provinsi_id' => 16,
            ),
            111 => 
            array (
                'id' => 1671,
                'nama' => 'KOTA PALEMBANG',
                'provinsi_id' => 16,
            ),
            112 => 
            array (
                'id' => 1672,
                'nama' => 'KOTA PRABUMULIH',
                'provinsi_id' => 16,
            ),
            113 => 
            array (
                'id' => 1673,
                'nama' => 'KOTA PAGAR ALAM',
                'provinsi_id' => 16,
            ),
            114 => 
            array (
                'id' => 1674,
                'nama' => 'KOTA LUBUKLINGGAU',
                'provinsi_id' => 16,
            ),
            115 => 
            array (
                'id' => 1701,
                'nama' => 'KABUPATEN BENGKULU SELATAN',
                'provinsi_id' => 17,
            ),
            116 => 
            array (
                'id' => 1702,
                'nama' => 'KABUPATEN REJANG LEBONG',
                'provinsi_id' => 17,
            ),
            117 => 
            array (
                'id' => 1703,
                'nama' => 'KABUPATEN BENGKULU UTARA',
                'provinsi_id' => 17,
            ),
            118 => 
            array (
                'id' => 1704,
                'nama' => 'KABUPATEN KAUR',
                'provinsi_id' => 17,
            ),
            119 => 
            array (
                'id' => 1705,
                'nama' => 'KABUPATEN SELUMA',
                'provinsi_id' => 17,
            ),
            120 => 
            array (
                'id' => 1706,
                'nama' => 'KABUPATEN MUKOMUKO',
                'provinsi_id' => 17,
            ),
            121 => 
            array (
                'id' => 1707,
                'nama' => 'KABUPATEN LEBONG',
                'provinsi_id' => 17,
            ),
            122 => 
            array (
                'id' => 1708,
                'nama' => 'KABUPATEN KEPAHIANG',
                'provinsi_id' => 17,
            ),
            123 => 
            array (
                'id' => 1709,
                'nama' => 'KABUPATEN BENGKULU TENGAH',
                'provinsi_id' => 17,
            ),
            124 => 
            array (
                'id' => 1771,
                'nama' => 'KOTA BENGKULU',
                'provinsi_id' => 17,
            ),
            125 => 
            array (
                'id' => 1801,
                'nama' => 'KABUPATEN LAMPUNG BARAT',
                'provinsi_id' => 18,
            ),
            126 => 
            array (
                'id' => 1802,
                'nama' => 'KABUPATEN TANGGAMUS',
                'provinsi_id' => 18,
            ),
            127 => 
            array (
                'id' => 1803,
                'nama' => 'KABUPATEN LAMPUNG SELATAN',
                'provinsi_id' => 18,
            ),
            128 => 
            array (
                'id' => 1804,
                'nama' => 'KABUPATEN LAMPUNG TIMUR',
                'provinsi_id' => 18,
            ),
            129 => 
            array (
                'id' => 1805,
                'nama' => 'KABUPATEN LAMPUNG TENGAH',
                'provinsi_id' => 18,
            ),
            130 => 
            array (
                'id' => 1806,
                'nama' => 'KABUPATEN LAMPUNG UTARA',
                'provinsi_id' => 18,
            ),
            131 => 
            array (
                'id' => 1807,
                'nama' => 'KABUPATEN WAY KANAN',
                'provinsi_id' => 18,
            ),
            132 => 
            array (
                'id' => 1808,
                'nama' => 'KABUPATEN TULANGBAWANG',
                'provinsi_id' => 18,
            ),
            133 => 
            array (
                'id' => 1809,
                'nama' => 'KABUPATEN PESAWARAN',
                'provinsi_id' => 18,
            ),
            134 => 
            array (
                'id' => 1810,
                'nama' => 'KABUPATEN PRINGSEWU',
                'provinsi_id' => 18,
            ),
            135 => 
            array (
                'id' => 1811,
                'nama' => 'KABUPATEN MESUJI',
                'provinsi_id' => 18,
            ),
            136 => 
            array (
                'id' => 1812,
                'nama' => 'KABUPATEN TULANG BAWANG BARAT',
                'provinsi_id' => 18,
            ),
            137 => 
            array (
                'id' => 1813,
                'nama' => 'KABUPATEN PESISIR BARAT',
                'provinsi_id' => 18,
            ),
            138 => 
            array (
                'id' => 1871,
                'nama' => 'KOTA BANDAR LAMPUNG',
                'provinsi_id' => 18,
            ),
            139 => 
            array (
                'id' => 1872,
                'nama' => 'KOTA METRO',
                'provinsi_id' => 18,
            ),
            140 => 
            array (
                'id' => 1901,
                'nama' => 'KABUPATEN BANGKA',
                'provinsi_id' => 19,
            ),
            141 => 
            array (
                'id' => 1902,
                'nama' => 'KABUPATEN BELITUNG',
                'provinsi_id' => 19,
            ),
            142 => 
            array (
                'id' => 1903,
                'nama' => 'KABUPATEN BANGKA BARAT',
                'provinsi_id' => 19,
            ),
            143 => 
            array (
                'id' => 1904,
                'nama' => 'KABUPATEN BANGKA TENGAH',
                'provinsi_id' => 19,
            ),
            144 => 
            array (
                'id' => 1905,
                'nama' => 'KABUPATEN BANGKA SELATAN',
                'provinsi_id' => 19,
            ),
            145 => 
            array (
                'id' => 1906,
                'nama' => 'KABUPATEN BELITUNG TIMUR',
                'provinsi_id' => 19,
            ),
            146 => 
            array (
                'id' => 1971,
                'nama' => 'KOTA PANGKAL PINANG',
                'provinsi_id' => 19,
            ),
            147 => 
            array (
                'id' => 2101,
                'nama' => 'KABUPATEN KARIMUN',
                'provinsi_id' => 21,
            ),
            148 => 
            array (
                'id' => 2102,
                'nama' => 'KABUPATEN BINTAN',
                'provinsi_id' => 21,
            ),
            149 => 
            array (
                'id' => 2103,
                'nama' => 'KABUPATEN NATUNA',
                'provinsi_id' => 21,
            ),
            150 => 
            array (
                'id' => 2104,
                'nama' => 'KABUPATEN LINGGA',
                'provinsi_id' => 21,
            ),
            151 => 
            array (
                'id' => 2105,
                'nama' => 'KABUPATEN KEPULAUAN ANAMBAS',
                'provinsi_id' => 21,
            ),
            152 => 
            array (
                'id' => 2171,
                'nama' => 'KOTA B A T A M',
                'provinsi_id' => 21,
            ),
            153 => 
            array (
                'id' => 2172,
                'nama' => 'KOTA TANJUNG PINANG',
                'provinsi_id' => 21,
            ),
            154 => 
            array (
                'id' => 3101,
                'nama' => 'KABUPATEN KEPULAUAN SERIBU',
                'provinsi_id' => 31,
            ),
            155 => 
            array (
                'id' => 3171,
                'nama' => 'KOTA JAKARTA SELATAN',
                'provinsi_id' => 31,
            ),
            156 => 
            array (
                'id' => 3172,
                'nama' => 'KOTA JAKARTA TIMUR',
                'provinsi_id' => 31,
            ),
            157 => 
            array (
                'id' => 3173,
                'nama' => 'KOTA JAKARTA PUSAT',
                'provinsi_id' => 31,
            ),
            158 => 
            array (
                'id' => 3174,
                'nama' => 'KOTA JAKARTA BARAT',
                'provinsi_id' => 31,
            ),
            159 => 
            array (
                'id' => 3175,
                'nama' => 'KOTA JAKARTA UTARA',
                'provinsi_id' => 31,
            ),
            160 => 
            array (
                'id' => 3201,
                'nama' => 'KABUPATEN BOGOR',
                'provinsi_id' => 32,
            ),
            161 => 
            array (
                'id' => 3202,
                'nama' => 'KABUPATEN SUKABUMI',
                'provinsi_id' => 32,
            ),
            162 => 
            array (
                'id' => 3203,
                'nama' => 'KABUPATEN CIANJUR',
                'provinsi_id' => 32,
            ),
            163 => 
            array (
                'id' => 3204,
                'nama' => 'KABUPATEN BANDUNG',
                'provinsi_id' => 32,
            ),
            164 => 
            array (
                'id' => 3205,
                'nama' => 'KABUPATEN GARUT',
                'provinsi_id' => 32,
            ),
            165 => 
            array (
                'id' => 3206,
                'nama' => 'KABUPATEN TASIKMALAYA',
                'provinsi_id' => 32,
            ),
            166 => 
            array (
                'id' => 3207,
                'nama' => 'KABUPATEN CIAMIS',
                'provinsi_id' => 32,
            ),
            167 => 
            array (
                'id' => 3208,
                'nama' => 'KABUPATEN KUNINGAN',
                'provinsi_id' => 32,
            ),
            168 => 
            array (
                'id' => 3209,
                'nama' => 'KABUPATEN CIREBON',
                'provinsi_id' => 32,
            ),
            169 => 
            array (
                'id' => 3210,
                'nama' => 'KABUPATEN MAJALENGKA',
                'provinsi_id' => 32,
            ),
            170 => 
            array (
                'id' => 3211,
                'nama' => 'KABUPATEN SUMEDANG',
                'provinsi_id' => 32,
            ),
            171 => 
            array (
                'id' => 3212,
                'nama' => 'KABUPATEN INDRAMAYU',
                'provinsi_id' => 32,
            ),
            172 => 
            array (
                'id' => 3213,
                'nama' => 'KABUPATEN SUBANG',
                'provinsi_id' => 32,
            ),
            173 => 
            array (
                'id' => 3214,
                'nama' => 'KABUPATEN PURWAKARTA',
                'provinsi_id' => 32,
            ),
            174 => 
            array (
                'id' => 3215,
                'nama' => 'KABUPATEN KARAWANG',
                'provinsi_id' => 32,
            ),
            175 => 
            array (
                'id' => 3216,
                'nama' => 'KABUPATEN BEKASI',
                'provinsi_id' => 32,
            ),
            176 => 
            array (
                'id' => 3217,
                'nama' => 'KABUPATEN BANDUNG BARAT',
                'provinsi_id' => 32,
            ),
            177 => 
            array (
                'id' => 3218,
                'nama' => 'KABUPATEN PANGANDARAN',
                'provinsi_id' => 32,
            ),
            178 => 
            array (
                'id' => 3271,
                'nama' => 'KOTA BOGOR',
                'provinsi_id' => 32,
            ),
            179 => 
            array (
                'id' => 3272,
                'nama' => 'KOTA SUKABUMI',
                'provinsi_id' => 32,
            ),
            180 => 
            array (
                'id' => 3273,
                'nama' => 'KOTA BANDUNG',
                'provinsi_id' => 32,
            ),
            181 => 
            array (
                'id' => 3274,
                'nama' => 'KOTA CIREBON',
                'provinsi_id' => 32,
            ),
            182 => 
            array (
                'id' => 3275,
                'nama' => 'KOTA BEKASI',
                'provinsi_id' => 32,
            ),
            183 => 
            array (
                'id' => 3276,
                'nama' => 'KOTA DEPOK',
                'provinsi_id' => 32,
            ),
            184 => 
            array (
                'id' => 3277,
                'nama' => 'KOTA CIMAHI',
                'provinsi_id' => 32,
            ),
            185 => 
            array (
                'id' => 3278,
                'nama' => 'KOTA TASIKMALAYA',
                'provinsi_id' => 32,
            ),
            186 => 
            array (
                'id' => 3279,
                'nama' => 'KOTA BANJAR',
                'provinsi_id' => 32,
            ),
            187 => 
            array (
                'id' => 3301,
                'nama' => 'KABUPATEN CILACAP',
                'provinsi_id' => 33,
            ),
            188 => 
            array (
                'id' => 3302,
                'nama' => 'KABUPATEN BANYUMAS',
                'provinsi_id' => 33,
            ),
            189 => 
            array (
                'id' => 3303,
                'nama' => 'KABUPATEN PURBALINGGA',
                'provinsi_id' => 33,
            ),
            190 => 
            array (
                'id' => 3304,
                'nama' => 'KABUPATEN BANJARNEGARA',
                'provinsi_id' => 33,
            ),
            191 => 
            array (
                'id' => 3305,
                'nama' => 'KABUPATEN KEBUMEN',
                'provinsi_id' => 33,
            ),
            192 => 
            array (
                'id' => 3306,
                'nama' => 'KABUPATEN PURWOREJO',
                'provinsi_id' => 33,
            ),
            193 => 
            array (
                'id' => 3307,
                'nama' => 'KABUPATEN WONOSOBO',
                'provinsi_id' => 33,
            ),
            194 => 
            array (
                'id' => 3308,
                'nama' => 'KABUPATEN MAGELANG',
                'provinsi_id' => 33,
            ),
            195 => 
            array (
                'id' => 3309,
                'nama' => 'KABUPATEN BOYOLALI',
                'provinsi_id' => 33,
            ),
            196 => 
            array (
                'id' => 3310,
                'nama' => 'KABUPATEN KLATEN',
                'provinsi_id' => 33,
            ),
            197 => 
            array (
                'id' => 3311,
                'nama' => 'KABUPATEN SUKOHARJO',
                'provinsi_id' => 33,
            ),
            198 => 
            array (
                'id' => 3312,
                'nama' => 'KABUPATEN WONOGIRI',
                'provinsi_id' => 33,
            ),
            199 => 
            array (
                'id' => 3313,
                'nama' => 'KABUPATEN KARANGANYAR',
                'provinsi_id' => 33,
            ),
            200 => 
            array (
                'id' => 3314,
                'nama' => 'KABUPATEN SRAGEN',
                'provinsi_id' => 33,
            ),
            201 => 
            array (
                'id' => 3315,
                'nama' => 'KABUPATEN GROBOGAN',
                'provinsi_id' => 33,
            ),
            202 => 
            array (
                'id' => 3316,
                'nama' => 'KABUPATEN BLORA',
                'provinsi_id' => 33,
            ),
            203 => 
            array (
                'id' => 3317,
                'nama' => 'KABUPATEN REMBANG',
                'provinsi_id' => 33,
            ),
            204 => 
            array (
                'id' => 3318,
                'nama' => 'KABUPATEN PATI',
                'provinsi_id' => 33,
            ),
            205 => 
            array (
                'id' => 3319,
                'nama' => 'KABUPATEN KUDUS',
                'provinsi_id' => 33,
            ),
            206 => 
            array (
                'id' => 3320,
                'nama' => 'KABUPATEN JEPARA',
                'provinsi_id' => 33,
            ),
            207 => 
            array (
                'id' => 3321,
                'nama' => 'KABUPATEN DEMAK',
                'provinsi_id' => 33,
            ),
            208 => 
            array (
                'id' => 3322,
                'nama' => 'KABUPATEN SEMARANG',
                'provinsi_id' => 33,
            ),
            209 => 
            array (
                'id' => 3323,
                'nama' => 'KABUPATEN TEMANGGUNG',
                'provinsi_id' => 33,
            ),
            210 => 
            array (
                'id' => 3324,
                'nama' => 'KABUPATEN KENDAL',
                'provinsi_id' => 33,
            ),
            211 => 
            array (
                'id' => 3325,
                'nama' => 'KABUPATEN BATANG',
                'provinsi_id' => 33,
            ),
            212 => 
            array (
                'id' => 3326,
                'nama' => 'KABUPATEN PEKALONGAN',
                'provinsi_id' => 33,
            ),
            213 => 
            array (
                'id' => 3327,
                'nama' => 'KABUPATEN PEMALANG',
                'provinsi_id' => 33,
            ),
            214 => 
            array (
                'id' => 3328,
                'nama' => 'KABUPATEN TEGAL',
                'provinsi_id' => 33,
            ),
            215 => 
            array (
                'id' => 3329,
                'nama' => 'KABUPATEN BREBES',
                'provinsi_id' => 33,
            ),
            216 => 
            array (
                'id' => 3371,
                'nama' => 'KOTA MAGELANG',
                'provinsi_id' => 33,
            ),
            217 => 
            array (
                'id' => 3372,
                'nama' => 'KOTA SURAKARTA',
                'provinsi_id' => 33,
            ),
            218 => 
            array (
                'id' => 3373,
                'nama' => 'KOTA SALATIGA',
                'provinsi_id' => 33,
            ),
            219 => 
            array (
                'id' => 3374,
                'nama' => 'KOTA SEMARANG',
                'provinsi_id' => 33,
            ),
            220 => 
            array (
                'id' => 3375,
                'nama' => 'KOTA PEKALONGAN',
                'provinsi_id' => 33,
            ),
            221 => 
            array (
                'id' => 3376,
                'nama' => 'KOTA TEGAL',
                'provinsi_id' => 33,
            ),
            222 => 
            array (
                'id' => 3401,
                'nama' => 'KABUPATEN KULON PROGO',
                'provinsi_id' => 34,
            ),
            223 => 
            array (
                'id' => 3402,
                'nama' => 'KABUPATEN BANTUL',
                'provinsi_id' => 34,
            ),
            224 => 
            array (
                'id' => 3403,
                'nama' => 'KABUPATEN GUNUNG KIDUL',
                'provinsi_id' => 34,
            ),
            225 => 
            array (
                'id' => 3404,
                'nama' => 'KABUPATEN SLEMAN',
                'provinsi_id' => 34,
            ),
            226 => 
            array (
                'id' => 3471,
                'nama' => 'KOTA YOGYAKARTA',
                'provinsi_id' => 34,
            ),
            227 => 
            array (
                'id' => 3501,
                'nama' => 'KABUPATEN PACITAN',
                'provinsi_id' => 35,
            ),
            228 => 
            array (
                'id' => 3502,
                'nama' => 'KABUPATEN PONOROGO',
                'provinsi_id' => 35,
            ),
            229 => 
            array (
                'id' => 3503,
                'nama' => 'KABUPATEN TRENGGALEK',
                'provinsi_id' => 35,
            ),
            230 => 
            array (
                'id' => 3504,
                'nama' => 'KABUPATEN TULUNGAGUNG',
                'provinsi_id' => 35,
            ),
            231 => 
            array (
                'id' => 3505,
                'nama' => 'KABUPATEN BLITAR',
                'provinsi_id' => 35,
            ),
            232 => 
            array (
                'id' => 3506,
                'nama' => 'KABUPATEN KEDIRI',
                'provinsi_id' => 35,
            ),
            233 => 
            array (
                'id' => 3507,
                'nama' => 'KABUPATEN MALANG',
                'provinsi_id' => 35,
            ),
            234 => 
            array (
                'id' => 3508,
                'nama' => 'KABUPATEN LUMAJANG',
                'provinsi_id' => 35,
            ),
            235 => 
            array (
                'id' => 3509,
                'nama' => 'KABUPATEN JEMBER',
                'provinsi_id' => 35,
            ),
            236 => 
            array (
                'id' => 3510,
                'nama' => 'KABUPATEN BANYUWANGI',
                'provinsi_id' => 35,
            ),
            237 => 
            array (
                'id' => 3511,
                'nama' => 'KABUPATEN BONDOWOSO',
                'provinsi_id' => 35,
            ),
            238 => 
            array (
                'id' => 3512,
                'nama' => 'KABUPATEN SITUBONDO',
                'provinsi_id' => 35,
            ),
            239 => 
            array (
                'id' => 3513,
                'nama' => 'KABUPATEN PROBOLINGGO',
                'provinsi_id' => 35,
            ),
            240 => 
            array (
                'id' => 3514,
                'nama' => 'KABUPATEN PASURUAN',
                'provinsi_id' => 35,
            ),
            241 => 
            array (
                'id' => 3515,
                'nama' => 'KABUPATEN SIDOARJO',
                'provinsi_id' => 35,
            ),
            242 => 
            array (
                'id' => 3516,
                'nama' => 'KABUPATEN MOJOKERTO',
                'provinsi_id' => 35,
            ),
            243 => 
            array (
                'id' => 3517,
                'nama' => 'KABUPATEN JOMBANG',
                'provinsi_id' => 35,
            ),
            244 => 
            array (
                'id' => 3518,
                'nama' => 'KABUPATEN NGANJUK',
                'provinsi_id' => 35,
            ),
            245 => 
            array (
                'id' => 3519,
                'nama' => 'KABUPATEN MADIUN',
                'provinsi_id' => 35,
            ),
            246 => 
            array (
                'id' => 3520,
                'nama' => 'KABUPATEN MAGETAN',
                'provinsi_id' => 35,
            ),
            247 => 
            array (
                'id' => 3521,
                'nama' => 'KABUPATEN NGAWI',
                'provinsi_id' => 35,
            ),
            248 => 
            array (
                'id' => 3522,
                'nama' => 'KABUPATEN BOJONEGORO',
                'provinsi_id' => 35,
            ),
            249 => 
            array (
                'id' => 3523,
                'nama' => 'KABUPATEN TUBAN',
                'provinsi_id' => 35,
            ),
            250 => 
            array (
                'id' => 3524,
                'nama' => 'KABUPATEN LAMONGAN',
                'provinsi_id' => 35,
            ),
            251 => 
            array (
                'id' => 3525,
                'nama' => 'KABUPATEN GRESIK',
                'provinsi_id' => 35,
            ),
            252 => 
            array (
                'id' => 3526,
                'nama' => 'KABUPATEN BANGKALAN',
                'provinsi_id' => 35,
            ),
            253 => 
            array (
                'id' => 3527,
                'nama' => 'KABUPATEN SAMPANG',
                'provinsi_id' => 35,
            ),
            254 => 
            array (
                'id' => 3528,
                'nama' => 'KABUPATEN PAMEKASAN',
                'provinsi_id' => 35,
            ),
            255 => 
            array (
                'id' => 3529,
                'nama' => 'KABUPATEN SUMENEP',
                'provinsi_id' => 35,
            ),
            256 => 
            array (
                'id' => 3571,
                'nama' => 'KOTA KEDIRI',
                'provinsi_id' => 35,
            ),
            257 => 
            array (
                'id' => 3572,
                'nama' => 'KOTA BLITAR',
                'provinsi_id' => 35,
            ),
            258 => 
            array (
                'id' => 3573,
                'nama' => 'KOTA MALANG',
                'provinsi_id' => 35,
            ),
            259 => 
            array (
                'id' => 3574,
                'nama' => 'KOTA PROBOLINGGO',
                'provinsi_id' => 35,
            ),
            260 => 
            array (
                'id' => 3575,
                'nama' => 'KOTA PASURUAN',
                'provinsi_id' => 35,
            ),
            261 => 
            array (
                'id' => 3576,
                'nama' => 'KOTA MOJOKERTO',
                'provinsi_id' => 35,
            ),
            262 => 
            array (
                'id' => 3577,
                'nama' => 'KOTA MADIUN',
                'provinsi_id' => 35,
            ),
            263 => 
            array (
                'id' => 3578,
                'nama' => 'KOTA SURABAYA',
                'provinsi_id' => 35,
            ),
            264 => 
            array (
                'id' => 3579,
                'nama' => 'KOTA BATU',
                'provinsi_id' => 35,
            ),
            265 => 
            array (
                'id' => 3601,
                'nama' => 'KABUPATEN PANDEGLANG',
                'provinsi_id' => 36,
            ),
            266 => 
            array (
                'id' => 3602,
                'nama' => 'KABUPATEN LEBAK',
                'provinsi_id' => 36,
            ),
            267 => 
            array (
                'id' => 3603,
                'nama' => 'KABUPATEN TANGERANG',
                'provinsi_id' => 36,
            ),
            268 => 
            array (
                'id' => 3604,
                'nama' => 'KABUPATEN SERANG',
                'provinsi_id' => 36,
            ),
            269 => 
            array (
                'id' => 3671,
                'nama' => 'KOTA TANGERANG',
                'provinsi_id' => 36,
            ),
            270 => 
            array (
                'id' => 3672,
                'nama' => 'KOTA CILEGON',
                'provinsi_id' => 36,
            ),
            271 => 
            array (
                'id' => 3673,
                'nama' => 'KOTA SERANG',
                'provinsi_id' => 36,
            ),
            272 => 
            array (
                'id' => 3674,
                'nama' => 'KOTA TANGERANG SELATAN',
                'provinsi_id' => 36,
            ),
            273 => 
            array (
                'id' => 5101,
                'nama' => 'KABUPATEN JEMBRANA',
                'provinsi_id' => 51,
            ),
            274 => 
            array (
                'id' => 5102,
                'nama' => 'KABUPATEN TABANAN',
                'provinsi_id' => 51,
            ),
            275 => 
            array (
                'id' => 5103,
                'nama' => 'KABUPATEN BADUNG',
                'provinsi_id' => 51,
            ),
            276 => 
            array (
                'id' => 5104,
                'nama' => 'KABUPATEN GIANYAR',
                'provinsi_id' => 51,
            ),
            277 => 
            array (
                'id' => 5105,
                'nama' => 'KABUPATEN KLUNGKUNG',
                'provinsi_id' => 51,
            ),
            278 => 
            array (
                'id' => 5106,
                'nama' => 'KABUPATEN BANGLI',
                'provinsi_id' => 51,
            ),
            279 => 
            array (
                'id' => 5107,
                'nama' => 'KABUPATEN KARANG ASEM',
                'provinsi_id' => 51,
            ),
            280 => 
            array (
                'id' => 5108,
                'nama' => 'KABUPATEN BULELENG',
                'provinsi_id' => 51,
            ),
            281 => 
            array (
                'id' => 5171,
                'nama' => 'KOTA DENPASAR',
                'provinsi_id' => 51,
            ),
            282 => 
            array (
                'id' => 5201,
                'nama' => 'KABUPATEN LOMBOK BARAT',
                'provinsi_id' => 52,
            ),
            283 => 
            array (
                'id' => 5202,
                'nama' => 'KABUPATEN LOMBOK TENGAH',
                'provinsi_id' => 52,
            ),
            284 => 
            array (
                'id' => 5203,
                'nama' => 'KABUPATEN LOMBOK TIMUR',
                'provinsi_id' => 52,
            ),
            285 => 
            array (
                'id' => 5204,
                'nama' => 'KABUPATEN SUMBAWA',
                'provinsi_id' => 52,
            ),
            286 => 
            array (
                'id' => 5205,
                'nama' => 'KABUPATEN DOMPU',
                'provinsi_id' => 52,
            ),
            287 => 
            array (
                'id' => 5206,
                'nama' => 'KABUPATEN BIMA',
                'provinsi_id' => 52,
            ),
            288 => 
            array (
                'id' => 5207,
                'nama' => 'KABUPATEN SUMBAWA BARAT',
                'provinsi_id' => 52,
            ),
            289 => 
            array (
                'id' => 5208,
                'nama' => 'KABUPATEN LOMBOK UTARA',
                'provinsi_id' => 52,
            ),
            290 => 
            array (
                'id' => 5271,
                'nama' => 'KOTA MATARAM',
                'provinsi_id' => 52,
            ),
            291 => 
            array (
                'id' => 5272,
                'nama' => 'KOTA BIMA',
                'provinsi_id' => 52,
            ),
            292 => 
            array (
                'id' => 5301,
                'nama' => 'KABUPATEN SUMBA BARAT',
                'provinsi_id' => 53,
            ),
            293 => 
            array (
                'id' => 5302,
                'nama' => 'KABUPATEN SUMBA TIMUR',
                'provinsi_id' => 53,
            ),
            294 => 
            array (
                'id' => 5303,
                'nama' => 'KABUPATEN KUPANG',
                'provinsi_id' => 53,
            ),
            295 => 
            array (
                'id' => 5304,
                'nama' => 'KABUPATEN TIMOR TENGAH SELATAN',
                'provinsi_id' => 53,
            ),
            296 => 
            array (
                'id' => 5305,
                'nama' => 'KABUPATEN TIMOR TENGAH UTARA',
                'provinsi_id' => 53,
            ),
            297 => 
            array (
                'id' => 5306,
                'nama' => 'KABUPATEN BELU',
                'provinsi_id' => 53,
            ),
            298 => 
            array (
                'id' => 5307,
                'nama' => 'KABUPATEN ALOR',
                'provinsi_id' => 53,
            ),
            299 => 
            array (
                'id' => 5308,
                'nama' => 'KABUPATEN LEMBATA',
                'provinsi_id' => 53,
            ),
            300 => 
            array (
                'id' => 5309,
                'nama' => 'KABUPATEN FLORES TIMUR',
                'provinsi_id' => 53,
            ),
            301 => 
            array (
                'id' => 5310,
                'nama' => 'KABUPATEN SIKKA',
                'provinsi_id' => 53,
            ),
            302 => 
            array (
                'id' => 5311,
                'nama' => 'KABUPATEN ENDE',
                'provinsi_id' => 53,
            ),
            303 => 
            array (
                'id' => 5312,
                'nama' => 'KABUPATEN NGADA',
                'provinsi_id' => 53,
            ),
            304 => 
            array (
                'id' => 5313,
                'nama' => 'KABUPATEN MANGGARAI',
                'provinsi_id' => 53,
            ),
            305 => 
            array (
                'id' => 5314,
                'nama' => 'KABUPATEN ROTE NDAO',
                'provinsi_id' => 53,
            ),
            306 => 
            array (
                'id' => 5315,
                'nama' => 'KABUPATEN MANGGARAI BARAT',
                'provinsi_id' => 53,
            ),
            307 => 
            array (
                'id' => 5316,
                'nama' => 'KABUPATEN SUMBA TENGAH',
                'provinsi_id' => 53,
            ),
            308 => 
            array (
                'id' => 5317,
                'nama' => 'KABUPATEN SUMBA BARAT DAYA',
                'provinsi_id' => 53,
            ),
            309 => 
            array (
                'id' => 5318,
                'nama' => 'KABUPATEN NAGEKEO',
                'provinsi_id' => 53,
            ),
            310 => 
            array (
                'id' => 5319,
                'nama' => 'KABUPATEN MANGGARAI TIMUR',
                'provinsi_id' => 53,
            ),
            311 => 
            array (
                'id' => 5320,
                'nama' => 'KABUPATEN SABU RAIJUA',
                'provinsi_id' => 53,
            ),
            312 => 
            array (
                'id' => 5321,
                'nama' => 'KABUPATEN MALAKA',
                'provinsi_id' => 53,
            ),
            313 => 
            array (
                'id' => 5371,
                'nama' => 'KOTA KUPANG',
                'provinsi_id' => 53,
            ),
            314 => 
            array (
                'id' => 6101,
                'nama' => 'KABUPATEN SAMBAS',
                'provinsi_id' => 61,
            ),
            315 => 
            array (
                'id' => 6102,
                'nama' => 'KABUPATEN BENGKAYANG',
                'provinsi_id' => 61,
            ),
            316 => 
            array (
                'id' => 6103,
                'nama' => 'KABUPATEN LANDAK',
                'provinsi_id' => 61,
            ),
            317 => 
            array (
                'id' => 6104,
                'nama' => 'KABUPATEN MEMPAWAH',
                'provinsi_id' => 61,
            ),
            318 => 
            array (
                'id' => 6105,
                'nama' => 'KABUPATEN SANGGAU',
                'provinsi_id' => 61,
            ),
            319 => 
            array (
                'id' => 6106,
                'nama' => 'KABUPATEN KETAPANG',
                'provinsi_id' => 61,
            ),
            320 => 
            array (
                'id' => 6107,
                'nama' => 'KABUPATEN SINTANG',
                'provinsi_id' => 61,
            ),
            321 => 
            array (
                'id' => 6108,
                'nama' => 'KABUPATEN KAPUAS HULU',
                'provinsi_id' => 61,
            ),
            322 => 
            array (
                'id' => 6109,
                'nama' => 'KABUPATEN SEKADAU',
                'provinsi_id' => 61,
            ),
            323 => 
            array (
                'id' => 6110,
                'nama' => 'KABUPATEN MELAWI',
                'provinsi_id' => 61,
            ),
            324 => 
            array (
                'id' => 6111,
                'nama' => 'KABUPATEN KAYONG UTARA',
                'provinsi_id' => 61,
            ),
            325 => 
            array (
                'id' => 6112,
                'nama' => 'KABUPATEN KUBU RAYA',
                'provinsi_id' => 61,
            ),
            326 => 
            array (
                'id' => 6171,
                'nama' => 'KOTA PONTIANAK',
                'provinsi_id' => 61,
            ),
            327 => 
            array (
                'id' => 6172,
                'nama' => 'KOTA SINGKAWANG',
                'provinsi_id' => 61,
            ),
            328 => 
            array (
                'id' => 6201,
                'nama' => 'KABUPATEN KOTAWARINGIN BARAT',
                'provinsi_id' => 62,
            ),
            329 => 
            array (
                'id' => 6202,
                'nama' => 'KABUPATEN KOTAWARINGIN TIMUR',
                'provinsi_id' => 62,
            ),
            330 => 
            array (
                'id' => 6203,
                'nama' => 'KABUPATEN KAPUAS',
                'provinsi_id' => 62,
            ),
            331 => 
            array (
                'id' => 6204,
                'nama' => 'KABUPATEN BARITO SELATAN',
                'provinsi_id' => 62,
            ),
            332 => 
            array (
                'id' => 6205,
                'nama' => 'KABUPATEN BARITO UTARA',
                'provinsi_id' => 62,
            ),
            333 => 
            array (
                'id' => 6206,
                'nama' => 'KABUPATEN SUKAMARA',
                'provinsi_id' => 62,
            ),
            334 => 
            array (
                'id' => 6207,
                'nama' => 'KABUPATEN LAMANDAU',
                'provinsi_id' => 62,
            ),
            335 => 
            array (
                'id' => 6208,
                'nama' => 'KABUPATEN SERUYAN',
                'provinsi_id' => 62,
            ),
            336 => 
            array (
                'id' => 6209,
                'nama' => 'KABUPATEN KATINGAN',
                'provinsi_id' => 62,
            ),
            337 => 
            array (
                'id' => 6210,
                'nama' => 'KABUPATEN PULANG PISAU',
                'provinsi_id' => 62,
            ),
            338 => 
            array (
                'id' => 6211,
                'nama' => 'KABUPATEN GUNUNG MAS',
                'provinsi_id' => 62,
            ),
            339 => 
            array (
                'id' => 6212,
                'nama' => 'KABUPATEN BARITO TIMUR',
                'provinsi_id' => 62,
            ),
            340 => 
            array (
                'id' => 6213,
                'nama' => 'KABUPATEN MURUNG RAYA',
                'provinsi_id' => 62,
            ),
            341 => 
            array (
                'id' => 6271,
                'nama' => 'KOTA PALANGKA RAYA',
                'provinsi_id' => 62,
            ),
            342 => 
            array (
                'id' => 6301,
                'nama' => 'KABUPATEN TANAH LAUT',
                'provinsi_id' => 63,
            ),
            343 => 
            array (
                'id' => 6302,
                'nama' => 'KABUPATEN KOTA BARU',
                'provinsi_id' => 63,
            ),
            344 => 
            array (
                'id' => 6303,
                'nama' => 'KABUPATEN BANJAR',
                'provinsi_id' => 63,
            ),
            345 => 
            array (
                'id' => 6304,
                'nama' => 'KABUPATEN BARITO KUALA',
                'provinsi_id' => 63,
            ),
            346 => 
            array (
                'id' => 6305,
                'nama' => 'KABUPATEN TAPIN',
                'provinsi_id' => 63,
            ),
            347 => 
            array (
                'id' => 6306,
                'nama' => 'KABUPATEN HULU SUNGAI SELATAN',
                'provinsi_id' => 63,
            ),
            348 => 
            array (
                'id' => 6307,
                'nama' => 'KABUPATEN HULU SUNGAI TENGAH',
                'provinsi_id' => 63,
            ),
            349 => 
            array (
                'id' => 6308,
                'nama' => 'KABUPATEN HULU SUNGAI UTARA',
                'provinsi_id' => 63,
            ),
            350 => 
            array (
                'id' => 6309,
                'nama' => 'KABUPATEN TABALONG',
                'provinsi_id' => 63,
            ),
            351 => 
            array (
                'id' => 6310,
                'nama' => 'KABUPATEN TANAH BUMBU',
                'provinsi_id' => 63,
            ),
            352 => 
            array (
                'id' => 6311,
                'nama' => 'KABUPATEN BALANGAN',
                'provinsi_id' => 63,
            ),
            353 => 
            array (
                'id' => 6371,
                'nama' => 'KOTA BANJARMASIN',
                'provinsi_id' => 63,
            ),
            354 => 
            array (
                'id' => 6372,
                'nama' => 'KOTA BANJAR BARU',
                'provinsi_id' => 63,
            ),
            355 => 
            array (
                'id' => 6401,
                'nama' => 'KABUPATEN PASER',
                'provinsi_id' => 64,
            ),
            356 => 
            array (
                'id' => 6402,
                'nama' => 'KABUPATEN KUTAI BARAT',
                'provinsi_id' => 64,
            ),
            357 => 
            array (
                'id' => 6403,
                'nama' => 'KABUPATEN KUTAI KARTANEGARA',
                'provinsi_id' => 64,
            ),
            358 => 
            array (
                'id' => 6404,
                'nama' => 'KABUPATEN KUTAI TIMUR',
                'provinsi_id' => 64,
            ),
            359 => 
            array (
                'id' => 6405,
                'nama' => 'KABUPATEN BERAU',
                'provinsi_id' => 64,
            ),
            360 => 
            array (
                'id' => 6409,
                'nama' => 'KABUPATEN PENAJAM PASER UTARA',
                'provinsi_id' => 64,
            ),
            361 => 
            array (
                'id' => 6411,
                'nama' => 'KABUPATEN MAHAKAM HULU',
                'provinsi_id' => 64,
            ),
            362 => 
            array (
                'id' => 6471,
                'nama' => 'KOTA BALIKPAPAN',
                'provinsi_id' => 64,
            ),
            363 => 
            array (
                'id' => 6472,
                'nama' => 'KOTA SAMARINDA',
                'provinsi_id' => 64,
            ),
            364 => 
            array (
                'id' => 6474,
                'nama' => 'KOTA BONTANG',
                'provinsi_id' => 64,
            ),
            365 => 
            array (
                'id' => 6501,
                'nama' => 'KABUPATEN MALINAU',
                'provinsi_id' => 65,
            ),
            366 => 
            array (
                'id' => 6502,
                'nama' => 'KABUPATEN BULUNGAN',
                'provinsi_id' => 65,
            ),
            367 => 
            array (
                'id' => 6503,
                'nama' => 'KABUPATEN TANA TIDUNG',
                'provinsi_id' => 65,
            ),
            368 => 
            array (
                'id' => 6504,
                'nama' => 'KABUPATEN NUNUKAN',
                'provinsi_id' => 65,
            ),
            369 => 
            array (
                'id' => 6571,
                'nama' => 'KOTA TARAKAN',
                'provinsi_id' => 65,
            ),
            370 => 
            array (
                'id' => 7101,
                'nama' => 'KABUPATEN BOLAANG MONGONDOW',
                'provinsi_id' => 71,
            ),
            371 => 
            array (
                'id' => 7102,
                'nama' => 'KABUPATEN MINAHASA',
                'provinsi_id' => 71,
            ),
            372 => 
            array (
                'id' => 7103,
                'nama' => 'KABUPATEN KEPULAUAN SANGIHE',
                'provinsi_id' => 71,
            ),
            373 => 
            array (
                'id' => 7104,
                'nama' => 'KABUPATEN KEPULAUAN TALAUD',
                'provinsi_id' => 71,
            ),
            374 => 
            array (
                'id' => 7105,
                'nama' => 'KABUPATEN MINAHASA SELATAN',
                'provinsi_id' => 71,
            ),
            375 => 
            array (
                'id' => 7106,
                'nama' => 'KABUPATEN MINAHASA UTARA',
                'provinsi_id' => 71,
            ),
            376 => 
            array (
                'id' => 7107,
                'nama' => 'KABUPATEN BOLAANG MONGONDOW UTARA',
                'provinsi_id' => 71,
            ),
            377 => 
            array (
                'id' => 7108,
                'nama' => 'KABUPATEN SIAU TAGULANDANG BIARO',
                'provinsi_id' => 71,
            ),
            378 => 
            array (
                'id' => 7109,
                'nama' => 'KABUPATEN MINAHASA TENGGARA',
                'provinsi_id' => 71,
            ),
            379 => 
            array (
                'id' => 7110,
                'nama' => 'KABUPATEN BOLAANG MONGONDOW SELATAN',
                'provinsi_id' => 71,
            ),
            380 => 
            array (
                'id' => 7111,
                'nama' => 'KABUPATEN BOLAANG MONGONDOW TIMUR',
                'provinsi_id' => 71,
            ),
            381 => 
            array (
                'id' => 7171,
                'nama' => 'KOTA MANADO',
                'provinsi_id' => 71,
            ),
            382 => 
            array (
                'id' => 7172,
                'nama' => 'KOTA BITUNG',
                'provinsi_id' => 71,
            ),
            383 => 
            array (
                'id' => 7173,
                'nama' => 'KOTA TOMOHON',
                'provinsi_id' => 71,
            ),
            384 => 
            array (
                'id' => 7174,
                'nama' => 'KOTA KOTAMOBAGU',
                'provinsi_id' => 71,
            ),
            385 => 
            array (
                'id' => 7201,
                'nama' => 'KABUPATEN BANGGAI KEPULAUAN',
                'provinsi_id' => 72,
            ),
            386 => 
            array (
                'id' => 7202,
                'nama' => 'KABUPATEN BANGGAI',
                'provinsi_id' => 72,
            ),
            387 => 
            array (
                'id' => 7203,
                'nama' => 'KABUPATEN MOROWALI',
                'provinsi_id' => 72,
            ),
            388 => 
            array (
                'id' => 7204,
                'nama' => 'KABUPATEN POSO',
                'provinsi_id' => 72,
            ),
            389 => 
            array (
                'id' => 7205,
                'nama' => 'KABUPATEN DONGGALA',
                'provinsi_id' => 72,
            ),
            390 => 
            array (
                'id' => 7206,
                'nama' => 'KABUPATEN TOLI-TOLI',
                'provinsi_id' => 72,
            ),
            391 => 
            array (
                'id' => 7207,
                'nama' => 'KABUPATEN BUOL',
                'provinsi_id' => 72,
            ),
            392 => 
            array (
                'id' => 7208,
                'nama' => 'KABUPATEN PARIGI MOUTONG',
                'provinsi_id' => 72,
            ),
            393 => 
            array (
                'id' => 7209,
                'nama' => 'KABUPATEN TOJO UNA-UNA',
                'provinsi_id' => 72,
            ),
            394 => 
            array (
                'id' => 7210,
                'nama' => 'KABUPATEN SIGI',
                'provinsi_id' => 72,
            ),
            395 => 
            array (
                'id' => 7211,
                'nama' => 'KABUPATEN BANGGAI LAUT',
                'provinsi_id' => 72,
            ),
            396 => 
            array (
                'id' => 7212,
                'nama' => 'KABUPATEN MOROWALI UTARA',
                'provinsi_id' => 72,
            ),
            397 => 
            array (
                'id' => 7271,
                'nama' => 'KOTA PALU',
                'provinsi_id' => 72,
            ),
            398 => 
            array (
                'id' => 7301,
                'nama' => 'KABUPATEN KEPULAUAN SELAYAR',
                'provinsi_id' => 73,
            ),
            399 => 
            array (
                'id' => 7302,
                'nama' => 'KABUPATEN BULUKUMBA',
                'provinsi_id' => 73,
            ),
            400 => 
            array (
                'id' => 7303,
                'nama' => 'KABUPATEN BANTAENG',
                'provinsi_id' => 73,
            ),
            401 => 
            array (
                'id' => 7304,
                'nama' => 'KABUPATEN JENEPONTO',
                'provinsi_id' => 73,
            ),
            402 => 
            array (
                'id' => 7305,
                'nama' => 'KABUPATEN TAKALAR',
                'provinsi_id' => 73,
            ),
            403 => 
            array (
                'id' => 7306,
                'nama' => 'KABUPATEN GOWA',
                'provinsi_id' => 73,
            ),
            404 => 
            array (
                'id' => 7307,
                'nama' => 'KABUPATEN SINJAI',
                'provinsi_id' => 73,
            ),
            405 => 
            array (
                'id' => 7308,
                'nama' => 'KABUPATEN MAROS',
                'provinsi_id' => 73,
            ),
            406 => 
            array (
                'id' => 7309,
                'nama' => 'KABUPATEN PANGKAJENE DAN KEPULAUAN',
                'provinsi_id' => 73,
            ),
            407 => 
            array (
                'id' => 7310,
                'nama' => 'KABUPATEN BARRU',
                'provinsi_id' => 73,
            ),
            408 => 
            array (
                'id' => 7311,
                'nama' => 'KABUPATEN BONE',
                'provinsi_id' => 73,
            ),
            409 => 
            array (
                'id' => 7312,
                'nama' => 'KABUPATEN SOPPENG',
                'provinsi_id' => 73,
            ),
            410 => 
            array (
                'id' => 7313,
                'nama' => 'KABUPATEN WAJO',
                'provinsi_id' => 73,
            ),
            411 => 
            array (
                'id' => 7314,
                'nama' => 'KABUPATEN SIDENRENG RAPPANG',
                'provinsi_id' => 73,
            ),
            412 => 
            array (
                'id' => 7315,
                'nama' => 'KABUPATEN PINRANG',
                'provinsi_id' => 73,
            ),
            413 => 
            array (
                'id' => 7316,
                'nama' => 'KABUPATEN ENREKANG',
                'provinsi_id' => 73,
            ),
            414 => 
            array (
                'id' => 7317,
                'nama' => 'KABUPATEN LUWU',
                'provinsi_id' => 73,
            ),
            415 => 
            array (
                'id' => 7318,
                'nama' => 'KABUPATEN TANA TORAJA',
                'provinsi_id' => 73,
            ),
            416 => 
            array (
                'id' => 7322,
                'nama' => 'KABUPATEN LUWU UTARA',
                'provinsi_id' => 73,
            ),
            417 => 
            array (
                'id' => 7325,
                'nama' => 'KABUPATEN LUWU TIMUR',
                'provinsi_id' => 73,
            ),
            418 => 
            array (
                'id' => 7326,
                'nama' => 'KABUPATEN TORAJA UTARA',
                'provinsi_id' => 73,
            ),
            419 => 
            array (
                'id' => 7371,
                'nama' => 'KOTA MAKASSAR',
                'provinsi_id' => 73,
            ),
            420 => 
            array (
                'id' => 7372,
                'nama' => 'KOTA PAREPARE',
                'provinsi_id' => 73,
            ),
            421 => 
            array (
                'id' => 7373,
                'nama' => 'KOTA PALOPO',
                'provinsi_id' => 73,
            ),
            422 => 
            array (
                'id' => 7401,
                'nama' => 'KABUPATEN BUTON',
                'provinsi_id' => 74,
            ),
            423 => 
            array (
                'id' => 7402,
                'nama' => 'KABUPATEN MUNA',
                'provinsi_id' => 74,
            ),
            424 => 
            array (
                'id' => 7403,
                'nama' => 'KABUPATEN KONAWE',
                'provinsi_id' => 74,
            ),
            425 => 
            array (
                'id' => 7404,
                'nama' => 'KABUPATEN KOLAKA',
                'provinsi_id' => 74,
            ),
            426 => 
            array (
                'id' => 7405,
                'nama' => 'KABUPATEN KONAWE SELATAN',
                'provinsi_id' => 74,
            ),
            427 => 
            array (
                'id' => 7406,
                'nama' => 'KABUPATEN BOMBANA',
                'provinsi_id' => 74,
            ),
            428 => 
            array (
                'id' => 7407,
                'nama' => 'KABUPATEN WAKATOBI',
                'provinsi_id' => 74,
            ),
            429 => 
            array (
                'id' => 7408,
                'nama' => 'KABUPATEN KOLAKA UTARA',
                'provinsi_id' => 74,
            ),
            430 => 
            array (
                'id' => 7409,
                'nama' => 'KABUPATEN BUTON UTARA',
                'provinsi_id' => 74,
            ),
            431 => 
            array (
                'id' => 7410,
                'nama' => 'KABUPATEN KONAWE UTARA',
                'provinsi_id' => 74,
            ),
            432 => 
            array (
                'id' => 7411,
                'nama' => 'KABUPATEN KOLAKA TIMUR',
                'provinsi_id' => 74,
            ),
            433 => 
            array (
                'id' => 7412,
                'nama' => 'KABUPATEN KONAWE KEPULAUAN',
                'provinsi_id' => 74,
            ),
            434 => 
            array (
                'id' => 7413,
                'nama' => 'KABUPATEN MUNA BARAT',
                'provinsi_id' => 74,
            ),
            435 => 
            array (
                'id' => 7414,
                'nama' => 'KABUPATEN BUTON TENGAH',
                'provinsi_id' => 74,
            ),
            436 => 
            array (
                'id' => 7415,
                'nama' => 'KABUPATEN BUTON SELATAN',
                'provinsi_id' => 74,
            ),
            437 => 
            array (
                'id' => 7471,
                'nama' => 'KOTA KENDARI',
                'provinsi_id' => 74,
            ),
            438 => 
            array (
                'id' => 7472,
                'nama' => 'KOTA BAUBAU',
                'provinsi_id' => 74,
            ),
            439 => 
            array (
                'id' => 7501,
                'nama' => 'KABUPATEN BOALEMO',
                'provinsi_id' => 75,
            ),
            440 => 
            array (
                'id' => 7502,
                'nama' => 'KABUPATEN GORONTALO',
                'provinsi_id' => 75,
            ),
            441 => 
            array (
                'id' => 7503,
                'nama' => 'KABUPATEN POHUWATO',
                'provinsi_id' => 75,
            ),
            442 => 
            array (
                'id' => 7504,
                'nama' => 'KABUPATEN BONE BOLANGO',
                'provinsi_id' => 75,
            ),
            443 => 
            array (
                'id' => 7505,
                'nama' => 'KABUPATEN GORONTALO UTARA',
                'provinsi_id' => 75,
            ),
            444 => 
            array (
                'id' => 7571,
                'nama' => 'KOTA GORONTALO',
                'provinsi_id' => 75,
            ),
            445 => 
            array (
                'id' => 7601,
                'nama' => 'KABUPATEN MAJENE',
                'provinsi_id' => 76,
            ),
            446 => 
            array (
                'id' => 7602,
                'nama' => 'KABUPATEN POLEWALI MANDAR',
                'provinsi_id' => 76,
            ),
            447 => 
            array (
                'id' => 7603,
                'nama' => 'KABUPATEN MAMASA',
                'provinsi_id' => 76,
            ),
            448 => 
            array (
                'id' => 7604,
                'nama' => 'KABUPATEN MAMUJU',
                'provinsi_id' => 76,
            ),
            449 => 
            array (
                'id' => 7605,
                'nama' => 'KABUPATEN MAMUJU UTARA',
                'provinsi_id' => 76,
            ),
            450 => 
            array (
                'id' => 7606,
                'nama' => 'KABUPATEN MAMUJU TENGAH',
                'provinsi_id' => 76,
            ),
            451 => 
            array (
                'id' => 8101,
                'nama' => 'KABUPATEN MALUKU TENGGARA BARAT',
                'provinsi_id' => 81,
            ),
            452 => 
            array (
                'id' => 8102,
                'nama' => 'KABUPATEN MALUKU TENGGARA',
                'provinsi_id' => 81,
            ),
            453 => 
            array (
                'id' => 8103,
                'nama' => 'KABUPATEN MALUKU TENGAH',
                'provinsi_id' => 81,
            ),
            454 => 
            array (
                'id' => 8104,
                'nama' => 'KABUPATEN BURU',
                'provinsi_id' => 81,
            ),
            455 => 
            array (
                'id' => 8105,
                'nama' => 'KABUPATEN KEPULAUAN ARU',
                'provinsi_id' => 81,
            ),
            456 => 
            array (
                'id' => 8106,
                'nama' => 'KABUPATEN SERAM BAGIAN BARAT',
                'provinsi_id' => 81,
            ),
            457 => 
            array (
                'id' => 8107,
                'nama' => 'KABUPATEN SERAM BAGIAN TIMUR',
                'provinsi_id' => 81,
            ),
            458 => 
            array (
                'id' => 8108,
                'nama' => 'KABUPATEN MALUKU BARAT DAYA',
                'provinsi_id' => 81,
            ),
            459 => 
            array (
                'id' => 8109,
                'nama' => 'KABUPATEN BURU SELATAN',
                'provinsi_id' => 81,
            ),
            460 => 
            array (
                'id' => 8171,
                'nama' => 'KOTA AMBON',
                'provinsi_id' => 81,
            ),
            461 => 
            array (
                'id' => 8172,
                'nama' => 'KOTA TUAL',
                'provinsi_id' => 81,
            ),
            462 => 
            array (
                'id' => 8201,
                'nama' => 'KABUPATEN HALMAHERA BARAT',
                'provinsi_id' => 82,
            ),
            463 => 
            array (
                'id' => 8202,
                'nama' => 'KABUPATEN HALMAHERA TENGAH',
                'provinsi_id' => 82,
            ),
            464 => 
            array (
                'id' => 8203,
                'nama' => 'KABUPATEN KEPULAUAN SULA',
                'provinsi_id' => 82,
            ),
            465 => 
            array (
                'id' => 8204,
                'nama' => 'KABUPATEN HALMAHERA SELATAN',
                'provinsi_id' => 82,
            ),
            466 => 
            array (
                'id' => 8205,
                'nama' => 'KABUPATEN HALMAHERA UTARA',
                'provinsi_id' => 82,
            ),
            467 => 
            array (
                'id' => 8206,
                'nama' => 'KABUPATEN HALMAHERA TIMUR',
                'provinsi_id' => 82,
            ),
            468 => 
            array (
                'id' => 8207,
                'nama' => 'KABUPATEN PULAU MOROTAI',
                'provinsi_id' => 82,
            ),
            469 => 
            array (
                'id' => 8208,
                'nama' => 'KABUPATEN PULAU TALIABU',
                'provinsi_id' => 82,
            ),
            470 => 
            array (
                'id' => 8271,
                'nama' => 'KOTA TERNATE',
                'provinsi_id' => 82,
            ),
            471 => 
            array (
                'id' => 8272,
                'nama' => 'KOTA TIDORE KEPULAUAN',
                'provinsi_id' => 82,
            ),
            472 => 
            array (
                'id' => 9101,
                'nama' => 'KABUPATEN FAKFAK',
                'provinsi_id' => 91,
            ),
            473 => 
            array (
                'id' => 9102,
                'nama' => 'KABUPATEN KAIMANA',
                'provinsi_id' => 91,
            ),
            474 => 
            array (
                'id' => 9103,
                'nama' => 'KABUPATEN TELUK WONDAMA',
                'provinsi_id' => 91,
            ),
            475 => 
            array (
                'id' => 9104,
                'nama' => 'KABUPATEN TELUK BINTUNI',
                'provinsi_id' => 91,
            ),
            476 => 
            array (
                'id' => 9105,
                'nama' => 'KABUPATEN MANOKWARI',
                'provinsi_id' => 91,
            ),
            477 => 
            array (
                'id' => 9106,
                'nama' => 'KABUPATEN SORONG SELATAN',
                'provinsi_id' => 91,
            ),
            478 => 
            array (
                'id' => 9107,
                'nama' => 'KABUPATEN SORONG',
                'provinsi_id' => 91,
            ),
            479 => 
            array (
                'id' => 9108,
                'nama' => 'KABUPATEN RAJA AMPAT',
                'provinsi_id' => 91,
            ),
            480 => 
            array (
                'id' => 9109,
                'nama' => 'KABUPATEN TAMBRAUW',
                'provinsi_id' => 91,
            ),
            481 => 
            array (
                'id' => 9110,
                'nama' => 'KABUPATEN MAYBRAT',
                'provinsi_id' => 91,
            ),
            482 => 
            array (
                'id' => 9111,
                'nama' => 'KABUPATEN MANOKWARI SELATAN',
                'provinsi_id' => 91,
            ),
            483 => 
            array (
                'id' => 9112,
                'nama' => 'KABUPATEN PEGUNUNGAN ARFAK',
                'provinsi_id' => 91,
            ),
            484 => 
            array (
                'id' => 9171,
                'nama' => 'KOTA SORONG',
                'provinsi_id' => 91,
            ),
            485 => 
            array (
                'id' => 9401,
                'nama' => 'KABUPATEN MERAUKE',
                'provinsi_id' => 94,
            ),
            486 => 
            array (
                'id' => 9402,
                'nama' => 'KABUPATEN JAYAWIJAYA',
                'provinsi_id' => 94,
            ),
            487 => 
            array (
                'id' => 9403,
                'nama' => 'KABUPATEN JAYAPURA',
                'provinsi_id' => 94,
            ),
            488 => 
            array (
                'id' => 9404,
                'nama' => 'KABUPATEN NABIRE',
                'provinsi_id' => 94,
            ),
            489 => 
            array (
                'id' => 9408,
                'nama' => 'KABUPATEN KEPULAUAN YAPEN',
                'provinsi_id' => 94,
            ),
            490 => 
            array (
                'id' => 9409,
                'nama' => 'KABUPATEN BIAK NUMFOR',
                'provinsi_id' => 94,
            ),
            491 => 
            array (
                'id' => 9410,
                'nama' => 'KABUPATEN PANIAI',
                'provinsi_id' => 94,
            ),
            492 => 
            array (
                'id' => 9411,
                'nama' => 'KABUPATEN PUNCAK JAYA',
                'provinsi_id' => 94,
            ),
            493 => 
            array (
                'id' => 9412,
                'nama' => 'KABUPATEN MIMIKA',
                'provinsi_id' => 94,
            ),
            494 => 
            array (
                'id' => 9413,
                'nama' => 'KABUPATEN BOVEN DIGOEL',
                'provinsi_id' => 94,
            ),
            495 => 
            array (
                'id' => 9414,
                'nama' => 'KABUPATEN MAPPI',
                'provinsi_id' => 94,
            ),
            496 => 
            array (
                'id' => 9415,
                'nama' => 'KABUPATEN ASMAT',
                'provinsi_id' => 94,
            ),
            497 => 
            array (
                'id' => 9416,
                'nama' => 'KABUPATEN YAHUKIMO',
                'provinsi_id' => 94,
            ),
            498 => 
            array (
                'id' => 9417,
                'nama' => 'KABUPATEN PEGUNUNGAN BINTANG',
                'provinsi_id' => 94,
            ),
            499 => 
            array (
                'id' => 9418,
                'nama' => 'KABUPATEN TOLIKARA',
                'provinsi_id' => 94,
            ),
        ));

        DB::table('kabupaten_kota')->insert(array (
            0 => 
            array (
                'id' => 9419,
                'nama' => 'KABUPATEN SARMI',
                'provinsi_id' => 94,
            ),
            1 => 
            array (
                'id' => 9420,
                'nama' => 'KABUPATEN KEEROM',
                'provinsi_id' => 94,
            ),
            2 => 
            array (
                'id' => 9426,
                'nama' => 'KABUPATEN WAROPEN',
                'provinsi_id' => 94,
            ),
            3 => 
            array (
                'id' => 9427,
                'nama' => 'KABUPATEN SUPIORI',
                'provinsi_id' => 94,
            ),
            4 => 
            array (
                'id' => 9428,
                'nama' => 'KABUPATEN MAMBERAMO RAYA',
                'provinsi_id' => 94,
            ),
            5 => 
            array (
                'id' => 9429,
                'nama' => 'KABUPATEN NDUGA',
                'provinsi_id' => 94,
            ),
            6 => 
            array (
                'id' => 9430,
                'nama' => 'KABUPATEN LANNY JAYA',
                'provinsi_id' => 94,
            ),
            7 => 
            array (
                'id' => 9431,
                'nama' => 'KABUPATEN MAMBERAMO TENGAH',
                'provinsi_id' => 94,
            ),
            8 => 
            array (
                'id' => 9432,
                'nama' => 'KABUPATEN YALIMO',
                'provinsi_id' => 94,
            ),
            9 => 
            array (
                'id' => 9433,
                'nama' => 'KABUPATEN PUNCAK',
                'provinsi_id' => 94,
            ),
            10 => 
            array (
                'id' => 9434,
                'nama' => 'KABUPATEN DOGIYAI',
                'provinsi_id' => 94,
            ),
            11 => 
            array (
                'id' => 9435,
                'nama' => 'KABUPATEN INTAN JAYA',
                'provinsi_id' => 94,
            ),
            12 => 
            array (
                'id' => 9436,
                'nama' => 'KABUPATEN DEIYAI',
                'provinsi_id' => 94,
            ),
            13 => 
            array (
                'id' => 9471,
                'nama' => 'KOTA JAYAPURA',
                'provinsi_id' => 94,
            ),
        ));
        
        
    }
}