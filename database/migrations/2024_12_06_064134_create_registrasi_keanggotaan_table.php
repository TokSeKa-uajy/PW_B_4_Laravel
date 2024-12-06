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
        Schema::create('registrasi_keanggotaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_keanggotaan'); // Foreign key 
            $table->date('Tanggal_pembayaran'); // Tanggal pembayaran
            $table->decimal('Total_pembayaran', 10, 2); // Total pembayaran
            $table->enum('Status_pembayaran', ['paid', 'pending', 'failed']); // Status pembayaran
            $table->enum('Jenis_pembayaran', ['Kartu Kredit', 'Kartu Debit', 'E Wallet']); // Jenis pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_keanggotaan');
    }
};
