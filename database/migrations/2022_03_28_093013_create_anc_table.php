<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anc', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('anggota_keluarga_id');
            $table->bigInteger('bidan_id');
            $table->integer('pemeriksaan_ke');
            $table->string('kategori_badan');
            $table->string('kategori_tekanan_darah');
            $table->string('kategori_lengan_atas');
            $table->string('kategori_denyut_jantung');
            $table->string('kategori_hemoglobin_darah');
            $table->string('vaksin_tetanus_sebelum_hamil');
            $table->string('vaksin_tetanus_sesudah_hamil');
            $table->string('minum_tablet');
            $table->string('konseling');
            $table->string('posisi_janin');
            $table->integer('is_valid')->default(0);
            $table->date('tanggal_validasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anc');
    }
}
