<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - UKK RPL</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --secondary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            --warning-gradient: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-primary: 0 10px 20px rgba(106, 17, 203, 0.2);
            --shadow-light: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 10px;
        }

        /* Navbar Modern */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            padding-left: 45px;
        }

        .navbar-brand img {
            width: 35px;
            height: 35px;
            margin-right: 10px;
            border-radius: 10px;
            box-shadow: var(--shadow-primary);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin-right: 10px;
            box-shadow: var(--shadow-primary);
        }

        /* Sidebar Modern */
        .sidebar-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.05);
            min-height: calc(100vh - 80px);
            border-radius: 0 20px 20px 0;
            margin: 10px;
            padding: 20px 0;
        }

        .sidebar-profile {
            text-align: center;
            padding: 30px 20px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, rgba(106, 17, 203, 0.1) 0%, rgba(37, 117, 252, 0.1) 100%);
            border-radius: 15px;
            margin: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin: 0 auto 15px;
            box-shadow: var(--shadow-primary);
        }

        .sidebar-nav {
            padding: 0 20px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px 0;
            color: #555;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(106, 17, 203, 0.1) 0%, rgba(37, 117, 252, 0.1) 100%);
            color: #6a11cb;
            transform: translateX(5px);
        }

        .sidebar-nav a i {
            width: 25px;
            font-size: 1.2rem;
        }

        /* Stat Cards Modern */
        .stat-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            box-shadow: var(--shadow-light);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.9;
        }

        .stat-card-content {
            position: relative;
            z-index: 1;
            padding: 25px;
            color: white;
        }

        /* Main Content Area */
        .main-content {
            padding: 20px;
            min-height: calc(100vh - 80px);
        }

        .page-header {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-light);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary-gradient);
        }

        /* Cards Modern */
        .modern-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .modern-card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .modern-card-body {
            padding: 20px;
        }

        /* List Items Modern */
        .list-item-modern {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px;
            transition: all 0.3s ease;
        }

        .list-item-modern:hover {
            background: linear-gradient(90deg, rgba(106, 17, 203, 0.05) 0%, rgba(37, 117, 252, 0.05) 100%);
            transform: translateX(5px);
        }

        .list-item-modern:last-child {
            border-bottom: none;
        }

        /* Quick Actions */
        .quick-action-btn {
            background: white;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .quick-action-btn:hover {
            border-color: #6a11cb;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(106, 17, 203, 0.2);
        }

        .quick-action-btn i {
            font-size: 24px;
            margin-bottom: 10px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Progress Bar */
        .progress-modern {
            height: 8px;
            border-radius: 4px;
            background: rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .progress-modern-bar {
            background: var(--primary-gradient);
            transition: width 1.5s ease-in-out;
        }

        /* Badges Modern */
        .badge-modern {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            background: var(--primary-gradient);
            color: white;
        }

        /* Footer */
        .footer-modern {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: var(--shadow-light);
            text-align: center;
            color: #666;
        }

        /* Loading Indicator */
        .loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            z-index: 9999;
            transform: translateX(-100%);
        }

        .loading-indicator.loaded {
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-glass {
                min-height: auto;
                margin: 10px;
                border-radius: 15px;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .stat-card {
                margin-bottom: 15px;
            }
        }

        /* Simple animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.5s ease-out;
        }
    </style>
</head>
<body>
    <!-- Loading Indicator -->
    <div class="loading-indicator" id="loadingIndicator"></div>
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container-fluid px-4">
           <a class="navbar-brand" href="/guru/dashboard">
    <img src="{{ asset('image-removebg-preview.png') }}" 
         alt="Logo SMK"
         style="width: 35px; height: 35px; margin-right: 10px;"
         id="schoolLogo"
         onerror="showLogoFallback()">
    <strong>Catatan Mengajar</strong>
</a>
            
            <div class="d-flex align-items-center">
                <div class="me-3 text-end d-none d-md-block">
                   
                    <div class="d-inline-block">
                        <span class="fw-medium text-dark">{{ $guru->nama }}</span>
                        <div>
                            <small class="badge-modern">{{ session('peran') }}</small>
                        </div>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger px-3">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-5 pt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block">
                <div class="sidebar-glass animate-fadeIn">
                    <div class="sidebar-profile">
                        <div class="profile-avatar">
                            {{ strtoupper(substr($guru->nama, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold mb-1">{{ $guru->nama }}</h6>
                        <small class="text-muted">{{ $guru->nip ?? 'NIP: -' }}</small>
                        <div class="progress-modern mt-3">
                            <div class="progress-modern-bar" style="width: {{ min(($total_kegiatan / 100) * 100, 100) }}%"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">Progress Kegiatan</small>
                    </div>
                    
                    <nav class="sidebar-nav">
                        <a href="/guru/dashboard" class="active">
                            <i class="bi bi-speedometer2"></i>
                            <span class="ms-3">Dashboard</span>
                        </a>
                        <a href="/guru/kegiatan">
                            <i class="bi bi-journal-text"></i>
                            <span class="ms-3">Kegiatan Mengajar</span>
                        </a>
                        <a href="/guru/laporan-bulanan">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span class="ms-3">Laporan Bulanan</span>
                        </a>
                        <a href="/guru/jadwal">
                            <i class="bi bi-calendar-week"></i>
                            <span class="ms-3">Jadwal Saya</span>
                        </a>
                        <a href="/guru/profil">
                            <i class="bi bi-person"></i>
                            <span class="ms-3">Profil Saya</span>
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto">
                <div class="main-content">
                    <!-- Flash Messages -->
                    <div class="row mb-4">
                        <div class="col-12">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none;">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Page Header -->
                    <div class="page-header animate-slideUp">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="fw-bold mb-2">
                                    <i class="bi bi-speedometer2 me-2" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                    Dashboard Guru
                                </h3>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar-date me-1"></i> 
                                    {{ date('d F Y') }} | 
                                    <span class="badge-modern">{{ $hari_nama }}</span>
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="/guru/kegiatan/create" class="btn btn-primary px-4" style="background: var(--primary-gradient); border: none;">
                                        <i class="bi bi-plus-circle me-1"></i> Input Kegiatan
                                    </a>
                                    <a href="/guru/kegiatan" class="btn btn-outline-primary px-4">
                                        <i class="bi bi-journal-text me-1"></i> Lihat Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Statistik -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card animate-slideUp" style="animation-delay: 0.1s">
                                <div class="stat-card-bg" style="background: var(--primary-gradient);"></div>
                                <div class="stat-card-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Total Kegiatan</h6>
                                            <h2 class="mb-0 fw-bold">{{ $total_kegiatan }}</h2>
                                        </div>
                                        <i class="bi bi-journal-text fs-1 opacity-75"></i>
                                    </div>
                                    <small class="opacity-75">Catatan mengajar tersimpan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card animate-slideUp" style="animation-delay: 0.2s">
                                <div class="stat-card-bg" style="background: var(--success-gradient);"></div>
                                <div class="stat-card-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Total Jadwal</h6>
                                            <h2 class="mb-0 fw-bold">{{ $total_jadwal }}</h2>
                                        </div>
                                        <i class="bi bi-calendar-check fs-1 opacity-75"></i>
                                    </div>
                                    <small class="opacity-75">Jadwal mengajar aktif</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card animate-slideUp" style="animation-delay: 0.3s">
                                <div class="stat-card-bg" style="background: var(--warning-gradient);"></div>
                                <div class="stat-card-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Hari Ini</h6>
                                            <h2 class="mb-0 fw-bold">{{ count($jadwal_hari_ini) }}</h2>
                                        </div>
                                        <i class="bi bi-calendar-day fs-1 opacity-75"></i>
                                    </div>
                                    <small class="opacity-75">Jadwal hari ini</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card animate-slideUp" style="animation-delay: 0.4s">
                                <div class="stat-card-bg" style="background: var(--info-gradient);"></div>
                                <div class="stat-card-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Status Akun</h6>
                                            <h2 class="mb-0 fw-bold">Aktif</h2>
                                        </div>
                                        <i class="bi bi-shield-check fs-1 opacity-75"></i>
                                    </div>
                                    <small class="opacity-75">Sistem UKK RPL</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Jadwal Hari Ini -->
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="modern-card animate-slideUp">
                                <div class="modern-card-header">
                                    <h5 class="mb-0">
                                        <i class="bi bi-calendar-day me-2" style="color: #6a11cb;"></i>
                                        Jadwal Mengajar Hari Ini
                                    </h5>
                                </div>
                                <div class="modern-card-body">
                                    @if(count($jadwal_hari_ini) > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($jadwal_hari_ini as $jadwal)
                                        <div class="list-item-modern">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-semibold mb-1">
                                                        {{ $jadwal->mata_pelajaran }}
                                                        <span class="badge bg-primary bg-opacity-10 text-primary ms-2">
                                                            Jam ke-{{ $jadwal->jam_ke }}
                                                        </span>
                                                    </h6>
                                                    <div class="d-flex align-items-center text-muted mb-2">
                                                        <small class="me-3">
                                                            <i class="bi bi-clock me-1"></i>
                                                            {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }}
                                                        </small>
                                                        <small>
                                                            <i class="bi bi-house-door me-1"></i>
                                                            {{ $jadwal->nama_kelas }}
                                                        </small>
                                                    </div>
                                                    @if(isset($jadwal->keterangan) && !empty(trim($jadwal->keterangan)))
                                                    <small class="text-info">
                                                        <i class="bi bi-info-circle me-1"></i> 
                                                        {{ $jadwal->keterangan }}
                                                    </small>
                                                    @endif
                                                </div>
                                                <a href="/guru/kegiatan/create" class="btn btn-sm btn-primary px-3" style="background: var(--primary-gradient); border: none;">
                                                    <i class="bi bi-plus-circle me-1"></i> Input
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-calendar-x display-4 text-muted mb-3"></i>
                                        <h6 class="text-muted mb-2">Tidak ada jadwal hari ini</h6>
                                        <p class="text-muted small">Silakan cek jadwal Anda untuk hari lainnya</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="col-lg-4">
                            <div class="modern-card animate-slideUp" style="animation-delay: 0.2s">
                                <div class="modern-card-header">
                                    <h5 class="mb-0">
                                        <i class="bi bi-lightning-charge me-2" style="color: #f7971e;"></i>
                                        Aksi Cepat
                                    </h5>
                                </div>
                                <div class="modern-card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <a href="/guru/kegiatan/create" class="quick-action-btn d-block">
                                                <i class="bi bi-journal-plus"></i>
                                                <span class="d-block mt-2 fw-medium">Input Kegiatan</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="/guru/jadwal" class="quick-action-btn d-block">
                                                <i class="bi bi-calendar2-week"></i>
                                                <span class="d-block mt-2 fw-medium">Lihat Jadwal</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="/guru/kegiatan" class="quick-action-btn d-block">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span class="d-block mt-2 fw-medium">Kegiatan Saya</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="/guru/profil" class="quick-action-btn d-block">
                                                <i class="bi bi-person-gear"></i>
                                                <span class="d-block mt-2 fw-medium">Profil Saya</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kegiatan Terbaru -->
                    <div class="modern-card mb-4 animate-slideUp">
                        <div class="modern-card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history me-2" style="color: #00b09b;"></i>
                                Kegiatan Mengajar Terbaru
                            </h5>
                            <a href="/guru/kegiatan" class="btn btn-sm btn-link text-decoration-none" style="color: #6a11cb;">
                                Lihat semua <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="modern-card-body">
                            @if($kegiatan_terbaru->count() > 0)
                            <div class="row g-4">
                                @foreach($kegiatan_terbaru as $kegiatan)
                                <div class="col-md-6 col-lg-4">
                                    <div class="modern-card h-100" style="box-shadow: none; border: 1px solid rgba(0,0,0,0.05);">
                                        <div class="modern-card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h6 class="fw-semibold mb-0 text-truncate">{{ $kegiatan->mata_pelajaran }}</h6>
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    {{ date('H:i', strtotime($kegiatan->created_at)) }}
                                                </span>
                                            </div>
                                            <small class="text-muted d-block mb-2">
                                                <i class="bi bi-calendar me-1"></i> {{ $kegiatan->tanggal }}
                                            </small>
                                            <small class="text-muted d-block mb-3">
                                                <i class="bi bi-house-door me-1"></i> {{ $kegiatan->nama_kelas }}
                                            </small>
                                            <p class="mb-2 small">
                                                <strong>Materi:</strong> {{ Str::limit($kegiatan->materi, 60) }}
                                            </p>
                                            @if(isset($kegiatan->catatan) && !empty($kegiatan->catatan))
                                            <div class="mt-3 p-2 bg-light rounded">
                                                <small class="text-muted">
                                                    <i class="bi bi-chat-left-text me-1"></i> 
                                                    {{ Str::limit($kegiatan->catatan, 50) }}
                                                </small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="bi bi-journal-x display-4 text-muted mb-3"></i>
                                <h6 class="text-muted mb-2">Belum ada kegiatan</h6>
                                <p class="text-muted small mb-3">Mulai dengan membuat kegiatan mengajar pertama Anda</p>
                                <a href="/guru/kegiatan/create" class="btn btn-primary" style="background: var(--primary-gradient); border: none;">
                                    <i class="bi bi-plus-circle me-1"></i> Buat Kegiatan
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Informasi & Footer -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modern-card h-100">
                                <div class="modern-card-header">
                                    <h6 class="mb-0">
                                        <i class="bi bi-info-circle me-2" style="color: #4facfe;"></i>
                                        Informasi Sistem
                                    </h6>
                                </div>
                                <div class="modern-card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-3 d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-3 fs-5"></i>
                                            <div>
                                                <small class="text-muted">Login terakhir</small>
                                                <div class="fw-medium">{{ date('d/m/Y H:i') }}</div>
                                            </div>
                                        </li>
                                        <li class="mb-3 d-flex align-items-center">
                                            <i class="bi bi-calendar-check me-3 fs-5" style="color: #6a11cb;"></i>
                                            <div>
                                                <small class="text-muted">Hari aktif</small>
                                                <div class="fw-medium">Senin - Jumat</div>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <i class="bi bi-shield-check me-3 fs-5" style="color: #00b09b;"></i>
                                            <div>
                                                <small class="text-muted">Status sistem</small>
                                                <div class="fw-medium">UKK RPL 2026 - Sistem Valid</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="footer-modern">
                                <div class="mb-3">
                                    <i class="bi bi-c-circle me-1"></i>
                                    <span>2026 Aplikasi Catatan Mengajar Guru - UKK RPL</span>
                                </div>
                                <div class="small text-muted">
                                    Versi 1.0 | User: {{ session('username') }}
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        SMK Muhammadiyah 04 - Sistem Informasi Manajemen Guru
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Simple and optimized JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
        
        // Hide loading indicator
        setTimeout(function() {
            const loader = document.getElementById('loadingIndicator');
            if (loader) {
                loader.classList.add('loaded');
                setTimeout(function() {
                    if (loader.parentNode) {
                        loader.parentNode.removeChild(loader);
                    }
                }, 300);
            }
        }, 500);
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.classList.remove('show');
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 150);
            });
        }, 5000);
        
        // Simple counter animation
        document.querySelectorAll('.stat-card-content h2').forEach(function(stat) {
            const originalText = stat.textContent;
            const target = parseInt(originalText);
            
            if (!isNaN(target)) {
                let current = 0;
                const increment = target / 30;
                const timer = setInterval(function() {
                    current += increment;
                    if (current >= target) {
                        stat.textContent = target;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.round(current);
                    }
                }, 30);
            }
        });
        
        // Logo fallback function
        window.showLogoFallback = function() {
            const logo = document.getElementById('schoolLogo');
            if (logo) {
                logo.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="%236a11cb" rx="10"/><text x="50" y="65" font-family="Arial" font-size="45" fill="white" text-anchor="middle">S</text></svg>';
                logo.alt = 'Logo Default - SMK Muhammadiyah 04';
            }
        };
        
        // Form loading state
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i>Memproses...';
                    submitBtn.disabled = true;
                }
            });
        });
        
        // Add spin animation for loading icons
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .bi-arrow-clockwise.spin {
                animation: spin 1s linear infinite;
                display: inline-block;
            }
        `;
        document.head.appendChild(style);
        
        // Back to top button
        const backToTop = document.createElement('button');
        backToTop.innerHTML = '<i class="bi bi-chevron-up"></i>';
        backToTop.className = 'back-to-top';
        backToTop.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(106, 17, 203, 0.3);
            z-index: 1000;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            display: none;
            align-items: center;
            justify-content: center;
        `;
        document.body.appendChild(backToTop);
        
        // Show/hide back to top button
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.style.display = 'flex';
                setTimeout(function() {
                    backToTop.style.opacity = '1';
                    backToTop.style.transform = 'translateY(0)';
                }, 10);
            } else {
                backToTop.style.opacity = '0';
                backToTop.style.transform = 'translateY(20px)';
                setTimeout(function() {
                    if (parseFloat(backToTop.style.opacity) === 0) {
                        backToTop.style.display = 'none';
                    }
                }, 300);
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>