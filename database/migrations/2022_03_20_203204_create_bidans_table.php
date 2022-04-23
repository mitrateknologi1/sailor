<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('nik');
            $table->text('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('agama_id');
            $table->string('tujuh_angka_terakhir_str');
            $table->string('nomor_hp');
            $table->string('email')->nullable();
            $table->string('alamat');
            $table->bigInteger('desa_kelurahan_id');
            $table->bigInteger('kecamatan_id');
            $table->bigInteger('kabupaten_kota_id');
            $table->bigInteger('provinsi_id');
            $table->string('foto_profil')->nullable();
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
        Schema::dropIfExists('bidan');
    }
}
