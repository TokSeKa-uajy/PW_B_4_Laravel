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
        Schema::create('umpan_balik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_pengguna'); // Prepare for future foreign key
            $table->unsignedBigInteger('ID_kelas'); // Prepare for future foreign key
            $table->integer('Rating')->nullable(); // Rating as DOUBLE nullable
            $table->string('Komentar', 255)->nullable(); // Komentar as VARCHAR(255) nullable
            $table->date('Tanggal_umpan_balik'); // Tanggal umpan balik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umpan_balik');
    }
};
