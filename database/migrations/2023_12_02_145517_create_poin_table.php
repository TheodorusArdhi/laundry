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
        Schema::create('poin', function (Blueprint $table) {
            $table->id('id_poin');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_transaksi');
            $table->integer('jumlah');
            $table->date('tgl_tenggat');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poin');
    }
};
