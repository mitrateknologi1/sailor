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
            $table->uuid('id')->primary();
            $table->uuid('bidan_id')->nullable();
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
            // $table->date('dikeluarkan_tanggal')->nullable();
            // $table->text('dikeluarkan_oleh')->nullable();
            $table->text('file_kk')->nullable();
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
        Schema::dropIfExists('kartu_keluarga');
    }
}
