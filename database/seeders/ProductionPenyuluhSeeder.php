<?php

namespace Database\Seeders;

use App\Models\Penyuluh;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator;

class ProductionPenyuluhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $no_hp = 822222222222;
        $index = 1;

        $nama = [
            [
                'nama' => 'Dr. Susi Susilawati, SHi.,MH',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
            [
                'nama' => 'Dr. Abdul Rahman, SP., MP',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Dra. Ritha Safithri, M.Si',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
            [
                'nama' => 'Dr. Mardi Lestari, S.Pd., M.Pd.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Zainal , S.Pt., M.Si',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Muhammad Ridwan, SH., MH',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Dr. Zulnuraini, S,Pd., M.Pd',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
            [
                'nama' => 'Dr. Adrianton, SP., MP.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'dr. Gabriella Bamba Ratih Lintin, M.Biomed.',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
            [
                'nama' => 'Muhammad Jusman Rau, S.KM., M.Kes.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Rendra Zainal Maliki, S.Pd., M.Pd.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Jamaluddin, S. Farm., M.Si',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Dr. Jamaludin M. Sakung, S.Pd., M.Kes.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Budi, S.Pd., M.Pd.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Dr. Ramli, SP., MP.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Dr. Muh. Nawawi, M.Si',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Prof. Dr. Rosmala Nur, M.Si.',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
            [
                'nama' => 'Jane Mariem Monepa, S.Psi., M.Psi., Psikolog',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
            [
                'nama' => 'Made Krisna Laksmayani Antara, SP, M.P',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Dr. Ir. Rois Hasbi, MP',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Syaiful Hendra, S.Kom., M.Kom.',
                'jenis_kelamin' => 'LAKI-LAKI'
            ],
            [
                'nama' => 'Hajra Rasmita Ngemba, S.Kom., M.Kom',
                'jenis_kelamin' => 'PEREMPUAN'
            ],
        ];

        for ($i = 0; $i < count($nama); $i++) {
            $user = new User();
            $user->nomor_hp = "0" . $no_hp;
            $user->nik = $faker->nik;
            $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $user->role = 'penyuluh';
            $user->is_remaja = 0;
            $user->status = 1;
            $user->save();

            $penyuluh = new Penyuluh();
            $penyuluh->user_id = $user->id;
            $penyuluh->nik = $user->nik;
            $penyuluh->nama_lengkap = $nama[$i]['nama'];
            $penyuluh->jenis_kelamin = $nama[$i]['jenis_kelamin'];
            $penyuluh->tempat_lahir = 'SILAE';
            $penyuluh->tanggal_lahir = '1996-01-01';
            $penyuluh->agama_id = 1;
            $penyuluh->tujuh_angka_terakhir_str = '0000000';
            $penyuluh->nomor_hp = $user->nomor_hp;
            $penyuluh->email = 'penyuluh' . $index . '@gmail.com';
            $penyuluh->alamat = 'Jl. Mangga';
            $penyuluh->desa_kelurahan_id = 7210120004;
            $penyuluh->kecamatan_id = 7210120;
            $penyuluh->kabupaten_kota_id = 7210;
            $penyuluh->provinsi_id = 72;
            $penyuluh->foto_profil = NULL;
            $penyuluh->save();

            $no_hp++;
            $index++;
        }
    }
}
