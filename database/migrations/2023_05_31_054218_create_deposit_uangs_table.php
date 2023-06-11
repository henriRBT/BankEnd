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
        Schema::create('deposit_uangs', function (Blueprint $table) {
            $table->string('no_struk_uang')->unique()->primary();
            $table->string('id_pegawai');
            $table->foreign('id_pegawai')->references('id')->on('pegawais')->cascadeOnUpdate()->OnDelete;
            $table->string('id_member');
            $table->foreign('id_member')->references('id')->on('members')->cascadeOnUpdate()->OnDelete;
            $table->foreignId('promo_id')->constrained();
            $table->Date('tanggal_transaksi');
            $table->float('jumlah_bayar');
            $table->float('bonus');
            $table->float('total_deposit');
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
        Schema::dropIfExists('deposit_uangs');
    }
};
