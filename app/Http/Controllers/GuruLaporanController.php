<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruLaporanController extends Controller
{
    public function index(Request $request)
    {
        if (!session('logged_in') || session('peran') != 'guru') {
            return redirect('/login');
        }
        
        $guru = DB::table('guru')
            ->where('pengguna_id', session('user_id'))
            ->first();
        
        if (!$guru) {
            return redirect('/login')->with('error', 'Data guru tidak ditemukan');
        }
        
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        $kegiatan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
            ->where('jm.guru_id', $guru->id)
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->orderBy('km.tanggal', 'desc')
            ->select(
                'km.*',
                'k.nama_kelas',
                'jm.mata_pelajaran',
                'jm.hari',
                'mjs.jam_ke',
                'mjs.waktu_mulai',
                'mjs.waktu_selesai'
            )
            ->get();
        
        // Hitung statistik
        $statistik = $this->hitungStatistik($kegiatan);
        
        $kelasList = DB::table('jadwal_mengajar as jm')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->where('jm.guru_id', $guru->id)
            ->select('k.id', 'k.nama_kelas')
            ->distinct()
            ->get();
        
        return view('guru.laporan.index', compact(
            'guru', 'kegiatan', 'statistik', 'kelasList', 'bulan', 'tahun'
        ));
    }
    
    public function exportCsv(Request $request)
    {
        if (!session('logged_in') || session('peran') != 'guru') {
            return redirect('/login');
        }
        
        $guru = DB::table('guru')
            ->where('pengguna_id', session('user_id'))
            ->first();
        
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        $kegiatan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
            ->where('jm.guru_id', $guru->id)
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->orderBy('km.tanggal', 'asc')
            ->orderBy('mjs.waktu_mulai')
            ->select(
                'km.tanggal',
                'jm.hari',
                'mjs.jam_ke',
                'k.nama_kelas',
                'jm.mata_pelajaran',
                'km.materi',
                'km.catatan',
                DB::raw("CONCAT(SUBSTRING(mjs.waktu_mulai, 1, 5), '-', SUBSTRING(mjs.waktu_selesai, 1, 5)) as waktu")
            )
            ->get();
        
        $filename = "laporan_bulanan_{$guru->nama}_{$bulan}_{$tahun}.csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['NO', 'TANGGAL', 'HARI', 'JAM KE', 'WAKTU', 'KELAS', 'MATA PELAJARAN', 'MATERI', 'CATATAN']);
        
        $no = 1;
        foreach ($kegiatan as $item) {
            fputcsv($output, [
                $no++,
                date('d/m/Y', strtotime($item->tanggal)),
                $item->hari,
                $item->jam_ke,
                $item->waktu,
                $item->nama_kelas,
                $item->mata_pelajaran,
                $item->materi,
                $item->catatan ?? '-'
            ]);
        }
        
        fputcsv($output, ['', '', '', '', '', '', 'TOTAL KEGIATAN:', $kegiatan->count(), '']);
        
        fclose($output);
        exit;
    }
    
 public function exportExcel(Request $request)
{
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    $bulan = $request->get('bulan', date('m'));
    $tahun = $request->get('tahun', date('Y'));
    
    // DEBUG: Tampilkan nilai bulan
    error_log("Bulan dari request: " . $bulan . " (type: " . gettype($bulan) . ")");
    
    // AMBIL DATA KEGIATAN DENGAN KEHADIRAN SISWA
    $kegiatan = DB::table('kegiatan_mengajar as km')
        ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
        ->leftJoin('kehadiran_siswa as ks', 'km.id', '=', 'ks.kegiatan_id') // TAMBAH INI
        ->leftJoin('siswa as s', 'ks.siswa_id', '=', 's.id') // TAMBAH INI
        ->where('jm.guru_id', $guru->id)
        ->whereMonth('km.tanggal', $bulan)
        ->whereYear('km.tanggal', $tahun)
        ->orderBy('km.tanggal', 'asc')
        ->orderBy('mjs.waktu_mulai')
        ->orderBy('s.nama') // Urutkan berdasarkan nama siswa
        ->select(
            'km.tanggal',
            'jm.hari',
            'mjs.jam_ke',
            'k.nama_kelas',
            'jm.mata_pelajaran',
            'km.materi',
            'km.catatan',
            'mjs.waktu_mulai',
            'mjs.waktu_selesai',
            // TAMBAH DATA KEHADIRAN
            's.nis',
            's.nama as nama_siswa',
            'ks.status as status_kehadiran',
            'ks.keterangan as keterangan_kehadiran'
        )
        ->get();
    
    // PERBAIKAN UTAMA: Gunakan array dengan bulan sebagai string
    $namaBulan = [
        '01' => 'Januari',
        '02' => 'Februari', 
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September'
    ];
    
    // Pastikan bulan 2 digit
    if (strlen($bulan) == 1) {
        $bulan = '0' . $bulan;
    }
    
    // Ambil nama bulan dengan fallback
    $bulanNama = $namaBulan[$bulan] ?? 'Bulan-' . $bulan;
    
    // Bersihkan nama file
    $namaGuruClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $guru->nama);
    $filename = "Laporan_Bulanan_{$namaGuruClean}_{$bulanNama}_{$tahun}.xls";
    
    // Header untuk Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");
    
    // Output HTML sebagai Excel
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Calibri, Arial, sans-serif; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4CAF50; color: white; font-weight: bold; padding: 10px; text-align: center; }
            td { border: 1px solid #ddd; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .header-title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 20px; }
            .sub-header { font-size: 14px; margin-bottom: 10px; }
            .total-row { font-weight: bold; background-color: #e8f5e9; }
            .center { text-align: center; }
            .left { text-align: left; }
            .right { text-align: right; }
            .kegiatan-row { background-color: #e3f2fd; }
            .kehadiran-row { background-color: #f1f8e9; }
        </style>
    </head>
    <body>
    
    <!-- Judul Laporan -->
    <div class="header-title">LAPORAN BULANAN KEGIATAN MENGAJAR DAN KEHADIRAN SISWA</div>
    <div class="sub-header">
        <strong>Nama Guru:</strong> <?php echo $guru->nama; ?><br>
        <strong>NIP:</strong> <?php echo $guru->nip ?? '-'; ?><br>
        <strong>Periode:</strong> <?php echo $bulanNama . ' ' . $tahun; ?><br>
        <strong>Tanggal Cetak:</strong> <?php echo date('d/m/Y H:i:s'); ?>
    </div>
    
    <br>
    
    <!-- Tabel Data -->
    <table border="1">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="10%">TANGGAL</th>
                <th width="8%">HARI</th>
                <th width="6%">JAM KE</th>
                <th width="10%">WAKTU</th>
                <th width="10%">KELAS</th>
                <th width="12%">MATA PELAJARAN</th>
                <th width="15%">MATERI</th>
                <th width="10%">NIS</th>
                <th width="15%">NAMA SISWA</th>
                <th width="8%">STATUS</th>
                <th width="10%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $totalKegiatan = 0;
            $lastKegiatanKey = null;
            
            foreach ($kegiatan as $item): 
                // Buat unique key untuk setiap kegiatan (tanpa siswa)
                $kegiatanKey = $item->tanggal . '-' . $item->jam_ke . '-' . $item->nama_kelas;
                
                // Jika ini kegiatan baru, tambah row kegiatan
                if ($kegiatanKey !== $lastKegiatanKey) {
                    $totalKegiatan++;
            ?>
            <tr class="kegiatan-row">
                <td class="center" rowspan="<?php echo 'X'; // Akan dihitung nanti ?>"><?php echo $no++; ?></td>
                <td class="center"><?php echo date('d/m/Y', strtotime($item->tanggal)); ?></td>
                <td class="center"><?php echo $item->hari; ?></td>
                <td class="center"><?php echo $item->jam_ke; ?></td>
                <td class="center">
                    <?php echo substr($item->waktu_mulai, 0, 5) . ' - ' . substr($item->waktu_selesai, 0, 5); ?>
                </td>
                <td class="center"><?php echo $item->nama_kelas; ?></td>
                <td class="left"><?php echo $item->mata_pelajaran; ?></td>
                <td class="left"><?php echo $item->materi; ?></td>
                <td colspan="4" class="center"><strong>DATA KEGIATAN</strong></td>
            </tr>
            <?php 
                $lastKegiatanKey = $kegiatanKey;
                }
                
                // Tampilkan data kehadiran siswa
                if ($item->nis) { // Jika ada data siswa
            ?>
            <tr class="kehadiran-row">
                <td colspan="8"></td> <!-- Kolom kosong untuk alignment -->
                <td class="center"><?php echo $item->nis; ?></td>
                <td class="left"><?php echo $item->nama_siswa; ?></td>
                <td class="center">
                    <?php 
                    $status = $item->status_kehadiran ?? 'Alpa';
                    $colors = [
                        'Hadir' => 'green',
                        'Izin' => 'orange',
                        'Sakit' => 'blue',
                        'Alpa' => 'red'
                    ];
                    $color = $colors[$status] ?? 'black';
                    ?>
                    <span style="color: <?php echo $color; ?>; font-weight: bold;">
                        <?php echo $status; ?>
                    </span>
                </td>
                <td class="left"><?php echo $item->keterangan_kehadiran ?: '-'; ?></td>
            </tr>
            <?php 
                } else { 
                // Jika tidak ada data kehadiran (belum diinput)
            ?>
            <tr class="kehadiran-row">
                <td colspan="8"></td>
                <td class="center" colspan="4" style="color: #666; font-style: italic;">
                    Data kehadiran belum diinput
                </td>
            </tr>
            <?php } ?>
            <?php endforeach; ?>
            
            <?php if (count($kegiatan) === 0): ?>
            <tr>
                <td colspan="12" class="center" style="color: #999; padding: 30px;">
                    Tidak ada data kegiatan untuk periode <?php echo $bulanNama . ' ' . $tahun; ?>
                </td>
            </tr>
            <?php endif; ?>
            
            <!-- Baris Total -->
            <tr class="total-row">
                <td colspan="8" class="right"><strong>TOTAL KEGIATAN:</strong></td>
                <td colspan="4" class="center"><strong><?php echo $totalKegiatan; ?></strong></td>
            </tr>
        </tbody>
    </table>
    
    <br>
    
    <!-- Statistik -->
    <div style="margin-top: 20px;">
        <h4>STATISTIK</h4>
        <table border="1" style="width: 50%;">
            <tr>
                <td><strong>Total Hari Mengajar:</strong></td>
                <td>
                    <?php 
                    $hariMengajar = $kegiatan->unique('tanggal')->count();
                    echo $hariMengajar; 
                    ?> hari
                </td>
            </tr>
            <tr>
                <td><strong>Total Jam Pelajaran:</strong></td>
                <td><?php echo $totalKegiatan; ?> jam</td>
            </tr>
            <tr>
                <td><strong>Total Data Kehadiran:</strong></td>
                <td>
                    <?php 
                    $totalKehadiran = $kegiatan->filter(function($item) {
                        return !empty($item->nis);
                    })->count();
                    echo $totalKehadiran; 
                    ?> data
                </td>
            </tr>
            <tr>
                <td><strong>Rata-rata per Hari:</strong></td>
                <td>
                    <?php 
                    echo $hariMengajar > 0 ? round($totalKegiatan / $hariMengajar, 1) : 0; 
                    ?> jam/hari
                </td>
            </tr>
        </table>
    </div>
    
    <br><br>
    
    <!-- Tanda Tangan -->
    <div style="width: 100%; text-align: center; margin-top: 50px;">
        <div style="width: 50%; float: left; text-align: center;">
            <br><br><br>
            <hr style="width: 200px;">
            <strong>Guru</strong><br>
            <?php echo $guru->nama; ?>
        </div>
        <div style="width: 50%; float: left; text-align: center;">
            Mengetahui,<br>
            <strong>Kepala Sekolah</strong><br><br><br><br>
            <hr style="width: 200px;">
            <strong>(_______________________)</strong>
        </div>
    </div>
    
    </body>
    </html>
    <?php
    exit;

}
    
    // METHOD INI YANG HARUS DITAMBAHKAN ↓↓↓
    private function hitungStatistik($kegiatan)
    {
        $totalHari = $kegiatan->groupBy('tanggal')->count();
        $totalJam = $kegiatan->count();
        $rataJam = $totalHari > 0 ? round($totalJam / $totalHari, 1) : 0;
        
        $perKelas = [];
        foreach ($kegiatan as $item) {
            $kelas = $item->nama_kelas;
            if (!isset($perKelas[$kelas])) {
                $perKelas[$kelas] = 0;
            }
            $perKelas[$kelas]++;
        }
        
        return [
            'total_hari' => $totalHari,
            'total_jam' => $totalJam,
            'rata_jam' => $rataJam,
            'per_kelas' => $perKelas,
        ];
    }

// TAMBAHKAN METHOD INI DI GuruLaporanController.php

public function exportRekapKehadiran(Request $request)
{
    if (!session('logged_in') || session('peran') != 'guru') {
        return redirect('/login');
    }
    
    $guru = DB::table('guru')
        ->where('pengguna_id', session('user_id'))
        ->first();
    
    $bulan = $request->get('bulan', date('m'));
    $tahun = $request->get('tahun', date('Y'));
    $kelas_id = $request->get('kelas_id');
    
    // Pastikan bulan 2 digit
    if (strlen($bulan) == 1) {
        $bulan = '0' . $bulan;
    }
    
    // Nama bulan
    $namaBulan = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    $bulanNama = $namaBulan[$bulan] ?? 'Bulan-' . $bulan;
    
    // **QUERY YANG LEBIH BAIK: Ambil semua siswa dari kelas yang diajar**
    // 1. Dapatkan semua kelas yang diajar guru ini
    $kelasDiajar = DB::table('jadwal_mengajar as jm')
        ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
        ->where('jm.guru_id', $guru->id)
        ->select('k.id', 'k.nama_kelas', 'jm.mata_pelajaran')
        ->distinct()
        ->get();
    
    // 2. Ambil semua siswa dari kelas-kelas tersebut
    $siswaList = collect();
    foreach ($kelasDiajar as $kelas) {
        // Skip jika filter kelas spesifik dan tidak match
        if ($kelas_id && $kelas->id != $kelas_id) {
            continue;
        }
        
        $siswa = DB::table('siswa as s')
            ->where('s.kelas_id', $kelas->id)
            ->select(
                's.id as siswa_id',
                's.nis',
                's.nama',
                DB::raw("'{$kelas->id}' as kelas_id"),
                DB::raw("'{$kelas->nama_kelas}' as nama_kelas"),
                DB::raw("'{$kelas->mata_pelajaran}' as mata_pelajaran")
            )
            ->get();
        
        $siswaList = $siswaList->merge($siswa);
    }
    
    if ($siswaList->isEmpty()) {
        // Generate file kosong
        $namaGuruClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $guru->nama);
        $filename = "Rekap_Kehadiran_{$namaGuruClean}_{$bulanNama}_{$tahun}.xls";
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        
        echo "<html><body>";
        echo "<h3>Tidak ada siswa di kelas yang diajar</h3>";
        echo "</body></html>";
        exit;
    }
    
    // 3. HITUNG KEHADIRAN SETIAP SISWA
    $rekapKehadiran = [];
    foreach ($siswaList as $siswa) {
        // Hitung kehadiran per status
        $kehadiran = DB::table('kehadiran_siswa as ks')
            ->join('kegiatan_mengajar as km', 'ks.kegiatan_id', '=', 'km.id')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->where('ks.siswa_id', $siswa->siswa_id)
            ->where('jm.guru_id', $guru->id)
            ->where('jm.kelas_id', $siswa->kelas_id)
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->selectRaw("
                COUNT(CASE WHEN ks.status = 'Hadir' THEN 1 END) as hadir,
                COUNT(CASE WHEN ks.status = 'Izin' THEN 1 END) as izin,
                COUNT(CASE WHEN ks.status = 'Sakit' THEN 1 END) as sakit,
                COUNT(CASE WHEN ks.status = 'Alpa' THEN 1 END) as alpa,
                COUNT(*) as total
            ")
            ->first();
        
        // Total pertemuan di kelas tersebut
        $totalPertemuan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->where('jm.guru_id', $guru->id)
            ->where('jm.kelas_id', $siswa->kelas_id)
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->count();
        
        // Persentase kehadiran
        $persentase = $totalPertemuan > 0 ? 
            round(($kehadiran->hadir / $totalPertemuan) * 100, 1) : 0;
        
        $rekapKehadiran[] = [
            'nis' => $siswa->nis,
            'nama' => $siswa->nama,
            'kelas' => $siswa->nama_kelas,
            'mata_pelajaran' => $siswa->mata_pelajaran,
            'hadir' => $kehadiran->hadir ?? 0,
            'izin' => $kehadiran->izin ?? 0,
            'sakit' => $kehadiran->sakit ?? 0,
            'alpa' => $kehadiran->alpa ?? 0,
            'total_kehadiran' => $kehadiran->total ?? 0,
            'total_pertemuan' => $totalPertemuan,
            'persentase' => $persentase
        ];
    }
    
    // ... (lanjutan kode yang sama)
    
    // 3. HITUNG REKAP PER KELAS
    $rekapKelas = [];
    foreach ($rekapKehadiran as $item) {
        $kelas = $item['kelas'];
        if (!isset($rekapKelas[$kelas])) {
            $rekapKelas[$kelas] = [
                'total_siswa' => 0,
                'rata_hadir' => 0,
                'rata_izin' => 0,
                'rata_sakit' => 0,
                'rata_alpa' => 0,
                'rata_persentase' => 0
            ];
        }
        $rekapKelas[$kelas]['total_siswa']++;
        $rekapKelas[$kelas]['rata_hadir'] += $item['hadir'];
        $rekapKelas[$kelas]['rata_izin'] += $item['izin'];
        $rekapKelas[$kelas]['rata_sakit'] += $item['sakit'];
        $rekapKelas[$kelas]['rata_alpa'] += $item['alpa'];
        $rekapKelas[$kelas]['rata_persentase'] += $item['persentase'];
    }
    
    // Hitung rata-rata
    foreach ($rekapKelas as $kelas => $data) {
        if ($data['total_siswa'] > 0) {
            $rekapKelas[$kelas]['rata_hadir'] = round($data['rata_hadir'] / $data['total_siswa'], 1);
            $rekapKelas[$kelas]['rata_izin'] = round($data['rata_izin'] / $data['total_siswa'], 1);
            $rekapKelas[$kelas]['rata_sakit'] = round($data['rata_sakit'] / $data['total_siswa'], 1);
            $rekapKelas[$kelas]['rata_alpa'] = round($data['rata_alpa'] / $data['total_siswa'], 1);
            $rekapKelas[$kelas]['rata_persentase'] = round($data['rata_persentase'] / $data['total_siswa'], 1);
        }
    }
    
    // 4. GENERATE EXCEL
    $namaGuruClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $guru->nama);
    $filename = "Rekap_Kehadiran_{$namaGuruClean}_{$bulanNama}_{$tahun}.xls";
    
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Calibri, Arial, sans-serif; }
            table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
            th { background-color: #4CAF50; color: white; font-weight: bold; padding: 10px; text-align: center; }
            td { border: 1px solid #ddd; padding: 8px; }
            .header-title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 20px; }
            .sub-header { font-size: 14px; margin-bottom: 10px; }
            .center { text-align: center; }
            .left { text-align: left; }
            .right { text-align: right; }
            .bg-hijau { background-color: #c8e6c9; }
            .bg-kuning { background-color: #fff9c4; }
            .bg-merah { background-color: #ffcdd2; }
            .total-row { font-weight: bold; background-color: #e3f2fd; }
        </style>
    </head>
    <body>
    
    <!-- Judul Laporan -->
    <div class="header-title">REKAPITULASI KEHADIRAN SISWA PER BULAN</div>
    <div class="sub-header">
        <strong>Nama Guru:</strong> <?php echo $guru->nama; ?><br>
        <strong>NIP:</strong> <?php echo $guru->nip ?? '-'; ?><br>
        <strong>Periode:</strong> <?php echo $bulanNama . ' ' . $tahun; ?><br>
        <strong>Tanggal Cetak:</strong> <?php echo date('d/m/Y H:i:s'); ?>
    </div>
    
    <?php if (count($rekapKehadiran) > 0): ?>
    
    <!-- REKAP PER KELAS -->
    <h3>Rekap Rata-rata per Kelas</h3>
    <table border="1">
        <thead>
            <tr>
                <th>KELAS</th>
                <th>JUMLAH SISWA</th>
                <th>RATA-RATA HADIR</th>
                <th>RATA-RATA IZIN</th>
                <th>RATA-RATA SAKIT</th>
                <th>RATA-RATA ALPA</th>
                <th>RATA-RATA PRESENSI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekapKelas as $kelas => $data): ?>
            <tr class="total-row">
                <td class="center"><?php echo $kelas; ?></td>
                <td class="center"><?php echo $data['total_siswa']; ?></td>
                <td class="center"><?php echo $data['rata_hadir']; ?></td>
                <td class="center"><?php echo $data['rata_izin']; ?></td>
                <td class="center"><?php echo $data['rata_sakit']; ?></td>
                <td class="center"><?php echo $data['rata_alpa']; ?></td>
                <td class="center">
                    <?php 
                    $warna = $data['rata_persentase'] >= 90 ? 'green' : 
                            ($data['rata_persentase'] >= 75 ? 'orange' : 'red');
                    ?>
                    <span style="color: <?php echo $warna; ?>; font-weight: bold;">
                        <?php echo $data['rata_persentase']; ?>%
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    
    <!-- DETAIL PER SISWA -->
    <h3>Detail Kehadiran per Siswa</h3>
    <table border="1">
        <thead>
            <tr>
                <th>NO</th>
                <th>NIS</th>
                <th>NAMA SISWA</th>
                <th>KELAS</th>
                <th>MATA PELAJARAN</th>
                <th>HADIR</th>
                <th>IZIN</th>
                <th>SAKIT</th>
                <th>ALPA</th>
                <th>TOTAL</th>
                <th>PERTEMUAN</th>
                <th>PRESENSI</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $currentClass = '';
            foreach ($rekapKehadiran as $item): 
                // Tampilkan nama kelas hanya sekali per grup
                if ($item['kelas'] != $currentClass) {
                    $currentClass = $item['kelas'];
            ?>
            <tr class="total-row">
                <td colspan="13" style="background-color: #bbdefb;">
                    <strong>KELAS: <?php echo $item['kelas']; ?></strong>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td class="center"><?php echo $no++; ?></td>
                <td class="center"><?php echo $item['nis']; ?></td>
                <td class="left"><?php echo $item['nama']; ?></td>
                <td class="center"><?php echo $item['kelas']; ?></td>
                <td class="left"><?php echo $item['mata_pelajaran']; ?></td>
                <td class="center bg-hijau"><?php echo $item['hadir']; ?></td>
                <td class="center bg-kuning"><?php echo $item['izin']; ?></td>
                <td class="center bg-kuning"><?php echo $item['sakit']; ?></td>
                <td class="center bg-merah"><?php echo $item['alpa']; ?></td>
                <td class="center"><?php echo $item['total_kehadiran']; ?></td>
                <td class="center"><?php echo $item['total_pertemuan']; ?></td>
                <td class="center">
                    <?php 
                    $warna = $item['persentase'] >= 90 ? 'green' : 
                            ($item['persentase'] >= 75 ? 'orange' : 'red');
                    $bg = $item['persentase'] >= 90 ? '#c8e6c9' : 
                         ($item['persentase'] >= 75 ? '#fff9c4' : '#ffcdd2');
                    ?>
                    <span style="color: <?php echo $warna; ?>; font-weight: bold; background-color: <?php echo $bg; ?>; padding: 2px 8px; border-radius: 3px;">
                        <?php echo $item['persentase']; ?>%
                    </span>
                </td>
                <td class="left">
                    <?php 
                    if ($item['persentase'] >= 90) {
                        echo "Sangat Baik";
                    } elseif ($item['persentase'] >= 75) {
                        echo "Baik";
                    } elseif ($item['persentase'] >= 60) {
                        echo "Cukup";
                    } else {
                        echo "Perlu Perhatian";
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- LEGENDA -->
    <div style="margin-top: 20px; font-size: 12px; color: #666;">
        <strong>Legenda:</strong><br>
        • <span style="background-color: #c8e6c9; padding: 2px 5px;">≥90%</span> = Sangat Baik<br>
        • <span style="background-color: #fff9c4; padding: 2px 5px;">75-89%</span> = Baik<br>
        • <span style="background-color: #ffcdd2; padding: 2px 5px;"><75%</span> = Perlu Perhatian
    </div>
    
    <?php else: ?>
    
    <div style="text-align: center; padding: 50px; color: #999;">
        <h3>Tidak ada data kehadiran untuk periode <?php echo $bulanNama . ' ' . $tahun; ?></h3>
        <p>Pastikan sudah menginput kegiatan mengajar dan kehadiran siswa.</p>
    </div>
    
    <?php endif; ?>
    
    <br><br>
    
    <!-- Tanda Tangan -->
    <div style="width: 100%; text-align: center; margin-top: 50px;">
        <div style="width: 50%; float: left; text-align: center;">
            <br><br><br>
            <hr style="width: 200px;">
            <strong>Guru Mata Pelajaran</strong><br>
            <?php echo $guru->nama; ?>
        </div>
        <div style="width: 50%; float: left; text-align: center;">
            Mengetahui,<br>
            <strong>Kepala Sekolah</strong><br><br><br><br>
            <hr style="width: 200px;">
            <strong>(_______________________)</strong>
        </div>
    </div>
    
    </body>
    </html>
    <?php
    exit;
}
    
}