<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas');
            $table->string('nama_fasilitas', 100);
            $table->string('lokasi', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('status_fasilitas', ['baik', 'rusak', 'perbaikan'])->default('baik');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};