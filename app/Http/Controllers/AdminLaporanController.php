<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    // HALAMAN SEDERHANA: LAPORAN KEGIATAN SEMUA GURU
    public function kegiatan(Request $request)
    {
        // Cek login admin
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }
        
        // Filter sederhana
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Query sederhana - semua kegiatan bulan ini
        $kegiatan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->join('guru as g', 'jm.guru_id', '=', 'g.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->orderBy('km.tanggal', 'desc')
            ->orderBy('km.created_at', 'desc')
            ->select(
                'km.tanggal',
                'g.nama as nama_guru',
                'k.nama_kelas',
                'jm.mata_pelajaran',
                'km.materi',
                'km.catatan'
            )
            ->paginate(15);
        
        // Data untuk filter
        $guruList = DB::table('guru')->orderBy('nama')->get();
        $kelasList = DB::table('kelas')->orderBy('nama_kelas')->get();
        
        return view('admin.laporan.kegiatan', compact(
            'kegiatan', 'guruList', 'kelasList', 'bulan', 'tahun'
        ));
    }
    
    // HALAMAN REKAP KEHADIRAN (SIMPLE VERSION)
    public function kehadiran(Request $request)
    {
        // Cek login admin
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }
        
        $kelas_id = $request->get('kelas_id');
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Query sederhana: kelas dan siswa saja
        $kelasList = DB::table('kelas')->orderBy('nama_kelas')->get();
        
        return view('admin.laporan.kehadiran', compact(
            'kelasList', 'kelas_id', 'bulan', 'tahun'
        ));
    }
}