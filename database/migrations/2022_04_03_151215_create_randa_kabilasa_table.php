<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRandaKabilasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('randa_kabilasa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('anggota_keluarga_id');
            $table->uuid('bidan_id')->nullable();
            $table->integer('is_mencegah_malnutrisi')->default(0);
            $table->integer('is_mencegah_pernikahan_dini')->default(0);
            $table->integer('is_meningkatkan_life_skill')->default(0);
            $table->string('kategori_hb');
            $table->string('kategori_lingkar_lengan_atas');
            $table->string('kategori_imt');
            $table->string('kategori_mencegah_malnutrisi')->nullable();
            $table->string('kategori_meningkatkan_life_skill')->nullable();
            $table->string('kategori_mencegah_pernikahan_dini')->nullable();
            $table->integer('is_valid_mencegah_malnutrisi')->default(0);
            $table->integer('is_valid_mencegah_pernikahan_dini')->default(0);
            $table->integer('is_valid_meningkatkan_life_skill')->default(0);
            $table->date('tanggal_validasi')->nullable();
            $table->text('alasan_ditolak_mencegah_malnutrisi')->nullable();
            $table->text('alasan_ditolak_mencegah_pernikahan_dini')->nullable();
            $table->text('alasan_ditolak_meningkatkan_life_skill')->nullable();
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
        Schema::dropIfExists('randa_kabilasa');
    }
}
