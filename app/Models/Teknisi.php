<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Perbaikan;

class Teknisi extends Model
{
    use HasFactory;

    protected $table = 'teknisi';
    protected $primaryKey = 'id_teknisi';

    protected $fillable = [
        'nama_teknisi',
        'no_telepon',
        'email',
    ];

    // 1 teknisi bisa mengerjakan banyak baris perbaikan
    public function perbaikan(): HasMany
    {
        return $this->hasMany(Perbaikan::class, 'id_teknisi', 'id_teknisi');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }
}