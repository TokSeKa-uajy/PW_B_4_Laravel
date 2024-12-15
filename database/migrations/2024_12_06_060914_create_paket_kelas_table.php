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
        Schema::create('paket_kelas', function (Blueprint $table) {
            $table->bigIncrements('id_paket_kelas');
            $table->unsignedBigInteger('id_kelas');
            $table->enum('durasi', ['1_bulan', '6_bulan', '1_tahun']);
            $table->decimal('harga', 10, 2);
            
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_kelas');
    }
};
