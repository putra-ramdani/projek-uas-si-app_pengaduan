<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');

            // 1 pengaduan bisa punya banyak baris perbaikan (riwayat/log progres)
            $table->foreignId('id_pengaduan')
                ->constrained('pengaduan', 'id_pengaduan')
                ->onDelete('cascade');

            $table->foreignId('id_teknisi')
                ->constrained('teknisi', 'id_teknisi')
                ->onDelete('cascade');

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('deskripsi_perbaikan')->nullable();
            $table->enum('status_perbaikan', ['proses', 'selesai'])->default('proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbaikan');
    }
};