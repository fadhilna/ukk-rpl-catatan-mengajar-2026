<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    // EXPORT EXCEL - LAPORAN KEGIATAN
    public function exportExcelKegiatan(Request $request)
    {
        // Cek session admin
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }
        
        // Filter
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Query data
        $kegiatan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->join('guru as g', 'jm.guru_id', '=', 'g.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->orderBy('km.tanggal', 'desc')
            ->select(
                'km.tanggal',
                'g.nama as nama_guru',
                'g.nip',
                'k.nama_kelas',
                'jm.mata_pelajaran',
                'km.materi',
                'km.catatan',
                'jm.hari',
                'mjs.jam_ke',
                DB::raw("CONCAT(SUBSTRING(mjs.waktu_mulai, 1, 5), ' - ', SUBSTRING(mjs.waktu_selesai, 1, 5)) as waktu")
            )
            ->get();
        
        // Nama file
        $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
        $filename = "Laporan_Kegiatan_Guru_{$namaBulan}_{$tahun}.xlsx";
        
        // Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // HEADER UTAMA
        $sheet->setCellValue('A1', 'LAPORAN KEGIATAN MENGAJAR GURU');
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        
        $sheet->setCellValue('A2', 'SMK Muhammadiyah 04 Bayat');
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        
        $sheet->setCellValue('A3', 'Periode: ' . $namaBulan . ' ' . $tahun);
        $sheet->mergeCells('A3:I3');
        
        $sheet->setCellValue('A4', 'Tanggal Cetak: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A4:I4');
        
        // HEADER TABEL
        $sheet->setCellValue('A6', 'NO');
        $sheet->setCellValue('B6', 'TANGGAL');
        $sheet->setCellValue('C6', 'HARI');
        $sheet->setCellValue('D6', 'WAKTU');
        $sheet->setCellValue('E6', 'NAMA GURU');
        $sheet->setCellValue('F6', 'NIP');
        $sheet->setCellValue('G6', 'KELAS');
        $sheet->setCellValue('H6', 'MATA PELAJARAN');
        $sheet->setCellValue('I6', 'MATERI');
        $sheet->setCellValue('J6', 'CATATAN');
        
        // Style header tabel
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2C3E50']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
            ]
        ];
        
        for ($col = 'A'; $col <= 'J'; $col++) {
            $sheet->getStyle($col . '6')->applyFromArray($headerStyle);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // DATA
        $row = 7;
        $no = 1;
        foreach ($kegiatan as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($item->tanggal)));
            $sheet->setCellValue('C' . $row, $item->hari);
            $sheet->setCellValue('D' . $row, $item->waktu);
            $sheet->setCellValue('E' . $row, $item->nama_guru);
            $sheet->setCellValue('F' . $row, $item->nip ?? '-');
            $sheet->setCellValue('G' . $row, $item->nama_kelas);
            $sheet->setCellValue('H' . $row, $item->mata_pelajaran);
            $sheet->setCellValue('I' . $row, $item->materi);
            $sheet->setCellValue('J' . $row, $item->catatan ?? '-');
            
            // Alternating row color
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':J' . $row)
                    ->getFill()->setFillType('solid')->getStartColor()->setRGB('F8F9FA');
            }
            
            $row++;
            $no++;
        }
        
        // Border untuk seluruh tabel
        $lastRow = $row - 1;
        $tableRange = 'A6:J' . $lastRow;
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ];
        $sheet->getStyle($tableRange)->applyFromArray($borderStyle);
        
        // TOTAL
        $sheet->setCellValue('A' . $row, 'TOTAL KEGIATAN:');
        $sheet->mergeCells('A' . $row . ':I' . $row);
        $sheet->setCellValue('J' . $row, $kegiatan->count());
        
        $totalStyle = [
            'font' => ['bold' => true, 'size' => 11],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E8F5E9']],
            'alignment' => ['horizontal' => 'right']
        ];
        $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray($totalStyle);
        
        // TANDA TANGAN
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Mengetahui,');
        $sheet->setCellValue('E' . $row, 'Kepala Sekolah,');
        
        $row += 4;
        $sheet->setCellValue('A' . $row, '_________________________');
        $sheet->setCellValue('E' . $row, '_________________________');
        
        $row += 1;
        $sheet->setCellValue('A' . $row, 'Administrator');
        $sheet->setCellValue('E' . $row, 'Kepala SMK Muh 04 Bayat');
        
        // Simpan ke output
        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
    
    // EXPORT PDF - LAPORAN KEGIATAN
    public function exportPdfKegiatan(Request $request)
    {
        // Cek session admin
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }
        
        // Filter
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Query data
        $kegiatan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->join('guru as g', 'jm.guru_id', '=', 'g.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->join('master_jam_sekolah as mjs', 'jm.jam_ke_id', '=', 'mjs.id')
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->orderBy('km.tanggal', 'desc')
            ->select(
                'km.tanggal',
                'g.nama as nama_guru',
                'g.nip',
                'k.nama_kelas',
                'jm.mata_pelajaran',
                'km.materi',
                'km.catatan',
                'jm.hari',
                'mjs.jam_ke',
                DB::raw("CONCAT(SUBSTRING(mjs.waktu_mulai, 1, 5), ' - ', SUBSTRING(mjs.waktu_selesai, 1, 5)) as waktu")
            )
            ->get();
        
        $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
        
        $data = [
            'kegiatan' => $kegiatan,
            'periode' => $namaBulan . ' ' . $tahun,
            'tanggal_cetak' => date('d/m/Y H:i:s'),
            'total' => $kegiatan->count()
        ];
        
        // Generate PDF
        $pdf = Pdf::loadView('admin.laporan.pdf.kegiatan', $data);
        
        $filename = "Laporan_Kegiatan_Guru_{$namaBulan}_{$tahun}.pdf";
        
        return $pdf->download($filename);
    }
    
    // EXPORT CSV - LAPORAN KEGIATAN
    public function exportCsvKegiatan(Request $request)
    {
        // Cek session admin
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }
        
        // Filter
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Query data
        $kegiatan = DB::table('kegiatan_mengajar as km')
            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
            ->join('guru as g', 'jm.guru_id', '=', 'g.id')
            ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
            ->whereMonth('km.tanggal', $bulan)
            ->whereYear('km.tanggal', $tahun)
            ->orderBy('km.tanggal', 'desc')
            ->select(
                'km.tanggal',
                'g.nama as nama_guru',
                'g.nip',
                'k.nama_kelas',
                'jm.mata_pelajaran',
                'km.materi',
                'km.catatan'
            )
            ->get();
        
        $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
        $filename = "Laporan_Kegiatan_Guru_{$namaBulan}_{$tahun}.csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // BOM untuk UTF-8
        fwrite($output, "\xEF\xBB\xBF");
        
        // Header
        fputcsv($output, ['LAPORAN KEGIATAN MENGAJAR GURU']);
        fputcsv($output, ['SMK Muhammadiyah 04 Boyolali']);
        fputcsv($output, ['Periode: ' . $namaBulan . ' ' . $tahun]);
        fputcsv($output, ['Tanggal Cetak: ' . date('d/m/Y H:i:s')]);
        fputcsv($output, []); // Baris kosong
        
        // Header tabel
        fputcsv($output, [
            'NO', 
            'TANGGAL', 
            'NAMA GURU', 
            'NIP', 
            'KELAS', 
            'MATA PELAJARAN', 
            'MATERI', 
            'CATATAN'
        ]);
        
        // Data
        $no = 1;
        foreach ($kegiatan as $item) {
            fputcsv($output, [
                $no++,
                date('d/m/Y', strtotime($item->tanggal)),
                $item->nama_guru,
                $item->nip ?? '-',
                $item->nama_kelas,
                $item->mata_pelajaran,
                $item->materi,
                $item->catatan ?? '-'
            ]);
        }
        
        // Total
        fputcsv($output, []);
        fputcsv($output, ['', '', '', '', '', '', 'TOTAL KEGIATAN:', $kegiatan->count()]);
        
        fclose($output);
        exit;
    }
}