<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Pengaduan;
use App\Models\Teknisi;

class Perbaikan extends Model
{
    use HasFactory;

    protected $table = 'perbaikan';
    protected $primaryKey = 'id_perbaikan';

    protected $fillable = [
        'id_pengaduan',
        'id_teknisi',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi_perbaikan',
        'status_perbaikan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(Teknisi::class, 'id_teknisi', 'id_teknisi');
    }
}