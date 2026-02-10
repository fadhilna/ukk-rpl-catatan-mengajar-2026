@extends('layouts.admin')

@section('content')


<!-- NAVBAR DENGAN MENU -->
<nav class="navbar navbar-glow navbar-expand-lg shadow">
    <div class="container-fluid px-4">
       <a class="navbar-brand fw-bold text-white" href="/admin">
    <img src="{{ asset('image-removebg-preview.png') }}" 
         alt="Logo SMK" 
         style="width: 35px; height: 35px; margin-right: 10px;">
    <span class="d-none d-md-inline">UKK RPL Admin</span>
</a>
        
        <!-- Menu untuk desktop -->
        <div class="d-none d-lg-flex ms-4">
            <div class="navbar-nav">
                <a class="nav-link text-white mx-2 {{ request()->is('admin') ? 'active' : '' }}" 
                   href="/admin">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/guru*') ? 'active' : '' }}" 
                   href="/admin/guru">
                    <i class="bi bi-people me-1"></i> Guru
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/kelas*') ? 'active' : '' }}" 
                   href="/admin/kelas">
                    <i class="bi bi-building me-1"></i> Kelas
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/jadwal*') ? 'active' : '' }}" 
                   href="/admin/jadwal">
                    <i class="bi bi-calendar-week me-1"></i> Jadwal
                </a>
                <!-- MENU DATA SISWA -->
                <a class="nav-link text-white mx-2 {{ request()->is('admin/siswa*') ? 'active' : '' }}" 
                   href="/admin/siswa">
                    <i class="bi bi-people-fill me-1"></i> Siswa
                </a>
            </div>
        </div>
        
        <!-- Search & Profil -->
        <div class="d-flex align-items-center">
            <!-- Profil -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
                   data-bs-toggle="dropdown">
                    <div class="me-2">
                        <div class="profile-img bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill text-primary"></i>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-semibold">{{ session('username') ?? 'Admin' }}</div>
                        <small class="opacity-75">Administrator</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="/admin">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                   <!-- Di dropdown menu profil -->
                    <li>
                        <a class="dropdown-item logout-animated" href="/logout" id="dropdownLogoutBtn">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <!-- Header dengan Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0 text-danger">
                        <i class="bi bi-journal-text"></i>
                        Laporan Kegiatan Semua Guru
                    </h4>
                    <p class="text-muted mb-0 mt-1">
                        Periode: <strong>{{ $namaBulan }} {{ $tahun }}</strong>
                    </p>
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
                                <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-info fs-6">
                <i class="bi bi-journal-check"></i>
                {{ $kegiatan->total() }} Kegiatan
            </span>
        </div>
        
        <div class="btn-group">
            <a href="/admin" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Export
            </button>
            
            <ul class="dropdown-menu">
                <li>
                    <!-- PERBAIKI LINK DENGAN PARAMETER BULAN & TAHUN -->
                    <a class="dropdown-item" href="{{ url('/admin/laporan/export-excel') }}?bulan={{ $bulan }}&tahun={{ $tahun }}">
                        <i class="bi bi-file-earmark-excel text-success"></i> Excel (Formal)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('/admin/laporan/export-pdf') }}?bulan={{ $bulan }}&tahun={{ $tahun }}">
                        <i class="bi bi-file-earmark-pdf text-danger"></i> PDF (Arsip)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('/admin/laporan/export-csv') }}?bulan={{ $bulan }}&tahun={{ $tahun }}">
                        <i class="bi bi-file-earmark-text text-info"></i> CSV (Simple)
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" onclick="window.print()">
                        <i class="bi bi-printer text-secondary"></i> Print Langsung
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Tabel Kegiatan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($kegiatan->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Tanggal</th>
                            <th width="20%">Guru</th>
                            <th width="15%">Kelas</th>
                            <th width="20%">Mata Pelajaran</th>
                            <th width="25%">Materi</th>
                            <th width="10%">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $item)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                            <td>
                                <strong>{{ $item->nama_guru }}</strong>
                            </td>
                            <td>{{ $item->nama_kelas }}</td>
                            <td>{{ $item->mata_pelajaran }}</td>
                            <td>{{ $item->materi }}</td>
                            <td>
                                @if($item->catatan)
                                    <span class="badge bg-info">Ada</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $kegiatan->links() }}
            </div>
            
            @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-journal-x display-1 text-muted"></i>
                </div>
                <h4 class="text-muted">Belum ada data kegiatan</h4>
                <p class="text-muted">Tidak ada kegiatan yang tercatat untuk periode {{ $namaBulan }} {{ $tahun }}.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection