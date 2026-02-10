@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">
                <i class="bi bi-journal-text me-2"></i>Laporan Bulanan
            </h2>
            <p class="text-muted mb-0">Rekap kegiatan mengajar per bulan</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary fs-6 p-2 me-3">
                <i class="bi bi-person-fill me-1"></i>{{ $guru->nama }}
            </span>
        </div>
    </div>
    <div class="mb-4">
    <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-month text-primary me-2"></i>
                        Periode: {{ date('F Y', strtotime($tahun . '-' . $bulan . '-01')) }}
                    </h5>
                </div>
                <div class="col-md-6">
                    <form method="GET" class="d-flex justify-content-end gap-2">
                        <select name="bulan" class="form-select w-auto">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        <select name="tahun" class="form-select w-auto">
                            @for($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        
                        <!-- TIGA TOMBOL EXPORT -->
                        <div class="btn-group" role="group">
                            <a href="{{ route('guru.laporan.export.csv') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" 
                               class="btn btn-info" title="Export CSV">
                                <i class="bi bi-file-earmark-text"></i> CSV
                            </a>
                            
                            <a href="{{ route('guru.laporan.export.excel') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" 
                               class="btn btn-success" title="Export Laporan Kegiatan (Excel)">
                                <i class="bi bi-file-earmark-excel"></i> Laporan
                            </a>
                            
                            <!-- TOMBOL BARU: Rekap Kehadiran -->
                            <a href="{{ route('guru.laporan.rekap.kehadiran') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" 
                               class="btn btn-warning" title="Export Rekap Kehadiran">
                                <i class="bi bi-person-lines-fill"></i> Rekap Hadir
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow border-0">
                <div class="card-body text-center py-4">
                    <h1 class="display-4 fw-bold">{{ $statistik['total_hari'] }}</h1>
                    <p class="mb-0">Hari Mengajar</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow border-0">
                <div class="card-body text-center py-4">
                    <h1 class="display-4 fw-bold">{{ $statistik['total_jam'] }}</h1>
                    <p class="mb-0">Total Jam</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow border-0">
                <div class="card-body text-center py-4">
                    <h1 class="display-4 fw-bold">{{ $statistik['rata_jam'] }}</h1>
                    <p class="mb-0">Rata-rata Jam/Hari</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow border-0">
                <div class="card-body text-center py-4">
                    <h1 class="display-4 fw-bold">{{ count($statistik['per_kelas']) }}</h1>
                    <p class="mb-0">Kelas Diajar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kegiatan Per Kelas -->
    @if(count($statistik['per_kelas']) > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Distribusi per Kelas</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($statistik['per_kelas'] as $kelas => $jumlah)
                <div class="col-md-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                        <div>
                            <h6 class="mb-1">{{ $kelas }}</h6>
                            <small class="text-muted">{{ $jumlah }} kegiatan</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $jumlah }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Daftar Kegiatan -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Kegiatan</h5>
            <div>
                <span class="badge bg-primary me-2">{{ $kegiatan->count() }} kegiatan</span>
                <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer"></i> Cetak
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($kegiatan->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Jam</th>
                            <th>Materi</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div>{{ date('d/m/Y', strtotime($item->tanggal)) }}</div>
                                <small class="text-muted">{{ $item->hari }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->nama_kelas }}</span>
                            </td>
                            <td>{{ $item->mata_pelajaran }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $item->jam_ke }} ({{ substr($item->waktu_mulai, 0, 5) }})
                                </span>
                            </td>
                            <td>
                                @if(strlen($item->materi) > 50)
                                    {{ substr($item->materi, 0, 50) }}...
                                @else
                                    {{ $item->materi }}
                                @endif
                            </td>
                            <td>
                                @if($item->catatan)
                                    @if(strlen($item->catatan) > 30)
                                        {{ substr($item->catatan, 0, 30) }}...
                                    @else
                                        {{ $item->catatan }}
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="/guru/kegiatan/detail/{{ $item->id }}" 
                                   class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-primary">
                            <td colspan="7" class="text-end fw-bold">TOTAL KEGIATAN:</td>
                            <td class="fw-bold">{{ $kegiatan->count() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h4 class="text-muted mt-3">Tidak ada kegiatan</h4>
                <p class="text-muted">Belum ada kegiatan mengajar pada periode ini</p>
                <a href="{{ route('guru.kegiatan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                </a>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Info Export -->
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Tips:</strong> 
        Gunakan <strong>Export Excel</strong> untuk format laporan rapi dengan header dan tanda tangan.
        Gunakan <strong>Export CSV</strong> untuk data mentah yang bisa diolah di spreadsheet.
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
    }
    .badge {
        font-size: 0.85em;
    }
    .table th {
        font-weight: 600;
        color: #495057;
    }
    .table tfoot td {
        font-size: 1.1em;
    }
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    @media print {
        .card-header, .btn, .alert, .form-select, .btn-group {
            display: none !important;
        }
        .table {
            border: 1px solid #000;
        }
        .table th, .table td {
            border: 1px solid #000;
        }
    }
</style>
@endsection