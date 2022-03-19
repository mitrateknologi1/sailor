<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTumbuhKembangAnaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tumbuh_kembang_anak', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->bigInteger('anggota_keluarga_id');
            $table->integer('is_valid');
            $table->bigInteger('nakes_id');
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
        Schema::dropIfExists('tumbuh_kembang_anak');
    }
}
