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
        Schema::create('transaksi_deposit_kelas', function (Blueprint $table) {
            $table->string('no_struk_kelas')->unique()->primary();
            $table->string('id_pegawai');
            $table->foreign('id_pegawai')->references('id')->on('pegawais')->cascadeOnUpdate()->OnDelete;
            $table->string('id_member');
            $table->foreign('id_member')->references('id')->on('members')->cascadeOnUpdate()->OnDelete;
            $table->foreignId('promo_id')->constrained()->unsigned();
            $table->foreignId('kelas_id')->constrained();
            $table->Date('tanggal_transaksi');
            $table->Date('tanggal_berlaku');
            $table->float('jumlah_deposit_kelas');
            $table->float('jumlah_bayar_kelas');
            $table->float('bonus');
            $table->float('total_deposit_kelas');
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
        Schema::dropIfExists('transaksi_deposit_kelas');
    }
};
