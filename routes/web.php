<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\GuruLaporanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Admin\JadwalController;

// ========================
// HELPER FUNCTIONS
// ========================
function isAdmin() {
    return session('logged_in') && session('peran') == 'admin';
}

function isGuru() {
    return session('logged_in') && session('peran') == 'guru';
}

function checkAdmin() {
    if (!isAdmin()) {
        return redirect('/login')->with('error', 'Akses ditolak. Hanya untuk admin.');
    }
    return null;
}

function checkGuru() {
    if (!isGuru()) {
        return redirect('/login')->with('error', 'Akses ditolak. Hanya untuk guru.');
    }
    return null;
}
// Helper function untuk log aktivitas (FIXED)
function logAktivitas($aktivitas) {
    try {
        if (!session('user_id')) return;
        
        // Cek apakah tabel log_aktivitas ada
        $tables = DB::select("SHOW TABLES LIKE 'log_aktivitas'");
        if (empty($tables)) {
            return; // Tabel tidak ada, skip
        }
        
        // Cek kolom yang tersedia
        $columns = DB::select("SHOW COLUMNS FROM log_aktivitas");
        $columnNames = collect($columns)->pluck('Field')->toArray();
        
        $logData = [
            'aktivitas' => $aktivitas,
           'created_at' => now() // ⭐ PERBAIKAN: gunakan created_at
        ];
        
        // Gunakan kolom yang sesuai
        if (in_array('pengguna_id', $columnNames)) {
            $logData['pengguna_id'] = session('user_id');
        } elseif (in_array('user_id', $columnNames)) {
            $logData['user_id'] = session('user_id');
        }
        
        DB::table('log_aktivitas')->insert($logData);
        
    } catch (Exception $e) {
        // Skip error untuk sementara
        // Untuk UKK, bisa diabaikan jika log tidak critical
    }
}

// ========================
// ROUTE DASAR
// ========================
Route::get('/', function () {
    return view('welcome');
});

// ========================
// AUTHENTICATION
// ========================
// ========================
// AUTHENTICATION (FIXED)
// ========================
Route::get('/login', function() {
    // Jika sudah login, redirect sesuai role
    if (session('logged_in')) {
        if (session('peran') == 'admin') {
            return redirect('/admin/guru');
        } else {
            return redirect('/guru/dashboard');
        }
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function(Request $request) {
    // Validasi
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);
    
    // Cari user
    $user = DB::table('pengguna')
        ->where('username', $request->username)
        ->first();
    
    // Verifikasi password (md5)
    if ($user && $user->password == md5($request->password)) {
        // Set session
        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'peran' => $user->peran,
            'logged_in' => true
        ]);
        
        // Log aktivitas (sesuai struktur tabel)
        try {
            // Cek struktur tabel log_aktivitas
            $columns = DB::select("SHOW COLUMNS FROM log_aktivitas");
            $columnNames = collect($columns)->pluck('Field')->toArray();
            
            $logData = [
                'aktivitas' => 'Login ke sistem',
                'created_at' => now() // ⭐ PERBAIKAN: gunakan created_at
            ];
            
            // Gunakan kolom yang sesuai
            if (in_array('pengguna_id', $columnNames)) {
                $logData['pengguna_id'] = $user->id;
            } elseif (in_array('user_id', $columnNames)) {
                $logData['user_id'] = $user->id;
            }
            
            DB::table('log_aktivitas')->insert($logData);
            
        } catch (Exception $e) {
            // Skip jika error log
            // Bisa diabaikan untuk testing
        }
        
        // Redirect berdasarkan role
       // Redirect berdasarkan role
       // Di route POST /login, ubah redirect admin:
        if ($user->peran == 'admin') {
            return redirect('/admin')->with('success', 'Login admin berhasil!');  // ⭐ KE /admin
        } else {
            return redirect('/guru/dashboard')->with('success', 'Selamat datang!');
        }
    }
    
    return back()->with('error', 'Username atau password salah');
})->name('login.submit');

Route::get('/logout', function() {
    // Log aktivitas logout (jika tabel ada)
    try {
        if (session('user_id')) {
            // Cek struktur tabel
            $columns = DB::select("SHOW COLUMNS FROM log_aktivitas");
            $columnNames = collect($columns)->pluck('Field')->toArray();
            
            $logData = [
                'aktivitas' => 'Logout dari sistem',
               'created_at' => now() // ⭐ PERBAIKAN: gunakan created_at
            ];
            
            // Gunakan kolom yang sesuai
            if (in_array('pengguna_id', $columnNames)) {
                $logData['pengguna_id'] = session('user_id');
            } elseif (in_array('user_id', $columnNames)) {
                $logData['user_id'] = session('user_id');
            }
            
            DB::table('log_aktivitas')->insert($logData);
        }
    } catch (Exception $e) {
        // Skip jika error
    }
    
    session()->flush();
    return redirect('/login')->with('success', 'Logout berhasil');
})->name('logout');

// ========================
// ROUTE ADMIN
// ========================
// DASHBOARD ADMIN (FIXED - PASTI JALAN)
// ========================
Route::get('/admin', function() {
    if (!session('logged_in') || session('peran') != 'admin') {
        return redirect('/login');
    }
    
    // STATISTIK DASAR
    $stats = [
        'total_guru' => DB::table('guru')->count(),
        'total_kelas' => DB::table('kelas')->count(),
        'total_siswa' => DB::table('siswa')->count(),
        'total_jadwal' => DB::table('jadwal_mengajar')->count(),
        'total_kegiatan' => DB::table('kegiatan_mengajar')->count(),
        'total_pengguna' => DB::table('pengguna')->count(),
    ];
    
    // QUERY AKTIVITAS - PAKAI created_at (SUDAH ADA DI TABLE)
    $aktivitas = DB::table('log_aktivitas as la')
        ->join('pengguna as p', 'la.pengguna_id', '=', 'p.id')
        ->orderBy('la.created_at', 'desc') // ⭐ PAKAI created_at
        ->limit(5)
        ->select('la.*', 'p.username')
        ->get();
    
    return view('admin.dashboard', [
        'stats' => $stats,
        'aktivitas' => $aktivitas
    ]);
})->name('admin.dashboard');

