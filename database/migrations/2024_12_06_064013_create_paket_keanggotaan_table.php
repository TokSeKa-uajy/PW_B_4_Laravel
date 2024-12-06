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
        Schema::create('paket_keanggotaan', function (Blueprint $table) {
            $table->id();
            $table->enum('Durasi', ['1_month', '6_months', '1_year']); // Durasi paket
            $table->decimal('Harga', 10, 2); // Harga paket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_keanggotaan');
    }
};
