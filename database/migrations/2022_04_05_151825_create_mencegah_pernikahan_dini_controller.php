<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMencegahPernikahanDiniController extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mencegah_pernikahan_dini', function (Blueprint $table) {
            $table->id();
            $table->uuid('randa_kabilasa_id');
            $table->string('jawaban_1')->nullable();
            $table->string('jawaban_2')->nullable();
            $table->string('jawaban_3')->nullable();
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
        Schema::dropIfExists('mencegah_pernikahan_dini');
    }
}
