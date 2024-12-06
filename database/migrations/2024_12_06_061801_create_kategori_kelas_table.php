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
        Schema::create('kategori_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_kategori', 255); // Nama kategori
            $table->text('Deskripsi_kategori')->nullable(); // Deskripsi kategori, nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_kelas');
    }
};
