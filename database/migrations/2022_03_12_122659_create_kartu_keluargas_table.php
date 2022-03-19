<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('akun_id')->nullable();
            $table->bigInteger('nomor_kk');
            $table->text('nama_kepala_keluarga');
            $table->text('alamat');
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->integer('kode_pos');
            $table->bigInteger('desa_kelurahan_id');
            $table->bigInteger('kecamatan_id');
            $table->bigInteger('kabupaten_kota_id');
            $table->bigInteger('provinsi_id');
            $table->date('dikeluarkan_tanggal')->nullable();
            $table->text('dikeluarkan_oleh')->nullable();
            $table->text('foto_kk');
            $table->integer('is_valid')->default(0);
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
        Schema::dropIfExists('kartu_keluarga');
    }
}
