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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->foreignId('id_role')->constrained('roles');
            $table->string('nama_pegawai');
            $table->string('alamat_pegawai');
            $table->string('no_telepon');
            $table->string('tanggal_lahir');
            $table->string('email_pegawai');
            $table->string('username');
            $table->string('password');
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
        Schema::dropIfExists('pegawais');
    }
};
