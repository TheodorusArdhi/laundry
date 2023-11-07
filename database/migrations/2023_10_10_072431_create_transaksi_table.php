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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->unsignedBigInteger('id_status_pembayaran')->nullable();
            $table->unsignedBigInteger('id_status_transaksi')->nullable();
            $table->unsignedBigInteger('id_pengumuman')->nullable();
            $table->string('no_transaksi');
            $table->date('tgl_masuk');
            $table->date('tgl_selesai')->nullable();
            $table->date('tgl_ambil')->nullable();
            $table->date('tgl_tenggat')->nullable();
            $table->integer('total_harga');
            $table->integer('diskon')->nullable();
            $table->integer('total_tagihan');
            $table->integer('diterima')->nullable();
            $table->text('komplain');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_admin')->references('id_user')->on('users');
            $table->foreign('id_status_pembayaran')->references('id_status')->on('status');
            $table->foreign('id_status_transaksi')->references('id_status')->on('status');
            $table->foreign('id_pengumuman')->references('id_pengumuman')->on('pengumuman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
