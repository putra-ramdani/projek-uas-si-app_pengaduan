<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'nama_fasilitas', 'lokasi', 'deskripsi', 'status_fasilitas'
    ];

    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'id_fasilitas', 'id_fasilitas');
    }
}