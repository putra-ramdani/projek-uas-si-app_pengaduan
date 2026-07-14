<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');

            // pelapor -> role karyawan_gudang di tabel users
            $table->foreignId('id_pengguna')
                ->constrained('users', 'id')
                ->onDelete('cascade');

            $table->foreignId('id_fasilitas')
                ->constrained('fasilitas', 'id_fasilitas')
                ->onDelete('cascade');

            $table->foreignId('id_kategori')
                ->constrained('kategori_fasilitas', 'id_kategori')
                ->onDelete('cascade');

            $table->date('tanggal_pengaduan');
            $table->text('deskripsi_kerusakan');
            $table->string('foto_kerusakan')->nullable(); // path file, bukan gambar langsung

            // kolom ini tidak ada di ERD awal tapi dibutuhkan wireframe (radio button prioritas)
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');

            $table->enum('status_pengaduan', ['baru', 'proses', 'selesai'])->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};