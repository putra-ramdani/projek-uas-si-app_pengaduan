<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teknisi', function (Blueprint $table) {
            $table->id('id_teknisi');
            $table->string('nama_teknisi', 100);
            $table->string('no_telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teknisi');
    }
};