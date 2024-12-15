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
        Schema::create('add_kategoris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_kategori', 255);
            $table->text('deskripsi_kategori')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_kategoris');
    }
};
