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
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->id('id_transaksi_detail');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_layanan');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
            $table->foreign('id_layanan')->references('id_layanan')->on('layanan');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
