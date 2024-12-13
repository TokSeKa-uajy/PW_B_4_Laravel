<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->bigIncrements('id_kelas');
            $table->unsignedBigInteger('id_pelatih');
            $table->unsignedBigInteger('id_kategori_kelas');
            $table->string('nama_kelas', 255);
            $table->text('deskripsi');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu', 'Setiap Hari']);
            $table->time('jam_mulai');
            $table->time('durasi');
            $table->integer('kapasitas_kelas');

            $table->foreign('id_pelatih')->references('id_pelatih')->on('pelatih')->onDelete('cascade');
            $table->foreign('id_kategori_kelas')->references('id_kategori_kelas')->on('kategori_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
