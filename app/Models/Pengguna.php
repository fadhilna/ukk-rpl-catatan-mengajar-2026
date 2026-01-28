<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id';
    
    // Field yang bisa diisi massal
    protected $fillable = [
        'username',
        'password',
        'peran'
    ];
    
    // Relasi ke tabel guru
    public function guru()
    {
        return $this->hasOne(Guru::class, 'pengguna_id');
    }
}