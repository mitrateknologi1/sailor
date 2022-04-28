<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasiTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lokasi_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_profil');
            $table->uuid('profil_id');
            $table->bigInteger('desa_kelurahan_id');
            $table->bigInteger('kecamatan_id');
            $table->bigInteger('kabupaten_kota_id');
            $table->bigInteger('provinsi_id');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lokasi_tugas');
    }
}
