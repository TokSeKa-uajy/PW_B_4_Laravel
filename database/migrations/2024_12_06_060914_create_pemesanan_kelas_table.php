<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanan_kelas', function (Blueprint $table) {
            $table->id(); // Primary key BIGINT auto-increment
            $table->unsignedBigInteger('ID_pengguna'); // Prepared for future foreign key
            $table->unsignedBigInteger('ID_kelas'); // Prepared for future foreign key
            $table->unsignedBigInteger('ID_paket_kelas'); // Prepared for future foreign key
            $table->date('Tanggal_pemesanan'); // Date of booking
            $table->enum('Status_pembayaran', ['Lunas', 'tertunda', 'gagal']); // Payment status
            $table->enum('Jenis_pembayaran', ['Kartu Kredit', 'Kartu Debit', 'E Wallet']); // Type of payment
            $table->date('Tanggal_mulai'); // Start date
            $table->date('Tanggal_selesai'); // End date
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
