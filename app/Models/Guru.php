<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id';
    
    // Field yang bisa diisi massal
    protected $fillable = [
        'nama', 
        'nip', 
        'email', 
        'pengguna_id'
    ];
    
    // Relasi ke tabel pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}