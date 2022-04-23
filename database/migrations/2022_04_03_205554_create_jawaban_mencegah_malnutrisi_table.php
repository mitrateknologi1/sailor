<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanMencegahMalnutrisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_mencegah_malnutrisi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mencegah_malnutrisi_id');
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
        Schema::dropIfExists('jawaban_mencegah_malnutrisi');
    }
}
