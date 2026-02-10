<?php
// app/Http\Controllers/Admin\JadwalController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        // Cek session admin
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login');
        }
        
        // Ambil data jadwal dengan join
        $jadwal = DB::table('jadwal_mengajar as jm')
            ->join('guru as g', 'jm.guru_id', '=', 'g.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
            ->orderByRaw("FIELD(jm.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('mjs.waktu_mulai')
            ->select(
                'jm.*',
                'g.nama as nama_guru',
                'k.nama_kelas',
                'mjs.waktu_mulai',
                'mjs.waktu_selesai',
                'mjs.jam_ke'
            )
            ->get();
        
        // Ambil data untuk dropdown
        $gurus = DB::table('guru')->orderBy('nama')->get();
        $kelas = DB::table('kelas')->orderBy('nama_kelas')->get();
        $jam_sekolah = DB::table('master_jam_sekolah')
            ->orderBy('jam_ke')
            ->get();
        
        return view('admin.jadwal.index', compact('jadwal', 'gurus', 'kelas', 'jam_sekolah'));
    }
    
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_ke_id' => 'required|exists:master_jam_sekolah,id',
            'mata_pelajaran' => 'required|string|max:100'
        ]);
        
        // Cek konflik jadwal
        $konflik = DB::table('jadwal_mengajar')
            ->where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where('jam_ke_id', $request->jam_ke_id)
            ->exists();
            
        if ($konflik) {
            return back()->with('error', 'Guru sudah memiliki jadwal di hari dan jam tersebut!');
        }
        
        // Simpan ke database
        DB::table('jadwal_mengajar')->insert([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'hari' => $request->hari,
            'jam_ke_id' => $request->jam_ke_id,
            'mata_pelajaran' => $request->mata_pelajaran,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }
     public function edit($id)
    {
        $jadwal = JadwalMengajar::with(['guru', 'kelas', 'jamSekolah'])->findOrFail($id);
        $gurus = Guru::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jam_sekolah = MasterJamSekolah::orderBy('jam_ke')->get();
        
        return view('admin.jadwal.edit', compact('jadwal', 'gurus', 'kelas', 'jam_sekolah'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_ke_id' => 'required|exists:master_jam_sekolah,id',
            'mata_pelajaran' => 'required|string|max:100',
        ]);
        
        $jadwal = JadwalMengajar::findOrFail($id);
        
        // Cek konflik jadwal (opsional)
        $konflik = JadwalMengajar::where('hari', $request->hari)
            ->where('jam_ke_id', $request->jam_ke_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('id', '!=', $id)
            ->exists();
            
        if ($konflik) {
            return back()->with('error', 'Jadwal konflik! Kelas sudah memiliki jadwal di hari dan jam tersebut.');
        }
        
        $jadwal->update($request->all());
        
        return redirect()->route('admin.jadwal')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->delete();
        
        return redirect()->route('admin.jadwal')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
    // Di JadwalController.php tambahkan:
public function storeMultiJam(Request $request)
{
    // Cek session
    if (!session('logged_in') || session('peran') != 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }
    
    // Validasi
    $request->validate([
        'guru_id' => 'required|exists:guru,id',
        'kelas_id' => 'required|exists:kelas,id',
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        'mata_pelajaran' => 'required|string|max:100',
        'jam_ke_ids' => 'required|array|min:1',
        'jam_ke_ids.*' => 'exists:master_jam_sekolah,id'
    ]);
    
    $guru_id = $request->guru_id;
    $kelas_id = $request->kelas_id;
    $hari = $request->hari;
    $mata_pelajaran = $request->mata_pelajaran;
    $jam_ke_ids = $request->jam_ke_ids;
    
    $successCount = 0;
    $failedCount = 0;
    $errors = [];
    
    foreach ($jam_ke_ids as $jam_ke_id) {
        // Cek konflik
        $konflikGuru = DB::table('jadwal_mengajar')
            ->where('guru_id', $guru_id)
            ->where('hari', $hari)
            ->where('jam_ke_id', $jam_ke_id)
            ->exists();
            
        $konflikKelas = DB::table('jadwal_mengajar')
            ->where('kelas_id', $kelas_id)
            ->where('hari', $hari)
            ->where('jam_ke_id', $jam_ke_id)
            ->exists();
        
        if (!$konflikGuru && !$konflikKelas) {
            DB::table('jadwal_mengajar')->insert([
                'guru_id' => $guru_id,
                'kelas_id' => $kelas_id,
                'hari' => $hari,
                'jam_ke_id' => $jam_ke_id,
                'mata_pelajaran' => $mata_pelajaran,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $successCount++;
        } else {
            $failedCount++;
            
            // Tentukan jenis konflik
            if ($konflikGuru && $konflikKelas) {
                $errors[] = "Jam ke-$jam_ke_id: Guru dan kelas sudah ada jadwal";
            } else if ($konflikGuru) {
                $errors[] = "Jam ke-$jam_ke_id: Guru sudah ada jadwal di jam ini";
            } else {
                $errors[] = "Jam ke-$jam_ke_id: Kelas sudah ada jadwal di jam ini";
            }
        }
    }
    
    if ($successCount > 0) {
        return response()->json([
            'success' => true,
            'count' => $successCount,
            'failed' => $failedCount,
            'message' => "Berhasil menambahkan $successCount jadwal" . 
                        ($failedCount > 0 ? ", $failedCount gagal karena konflik" : "")
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada jadwal yang berhasil ditambahkan',
            'errors' => $errors
        ]);
    }
}

// API untuk mengambil jam sekolah
public function getJamSekolah()
{
    $jam = DB::table('master_jam_sekolah')
        ->orderBy('jam_ke')
        ->get();
    
    return response()->json($jam);
}

// API untuk cek jadwal terpakai
public function getJadwalTerpakai(Request $request)
{
    $guru_id = $request->query('guru_id');
    $hari = $request->query('hari');
    
    $jadwal = DB::table('jadwal_mengajar')
        ->where('guru_id', $guru_id)
        ->where('hari', $hari)
        ->select('jam_ke_id')
        ->get();
    
    return response()->json($jadwal);
}

public function getJadwalKelas(Request $request)
{
    $kelas_id = $request->query('kelas_id');
    $hari = $request->query('hari');
    
    $jadwal = DB::table('jadwal_mengajar')
        ->where('kelas_id', $kelas_id)
        ->where('hari', $hari)
        ->select('jam_ke_id')
        ->get();
    
    return response()->json($jadwal);
}
    
}