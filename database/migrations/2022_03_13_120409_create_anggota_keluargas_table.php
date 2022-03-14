<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kartu_keluarga_id');
            $table->bigInteger('akun_id')->nullable();
            $table->string('nama_lengkap');
            $table->bigInteger('nik');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('jenis_pekerjaan');
            $table->string('golongan_darah');
            $table->string('status_perkawinan');
            $table->date('tanggal_perkawinan')->nullable();
            $table->string('status_hubungan_dalam_keluarga');
            $table->string('kewarganegaraan');
            $table->string('no_paspor')->default('-');
            $table->string('no_kitap')->default('-');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->text('alamat_domisili');
            $table->bigInteger('desa_kelurahan_id');
            $table->bigInteger('kecamatan_id');
            $table->bigInteger('kabupaten_kota_id');
            $table->bigInteger('provinsi_id');
            $table->string('foto_ket_domisili')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_profil')->nullable();
            $table->integer('is_validasi')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota_keluarga');
    }
}
