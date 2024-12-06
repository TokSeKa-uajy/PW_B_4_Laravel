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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('Email', 255)->unique();
            $table->string('Password', 100);
            $table->string('nomor_telepon', 20)->unique();
            $table->string('nama_depan', 255);
            $table->string('nama_belakang', 255);
            $table->boolean('jenis_kelamin');
            $table->string('alamat', 255)->nullable();
            $table->string('Foto_profil', 255);  // Assumes storing image URLs or paths
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
