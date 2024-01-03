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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->unsignedBigInteger('id_cabang')->nullable();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_telp');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('level');
            $table->string('notifikasi')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
