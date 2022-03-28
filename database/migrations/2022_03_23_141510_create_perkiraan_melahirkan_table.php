<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerkiraanMelahirkanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perkiraan_melahirkan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('anggota_keluarga_id');
            $table->bigInteger('bidan_id');
            $table->date('tanggal_haid_terakhir');
            $table->date('tanggal_perkiraan_lahir');
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
        Schema::dropIfExists('perkiraan_melahirkan');
    }
}
