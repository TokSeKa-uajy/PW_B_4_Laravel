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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id(); // ID_kelas as primary key
            $table->unsignedBigInteger('ID_pelatih'); // Assuming pelatih ID is a bigint
            $table->unsignedBigInteger('ID_Kategori'); // Unique VARCHAR(5) for category ID
            $table->string('Nama_kelas', 255); // Name of the class
            $table->text('Deskripsi'); // Description of the class
            $table->enum('Hari', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'All Day']); // Day of the class
            $table->time('Jam_mulai'); // Start time of the class
            $table->time('Durasi'); // Duration of the class
            $table->decimal('Harga', 10, 2); // Price of the class
            $table->integer('Kapasitas_kelas'); // Capacity of the class
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
