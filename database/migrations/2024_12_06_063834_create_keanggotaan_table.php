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
        Schema::create('keanggotaan', function (Blueprint $table) {
            // Note: No primary key defined
            $table->unsignedBigInteger('ID_pengguna');
            $table->unsignedBigInteger('ID_paket_keanggotaan');
            $table->date('tanggal_mulai'); // Start date of membership
            $table->date('tanggal_berakhir'); // End date of membership
            $table->boolean('status'); // Status of membership (active or not)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keanggotaan');
    }
};
