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
            $table->id(); // Menggunakan $table->id(); untuk BIGINT auto-increment
            $table->enum('Durasi', ['1_week', '1_month', '6_months']); // Durasi paket
            $table->decimal('Harga', 10, 2); // Harga paket
            $table->timestamps(); // Timestamps for created_at and updated_at
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
