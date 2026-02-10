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

            <!-- Stats Cards Modern -->
            <div class="row mb-4">
                <!-- FOLLOWS Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern follows-card">
                        <div class="card-header">
                            <h6 class="mb-0">FOLLOWS</h6>
                            <div class="percentage">{{ $stats['total_pengguna'] ?? '25' }}%</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total pengguna yang terdaftar dalam sistem</p>
                            <div class="progress-stats">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Progress</small>
                                    <small>{{ $stats['total_pengguna'] ?? '25' }}%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_pengguna'] ?? '25' }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-success">{{ $stats['total_pengguna'] ?? '30' }}% THIS MONTH</small>
                        </div>
                    </div>
                </div>

                <!-- VIEWS Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern views-card">
                        <div class="card-header">
                            <h6 class="mb-0">VIEWS</h6>
                            <div class="percentage">{{ $stats['total_kegiatan'] ?? '30' }}%</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total kegiatan yang tercatat dalam sistem</p>
                            <div class="progress-stats">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Progress</small>
                                    <small>{{ $stats['total_kegiatan'] ?? '30' }}%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_kegiatan'] ?? '30' }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-success">{{ $stats['total_kegiatan'] ?? '50' }}% THIS MONTH</small>
                        </div>
                    </div>
                </div>

                <!-- SCORE Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern score-card">
                        <div class="card-header">
                            <h6 class="mb-0">SCORE</h6>
                            <div class="percentage">{{ $stats['total_guru'] ?? '50' }}%</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total guru yang aktif dalam sistem</p>
                            <div class="progress-stats">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Progress</small>
                                    <small>{{ $stats['total_guru'] ?? '50' }}%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_guru'] ?? '50' }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-success">{{ $stats['total_guru'] ?? '60' }}% THIS MONTH</small>
                        </div>
                    </div>
                </div>

                <!-- SUBSCRIPTIONS Card -->
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="stats-card-modern subscriptions-card">
                        <div class="card-header">
                            <h6 class="mb-0">SUBSCRIPTIONS</h6>
                            <div class="percentage">{{ $stats['total_siswa'] ?? '75' }}%</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">Total siswa yang terdaftar dalam sistem</p>
                            <div class="progress-stats">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Progress</small>
                                    <small>{{ $stats['total_siswa'] ?? '75' }}%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_siswa'] ?? '75' }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-success">{{ $stats['total_siswa'] ?? '60' }}% THIS MONTH</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Additional Info -->
            <div class="row">
                <!-- Left Column - Charts -->
                <div class="col-lg-8 mb-4">
                    <!-- VIEWS Chart -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">VIEWS</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="circle-progress me-3" data-percentage="21">
                                    <div class="circle-progress-inner">
                                        <span>21%</span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">FOLLOWS</h6>
                                    <p class="text-muted small mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="circle-progress me-3" data-percentage="35">
                                    <div class="circle-progress-inner">
                                        <span>35%</span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">SCOPE</h6>
                                    <p class="text-muted small mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="circle-progress me-3" data-percentage="28">
                                    <div class="circle-progress-inner">
                                        <span>28%</span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">VIEWS</h6>
                                    <p class="text-muted small mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SUBSCRIPTIONS Bar Chart -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">SUBSCRIPTIONS</h5>
                        </div>
                        <div class="card-body">
                            <div class="bar-chart">
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 30%"></div>
                                            <small>SUN</small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 60%"></div>
                                            <small>MON</small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 45%"></div>
                                            <small>TUE</small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 75%"></div>
                                            <small>WED</small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 50%"></div>
                                            <small>THU</small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 85%"></div>
                                            <small>FRI</small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="bar-wrapper">
                                            <div class="bar" style="height: 40%"></div>
                                            <small>SAT</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EARNING Chart -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">EARNING</h5>
                        </div>
                        <div class="card-body">
                            <div class="earning-chart">
                                <div class="row text-center">
                                    <div class="col-3">
                                        <div class="earning-item">
                                            <div class="earning-value">300</div>
                                            <small>Guru</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="earning-item">
                                            <div class="earning-value">600</div>
                                            <small>Siswa</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="earning-item">
                                            <div class="earning-value">350</div>
                                            <small>Kelas</small>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="earning-item">
                                            <div class="earning-value">400</div>
                                            <small>Jadwal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Calendar and Activity -->
                <div class="col-lg-4">
                    <!-- Calendar -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Calendar</h5>
                        </div>
                        <div class="card-body">
                            <div class="calendar-widget">
                                <div class="calendar-header">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <h6 class="mb-0">{{ date('F Y') }}</h6>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="calendar-body">
                                    <div class="weekdays row text-center mb-2">
                                        <div class="col p-1"><small>S</small></div>
                                        <div class="col p-1"><small>M</small></div>
                                        <div class="col p-1"><small>T</small></div>
                                        <div class="col p-1"><small>W</small></div>
                                        <div class="col p-1"><small>T</small></div>
                                        <div class="col p-1"><small>F</small></div>
                                        <div class="col p-1"><small>S</small></div>
                                    </div>
                                    <div class="days row">
                                        @php
                                            $firstDay = date('w', strtotime(date('Y-m-01')));
                                            $daysInMonth = date('t');
                                            $currentDay = date('j');
                                        @endphp
                                        
                                        @for($i = 0; $i < $firstDay; $i++)
                                            <div class="col p-1 text-center"></div>
                                        @endfor
                                        
                                        @for($day = 1; $day <= $daysInMonth; $day++)
                                            <div class="col p-1 text-center">
                                                <div class="day {{ $day == $currentDay ? 'current-day' : '' }}">
                                                    {{ $day }}
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas Terbaru -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            @if($aktivitas->count() > 0)
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
    border-bottom: none;
    padding: 20px 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stats-card-modern .card-header h6 {
    font-family: 'Raleway', sans-serif;
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.percentage {
    font-size: 2rem;
    font-weight: 700;
    font-family: 'Montserrat', sans-serif;
}

.follows-card .percentage { color: var(--follows-color); }
.views-card .percentage { color: var(--views-color); }
.score-card .percentage { color: var(--score-color); }
.subscriptions-card .percentage { color: var(--subscriptions-color); }

.stats-card-modern .card-body {
    padding: 20px;
}

.stats-card-modern .card-text {
    font-size: 0.875rem;
    line-height: 1.5;
    color: #6c757d;
    font-family: 'Raleway', sans-serif;
}

.stats-card-modern .card-footer {
    background: transparent;
    border-top: 1px solid #e9ecef;
    padding: 15px 20px;
    font-family: 'Raleway', sans-serif;
}

.stats-card-modern .card-footer small {
    font-weight: 600;
}

.progress {
    height: 6px;
    border-radius: 3px;
    background-color: #e9ecef;
}

.progress-bar {
    border-radius: 3px;
    transition: width 1.5s ease;
}

.follows-card .progress-bar { background: var(--follows-color); }
.views-card .progress-bar { background: var(--views-color); }
.score-card .progress-bar { background: var(--score-color); }
.subscriptions-card .progress-bar { background: var(--subscriptions-color); }

/* Circle Progress */
.circle-progress {
    width: 60px;
    height: 60px;
    position: relative;
    border-radius: 50%;
    background: conic-gradient(#4361ee var(--percentage, 0%), #e9ecef 0%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.circle-progress::before {
    content: '';
    position: absolute;
    width: 50px;
    height: 50px;
    background: white;
    border-radius: 50%;
}

.circle-progress-inner {
    position: relative;
    z-index: 1;
    text-align: center;
}

.circle-progress-inner span {
    font-size: 0.875rem;
    font-weight: 600;
    color: #495057;
}

/* Bar Chart */
.bar-chart .bar-wrapper {
    height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
}

.bar-chart .bar {
    width: 20px;
    background: linear-gradient(to top, #4361ee, #4cc9f0);
    border-radius: 10px 10px 0 0;
    transition: height 1s ease;
    margin-bottom: 5px;
}

.bar-chart .bar:hover {
    opacity: 0.8;
}

/* Earning Chart */
.earning-item {
    padding: 15px;
    border-radius: 10px;
    background: rgba(67, 97, 238, 0.1);
    transition: all 0.3s ease;
}

.earning-item:hover {
    background: rgba(67, 97, 238, 0.2);
    transform: scale(1.05);
}

.earning-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4361ee;
    margin-bottom: 5px;
}

/* Calendar */
.calendar-widget .weekdays {
    font-weight: 600;
    color: #495057;
}

.calendar-widget .day {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    cursor: pointer;
}

.calendar-widget .day:hover {
    background: rgba(67, 97, 238, 0.1);
}

.calendar-widget .current-day {
    background: #4361ee;
    color: white;
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

/* Responsive */
@media (max-width: 768px) {
    .sidebar-menu {
        height: auto;
        position: static;
    }
    
    .main-content {
        padding: 15px;
    }
    
    .percentage {
        font-size: 1.5rem;
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

.follows-card { animation-delay: 0.1s; }
.views-card { animation-delay: 0.2s; }
.score-card { animation-delay: 0.3s; }
.subscriptions-card { animation-delay: 0.4s; }

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
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize circle progress
    $('.circle-progress').each(function() {
        const percentage = $(this).data('percentage');
        $(this).css('--percentage', percentage * 3.6 + 'deg');
    });

    // Animate progress bars
    $('.progress-bar').each(function() {
        const width = $(this).attr('style').match(/width: (\d+)%/);
        if (width) {
            $(this).css('width', '0%').animate({
                width: width[1] + '%'
            }, 1500);
        }
    });

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

    // Calendar navigation
    $('.calendar-widget .btn').on('click', function() {
        // Implement calendar navigation
        alert('Calendar navigation would go here');
    });

    // Stats card click
    $('.stats-card-modern').on('click', function() {
        const cardType = $(this).find('.card-header h6').text();
        alert('Viewing details for: ' + cardType);
    });
});
</script>
@endsection
