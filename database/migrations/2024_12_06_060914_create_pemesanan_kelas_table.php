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
        Schema::create('pemesanan_kelas', function (Blueprint $table) {
            $table->bigIncrements('id_pemesanan_kelas');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_paket_kelas');
            $table->date('tanggal_pemesanan');
            $table->enum('jenis_pembayaran', ['Kartu Kredit', 'Kartu Debit', 'E Wallet']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_paket_kelas')->references('id_paket_kelas')->on('paket_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_kelas');
    }
};
