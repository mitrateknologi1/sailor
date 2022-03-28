<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalDeteksiDiniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_deteksi_dini', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urutan');
            $table->text('soal');
            $table->integer('skor_ya')->default(0);
            $table->integer('skor_tidak')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('soal_deteksi_dini');
    }
}
