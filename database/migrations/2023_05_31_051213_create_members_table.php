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
        Schema::create('members', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('nama_member');
            $table->string('no_telepon_member');
            $table->string('alamat_member');
            $table->string('tanggal_lahir_member');
            $table->string('email_member');
            $table->date('tanggal_masa_aktif');
            $table->boolean('status');
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
        Schema::dropIfExists('members');
    }
};
