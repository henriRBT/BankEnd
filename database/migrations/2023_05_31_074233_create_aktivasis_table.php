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
        Schema::create('aktivasis', function (Blueprint $table) {
            $table->string('no_struk_aktivasi')->unique()->primary();
            $table->string('id_pegawai');
            $table->foreign('id_pegawai')->references('id')->on('pegawais')->cascadeOnUpdate()->OnDelete;
            $table->string('id_member');
            $table->foreign('id_member')->references('id')->on('members')->cascadeOnUpdate()->OnDelete;
            $table->Date('tanggal_transaksi');
            $table->float('jumlah_bayar');
            $table->Date('tanggal_berlaku');
            $table->float('bonus');
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
        Schema::dropIfExists('aktivasis');
    }
};
