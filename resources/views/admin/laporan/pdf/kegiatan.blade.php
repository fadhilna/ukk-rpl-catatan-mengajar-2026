<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan Guru</title>
    <style>
        /* CSS SEDERHANA TAPI PASTI BISA */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #000;
        }
        
        .header p {
            margin: 0;
            font-size: 11px;
            color: #555;
        }
        
        .info {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        
        th {
            background-color: #333;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #000;
            font-weight: bold;
        }
        
        td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .total {
            font-weight: bold;
            background-color: #e8f5e9 !important;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #666;
        }
        
        .ttd {
            margin-top: 40px;
        }
        
        .ttd-left, .ttd-right {
            width: 45%;
            display: inline-block;
            text-align: center;
        }
        
        .ttd-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 200px;
            display: inline-block;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <!-- DEBUG INFO -->
    <!-- Data Count: {{ $kegiatan->count() }} -->
    <!-- Periode: {{ $periode }} -->
    
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN KEGIATAN MENGAJAR GURU</h1>
        <p>SMK MUHAMMADIYAH 04 BAYAT</p>
        <p>Jl. Raya Bayat-Klaten KM 1, Bayat, Klaten</p>
    </div>
    
    <!-- Info Periode -->
    <div class="info">
        <strong>Periode:</strong> {{ $periode }}<br>
        <strong>Tanggal Cetak:</strong> {{ $tanggal_cetak }}<br>
        <strong>Total Data:</strong> {{ $total }} Kegiatan
    </div>
    
    <!-- Tabel Data -->
    @if($kegiatan->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">NO</th>
                    <th width="12%">TANGGAL</th>
                    <th width="20%">NAMA GURU</th>
                    <th width="15%">NIP</th>
                    <th width="13%">KELAS</th>
                    <th width="15%">MATA PELAJARAN</th>
                    <th width="20%">MATERI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kegiatan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                    <td>{{ $item->nama_guru }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    <td>{{ $item->mata_pelajaran }}</td>
                    <td>{{ $item->materi }}</td>
                </tr>
                @endforeach
                
                <!-- Total -->
                <tr class="total">
                    <td colspan="6" style="text-align: right; padding-right: 20px;">
                        TOTAL KEGIATAN:
                    </td>
                    <td>
                        {{ $total }}
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>Tidak ada data kegiatan</h3>
            <p>Tidak ada kegiatan yang tercatat untuk periode {{ $periode }}</p>
        </div>
    @endif
    
    <!-- Tanda Tangan -->
    @if($kegiatan->count() > 0)
    <div class="ttd">
        <div class="ttd-left">
            <p>Mengetahui,</p>
            <div class="ttd-line"></div>
            <p>Administrator</p>
        </div>
        
        <div class="ttd-right">
            <p>Bayat, {{ date('d F Y') }}</p>
            <div class="ttd-line"></div>
            <p>Kepala Sekolah</p>
            <p>SMK Muhammadiyah 04 Bayat</p>
        </div>
    </div>
    @endif
    
    <!-- Footer -->
    <div class="footer">
        <p style="text-align: center;">
            Dokumen ini dicetak otomatis dari Sistem Catatan Mengajar Guru.<br>
            Valid tanpa tanda tangan basah.
        </p>
    </div>
</body>
</html>