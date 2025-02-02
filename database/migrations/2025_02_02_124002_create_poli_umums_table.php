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
        Schema::create('poli_umum', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('nomor_antrian');
            $table->string('poli');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poli_umum');
    }
};
