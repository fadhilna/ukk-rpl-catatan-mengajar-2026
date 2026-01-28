<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/test-db', function() {
    $pengguna = DB::table('pengguna')->count();
    $guru = DB::table('guru')->count();
    
    return [
        'pengguna_count' => $pengguna,
        'guru_count' => $guru,
        'pengguna' => DB::table('pengguna')->get(),
        'guru' => DB::table('guru')->get()
    ];
});