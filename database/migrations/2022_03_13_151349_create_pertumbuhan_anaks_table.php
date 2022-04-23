<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertumbuhanAnaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertumbuhan_anak', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('anggota_keluarga_id');
            $table->bigInteger('bidan_id')->nullable();
            $table->integer('berat_badan');
            $table->float('zscore');
            $table->string('hasil');
            $table->integer('is_valid')->default(0);
            $table->date('tanggal_validasi')->nullable();
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
        Schema::dropIfExists('pertumbuhan_anak');
    }
}
