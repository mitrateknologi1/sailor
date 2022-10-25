<?php

namespace Database\Seeders;

use App\Models\Bidan;
use App\Models\Kecamatan;
use App\Models\LokasiTugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator;


class ProductionBidanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        $no_hp = 811111111111;
        $index = 1;

        $daftarKecamatan = Kecamatan::where('kabupaten_kota_id', 7210)->get();
        foreach ($daftarKecamatan as $kecamatan) {
            foreach ($kecamatan->desaKelurahan as $desa) {
                $user = new User();
                $user->nomor_hp = "0" . $no_hp;
                $user->nik = $faker->nik;
                $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
                $user->role = 'bidan';
                $user->is_remaja = 0;
                $user->status = 1;
                $user->save();

                $bidan = new Bidan();
                $bidan->user_id = $user->id;
                $bidan->nik = $user->nik;
                $bidan->nama_lengkap = 'Bidan Desa ' . $desa->nama . ' Kecamatan ' . $desa->kecamatan->nama;
                $bidan->jenis_kelamin = 'PEREMPUAN';
                $bidan->tempat_lahir = 'SILAE';
                $bidan->tanggal_lahir = '1996-01-01';
                $bidan->agama_id = 1;
                $bidan->tujuh_angka_terakhir_str = '0000000';
                $bidan->nomor_hp = $user->nomor_hp;
                $bidan->email = 'bidan' . $index . '@gmail.com';
                $bidan->alamat = 'Jl. Mangga';
                $bidan->desa_kelurahan_id = 7210120004;
                $bidan->kecamatan_id = 7210120;
                $bidan->kabupaten_kota_id = 7210;
                $bidan->provinsi_id = 72;
                $bidan->foto_profil = NULL;
                $bidan->save();

                $lokasiTugas = new LokasiTugas();
                $lokasiTugas->jenis_profil = 'bidan';
                $lokasiTugas->profil_id = $bidan->id;
                $lokasiTugas->desa_kelurahan_id = $desa->id;
                $lokasiTugas->kecamatan_id = $desa->kecamatan->id;
                $lokasiTugas->kabupaten_kota_id = $desa->kecamatan->kabupatenKota->id;
                $lokasiTugas->provinsi_id = $desa->kecamatan->kabupatenKota->provinsi->id;
                $lokasiTugas->save();

                $index++;
                $no_hp++;
            }
        }
    }
}
