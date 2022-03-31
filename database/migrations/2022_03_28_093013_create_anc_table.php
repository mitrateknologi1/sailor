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
            $table->id();
            $table->bigInteger('anggota_keluarga_id');
            $table->bigInteger('bidan_id');
            $table->integer('kehamilan_ke');
            $table->integer('pemeriksaan_ke');
            $table->date('tanggal_haid_terakhir');
            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->float('tekanan_darah_sistolik');
            $table->float('tekanan_darah_diastolik');
            $table->float('lengan_atas');
            $table->float('tinggi_fundus');
            $table->string('posisi_janin');
            $table->float('denyut_jantung_janin');
            $table->float('hemoglobin_darah');
            $table->string('vaksin_tetanus_sebelum_hamil');
            $table->string('vaksin_tetanus_sesudah_hamil');
            $table->string('minum_tablet');
            $table->string('konseling');
            $table->date('tanggal_perkiraan_lahir');
            $table->integer('usia_kehamilan');
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
