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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->decimal('sem_1', 3, 2)->nullable();
            $table->decimal('sem_2', 3, 2)->nullable();
            $table->decimal('sem_3', 3, 2)->nullable();
            // $table->unsignedBigInteger('mahasiswa_id')->unique();
            // $table->foreignId('mahasiswa_id')->unique()->constrained();
            // menggantikan penulisan kode di baris 11 sebelumnya
            $table->foreignId('mahasiswa_id')->unique()->constrained()->onDelete('cascade')->onUpdate('cascade');
            //  untuk mempermudah proses penghapusan dan update data yang ber-relasi
            $table->timestamps();

            // $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};