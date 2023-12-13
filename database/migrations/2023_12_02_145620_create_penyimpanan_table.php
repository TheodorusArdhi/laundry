<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyimpanan', function (Blueprint $table) {
            $table->id('id_penyimpanan');
            $table->unsignedBigInteger('id_cabang');
            $table->string('nama');
            $table->string('merek');
            $table->decimal('jumlah', $precision = 11, $scale = 1);
            $table->integer('harga');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id_cabang')->on('cabang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyimpanan');
    }
};
