<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_latihan', function (Blueprint $table) {
            $table->bigIncrements('id_riwayat_latihan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_pemesanan_kelas');
            $table->date('tanggal_latihan');

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_pemesanan_kelas')->references('id_pemesanan_kelas')->on('pemesanan_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_latihan');
    }
};
