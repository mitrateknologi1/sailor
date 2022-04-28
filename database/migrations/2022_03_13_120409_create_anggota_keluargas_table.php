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
            $table->uuid('id')->primary();
            $table->uuid('bidan_id')->nullable();
            $table->uuid('kartu_keluarga_id');
            $table->uuid('user_id')->nullable();
            $table->string('nama_lengkap');
            $table->bigInteger('nik');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('agama_id');
            $table->integer('pendidikan_id');
            $table->integer('jenis_pekerjaan_id');
            $table->integer('golongan_darah_id');
            $table->integer('status_perkawinan_id');
            $table->date('tanggal_perkawinan')->nullable();
            $table->integer('status_hubungan_dalam_keluarga_id');
            $table->string('kewarganegaraan');
            $table->string('no_paspor')->default('-');
            $table->string('no_kitap')->default('-');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            // $table->text('alamat');
            // $table->bigInteger('desa_kelurahan_id');
            // $table->bigInteger('kecamatan_id');
            // $table->bigInteger('kabupaten_kota_id');
            // $table->bigInteger('provinsi_id');
            $table->string('foto_profil')->nullable();
            $table->integer('is_valid')->default(0);
            $table->date('tanggal_validasi')->nullable();
            $table->text('alasan_ditolak')->nullable();
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
