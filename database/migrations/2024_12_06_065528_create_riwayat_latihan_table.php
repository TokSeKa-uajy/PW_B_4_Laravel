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
        Schema::create('riwayat_latihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_pengguna');// Foreign key to Pengguna
            $table->unsignedBigInteger('ID_Pemesanan_Kelas'); // Foreign key to PemesananKelas
            $table->date('Tanggal_latihan'); // Date of training
            $table->timestamps();
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
