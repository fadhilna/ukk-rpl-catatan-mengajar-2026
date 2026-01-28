<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
{
    // ... kode authentication ...
    
    $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
    
    // Jika data kosong, tambahkan data dummy untuk demo
    if ($kelas->isEmpty()) {
        $kelas = collect([
            (object) ['id' => 1, 'nama_kelas' => 'X RPL 1', 'created_at' => now()],
            (object) ['id' => 2, 'nama_kelas' => 'X RPL 2', 'created_at' => now()],
            (object) ['id' => 3, 'nama_kelas' => 'XI TKJ 1', 'created_at' => now()],
            (object) ['id' => 4, 'nama_kelas' => 'XI TKJ 2', 'created_at' => now()],
            (object) ['id' => 5, 'nama_kelas' => 'XII MM 1', 'created_at' => now()],
        ]);
    }
    
    // Hitung jumlah siswa per kelas (dummy data)
    $total_siswa = [];
    foreach ($kelas as $k) {
        $total_siswa[$k->id] = rand(25, 35); // Angka random untuk demo
    }
    
    return view('admin.kelas.index', [
        'kelas' => $kelas,
        'total_siswa' => $total_siswa
    ]);
}
    public function store(Request $request)
    {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak. Hanya untuk admin.');
        }
        
        // Validasi
        if (empty($request->nama_kelas)) {
            return back()->with('error', 'Nama kelas wajib diisi');
        }
        
        // Cek apakah nama kelas sudah ada
        $exists = DB::table('kelas')
            ->where('nama_kelas', $request->nama_kelas)
            ->exists();
            
        if ($exists) {
            return back()->with('error', 'Nama kelas sudah digunakan');
        }
        
        DB::table('kelas')->insert([
            'nama_kelas' => $request->nama_kelas,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Log aktivitas
        try {
            DB::table('log_aktivitas')->insert([
                'pengguna_id' => session('user_id'),
                'aktivitas' => 'Menambah kelas: ' . $request->nama_kelas,
                'created_at' => now()
            ]);
        } catch (\Exception $e) {
            // Skip jika error
        }
        
        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak. Hanya untuk admin.');
        }
        
        $kelas = DB::table('kelas')->where('id', $id)->first();
        
        if (!$kelas) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Kelas tidak ditemukan');
        }
        
        // Cek apakah kelas memiliki siswa
        $hasSiswa = DB::table('siswa')
            ->where('kelas_id', $id)
            ->exists();
            
        if ($hasSiswa) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa');
        }
        
        DB::table('kelas')->where('id', $id)->delete();
        
        // Log aktivitas
        try {
            DB::table('log_aktivitas')->insert([
                'pengguna_id' => session('user_id'),
                'aktivitas' => 'Menghapus kelas: ' . $kelas->nama_kelas,
                'created_at' => now()
            ]);
        } catch (\Exception $e) {
            // Skip jika error
        }
        
        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}