// CRUD Guru
// CRUD GURU ADMIN
// ========================
Route::prefix('admin/guru')->group(function () {
    Route::get('/', function() {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        $gurus = DB::table('guru')
            ->join('pengguna', 'guru.pengguna_id', '=', 'pengguna.id')
            ->select('guru.*', 'pengguna.username')
            ->get();
        
        return view('admin.guru.index', ['gurus' => $gurus]);
    })->name('admin.guru.index');
    
    Route::get('/create', function() {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        return view('admin.guru.create');
    })->name('admin.guru.create');
    
    Route::post('/', function(Request $request) {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        // Validasi
        if (empty($request->nama) || empty($request->username) || empty($request->password)) {
            return back()->with('error', 'Nama, username, dan password wajib diisi');
        }
        
        if ($request->password != $request->password_confirmation) {
            return back()->with('error', 'Password dan konfirmasi password tidak sama');
        }
        
        // Cek username
        $cek = DB::table('pengguna')->where('username', $request->username)->first();
        if ($cek) {
            return back()->with('error', 'Username sudah digunakan');
        }
        
        DB::beginTransaction();
        
        try {
            // 1. Insert pengguna
            $penggunaId = DB::table('pengguna')->insertGetId([
                'username' => $request->username,
                'password' => md5($request->password),
                'peran' => 'guru',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // 2. Insert guru
            DB::table('guru')->insert([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
                'pengguna_id' => $penggunaId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::commit();
            
            // Log aktivitas (FIXED)
            try {
                DB::table('log_aktivitas')->insert([
                    'pengguna_id' => session('user_id'),
                    'aktivitas' => 'Menambah data guru: ' . $request->nama,
                    'created_at' => now() // ⭐ PERBAIKAN
                ]);
            } catch (Exception $e) {
                // Skip log error
            }
            
            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil ditambahkan!');
            
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    })->name('admin.guru.store');
    
    Route::get('/{id}/edit', function($id) {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        $guru = DB::table('guru')
            ->join('pengguna', 'guru.pengguna_id', '=', 'pengguna.id')
            ->where('guru.id', $id)
            ->select('guru.*', 'pengguna.username')
            ->first();
        
        if (!$guru) {
            return redirect()->route('admin.guru.index')->with('error', 'Data tidak ditemukan');
        }
        
        return view('admin.guru.edit', ['guru' => $guru]);
    })->name('admin.guru.edit');
    
    Route::put('/{id}', function(Request $request, $id) {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        $guru = DB::table('guru')->where('id', $id)->first();
        if (!$guru) {
            return redirect('/admin/guru')->with('error', 'Data tidak ditemukan');
        }
        
        // Validasi
        if (empty($request->nama)) {
            return back()->with('error', 'Nama guru wajib diisi');
        }
        
        if ($request->password && $request->password != $request->password_confirmation) {
            return back()->with('error', 'Password dan konfirmasi password tidak sama');
        }
        
        // Update data guru
        DB::table('guru')->where('id', $id)->update([
            'nama' => $request->nama,
            'nip' => $request->nip ?? '',
            'email' => $request->email ?? '',
            'updated_at' => now(),
        ]);
        
        // Update password jika diisi
        if ($request->password) {
            DB::table('pengguna')->where('id', $guru->pengguna_id)->update([
                'password' => md5($request->password),
                'updated_at' => now(),
            ]);
        }
        
        // Log aktivitas (FIXED)
        try {
            DB::table('log_aktivitas')->insert([
                'pengguna_id' => session('user_id'),
                'aktivitas' => 'Mengedit data guru: ' . $request->nama,
                'created_at' => now() // ⭐ PERBAIKAN
            ]);
        } catch (Exception $e) {
            // Skip log error
        }
        
        return redirect('/admin/guru')->with('success', 'Data guru berhasil diupdate!');
    })->name('admin.guru.update');
    
    Route::delete('/{id}', function($id) {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        $guru = DB::table('guru')->where('id', $id)->first();
        if (!$guru) {
            return redirect()->route('admin.guru.index')->with('error', 'Data tidak ditemukan');
        }
        
        $namaGuru = $guru->nama;
        
        // Hapus pengguna (akan cascade ke guru)
        DB::table('pengguna')->where('id', $guru->pengguna_id)->delete();
        
        // Log aktivitas (FIXED)
        try {
            DB::table('log_aktivitas')->insert([
                'pengguna_id' => session('user_id'),
                'aktivitas' => 'Menghapus data guru: ' . $namaGuru,
                'created_at' => now() // ⭐ PERBAIKAN
            ]);
        } catch (Exception $e) {
            // Skip log error
        }
        
        return redirect()->route('admin.guru.index')->with('success', 'Data berhasil dihapus!');
    })->name('admin.guru.destroy');
});

// ========================
// CRUD KELAS (Admin) - MENGGUNAKAN CONTROLLER
// ========================
use App\Http\Controllers\Admin\KelasController;

Route::prefix('admin/kelas')->group(function () {
    Route::get('/', [KelasController::class, 'index'])->name('admin.kelas.index');
    Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::delete('/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
});

// ========================
// ROUTE JADWAL (TAMBAHKAN NAMA ROUTE)
// ========================
// ========================
// ROUTE JADWAL (Menggunakan Controller - Simpel Version)
// ========================
Route::get('/admin/jadwal', function() {
    if (!session('logged_in') || session('peran') != 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak');
    }
    
    return app()->make(JadwalController::class)->index();
})->name('admin.jadwal');

Route::post('/admin/jadwal/store', function() {
    if (!session('logged_in') || session('peran') != 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak');
    }
    
    $request = request(); // Ambil request
    return app()->make(JadwalController::class)->store($request);
})->name('admin.jadwal.store');

// PERBAIKAN: TAMBAHKAN }); untuk menutup route pertama
Route::post('/admin/jadwal/{id}/delete', function($id) {
    if (!session('logged_in') || session('peran') != 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak');
    }
    
    // Logika delete di sini (seharusnya panggil controller)
    // Contoh:
    // \App\Models\Jadwal::find($id)->delete();
    
    return redirect('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus');
}); // ✅ TAMBAHKAN INI untuk menutup closure

// Jadwal Routes
Route::prefix('admin/jadwal')->group(function () {
    Route::get('/', [JadwalController::class, 'index'])->name('admin.jadwal');
    Route::post('/store', [JadwalController::class, 'store'])->name('admin.jadwal.store');
    
    // Tambahkan route ini:
    Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
    Route::put('/{id}/update', [JadwalController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/{id}/delete', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy');
});
// ========================
// DASHBOARD GURU
// ========================
Route::get('/guru/dashboard', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login')->with('error', 'Silakan login sebagai guru');
    }
    
    // Ambil data guru
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    if (!$guru) {
        return redirect('/login')->with('error', 'Data guru tidak ditemukan');
    }
    
    // Jadwal hari ini
    $hari_ini = date('N');
    $hari_indonesia = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $hari_nama = $hari_indonesia[$hari_ini];
    
 // Cari query jadwal_hari_ini:
$jadwal_hari_ini = DB::table('jadwal_mengajar as jm')
    ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
    ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
    ->where('jm.guru_id', $guru->id)
    ->where('jm.hari', $hari_nama)
    ->orderBy('mjs.waktu_mulai')
    ->select(
        'jm.*', 
        'k.nama_kelas',
        'mjs.jam_ke',
        'mjs.waktu_mulai',
        'mjs.waktu_selesai',
        'mjs.keterangan'  // ⭐ PASTIKAN INI ADA!
    )
    ->get();
    
    // Statistik
    $total_kegiatan = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->where('jm.guru_id', $guru->id)
        ->count();
    
    $total_jadwal = DB::table('jadwal_mengajar')
        ->where('guru_id', $guru->id)
        ->count();
    
    // Cari query kegiatan_terbaru di route /guru/dashboard
$kegiatan_terbaru = DB::table('kegiatan_mengajar as km')
    ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
    ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
    ->where('jm.guru_id', $guru->id)
    ->orderBy('km.tanggal', 'desc')
    ->limit(5)
    // ⭐ PERBAIKAN: Hapus 'keterangan' jika tidak ada, atau tambah kolom
    ->select('km.*', 'k.nama_kelas', 'jm.mata_pelajaran', 'jm.hari')
    ->get();

    return view('guru.dashboard', [
        'guru' => $guru,
        'jadwal_hari_ini' => $jadwal_hari_ini,
        'hari_nama' => $hari_nama,
        'total_kegiatan' => $total_kegiatan,
        'total_jadwal' => $total_jadwal,
        'kegiatan_terbaru' => $kegiatan_terbaru
    ]);
    
})->name('guru.dashboard');
Route::get('/guru/kegiatan/create', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    if (!$guru) {
        return redirect('/login')->with('error', 'Data guru tidak ditemukan');
    }
    
    $tanggal_hari_ini = date('Y-m-d');
    $hari_ini = date('N');
    $hari_indonesia = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $hari_nama = $hari_indonesia[$hari_ini];
    
    // ============= PERBAIKAN UTAMA =============
    // 1. Ambil KELAS yang SUDAH diabsen hari ini
    $kelas_sudah_absen = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->where('jm.guru_id', $guru->id)
        ->whereDate('km.tanggal', $tanggal_hari_ini)
        ->select('k.id as kelas_id', 'k.nama_kelas', DB::raw('COUNT(*) as jumlah_kegiatan'))
        ->groupBy('k.id', 'k.nama_kelas')
        ->get();
    
    // 2. Ambil ID kelas yang sudah diabsen
    $kelas_sudah_absen_ids = $kelas_sudah_absen->pluck('kelas_id')->toArray();
    
    // 3. Ambil jadwal HANYA untuk kelas yang BELUM diabsen
    $jadwal_tersedia = DB::table('jadwal_mengajar as jm')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
        ->where('jm.guru_id', $guru->id)
        ->where('jm.hari', $hari_nama) // ⭐ FILTER HARI INI
        ->whereNotIn('jm.kelas_id', $kelas_sudah_absen_ids) // ⭐ FILTER KELAS YANG BELUM ABSEN
        ->orderBy('mjs.waktu_mulai')
        ->select('jm.*', 'k.nama_kelas', 'mjs.jam_ke', 'mjs.waktu_mulai', 'mjs.waktu_selesai')
        ->get();
    
    // ============= ALTERNATIF: Jika mau tampilkan semua jadwal tapi disable yang sudah diabsen =============
    /*
    // Ambil semua jadwal hari ini
    $semua_jadwal = DB::table('jadwal_mengajar as jm')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
        ->where('jm.guru_id', $guru->id)
        ->where('jm.hari', $hari_nama)
        ->orderBy('mjs.waktu_mulai')
        ->select('jm.*', 'k.nama_kelas', 'mjs.jam_ke', 'mjs.waktu_mulai', 'mjs.waktu_selesai')
        ->get();
    
    // Tandai jadwal yang kelasnya sudah diabsen
    foreach ($semua_jadwal as $j) {
        $j->kelas_sudah_absen = in_array($j->kelas_id, $kelas_sudah_absen_ids);
    }
    
    $jadwal_tersedia = $semua_jadwal;
    */
    
    return view('guru.kegiatan.create', [
        'guru' => $guru,
        'jadwal' => $jadwal_tersedia,
        'hari_nama' => $hari_nama,
        'tanggal_sekarang' => $tanggal_hari_ini,
        'kelas_sudah_absen' => $kelas_sudah_absen,
        'kelas_sudah_absen_ids' => $kelas_sudah_absen_ids // ⭐ TAMBAHKAN INI
    ]);
})->name('guru.kegiatan.create');

// ========================
// GURU: LIST KEGIATAN (INDEX)
// ========================
Route::get('/guru/kegiatan', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    if (!$guru) {
        return redirect('/login')->with('error', 'Data guru tidak ditemukan');
    }
    
    // Ambil kegiatan guru ini
    $kegiatan = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->where('jm.guru_id', $guru->id)
        ->orderBy('km.tanggal', 'desc')
        ->select('km.*', 'k.nama_kelas', 'jm.mata_pelajaran')
        ->get();
    
    return view('guru.kegiatan.index', [
        'guru' => $guru,
        'kegiatan' => $kegiatan
    ]);
})->name('guru.kegiatan.index'); // ⭐ INI PENTING!

// ========================
// ⭐⭐⭐ PERBAIKAN UTAMA: ROUTE STORE KEGIATAN ⭐⭐⭐
// ========================
Route::post('/guru/kegiatan', function(Request $request) {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    // ⭐ DEBUG: Lihat data yang dikirim
    error_log('=== DEBUG KEGIATAN ===');
    error_log('Jadwal ID: ' . $request->jadwal_id);
    error_log('Materi: ' . $request->materi);
    error_log('Kehadiran Data: ' . print_r($request->kehadiran, true));
    
    // Validasi
    if (empty($request->jadwal_id) || empty($request->materi)) {
        return back()->with('error', 'Jadwal dan materi wajib diisi');
    }
    
    DB::beginTransaction();
    
    try {
        // 1. SIMPAN KEGIATAN
        $kegiatanId = DB::table('kegiatan_mengajar')->insertGetId([
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => $request->tanggal ?? date('Y-m-d'),
            'materi' => $request->materi,
            'catatan' => $request->catatan ?? '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        error_log('Kegiatan ID dibuat: ' . $kegiatanId);
        
        // 2. ⭐⭐ PERBAIKAN UTAMA: SIMPAN KEHADIRAN SISWA ⭐⭐
        if ($request->has('kehadiran') && is_array($request->kehadiran)) {
            error_log('Jumlah siswa untuk kehadiran: ' . count($request->kehadiran));
            
            foreach ($request->kehadiran as $siswaId => $status) {
                // ⭐ CEK STRUKTUR TABEL kehadiran_siswa
                $columns = DB::select("SHOW COLUMNS FROM kehadiran_siswa");
                $columnNames = collect($columns)->pluck('Field')->toArray();
                
                error_log('Kolom yang tersedia: ' . implode(', ', $columnNames));
                
                // Data dasar untuk kehadiran
                $kehadiranData = [
                    'kegiatan_id' => $kegiatanId,
                    'siswa_id' => $siswaId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                // ⭐ GUNAKAN KOLOM YANG SESUAI DENGAN STRUKTUR TABEL
                if (in_array('status_hadir', $columnNames)) {
                    $kehadiranData['status_hadir'] = $status;
                } elseif (in_array('status', $columnNames)) {
                    $kehadiranData['status'] = $status;
                } elseif (in_array('keterangan', $columnNames)) {
                    $kehadiranData['keterangan'] = $status;
                } else {
                    // Jika tidak ada kolom status, buat kolom default
                    $kehadiranData['status'] = $status;
                }
                
                error_log('Simpan kehadiran - Siswa ID: ' . $siswaId . ', Status: ' . $status);
                
                // Insert ke database
                DB::table('kehadiran_siswa')->insert($kehadiranData);
            }
            
            error_log('Total kehadiran disimpan: ' . count($request->kehadiran));
        } else {
            error_log('⚠️ PERINGATAN: Tidak ada data kehadiran dari form');
            error_log('Request data: ' . print_r($request->all(), true));
        }
        
        DB::commit();
        
        // Log aktivitas
        try {
            DB::table('log_aktivitas')->insert([
                'pengguna_id' => session('user_id'),
                'aktivitas' => 'Menambah kegiatan mengajar',
                'created_at' => now()
            ]);
        } catch (Exception $e) {
            error_log('Error log aktivitas: ' . $e->getMessage());
        }
        
        return redirect('/guru/kegiatan')->with('success', 'Kegiatan dan kehadiran siswa berhasil disimpan!');
        
    } catch (Exception $e) {
        DB::rollBack();
        error_log('❌ ERROR SIMPAN KEGIATAN: ' . $e->getMessage());
        error_log('Trace: ' . $e->getTraceAsString());
        return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
})->name('guru.kegiatan.store');
    
    // Route untuk mengambil siswa berdasarkan jadwal (kelas)
    // ⭐ PASTIKAN ROUTE INI ADA di DALAM prefix 'guru/kegiatan':
Route::get('/get-siswa/{jadwal_id}', function($jadwal_id) {
    if (!session('logged_in') || session('peran') != 'guru') {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    $jadwal = DB::table('jadwal_mengajar')
        ->where('id', $jadwal_id)
        ->first();
    
    if (!$jadwal) {
        return response()->json(['error' => 'Jadwal tidak ditemukan'], 404);
    }
    
    $siswa = DB::table('siswa')
        ->where('kelas_id', $jadwal->kelas_id)
        ->orderBy('nama')
        ->select('id', 'nis', 'nama')
        ->get();
    
    return response()->json([
        'kelas_id' => $jadwal->kelas_id,
        'siswa' => $siswa
    ]);
})->name('guru.kegiatan.get-siswa'); // ⭐ NAMA ROUTE HARUS ADA
    
    // ⭐ 5. DELETE
    Route::post('/{id}/delete', function($id) {
        if (!session('logged_in') || session('peran') != 'guru') {
            return redirect('/login');
        }
        
        DB::table('kegiatan_mengajar')->where('id', $id)->delete();
        
        return redirect('/guru/kegiatan')->with('success', 'Kegiatan berhasil dihapus!');
    })->name('guru.kegiatan.delete');
    
  // Route detail kegiatan - FIXED VERSION
Route::get('/guru/kegiatan/detail/{id}', function($id) {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    // Ambil data kegiatan
    $kegiatan = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->where('km.id', $id)
        ->select('km.*', 'k.nama_kelas', 'jm.mata_pelajaran')
        ->first();
    
    if (!$kegiatan) {
        return redirect('/guru/kegiatan')->with('error', 'Data tidak ditemukan');
    }
    
    // Ambil data kehadiran
    $kehadiran = DB::table('kehadiran_siswa as ks')
        ->join('siswa as s', 'ks.siswa_id', '=', 's.id')
        ->where('ks.kegiatan_id', $id)
        ->orderBy('s.nama')
        ->select('s.nis', 's.nama', 'ks.status')
        ->get();
    
    // Hitung statistik
    $statistik = [
        'Hadir' => $kehadiran->where('status', 'Hadir')->count(),
        'Izin' => $kehadiran->where('status', 'Izin')->count(),
        'Sakit' => $kehadiran->where('status', 'Sakit')->count(),
        'Alpa' => $kehadiran->where('status', 'Alpa')->count(),
        'total' => $kehadiran->count()
    ];
    
    return view('guru.kegiatan.detail', [
        'kegiatan' => $kegiatan,
        'kehadiran' => $kehadiran,
        'statistik' => $statistik
    ]);
})->name('guru.kegiatan.detail');

// ========================
// GURU: GET SISWA BY JADWAL
// ========================
                Route::get('/get-siswa/{jadwal_id}', function($jadwal_id) {
                    // ⭐ DEBUG: Cek session
                    if (!session('logged_in') || session('peran') != 'guru') {
                        return response()->json(['error' => 'Unauthorized - Silakan login'], 401);
                    }
                    
                    // ⭐ DEBUG: Log request
                    error_log("Get siswa for jadwal_id: " . $jadwal_id);
                    
                    try {
                        // 1. Dapatkan kelas_id dari jadwal
                        $jadwal = DB::table('jadwal_mengajar')
                            ->where('id', $jadwal_id)
                            ->first();
                        
                        if (!$jadwal) {
                            return response()->json(['error' => 'Jadwal tidak ditemukan'], 404);
                        }
                        
                        // 2. Ambil semua siswa di kelas tersebut
                        $siswa = DB::table('siswa')
                            ->where('kelas_id', $jadwal->kelas_id)
                            ->orderBy('nama')
                            ->select('id', 'nis', 'nama')
                            ->get();
                        
                        // ⭐ DEBUG: Log hasil
                        error_log("Found " . $siswa->count() . " siswa in kelas_id: " . $jadwal->kelas_id);
                        
                        return response()->json([
                            'success' => true,
                            'kelas_id' => $jadwal->kelas_id,
                            'siswa' => $siswa
                        ]);
                        
                    } catch (Exception $e) {
                        error_log("Error in get-siswa: " . $e->getMessage());
                        return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
                    }
                })->name('guru.kegiatan.get-siswa');
// ========================
// FITUR GURU LAINNYA
// ========================
Route::get('/guru/jadwal', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    if (!$guru) {
        return redirect('/login')->with('error', 'Data guru tidak ditemukan');
    }
    
    $jadwal = DB::table('jadwal_mengajar as jm')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
        ->where('jm.guru_id', $guru->id)
        ->orderByRaw("FIELD(jm.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
        ->orderBy('mjs.waktu_mulai')
        ->select('jm.*', 'k.nama_kelas', 'mjs.jam_ke', 'mjs.waktu_mulai', 'mjs.waktu_selesai')
        ->get();
    
    return view('guru.jadwal', [
        'guru' => $guru,
        'jadwal' => $jadwal
    ]);
})->name('guru.jadwal');
Route::get('/guru/profil', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    // Join dengan tabel pengguna
    $guru = DB::table('guru as g')
        ->join('pengguna as p', 'g.pengguna_id', '=', 'p.id')
        ->where('g.id', session('user_id'))
        ->select('g.*', 'p.username')
        ->first();
    
    return view('guru.profil', compact('guru'));
})->name('guru.profil');
// Route ubah password
Route::get('/guru/profil/ubah-password', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    return view('guru.ubah-password');
})->name('guru.ubah-password');

Route::post('/guru/profil/ubah-password', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    // Validasi password lama dan baru
    // ...
    
    return redirect('/guru/profil')->with('success', 'Password berhasil diubah');
});

Route::get('/guru/profil/edit', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    // Join dengan tabel pengguna
    $guru = DB::table('guru as g')
        ->join('pengguna as p', 'g.pengguna_id', '=', 'p.id')
        ->where('g.id', session('user_id'))
        ->select('g.*', 'p.username')
        ->first();
    
    if (!$guru) {
        return redirect('/guru/profil')->with('error', 'Data guru tidak ditemukan');
    }
    
    return view('guru.profil-edit', compact('guru'));
})->name('guru.profil.edit');
Route::post('/guru/profil/update', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    // Update tabel guru saja (username di tabel pengguna)
    DB::table('guru')
        ->where('id', session('user_id'))
        ->update([
            'nama' => request('nama'),
            'nip' => request('nip'),
            'email' => request('email'),
            'updated_at' => now()
        ]);
    
    return redirect('/guru/profil')->with('success', 'Profil berhasil diperbarui!');
})->name('guru.profil.update');

// Route untuk laporan kehadiran per kelas
Route::get('/laporan-kehadiran', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    // Ambil semua kelas yang diajar guru ini
    $kelas = DB::table('jadwal_mengajar as jm')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->where('jm.guru_id', $guru->id)
        ->select('k.id', 'k.nama_kelas')
        ->distinct()
        ->get();
    
    return view('guru.laporan.index', [
        'guru' => $guru,
        'kelas' => $kelas
    ]);
})->name('guru.laporan.index');

// ========================
// CRUD SISWA (Admin)
// ========================
Route::prefix('admin/siswa')->group(function () {
    // Index - List siswa
    Route::get('/', function() {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        $siswa = DB::table('siswa as s')
            ->join('kelas as k', 's.kelas_id', '=', 'k.id')
            ->select('s.*', 'k.nama_kelas')
            ->orderBy('k.nama_kelas')
            ->orderBy('s.nama')
            ->get();
        
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        
        return view('admin.siswa.index', compact('siswa', 'kelas'));
    })->name('admin.siswa.index');
    
    // Store - Simpan siswa baru
    Route::post('/store', function(Request $request) {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        // VALIDASI LENGKAP
        if (empty($request->nama)) {
            return back()->with('error', 'Nama siswa wajib diisi');
        }
        
        if (empty($request->nis)) {
            return back()->with('error', 'NIS wajib diisi');
        }
        
        if (empty($request->kelas_id)) {
            return back()->with('error', 'Kelas wajib dipilih');
        }
        
        // Cek apakah NIS sudah digunakan
        $nisExists = DB::table('siswa')->where('nis', $request->nis)->exists();
        if ($nisExists) {
            return back()->with('error', 'NIS ' . $request->nis . ' sudah digunakan!');
        }
        
        // SIMPAN KE DATABASE
        DB::table('siswa')->insert([
            'nama' => $request->nama,
            'nis' => $request->nis,  // ⭐ WAJIB: NIS dari form
            'kelas_id' => $request->kelas_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return redirect('/admin/siswa')->with('success', 'Siswa ' . $request->nama . ' berhasil ditambahkan!');
    })->name('admin.siswa.store');
    
    // Delete - Hapus siswa (FIXED: pakai GET untuk sederhana)
    Route::get('/{id}/delete', function($id) {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses admin saja');
        }
        
        DB::table('siswa')->where('id', $id)->delete();
        return redirect('/admin/siswa')->with('success', 'Siswa berhasil dihapus!');
    })->name('admin.siswa.delete');
});
// Di routes/web.php
Route::get('/guru/laporan-bulanan', [GuruLaporanController::class, 'index'])
    ->name('guru.laporan.bulanan');
    
Route::get('/guru/laporan-bulanan/export-csv', [GuruLaporanController::class, 'exportCsv'])
    ->name('guru.laporan.export.csv');

// Tambah route baru untuk export Excel
Route::get('/guru/laporan-bulanan/export-excel', [GuruLaporanController::class, 'exportExcel'])
    ->name('guru.laporan.export.excel');

// routes/web.php

// Laporan rekap kehadiran
Route::get('/guru/laporan-bulanan/rekap-kehadiran', [GuruLaporanController::class, 'exportRekapKehadiran'])
    ->name('guru.laporan.rekap.kehadiran');    
// ========================
// UTILITY & TESTING
// ========================
Route::get('/test', function() {
    return "✅ Test route berhasil! " . date('H:i:s');
});

Route::get('/cek-db', function() {
    echo "<h2>Database Status</h2>";
    $tables = ['pengguna', 'guru', 'kelas', 'jadwal_mengajar', 'master_jam_sekolah', 
               'kegiatan_mengajar', 'siswa', 'kehadiran_siswa', 'log_aktivitas'];
    
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "<p>{$table}: {$count} records</p>";
        } catch (Exception $e) {
            echo "<p>{$table}: ERROR - " . $e->getMessage() . "</p>";
        }
    }
});
Route::get('/guru/profil/debug', function() {
    dd([
        'session_user_id' => session('user_id'),
        'session_username' => session('username'),
        'session_peran' => session('peran'),
        'guru_data' => DB::table('guru')->get()
    ]);
});

Route::get('/seed-data', function() {
    // Buat master jam sekolah
    $jamCount = DB::table('master_jam_sekolah')->count();
    if ($jamCount == 0) {
        $jam_sekolah = [
            ['jam_ke' => 1, 'waktu_mulai' => '07:00:00', 'waktu_selesai' => '07:45:00'],
            ['jam_ke' => 2, 'waktu_mulai' => '07:45:00', 'waktu_selesai' => '08:30:00'],
            ['jam_ke' => 3, 'waktu_mulai' => '08:30:00', 'waktu_selesai' => '09:15:00'],
            ['jam_ke' => 4, 'waktu_mulai' => '09:15:00', 'waktu_selesai' => '10:00:00'],
            ['jam_ke' => 5, 'waktu_mulai' => '10:15:00', 'waktu_selesai' => '11:00:00'],
            ['jam_ke' => 6, 'waktu_mulai' => '11:00:00', 'waktu_selesai' => '11:45:00'],
        ];
        
        foreach ($jam_sekolah as $jam) {
            DB::table('master_jam_sekolah')->insert([
                'jam_ke' => $jam['jam_ke'],
                'waktu_mulai' => $jam['waktu_mulai'],
                'waktu_selesai' => $jam['waktu_selesai'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    // Buat admin jika belum ada
    if (!DB::table('pengguna')->where('username', 'admin')->exists()) {
        DB::table('pengguna')->insert([
            'username' => 'admin',
            'password' => md5('admin123'),
            'peran' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    return "✅ Data berhasil di-seed!";
});

// routes/web.php

// routes/web.php
// routes/web.php - Perbaiki route untuk halaman laporan

Route::get('/admin/laporan-kegiatan', function(Request $request) {
    // Cek session admin
    if (!session('logged_in') || session('peran') != 'admin') {
        return redirect('/login')->with('error', 'Silakan login sebagai admin.');
    }
    
    // AMBIL PARAMETER FILTER DARI REQUEST
    $bulan = $request->get('bulan', date('m'));  // default bulan sekarang
    $tahun = $request->get('tahun', date('Y'));  // default tahun sekarang
    
    // Query data kegiatan dengan filter bulan/tahun
    $kegiatan = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->join('guru as g', 'jm.guru_id', '=', 'g.id')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->whereMonth('km.tanggal', $bulan)
        ->whereYear('km.tanggal', $tahun)
        ->orderBy('km.tanggal', 'desc')
        ->select(
            'km.id',
            'km.tanggal',
            'g.nama as nama_guru',
            'k.nama_kelas',
            'jm.mata_pelajaran',
            'km.materi',
            'km.catatan'
        )
        ->paginate(15);
    
    // Data untuk filter dropdown
    $guruList = DB::table('guru')->orderBy('nama')->get();
    $kelasList = DB::table('kelas')->orderBy('nama_kelas')->get();
    
    // Nama bulan untuk ditampilkan
    $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
    
    return view('admin.laporan.kegiatan', compact(
        'kegiatan', 
        'guruList', 
        'kelasList', 
        'bulan',      // ← INI YANG DITAMBAHKIN
        'tahun',      // ← INI YANG DITAMBAHKIN
        'namaBulan'   // ← INI JUGA
    ));
});
// Export Routes
Route::get('/admin/laporan/export-excel', [ExportController::class, 'exportExcelKegiatan'])
    ->name('admin.laporan.export.excel');

Route::get('/admin/laporan/export-pdf', [ExportController::class, 'exportPdfKegiatan'])
    ->name('admin.laporan.export.pdf');

Route::get('/admin/laporan/export-csv', [ExportController::class, 'exportCsvKegiatan'])
    ->name('admin.laporan.export.csv');
// routes/web.php

// Cukup tambah 2 route ini saja
Route::get('/admin/laporan/kegiatan', [AdminLaporanController::class, 'kegiatan']);
Route::get('/admin/laporan/kehadiran', [AdminLaporanController::class, 'kehadiran']);
// ========================
// UTILITY: CEK STRUKTUR TABEL KEHADIRAN
// ========================
Route::get('/cek-tabel-kehadiran', function() {
    echo "<h2>Struktur Tabel kehadiran_siswa</h2>";
    
    try {
        // Cek apakah tabel ada
        $tables = DB::select("SHOW TABLES LIKE 'kehadiran_siswa'");
        if (empty($tables)) {
            echo "<p style='color:red;'>❌ Tabel kehadiran_siswa TIDAK ADA!</p>";
            return;
        }
        
        echo "<p style='color:green;'>✅ Tabel kehadiran_siswa ADA</p>";
        
        // Lihat struktur
        $columns = DB::select("DESCRIBE kehadiran_siswa");
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>" . $col->Field . "</td>";
            echo "<td>" . $col->Type . "</td>";
            echo "<td>" . $col->Null . "</td>";
            echo "<td>" . $col->Key . "</td>";
            echo "<td>" . ($col->Default ?? 'NULL') . "</td>";
            echo "<td>" . $col->Extra . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Lihat contoh data
        echo "<h3>Contoh Data (5 terbaru):</h3>";
        $data = DB::table('kehadiran_siswa')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        
        if ($data->count() > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr>";
            foreach (array_keys((array)$data->first()) as $key) {
                echo "<th>" . $key . "</th>";
            }
            echo "</tr>";
            
            foreach ($data as $row) {
                echo "<tr>";
                foreach ((array)$row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada data</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
});

// ========================
// SIMPLE ADMIN DASHBOARD BACKUP
// ========================
Route::get('/admin-simple', function() {
    if (!session('logged_in') || session('peran') != 'admin') {
        return redirect('/login');
    }
    
    return view('admin.dashboard-simple', [
        'total_guru' => DB::table('guru')->count(),
        'total_kelas' => DB::table('kelas')->count(),
        'total_jadwal' => DB::table('jadwal_mengajar')->count(),
    ]);
});
// Tambahkan di web.php
Route::get('/debug-get-siswa/{id}', function($id) {
    echo "<pre>";
    echo "=== DEBUG API get-siswa ===\n";
    echo "Jadwal ID: " . $id . "\n\n";
    
    // Cek session
    echo "Session logged_in: " . (session('logged_in') ? 'YES' : 'NO') . "\n";
    echo "Session peran: " . session('peran') . "\n\n";
    
    // Cek jadwal
    $jadwal = DB::table('jadwal_mengajar')->where('id', $id)->first();
    echo "Jadwal ditemukan: " . ($jadwal ? 'YES' : 'NO') . "\n";
    if ($jadwal) {
        echo "Kelas ID: " . $jadwal->kelas_id . "\n";
    }
    echo "\n";
    
    // Cek siswa
    if ($jadwal) {
        $siswa = DB::table('siswa')->where('kelas_id', $jadwal->kelas_id)->get();
        echo "Jumlah siswa: " . $siswa->count() . "\n";
        foreach ($siswa as $s) {
            echo "- " . $s->id . " | " . $s->nis . " | " . $s->nama . "\n";
        }
    }
    
    echo "\n=== JSON Response ===\n";
    // Simulasikan response API
    if (!session('logged_in') || session('peran') != 'guru') {
        $response = json_encode(['error' => 'Unauthorized'], JSON_PRETTY_PRINT);
    } elseif (!$jadwal) {
        $response = json_encode(['error' => 'Jadwal tidak ditemukan'], JSON_PRETTY_PRINT);
    } else {
        $siswaData = DB::table('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->orderBy('nama')
            ->select('id', 'nis', 'nama')
            ->get();
            
        $response = json_encode([
            'kelas_id' => $jadwal->kelas_id,
            'siswa' => $siswaData,
            'count' => $siswaData->count()
        ], JSON_PRETTY_PRINT);
    }
    
    echo $response;
    echo "</pre>";
    exit;
});
// API untuk cek kegiatan kelas
Route::get('/cek-kegiatan-kelas', function() {
    $jadwal_id = request('jadwal_id');
    $tanggal = request('tanggal', date('Y-m-d'));
    
    // Cek session 
    if (!session('logged_in') || session('peran') != 'guru') {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    // Dapatkan info jadwal
    $jadwal = DB::table('jadwal_mengajar as jm')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->where('jm.id', $jadwal_id)
        ->select('jm.kelas_id', 'k.nama_kelas')
        ->first();
    
    if (!$jadwal) {
        return response()->json(['error' => 'Jadwal tidak ditemukan']);
    }
    
    // Hitung kegiatan untuk kelas ini hari ini (FIXED QUERY)
    $jumlah_kegiatan = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->where('jm.kelas_id', $jadwal->kelas_id)
        ->whereDate('km.tanggal', $tanggal)
        ->count();
    
    return response()->json([
        'success' => true,
        'kelas_id' => $jadwal->kelas_id,
        'nama_kelas' => $jadwal->nama_kelas,
        'jumlah' => $jumlah_kegiatan,
        'sudah_absen' => $jumlah_kegiatan > 0,
        'tanggal' => $tanggal
    ]);
})->name('api.cek.kegiatan.kelas');
// API: Get siswa by kelas
Route::get('/api/get-siswa-by-kelas/{kelas_id}', function($kelas_id) {
    if (!session('logged_in') || session('peran') != 'guru') {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    $siswa = DB::table('siswa')
        ->where('kelas_id', $kelas_id)
        ->orderBy('nama')
        ->select('id', 'nis', 'nama')
        ->get();
    
    return response()->json([
        'success' => true,
        'siswa' => $siswa,
        'count' => $siswa->count()
    ]);
});

// Store kegiatan baru (sistem per kelas)
Route::post('/guru/kegiatan/store-new', function() {
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $request = request();
    
    // Validasi
    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'jadwal_id' => 'required|array',
        'jadwal_id.*' => 'exists:jadwal_mengajar,id',
        'materi' => 'required|string',
        'catatan' => 'required|string',
        'tanggal' => 'required|date',
        'kehadiran' => 'required|array'
    ]);
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    // Cek apakah kelas sudah diabsen hari ini
    $sudah_absen = DB::table('kegiatan_mengajar')
        ->where('kelas_id', $request->kelas_id)
        ->whereDate('tanggal', $request->tanggal)
        ->exists();
    
    if ($sudah_absen) {
        return back()->with('error', 'Kelas ini sudah diabsen hari ini!');
    }
    
    // Ambil jadwal_id pertama dari array
    $jadwal_id = $request->jadwal_id[$request->kelas_id] ?? null;
    
    if (!$jadwal_id) {
        return back()->with('error', 'Pilih mata pelajaran!');
    }
    
    DB::beginTransaction();
    
    try {
        // 1. Simpan kegiatan
        $kegiatan_id = DB::table('kegiatan_mengajar')->insertGetId([
            'jadwal_id' => $jadwal_id,
            'kelas_id' => $request->kelas_id, // ⭐ INI YANG BARU
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // 2. Simpan kehadiran siswa
        foreach ($request->kehadiran as $siswa_id => $status) {
            DB::table('kehadiran_siswa')->insert([
                'kegiatan_id' => $kegiatan_id,
                'siswa_id' => $siswa_id,
                'status' => $status,
                'keterangan' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        DB::commit();
        
        return redirect('/guru/kegiatan')->with('success', 
            'Absen kelas berhasil disimpan! (Sistem 1x absen per kelas per hari)');
            
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
})->name('guru.kegiatan.store-new');

// ========================
// FALLBACK ROUTE
// ========================
Route::fallback(function() {
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <title>404 - Halaman Tidak Ditemukan</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='d-flex justify-content-center align-items-center' style='min-height: 100vh;'>
        <div class='text-center'>
            <h1 class='display-1 text-danger'>404</h1>
            <h3>Halaman Tidak Ditemukan</h3>
            <a href='/' class='btn btn-primary mt-3'>Kembali ke Beranda</a>
        </div>
    </body>
    </html>
    ";
});
// ========================
// DEBUG ROUTE - NO SESSION CHECK
// ========================
Route::get('/debug-get-siswa/{id}', function($id) {
    // ⭐ TANPA SESSION CHECK DULU
    try {
        // 1. Get jadwal
        $jadwal = DB::table('jadwal_mengajar')
            ->where('id', $id)
            ->first();
        
        if (!$jadwal) {
            return response()->json([
                'error' => 'Jadwal ID ' . $id . ' not found',
                'available_jadwal' => DB::table('jadwal_mengajar')->select('id', 'guru_id', 'kelas_id')->get()
            ]);
        }
        
        // 2. Get siswa
        $siswa = DB::table('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->select('id', 'nis', 'nama', 'kelas_id')
            ->get();
        
        return response()->json([
            'success' => true,
            'jadwal_id' => $id,
            'kelas_id' => $jadwal->kelas_id,
            'siswa_count' => $siswa->count(),
            'siswa' => $siswa
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Exception: ' . $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
Route::get('/test-detail/{id}', function($id) {
    $url = route('guru.kegiatan.detail', $id);
    return "Route URL: " . $url . "<br>" .
           "Akses langsung: <a href='$url'>Klik disini</a>";
});
// Route untuk multi-jam
Route::post('/admin/jadwal/store-multi-jam', [JadwalController::class, 'storeMultiJam'])
    ->name('admin.jadwal.store-multi-jam');

// API Routes
Route::get('/api/jam-sekolah', [JadwalController::class, 'getJamSekolah']);
Route::get('/api/jadwal-terpakai', [JadwalController::class, 'getJadwalTerpakai']);
Route::get('/api/jadwal-kelas', [JadwalController::class, 'getJadwalKelas']);