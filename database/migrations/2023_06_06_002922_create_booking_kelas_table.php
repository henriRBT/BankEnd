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
        Schema::create('booking_kelas', function (Blueprint $table) {
            $table->string('no_struk_kelas')->unique()->primary();
            $table->string('id_member');
            $table->foreign('id_member')->references('id')->on('members')->cascadeOnUpdate()->OnDelete;
            $table->foreignId('id_jadwal_harian')->constrained('jadwal_harians');
            $table->date('waktu_booking');
            $table->date('tanggal_booking');
            $table->float('slot_kelas');
            $table->string('tipe');
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
        Schema::dropIfExists('booking_kelas');
    }
};
