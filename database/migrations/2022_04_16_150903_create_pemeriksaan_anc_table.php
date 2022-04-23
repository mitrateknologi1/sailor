<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeriksaanAncTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan_anc', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('anc_id');
            $table->integer('kehamilan_ke');
            $table->date('tanggal_haid_terakhir');
            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->float('tekanan_darah_sistolik');
            $table->float('tekanan_darah_diastolik');
            $table->float('lengan_atas');
            $table->float('tinggi_fundus');
            $table->float('denyut_jantung_janin');
            $table->float('hemoglobin_darah');
            $table->date('tanggal_perkiraan_lahir');
            $table->integer('usia_kehamilan');
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
        Schema::dropIfExists('pemeriksaan_anc');
    }
}
