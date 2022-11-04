<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionPenyuluhTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('penyuluh')->delete();

        \DB::table('penyuluh')->insert(array(
            0 =>
            array(
                'id' => '01ddd2c1-bdfc-4389-9450-a76200f1ebba',
                'user_id' => '91b09cf8-e194-4467-8b61-01fa766af530',
                'nik' => 1405424909981869,
                'nama_lengkap' => 'Dr. Abdul Rahman, SP., MP',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222223',
                'email' => 'penyuluh2@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => '01f70bff-4f02-46be-99f7-ebddc41e1839',
                'user_id' => '10af8eae-b7f2-4e3e-8c94-f5593a71e2da',
                'nik' => 2172675512968866,
                'nama_lengkap' => 'Syaiful Hendra, S.Kom., M.Kom.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222242',
                'email' => 'penyuluh21@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => '09792271-3b4f-42d5-8538-def81edcf4ef',
                'user_id' => 'bfcf668b-6709-464f-83ba-8c5fea4c8c96',
                'nik' => 5204500402201429,
                'nama_lengkap' => 'Hajra Rasmita Ngemba, S.Kom., M.Kom',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222243',
                'email' => 'penyuluh22@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => '13c1ca42-c4a7-11ec-9d64-0242ac120002',
                'user_id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e85',
                'nik' => 1234567890123456,
                'nama_lengkap' => 'TIKA',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'TONDO',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '1234567',
                'nomor_hp' => '081234567896',
                'email' => 'test@email.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => '13c1ca42-c4a7-11ec-9d64-0242ac120003',
                'user_id' => '5gf9ba91-4778-404c-aa7f-5fd327e87e88',
                'nik' => 1234567890123459,
                'nama_lengkap' => 'NURBAYAH',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'TONDO',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '1234567',
                'nomor_hp' => '081234567899',
                'email' => 'test@email.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => '173d4662-8760-4997-a649-2801d694e204',
                'user_id' => '57119a28-8ba0-4aa1-a876-3b6909a820c3',
                'nik' => 7472846102201711,
                'nama_lengkap' => 'Dr. Zulnuraini, S,Pd., M.Pd',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222228',
                'email' => 'penyuluh7@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => '25d7f1f5-31a4-487c-99a5-b81a041555d2',
                'user_id' => '651822a3-a186-4c43-bc70-135132fbd20f',
                'nik' => 9105602402999639,
                'nama_lengkap' => 'Zainal , S.Pt., M.Si',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222226',
                'email' => 'penyuluh5@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            7 =>
            array(
                'id' => '429ab196-d740-4d5f-92fd-1901a4ec49aa',
                'user_id' => '1130aac2-c05d-44e3-b1b8-62d9672eb67e',
                'nik' => 3579556709950323,
                'nama_lengkap' => 'Dr. Mardi Lestari, S.Pd., M.Pd.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222225',
                'email' => 'penyuluh4@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            8 =>
            array(
                'id' => '4fd50918-5d10-4f35-a78c-d4fd29bf7fce',
                'user_id' => '35d9f5ac-e6fc-4af7-8237-9052875a8e2d',
                'nik' => 3509094310144747,
                'nama_lengkap' => 'Jane Mariem Monepa, S.Psi., M.Psi., Psikolog',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222239',
                'email' => 'penyuluh18@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'id' => '50d8b84e-1265-48e9-b0a0-b3c38e7b5d67',
                'user_id' => 'a105af8a-4d3c-4a03-b68b-c945b02fafa1',
                'nik' => 5317721011192800,
                'nama_lengkap' => 'Prof. Dr. Rosmala Nur, M.Si.',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222238',
                'email' => 'penyuluh17@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            10 =>
            array(
                'id' => '64e7298a-b441-412c-8d0c-fb8cba9c5ccf',
                'user_id' => 'f185761d-8b19-4c3c-b5d6-79590114ab40',
                'nik' => 7604000601115104,
                'nama_lengkap' => 'Dr. Ir. Rois Hasbi, MP',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222241',
                'email' => 'penyuluh20@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            11 =>
            array(
                'id' => '6d9374a0-fa71-41c6-ab6d-fcbe8b725531',
                'user_id' => 'fee77791-c9be-44f7-9173-5d6eb692860e',
                'nik' => 1201136106206967,
                'nama_lengkap' => 'Rendra Zainal Maliki, S.Pd., M.Pd.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222232',
                'email' => 'penyuluh11@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            12 =>
            array(
                'id' => '7520d430-b711-408b-bb3c-a495f7bb7474',
                'user_id' => 'dd484c08-1c1a-43c7-9158-f86ba66504b3',
                'nik' => 5314175708967970,
                'nama_lengkap' => 'Dr. Muh. Nawawi, M.Si',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222237',
                'email' => 'penyuluh16@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            13 =>
            array(
                'id' => '7873119a-d7ff-4734-9136-b2952d7afed0',
                'user_id' => '6218d86b-7076-4f0f-b8b5-ce28ecc5417f',
                'nik' => 9128895907037969,
                'nama_lengkap' => 'Dra. Ritha Safithri, M.Si',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222224',
                'email' => 'penyuluh3@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            14 =>
            array(
                'id' => '7d66f36f-164b-42b0-96db-d57cdeb3edba',
                'user_id' => 'dcd8a66e-bdb7-4fcf-9e64-1312af007d0e',
                'nik' => 7409045303969655,
                'nama_lengkap' => 'Dr. Jamaludin M. Sakung, S.Pd., M.Kes.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222234',
                'email' => 'penyuluh13@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            15 =>
            array(
                'id' => '8d3d567f-2bfe-40ff-9e8e-2cad29a122fc',
                'user_id' => '300f55aa-821a-4352-b047-f967381cfe77',
                'nik' => 1308031806053228,
                'nama_lengkap' => 'Budi, S.Pd., M.Pd.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222235',
                'email' => 'penyuluh14@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            16 =>
            array(
                'id' => 'af663b0a-60a9-4be4-a7a0-572e8a1c0e61',
                'user_id' => 'ff516049-9ebc-4b44-8bf4-ce03b3775738',
                'nik' => 5207672402150792,
                'nama_lengkap' => 'Muhammad Jusman Rau, S.KM., M.Kes.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222231',
                'email' => 'penyuluh10@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            17 =>
            array(
                'id' => 'bc643925-db76-4657-af17-88121eec3b3c',
                'user_id' => '5eea1a54-a8b4-4c86-b7f4-fd9da565d26b',
                'nik' => 9120585510937252,
                'nama_lengkap' => 'Jamaluddin, S. Farm., M.Si',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222233',
                'email' => 'penyuluh12@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            18 =>
            array(
                'id' => 'be202f7d-aa9d-4593-874a-eb38c6a53659',
                'user_id' => '8550fc40-c2e1-4b61-9ab1-0c86d7396ad5',
                'nik' => 9121955403134222,
                'nama_lengkap' => 'Dr. Susi Susilawati, SHi.,MH',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222222',
                'email' => 'penyuluh1@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            19 =>
            array(
                'id' => 'c0b05ac9-f12b-460d-8bda-86922b4e78d9',
                'user_id' => '9f85263b-c074-483c-83b8-85113300246a',
                'nik' => 3278672603048473,
                'nama_lengkap' => 'Dr. Adrianton, SP., MP.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222229',
                'email' => 'penyuluh8@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            20 =>
            array(
                'id' => 'c6212c70-5f76-4c98-b1e4-593b9faf370c',
                'user_id' => 'f7907690-0ced-476c-8c68-75d0f2cd2a5e',
                'nik' => 1905020703166340,
                'nama_lengkap' => 'Made Krisna Laksmayani Antara, SP, M.P',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222240',
                'email' => 'penyuluh19@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            21 =>
            array(
                'id' => 'd898661a-f66f-4dd8-9a6b-b9cceaa7931a',
                'user_id' => '512c7364-7bfe-4c51-92da-efdae497173a',
                'nik' => 6303776807967000,
                'nama_lengkap' => 'Dr. Ramli, SP., MP.',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222236',
                'email' => 'penyuluh15@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:13',
                'updated_at' => '2022-10-25 12:48:13',
                'deleted_at' => NULL,
            ),
            22 =>
            array(
                'id' => 'e6d007f7-29aa-4aa7-84ec-79ed31e8aecc',
                'user_id' => 'f5b4b5cb-1f2d-4abb-9b9f-b70ada2ce9da',
                'nik' => 1307095101025929,
                'nama_lengkap' => 'Muhammad Ridwan, SH., MH',
                'jenis_kelamin' => 'LAKI-LAKI',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222227',
                'email' => 'penyuluh6@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
            23 =>
            array(
                'id' => 'fe73212c-4852-4525-96e6-cdbe3410d7cc',
                'user_id' => '54a8c3c6-8373-4f87-9d45-ca157bbfa881',
                'nik' => 3578045305957526,
                'nama_lengkap' => 'dr. Gabriella Bamba Ratih Lintin, M.Biomed.',
                'jenis_kelamin' => 'PEREMPUAN',
                'tempat_lahir' => 'SILAE',
                'tanggal_lahir' => '1996-01-01',
                'agama_id' => 1,
                'tujuh_angka_terakhir_str' => '0000000',
                'nomor_hp' => '0822222222230',
                'email' => 'penyuluh9@gmail.com',
                'alamat' => 'Jl. Mangga',
                'desa_kelurahan_id' => 7210120004,
                'kecamatan_id' => 7210120,
                'kabupaten_kota_id' => 7210,
                'provinsi_id' => 72,
                'foto_profil' => NULL,
                'created_at' => '2022-10-25 12:48:12',
                'updated_at' => '2022-10-25 12:48:12',
                'deleted_at' => NULL,
            ),
        ));
    }
}