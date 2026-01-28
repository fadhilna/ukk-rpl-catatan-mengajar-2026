<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $table = 'kelas';
    protected $fillable = ['nama_kelas'];
    
    public $timestamps = true;
    
    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
    
    // Relasi ke jadwal mengajar
    public function jadwal()
    {
        return $this->hasMany(JadwalMengajar::class, 'kelas_id');
    }
}