@extends('layouts.admin')

@section('title', 'Dashboard Admin')
<!-- Favicon -->
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>">

@section('content')
<!-- NAVBAR DENGAN MENU -->
<nav class="navbar navbar-glow navbar-expand-lg shadow">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-white" href="/admin">
            <img src="{{ asset('image-removebg-preview.png') }}" alt="Logo SMK" style="width: 35px; height: 35px; margin-right: 10px;">
            <span class="d-none d-md-inline">UKK RPL Admin</span>
        </a>

        <!-- Search Bar -->
        <div class="search-bar mx-4 d-none d-lg-flex">
            <div class="input-group search-group">
                <span class="input-group-text bg-transparent border-0">
                    <i class="bi bi-search text-white"></i>
                </span>
                <input type="text" class="form-control search-input" placeholder="Search Here...">
            </div>
        </div>

        <!-- Menu untuk desktop -->
        <div class="d-none d-lg-flex ms-auto">
            <div class="navbar-nav">
                <a class="nav-link text-white mx-2 {{ request()->is('admin') ? 'active' : '' }}" href="/admin">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/guru*') ? 'active' : '' }}" href="/admin/guru">
                    <i class="bi bi-people me-1"></i> Guru
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/kelas*') ? 'active' : '' }}" href="/admin/kelas">
                    <i class="bi bi-building me-1"></i> Kelas
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/jadwal*') ? 'active' : '' }}" href="/admin/jadwal">
                    <i class="bi bi-calendar-week me-1"></i> Jadwal
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/siswa*') ? 'active' : '' }}" href="/admin/siswa">
                    <i class="bi bi-people-fill me-1"></i> Siswa
                </a>
            </div>
        </div>

        <!-- Profil -->
        <div class="d-flex align-items-center ms-3">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
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
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-lg-2 col-md-3 sidebar-menu p-0">
            <div class="sidebar-content">
                <div class="user-info p-4">
                    <div class="profile-img-lg bg-light d-flex align-items-center justify-content-center mx-auto mb-3">
                        <i class="bi bi-person-fill text-primary fs-3"></i>
                    </div>
                    <h5 class="text-center mb-1">{{ session('username') ?? 'Anne Williams' }}</h5>
                    <p class="text-center text-muted small mb-0">Administrator</p>
                </div>

                <div class="sidebar-nav px-3">
                    <h6 class="sidebar-title mb-3">MENU UTAMA</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="/admin">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('admin/guru*') ? 'active' : '' }}" href="/admin/guru">
                                <i class="bi bi-people me-2"></i>
                                Guru
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('admin/kelas*') ? 'active' : '' }}" href="/admin/kelas">
                                <i class="bi bi-building me-2"></i>
                                Kelas
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('admin/jadwal*') ? 'active' : '' }}" href="/admin/jadwal">
                                <i class="bi bi-calendar-week me-2"></i>
                                Jadwal
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->is('admin/siswa*') ? 'active' : '' }}" href="/admin/siswa">
                                <i class="bi bi-people-fill me-2"></i>
                                Siswa
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="#">
                                <i class="bi bi-chat me-2"></i>
                                Chat
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear me-2"></i>
                                Setting
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-question-circle me-2"></i>
                                Help
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10 col-md-9 main-content p-4">
            <!-- Header Content -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="fw-bold">Dashboard</h2>
                        <div class="d-flex align-items-center">
                            <div id="serverTime" class="me-3 text-muted small">
                                {{ date('l, d F Y H:i:s') }}
                            </div>
                            <div class="search-bar-mobile d-lg-none">
                                <div class="input-group search-group">
                                    <span class="input-group-text bg-transparent border-0">
                                        <i class="bi bi-search text-secondary"></i>
                                    </span>
                                    <input type="text" class="form-control search-input" placeholder="Search Here...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Modern - DATA REAL -->
            <div class="row mb-4">
                <!-- TOTAL PENGGUNA Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern follows-card">
                        <div class="card-header">
                            <h6 class="mb-0">TOTAL PENGGUNA</h6>
                            <div class="number">{{ $stats['total_pengguna'] ?? 0 }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total pengguna yang terdaftar dalam sistem</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="bi bi-people-fill fs-4 text-primary"></i>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bi bi-arrow-up-circle me-1"></i>
                                        {{ $stats['total_pengguna'] ?? 0 }} Pengguna
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/admin/guru" class="small text-decoration-none">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TOTAL KEGIATAN Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern views-card">
                        <div class="card-header">
                            <h6 class="mb-0">TOTAL KEGIATAN</h6>
                            <div class="number">{{ $stats['total_kegiatan'] ?? 0 }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total kegiatan mengajar yang tercatat</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="bi bi-calendar-check fs-4 text-info"></i>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bi bi-clipboard-check me-1"></i>
                                        {{ $stats['total_kegiatan'] ?? 0 }} Kegiatan
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/admin/laporan/kegiatan" class="small text-decoration-none">
                                <i class="bi bi-eye me-1"></i>Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TOTAL GURU Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern score-card">
                        <div class="card-header">
                            <h6 class="mb-0">TOTAL GURU</h6>
                            <div class="number">{{ $stats['total_guru'] ?? 0 }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total guru yang aktif dalam sistem</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="bi bi-person-badge fs-4 text-warning"></i>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bi bi-person-check me-1"></i>
                                        {{ $stats['total_guru'] ?? 0 }} Guru
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/admin/guru" class="small text-decoration-none">
                                <i class="bi bi-eye me-1"></i>Lihat Daftar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TOTAL SISWA Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern subscriptions-card">
                        <div class="card-header">
                            <h6 class="mb-0">TOTAL SISWA</h6>
                            <div class="number">{{ $stats['total_siswa'] ?? 0 }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total siswa yang terdaftar dalam sistem</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="bi bi-people fs-4 text-success"></i>
                                </div>
                                <div class="text-end">
                                    <small class="text-success">
                                        <i class="bi bi-person-plus me-1"></i>
                                        {{ $stats['total_siswa'] ?? 0 }} Siswa
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/admin/siswa" class="small text-decoration-none">
                                <i class="bi bi-eye me-1"></i>Lihat Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Cards -->
            <div class="row mb-4">
                <!-- TOTAL KELAS Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern">
                        <div class="card-header" style="border-bottom: 3px solid #4361ee;">
                            <h6 class="mb-0">TOTAL KELAS</h6>
                            <div class="number" style="color: #4361ee;">{{ $stats['total_kelas'] ?? 0 }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total kelas yang terdaftar</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="bi bi-building fs-4" style="color: #4361ee;"></i>
                                </div>
                                <div class="text-end">
                                    <a href="/admin/kelas" class="btn btn-sm btn-outline-primary">
                                        Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOTAL JADWAL Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern">
                        <div class="card-header" style="border-bottom: 3px solid #4cc9f0;">
                            <h6 class="mb-0">TOTAL JADWAL</h6>
                            <div class="number" style="color: #4cc9f0;">{{ $stats['total_jadwal'] ?? 0 }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total jadwal mengajar</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <i class="bi bi-calendar-week fs-4" style="color: #4cc9f0;"></i>
                                </div>
                                <div class="text-end">
                                    <a href="/admin/jadwal" class="btn btn-sm btn-outline-info">
                                        Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATISTIK BULAN INI -->
                <div class="col-xl-6 col-lg-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Statistik Bulan Ini</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                @php
                                    $bulanIni = date('m');
                                    $tahunIni = date('Y');
                                    
                                    // Hitung kegiatan bulan ini (contoh, bisa disesuaikan)
                                    $kegiatanBulanIni = DB::table('kegiatan_mengajar')
                                        ->whereMonth('tanggal', $bulanIni)
                                        ->whereYear('tanggal', $tahunIni)
                                        ->count();
                                        
                                    $kehadiranBulanIni = DB::table('kehadiran_siswa')
                                        ->join('kegiatan_mengajar', 'kehadiran_siswa.kegiatan_id', '=', 'kegiatan_mengajar.id')
                                        ->whereMonth('kegiatan_mengajar.tanggal', $bulanIni)
                                        ->whereYear('kegiatan_mengajar.tanggal', $tahunIni)
                                        ->count();
                                @endphp
                                <div class="col-3">
                                    <div class="p-3 rounded" style="background: rgba(67, 97, 238, 0.1);">
                                        <h3 class="mb-0">{{ $kegiatanBulanIni }}</h3>
                                        <small>Kegiatan</small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="p-3 rounded" style="background: rgba(76, 201, 240, 0.1);">
                                        <h3 class="mb-0">{{ $kehadiranBulanIni }}</h3>
                                        <small>Kehadiran</small>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="p-3 rounded" style="background: rgba(247, 37, 133, 0.1);">
                                        <h3 class="mb-0">{{ date('F Y') }}</h3>
                                        <small>Periode</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Additional Info -->
            <div class="row">
                <!-- Left Column - Data Real -->
                <div class="col-lg-8 mb-4">
                    <!-- DISTRIBUSI SISWA PER KELAS -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Distribusi Siswa per Kelas</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $kelasSiswa = DB::table('kelas')
                                    ->leftJoin('siswa', 'kelas.id', '=', 'siswa.kelas_id')
                                    ->select('kelas.nama_kelas', DB::raw('COUNT(siswa.id) as jumlah_siswa'))
                                    ->groupBy('kelas.id', 'kelas.nama_kelas')
                                    ->orderBy('kelas.nama_kelas')
                                    ->get();
                                
                                $maxSiswa = $kelasSiswa->max('jumlah_siswa') ?? 1;
                            @endphp
                            
                            <div class="bar-chart-real">
                                <div class="row text-center">
                                    @foreach($kelasSiswa as $kelas)
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" 
                                                 style="height: {{ ($kelas->jumlah_siswa / $maxSiswa) * 100 }}%;
                                                        background: linear-gradient(to top, #4361ee, #4cc9f0);">
                                            </div>
                                            <small>{{ $kelas->nama_kelas }}</small>
                                            <div class="mt-1">
                                                <small class="fw-bold">{{ $kelas->jumlah_siswa }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KEGIATAN TERBARU -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Kegiatan Mengajar Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $kegiatanTerbaru = DB::table('kegiatan_mengajar as km')
                                    ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
                                    ->join('guru as g', 'jm.guru_id', '=', 'g.id')
                                    ->join('kelas as k', 'jm.kelas_id', '=', 'k.id')
                                    ->orderBy('km.tanggal', 'desc')
                                    ->limit(8)
                                    ->select('km.tanggal', 'g.nama as guru', 'k.nama_kelas', 'jm.mata_pelajaran', 'km.materi')
                                    ->get();
                            @endphp
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Mapel</th>
                                            <th>Materi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kegiatanTerbaru as $kegiatan)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($kegiatan->tanggal)) }}</td>
                                            <td>{{ $kegiatan->guru }}</td>
                                            <td>{{ $kegiatan->nama_kelas }}</td>
                                            <td>{{ $kegiatan->mata_pelajaran }}</td>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                                    {{ $kegiatan->materi }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada kegiatan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Calendar and Activity -->
                <div class="col-lg-4">
                    <!-- Calendar -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Kalender</h5>
                        </div>
                        <div class="card-body">
                            <div class="calendar-widget">
                                <div class="calendar-header">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <button class="btn btn-sm btn-outline-secondary" id="prevMonth">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <h6 class="mb-0" id="currentMonth">{{ date('F Y') }}</h6>
                                        <button class="btn btn-sm btn-outline-secondary" id="nextMonth">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="calendar-body">
                                    <div class="weekdays row text-center mb-2">
                                        <div class="col p-1"><small>M</small></div>
                                        <div class="col p-1"><small>S</small></div>
                                        <div class="col p-1"><small>S</small></div>
                                        <div class="col p-1"><small>R</small></div>
                                        <div class="col p-1"><small>K</small></div>
                                        <div class="col p-1"><small>J</small></div>
                                        <div class="col p-1"><small>S</small></div>
                                    </div>
                                    <div class="days row" id="calendarDays">
                                        <!-- Calendar akan diisi oleh JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas Terbaru - DATA REAL -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            @if(isset($aktivitas) && $aktivitas->count() > 0)
                            <div class="timeline">
                                @foreach($aktivitas as $index => $act)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ 
                                        $index % 3 == 0 ? 'primary' : 
                                        ($index % 3 == 1 ? 'success' : 'info') 
                                    }}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">
                                                @php
                                                    $icon = 'bi-info-circle';
                                                    $color = 'secondary';
                                                    
                                                    if (str_contains($act->aktivitas, 'Login')) {
                                                        $icon = 'bi-box-arrow-in-right';
                                                        $color = 'success';
                                                    } elseif (str_contains($act->aktivitas, 'Logout')) {
                                                        $icon = 'bi-box-arrow-right';
                                                        $color = 'danger';
                                                    } elseif (str_contains($act->aktivitas, 'Menambah')) {
                                                        $icon = 'bi-plus-circle';
                                                        $color = 'primary';
                                                    } elseif (str_contains($act->aktivitas, 'Mengedit')) {
                                                        $icon = 'bi-pencil-square';
                                                        $color = 'warning';
                                                    } elseif (str_contains($act->aktivitas, 'Menghapus')) {
                                                        $icon = 'bi-trash';
                                                        $color = 'danger';
                                                    }
                                                @endphp
                                                <i class="bi {{ $icon }} text-{{ $color }} me-1"></i>
                                                {{ $act->username ?? 'System' }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($act->created_at)->format('H:i') }}
                                            </small>
                                        </div>
                                        <p class="mb-0 small text-muted">
                                            {{ $act->aktivitas }}
                                        </p>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($act->created_at)->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="bi bi-clock-history display-4 text-muted opacity-25"></i>
                                <p class="text-muted mt-2">Belum ada aktivitas</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap');

:root {
    --primary-color: #4361ee;
    --secondary-color: #3a0ca3;
    --success-color: #4cc9f0;
    --info-color: #4895ef;
    --warning-color: #f72585;
    --follows-color: #4361ee;
    --views-color: #4cc9f0;
    --score-color: #f72585;
    --subscriptions-color: #7209b7;
}

body {
    font-family: 'Montserrat', sans-serif;
    background-color: #f8f9fa;
}

/* Navbar */
.navbar-glow {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
}

/* Search Bar */
.search-bar .search-group {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    padding: 8px 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.search-input {
    background: transparent;
    border: none;
    color: white;
    font-family: 'Raleway', sans-serif;
}

.search-input:focus {
    background: transparent;
    color: white;
    box-shadow: none;
    border: none;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Sidebar */
.sidebar-menu {
    background: white;
    height: calc(100vh - 76px);
    position: sticky;
    top: 76px;
    border-right: 1px solid #e9ecef;
    box-shadow: 2px 0 10px rgba(0,0,0,0.05);
}

.sidebar-content {
    height: 100%;
    overflow-y: auto;
}

.user-info {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    color: white;
    margin-bottom: 20px;
}

.profile-img-lg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
}

.sidebar-title {
    color: #6c757d;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-nav .nav-link {
    color: #495057;
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
    font-family: 'Raleway', sans-serif;
    font-weight: 500;
}

.sidebar-nav .nav-link:hover {
    background: rgba(67, 97, 238, 0.1);
    color: #4361ee;
    transform: translateX(5px);
}

.sidebar-nav .nav-link.active {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    color: white;
    box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
}

.sidebar-nav .nav-link i {
    width: 20px;
    text-align: center;
}

/* Modern Stats Cards */
.stats-card-modern {
    background: white;
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    overflow: hidden;
}

.stats-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

.stats-card-modern .card-header {
    background: transparent;
    border-bottom: 3px solid;
    padding: 20px 20px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stats-card-modern .card-header h6 {
    font-family: 'Raleway', sans-serif;
    font-weight: 600;
    color: #495057;
    margin: 0;
    font-size: 0.9rem;
}

.number {
    font-size: 2rem;
    font-weight: 700;
    font-family: 'Montserrat', sans-serif;
}

.follows-card .card-header { border-color: var(--follows-color); }
.follows-card .number { color: var(--follows-color); }

.views-card .card-header { border-color: var(--views-color); }
.views-card .number { color: var(--views-color); }

.score-card .card-header { border-color: var(--score-color); }
.score-card .number { color: var(--score-color); }

.subscriptions-card .card-header { border-color: var(--subscriptions-color); }
.subscriptions-card .number { color: var(--subscriptions-color); }

.stats-card-modern .card-body {
    padding: 15px 20px;
}

.stats-card-modern .card-text {
    font-size: 0.875rem;
    line-height: 1.5;
    color: #6c757d;
    font-family: 'Raleway', sans-serif;
    margin-bottom: 0.5rem;
}

.stats-card-modern .card-footer {
    background: transparent;
    border-top: 1px solid #e9ecef;
    padding: 10px 20px;
    font-family: 'Raleway', sans-serif;
}

.stats-card-modern .card-footer a {
    color: #4361ee;
    font-weight: 500;
}

.stats-card-modern .card-footer a:hover {
    color: #3a0ca3;
}

/* Bar Chart Real */
.bar-chart-real .bar-wrapper {
    height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
}

.bar-chart-real .bar {
    width: 30px;
    min-height: 10px;
    background: linear-gradient(to top, #4361ee, #4cc9f0);
    border-radius: 10px 10px 0 0;
    transition: all 0.3s ease;
    margin-bottom: 5px;
}

.bar-chart-real .bar:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

/* Calendar */
.calendar-widget .weekdays {
    font-weight: 600;
    color: #495057;
    background: #f8f9fa;
    border-radius: 5px;
    padding: 5px 0;
}

.calendar-widget .day {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 2px auto;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    cursor: pointer;
    font-weight: 500;
}

.calendar-widget .day:hover {
    background: rgba(67, 97, 238, 0.1);
    color: #4361ee;
}

.calendar-widget .current-day {
    background: #4361ee;
    color: white;
    box-shadow: 0 2px 5px rgba(67, 97, 238, 0.3);
}

.calendar-widget .has-event {
    position: relative;
}

.calendar-widget .has-event::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 4px;
    background: #f72585;
    border-radius: 50%;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 15px;
}

.timeline-marker {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 10px;
}

/* Profile */
.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.profile-img:hover {
    transform: scale(1.1);
    box-shadow: 0 0 15px rgba(255,255,255,0.5);
}

/* Table */
.table th {
    font-weight: 600;
    color: #495057;
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: rgba(67, 97, 238, 0.05);
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar-menu {
        height: auto;
        position: static;
    }
    
    .main-content {
        padding: 15px;
    }
    
    .number {
        font-size: 1.5rem;
    }
    
    .bar-chart-real .bar {
        width: 20px;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stats-card-modern {
    animation: fadeInUp 0.6s ease;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 5px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
/* ======================== */
/* SOLUSI PALING AMAN: Sticky dengan Fixed */
/* ======================== */

/* Navbar tetap fixed */
.navbar-glow {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    height: 60px;
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
}

/* Sidebar juga fixed */
.sidebar-menu {
    position: fixed;
    top: 60px;
    left: 0;
    bottom: 0;
    width: 16.6667%;
    overflow-y: auto;
    z-index: 1020;
    background: white;
    border-right: 1px solid #e9ecef;
    box-shadow: 2px 0 10px rgba(0,0,0,0.05);
}

/* Main content offset */
.main-content {
    margin-left: 16.6667%;
    padding: 20px;
    padding-top: 80px; /* Navbar + sedikit spacing */
    min-height: 100vh;
    background: #f8f9fa;
}

/* Buat body bisa scroll penuh */
body {
    padding-top: 0;
    margin: 0;
    height: auto;
}

/* Responsive */
@media (max-width: 1199.98px) {
    .sidebar-menu {
        width: 200px;
    }
    .main-content {
        margin-left: 200px;
    }
}

@media (max-width: 991.98px) {
    .sidebar-menu {
        width: 180px;
    }
    .main-content {
        margin-left: 180px;
    }
}

@media (max-width: 767.98px) {
    .navbar-glow {
        height: 56px;
    }
    
    .sidebar-menu {
        top: 56px;
        width: 250px;
        left: -100%;
        transition: left 0.3s ease;
    }
    
    .sidebar-menu.show {
        left: 0;
    }
    
    .main-content {
        margin-left: 0;
        width: 100%;
        padding-top: 70px;
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Update live time
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const dateStr = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        $('#serverTime').text(dateStr + ' ' + timeStr);
    }

    setInterval(updateTime, 1000);
    updateTime();

    // Calendar functionality
    let currentDate = new Date();
    
    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        // Update month display
        $('#currentMonth').text(monthNames[month] + ' ' + year);
        
        // Get first day of month
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; // Adjust for Monday start
        
        // Clear previous days
        $('#calendarDays').empty();
        
        // Add empty cells for days before first day of month
        for (let i = 0; i < startingDay; i++) {
            $('#calendarDays').append('<div class="col p-1 text-center"></div>');
        }
        
        // Add days of the month
        const today = new Date();
        const isToday = (day) => {
            return day === today.getDate() && 
                   month === today.getMonth() && 
                   year === today.getFullYear();
        };
        
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = $('<div class="col p-1 text-center"></div>');
            const dayDiv = $('<div class="day"></div>').text(day);
            
            if (isToday(day)) {
                dayDiv.addClass('current-day');
            }
            
            // Check if there are events on this day (you can implement API call here)
            // For now, we'll just add random events for demo
            if (Math.random() > 0.7) {
                dayDiv.addClass('has-event');
            }
            
            dayElement.append(dayDiv);
            $('#calendarDays').append(dayElement);
        }
    }
    
    // Initial calendar render
    renderCalendar(currentDate);
    
    // Month navigation
    $('#prevMonth').click(function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });
    
    $('#nextMonth').click(function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });
    
    // Search functionality
    $('.search-input').on('keypress', function(e) {
        if (e.which === 13) {
            const query = $(this).val().trim();
            if (query) {
                alert('Searching for: ' + query);
                // Implement actual search functionality here
            }
        }
    });
    
    // Stats card click
    $('.stats-card-modern').on('click', function() {
        const cardTitle = $(this).find('.card-header h6').text().trim();
        let redirectUrl = '/admin';
        
        switch(cardTitle) {
            case 'TOTAL PENGGUNA':
            case 'TOTAL GURU':
                redirectUrl = '/admin/guru';
                break;
            case 'TOTAL SISWA':
                redirectUrl = '/admin/siswa';
                break;
            case 'TOTAL KELAS':
                redirectUrl = '/admin/kelas';
                break;
            case 'TOTAL JADWAL':
                redirectUrl = '/admin/jadwal';
                break;
            case 'TOTAL KEGIATAN':
                redirectUrl = '/admin/laporan/kegiatan';
                break;
        }
        
        window.location.href = redirectUrl;
    });
    
    // Animate numbers
    $('.number').each(function() {
        const $this = $(this);
        const finalValue = parseInt($this.text());
        const duration = 1500;
        const step = 20;
        const increment = finalValue / (duration / step);
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= finalValue) {
                $this.text(finalValue);
                clearInterval(timer);
            } else {
                $this.text(Math.floor(current));
            }
        }, step);
    });
});
</script>
@endsection