@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- NAVBAR DENGAN MENU -->
<nav class="navbar navbar-glow navbar-expand-lg shadow">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-white" href="/admin">
            <i class="bi bi-laptop me-2"></i>
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
                    <li>
                        <a class="dropdown-item" href="/logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Header Dashboard -->
<div class="container-fluid px-4 pt-4">
   <!-- Welcome Section - UBAH INI -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-hover text-white animate__animated animate__fadeIn" 
             style="background: linear-gradient(135deg, #4361ee, #3a0ca3); border: none;">
            <div class="card-body py-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <!-- Welcome Message yang lebih besar dan jelas -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3 me-3">
                                <i class="bi bi-hand-wave fs-2"></i>
                            </div>
                            <div>
                                <h1 class="fw-bold mb-1" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.2);">
                                    Halo, {{ session('username') ?? 'Admin' }}! 👋
                                </h1>
                                <p class="mb-0 opacity-90" style="font-size: 1.1rem;">
                                    Selamat datang di <strong>Sistem Manajemen Catatan Mengajar Guru</strong><br>
                                    <small class="opacity-75">UKK RPL 2026 - Siap untuk Ujian Kompetensi Keahlian</small>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Quick Stats Mini -->
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <div class="bg-white bg-opacity-15 rounded-pill px-3 py-1">
                                <small>
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ date('d F Y') }}
                                </small>
                            </div>
                            <div class="bg-white bg-opacity-15 rounded-pill px-3 py-1">
                                <small>
                                    <i class="bi bi-clock me-1"></i>
                                    <span id="liveWelcomeTime">{{ date('H:i') }}</span> WIB
                                </small>
                            </div>
                            <div class="bg-white bg-opacity-15 rounded-pill px-3 py-1">
                                <small>
                                    <i class="bi bi-shield-check me-1"></i>
                                    Status: <strong class="text-success">Online</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <div class="position-relative">
                            <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                <i class="bi bi-laptop fs-1"></i>
                            </div>
                            <div class="mt-3">
                                <div class="bg-white bg-opacity-20 rounded p-2 d-inline-block">
                                    <small class="d-block opacity-90">
                                        <i class="bi bi-activity me-1"></i>
                                        Sistem Aktif
                                    </small>
                                    <small class="opacity-75">
                                        Versi 1.0.0 | UKK RPL
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Guru -->
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="stats-card animate__animated animate__fadeInUp">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Guru</h6>
                        <h2 class="fw-bold mb-0 text-primary">{{ $stats['total_guru'] }}</h2>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> Aktif
                        </small>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-people-fill text-primary fs-4"></i>
                    </div>
                </div>
                <a href="/admin/guru" class="stretched-link"></a>
            </div>
        </div>
        
        <!-- Kelas -->
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="stats-card animate__animated animate__fadeInUp animate__delay-1s">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Kelas</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $stats['total_kelas'] }}</h2>
                        <small class="text-info">
                            <i class="bi bi-building"></i> Ruang
                        </small>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-building text-success fs-4"></i>
                    </div>
                </div>
                <a href="/admin/kelas" class="stretched-link"></a>
            </div>
        </div>
        
        <!-- Siswa -->
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="stats-card animate__animated animate__fadeInUp animate__delay-2s">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Siswa</h6>
                        <h2 class="fw-bold mb-0 text-warning">{{ $stats['total_siswa'] }}</h2>
                        <small class="text-muted">
                            <i class="bi bi-person"></i> Peserta didik
                        </small>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-person-badge text-warning fs-4"></i>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
        
        <!-- Jadwal -->
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="stats-card animate__animated animate__fadeInUp animate__delay-3s">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Jadwal</h6>
                        <h2 class="fw-bold mb-0 text-info">{{ $stats['total_jadwal'] }}</h2>
                        <small class="text-primary">
                            <i class="bi bi-calendar"></i> Mengajar
                        </small>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-calendar-week text-info fs-4"></i>
                    </div>
                </div>
                <a href="/admin/jadwal" class="stretched-link"></a>
            </div>
        </div>
        
        <!-- Kegiatan -->
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="stats-card animate__animated animate__fadeInUp animate__delay-4s">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Kegiatan</h6>
                        <h2 class="fw-bold mb-0 text-danger">{{ $stats['total_kegiatan'] }}</h2>
                        <small class="text-warning">
                            <i class="bi bi-check-circle"></i> Tercatat
                        </small>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-journal-text text-danger fs-4"></i>
                    </div>
                </div>
                <a href="/guru/kegiatan" class="stretched-link"></a>
            </div>
        </div>
        
        <!-- Pengguna -->
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <div class="stats-card animate__animated animate__fadeInUp animate__delay-5s">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pengguna</h6>
                        <h2 class="fw-bold mb-0 text-secondary">{{ $stats['total_pengguna'] }}</h2>
                        <small class="text-success">
                            <i class="bi bi-shield-check"></i> Terdaftar
                        </small>
                    </div>
                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-person text-secondary fs-4"></i>
                    </div>
                </div>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="row g-4">
        <!-- Quick Actions & System Info -->
        <div class="col-lg-8">
            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card card-hover shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                                Aksi Cepat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <a href="/admin/guru" class="btn btn-primary w-100 py-3 h-100">
                                        <div class="text-center">
                                            <i class="bi bi-people-fill fs-2 mb-2"></i>
                                            <div class="fw-semibold">Kelola Guru</div>
                                            <small class="opacity-75">{{ $stats['total_guru'] }} data</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="/admin/kelas" class="btn btn-success w-100 py-3 h-100">
                                        <div class="text-center">
                                            <i class="bi bi-building fs-2 mb-2"></i>
                                            <div class="fw-semibold">Kelola Kelas</div>
                                            <small class="opacity-75">{{ $stats['total_kelas'] }} data</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="/admin/jadwal" class="btn btn-info w-100 py-3 h-100">
                                        <div class="text-center">
                                            <i class="bi bi-calendar-week fs-2 mb-2"></i>
                                            <div class="fw-semibold">Kelola Jadwal</div>
                                            <small class="opacity-75">{{ $stats['total_jadwal'] }} data</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="/logout" class="btn btn-danger w-100 py-3 h-100">
                                        <div class="text-center">
                                            <i class="bi bi-box-arrow-right fs-2 mb-2"></i>
                                            <div class="fw-semibold">Logout</div>
                                            <small class="opacity-75">Keluar sistem</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Info -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-hover shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                Informasi Sistem
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="alert alert-success py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-check-circle-fill fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">Status Sistem</h6>
                                                <p class="mb-0 small">Semua sistem berjalan normal</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                    <i class="bi bi-database me-2 text-primary"></i>
                                                    Database
                                                </span>
                                                <span class="badge bg-success">Terhubung</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                    <i class="bi bi-shield-check me-2 text-success"></i>
                                                    Keamanan
                                                </span>
                                                <span class="badge bg-success">Aktif</span>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between">
                                                <span>
                                                    <i class="bi bi-server me-2 text-info"></i>
                                                    Server
                                                </span>
                                                <span class="badge bg-success">Online</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-body">
                                            <h6 class="text-primary mb-3">
                                                <i class="bi bi-journal-bookmark-fill me-2"></i>
                                                UKK RPL 2026
                                            </h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Aplikasi Catatan Mengajar Guru
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-calendar-check-fill text-info me-2"></i>
                                                    Versi: 1.0.0
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-person-fill text-warning me-2"></i>
                                                    Login sebagai: {{ session('username') ?? 'Admin' }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-flag-fill text-danger me-2"></i>
                                                    <span class="fw-semibold">Status: Siap Uji</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Aktivitas Terbaru -->
        <div class="col-lg-4">
            <div class="card card-hover shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history text-info me-2"></i>
                        Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($aktivitas->count() > 0)
                    <div class="timeline">
                        @foreach($aktivitas as $index => $act)
                        <div class="timeline-item animate__animated animate__fadeInRight" 
                             style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="timeline-marker bg-{{ 
                                $index % 3 == 0 ? 'primary' : 
                                ($index % 3 == 1 ? 'success' : 'info') 
                            }}"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">
                                        @if(str_contains($act->aktivitas, 'Login'))
                                            <i class="bi bi-box-arrow-in-right text-success me-1"></i>
                                        @elseif(str_contains($act->aktivitas, 'Logout'))
                                            <i class="bi bi-box-arrow-right text-danger me-1"></i>
                                        @elseif(str_contains($act->aktivitas, 'Menambah'))
                                            <i class="bi bi-plus-circle text-primary me-1"></i>
                                        @elseif(str_contains($act->aktivitas, 'Mengedit'))
                                            <i class="bi bi-pencil-square text-warning me-1"></i>
                                        @elseif(str_contains($act->aktivitas, 'Menghapus'))
                                            <i class="bi bi-trash text-danger me-1"></i>
                                        @else
                                            <i class="bi bi-info-circle text-secondary me-1"></i>
                                        @endif
                                        {{ $act->username ?? 'System' }}
                                    </h6>
                                    <small class="text-muted">
                                        {{ date('H:i', strtotime($act->created_at)) }}
                                    </small>
                                </div>
                                <p class="mb-0 small text-muted">
                                    {{ $act->aktivitas }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-clock-history display-4 text-muted opacity-25"></i>
                        </div>
                        <h6 class="text-muted mb-2">Belum ada aktivitas</h6>
                        <p class="text-muted small mb-0">Aktivitas akan muncul di sini</p>
                    </div>
                    @endif
                </div>
                @if($aktivitas->count() > 0)
                <div class="card-footer bg-transparent border-0">
                    <div class="text-center">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-list-ul me-1"></i> Lihat Semua Aktivitas
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="text-center text-muted small py-3">
                <div class="d-flex justify-content-center align-items-center">
                    <i class="bi bi-c-circle me-1"></i>
                    <span>UKK RPL 2026 - Sistem Manajemen Catatan Mengajar Guru</span>
                    <span class="mx-2">•</span>
                    <span>Versi 1.0.0</span>
                    <span class="mx-2">•</span>
                    <span id="serverTime">{{ date('d F Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Styles -->
@section('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    /* CSS Tambahan untuk Profil */
.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.profile-img:hover {
    transform: scale(1.1);
    box-shadow: 0 0 15px rgba(255,255,255,0.5);
}

/* Dropdown Menu Profil */
.dropdown-menu {
    border-radius: 10px;
    border: 1px solid rgba(0,0,0,0.1);
}

.dropdown-item {
    border-radius: 5px;
    margin: 2px 5px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background: linear-gradient(90deg, rgba(67, 97, 238, 0.1), rgba(67, 97, 238, 0.05));
    transform: translateX(5px);
}

/* Welcome Card */
.welcome-card {
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

/* Live Time di Welcome */
#liveWelcomeTime {
    font-weight: bold;
    background: rgba(255,255,255,0.2);
    padding: 2px 6px;
    border-radius: 4px;
    margin: 0 2px;
}
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    
    .timeline-content {
        padding-left: 15px;
    }
    
    .stats-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    
    .stats-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--bs-primary), var(--bs-info));
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .stats-card:hover::after {
        opacity: 1;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

<!-- Additional Scripts -->
@section('scripts')
<script>
$(document).ready(function() {
    // Live time update untuk navbar
    function updateDateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        
        const dateStr = now.toLocaleDateString('id-ID', options);
        const timeStr = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        });
        
        $('#liveTime').text(timeStr);
        $('#serverTime').text(now.toLocaleDateString('id-ID', options) + ' ' + timeStr);
    }
    
    // Update live time di welcome section
    function updateWelcomeTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
        $('#liveWelcomeTime').text(timeStr);
    }
    
    // Update system time di card system info
    function updateSystemTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
        $('#systemTime').text(timeStr);
    }
    
    // Update waktu setiap detik
    setInterval(updateDateTime, 1000);
    setInterval(updateWelcomeTime, 1000);
    setInterval(updateSystemTime, 60000);
    
    // Panggil fungsi saat halaman load
    updateDateTime();
    updateWelcomeTime();
    updateSystemTime();
    
    // Stats card hover effect
    $('.stats-card').hover(
        function() {
            $(this).css('transform', 'translateY(-5px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
    
    // Notification badge animation
    $('.badge-pulse').hover(
        function() {
            $(this).css('animation', 'pulse 1s infinite');
        },
        function() {
            $(this).css('animation', 'pulse 2s infinite');
        }
    );
    
    // Auto refresh data setiap 30 detik
    let refreshInterval = setInterval(function() {
        // Simulasi update notifikasi
        const badge = $('.badge-pulse');
        if (badge.length) {
            const current = parseInt(badge.text());
            if (current < 9) {
                badge.text(current + 1);
            }
        }
    }, 30000);
    
    // Stop refresh saat keluar halaman
    $(window).on('beforeunload', function() {
        clearInterval(refreshInterval);
    });
    
    // Toast notification untuk welcome
    setTimeout(function() {
        showToast(
            'Selamat datang di Dashboard Admin UKK RPL! 🎉', 
            'success'
        );
    }, 1000);
    
    // Progress bar animation
    $('.progress-bar').each(function() {
        const width = $(this).attr('style').match(/width: (\d+)%/);
        if (width) {
            $(this).css('width', '0%').animate({
                width: width[1] + '%'
            }, 1500);
        }
    });
    
    // Smooth scroll untuk internal links
    $(document).on('click', 'a[href^="#"]', function(e) {
        if($(this.hash).length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(this.hash).offset().top - 80
            }, 800);
        }
    });
});
</script>
@endsection