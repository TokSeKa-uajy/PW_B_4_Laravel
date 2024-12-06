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
        Schema::create('pelatih', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan', 255); // Nama depan pelatih
            $table->string('nama_belakang', 255); // Nama belakang pelatih
            $table->string('Foto_profil')->nullable(); // Kolom untuk URL atau path file foto profil, nullable
            $table->boolean('jenis_kelamin'); // Jenis kelamin sebagai boolean, 0 atau 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatih');
    }
};
