<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanDeteksiIbuMelahirkanStuntingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_deteksi_ibu_melahirkan_stunting', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deteksi_ibu_melahirkan_stunting_id');
            $table->bigInteger('soal_id');
            $table->string('jawaban');
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
        Schema::dropIfExists('JawabanDeteksiIbuMelahirkanStunting');
    }
}
