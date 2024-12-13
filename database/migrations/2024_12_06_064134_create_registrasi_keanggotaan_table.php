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
        Schema::create('registrasi_keanggotaan', function (Blueprint $table) {
            $table->bigIncrements('id_registrasi_keanggotaan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_paket_keanggotaan');
            $table->date('tanggal_pembayaran');
            $table->decimal('total_pembayaran', 10, 2);
            $table->enum('status_pembayaran', ['paid', 'pending', 'failed']);
            $table->enum('jenis_pembayaran', ['Kartu Kredit', 'Kartu Debit', 'E Wallet']);

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_paket_keanggotaan')->references('id_paket_keanggotaan')->on('paket_keanggotaan')->onDelete('cascade');
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
