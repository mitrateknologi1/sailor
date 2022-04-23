<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMencegahMalnutrisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mencegah_malnutrisi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('randa_kabilasa_id');
            $table->float('lingkar_lengan_atas');
            $table->float('tinggi_badan');
            $table->float('berat_badan');
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
        Schema::dropIfExists('mencegah_malnutrisi');
    }
}
