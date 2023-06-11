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
        Schema::create('booking_gyms', function (Blueprint $table) {
            $table->string('no_struk_gym')->unique()->primary();
            $table->string('id_member');
            $table->foreign('id_member')->references('id')->on('members')->cascadeOnUpdate()->OnDelete;
            $table->date('waktu_booking');
            $table->date('tanggal_booking');
            $table->string('slot_waktu');
            $table->datetime('waktu_presensi')->nullable();
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
        Schema::dropIfExists('booking_gyms');
    }
};
