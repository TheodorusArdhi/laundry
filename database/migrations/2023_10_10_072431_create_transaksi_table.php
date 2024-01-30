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
            $table->unsignedBigInteger('id_admin');
            $table->unsignedBigInteger('id_status_pembayaran')->nullable();
            $table->unsignedBigInteger('id_status_transaksi')->nullable();
            $table->unsignedBigInteger('id_pengumuman')->nullable();
            $table->unsignedBigInteger('id_cabang');
            $table->string('no_transaksi');
            $table->date('tgl_masuk');
            $table->date('tgl_selesai')->nullable();
            $table->date('tgl_ambil')->nullable();
            $table->date('tgl_tenggat')->nullable();
            $table->integer('total_harga')->default(0);
            $table->integer('diskon')->default(0);
            $table->integer('poin_masuk')->default(0);
            $table->integer('poin_keluar')->default(0);
            $table->integer('total_tagihan')->default(0);
            $table->integer('diterima')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_admin')->references('id_user')->on('users');
            $table->foreign('id_status_pembayaran')->references('id_status')->on('status');
            $table->foreign('id_status_transaksi')->references('id_status')->on('status');
            $table->foreign('id_pengumuman')->references('id_pengumuman')->on('pengumuman');
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
        Schema::dropIfExists('transaksi');
    }
};
