<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - UKK RPL</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Color Scheme konsisten dengan dashboard */
            --primary-color: #2d3748;
            --secondary-color: #4a5568;
            --accent-color: #3182ce;
            --accent-light: #4299e1;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --sidebar-bg: #1a202c;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --text-light: #a0aec0;
            --border-color: #e2e8f0;
            --border-light: #edf2f7;
            
            /* Gradients */
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            --gradient-3: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --gradient-4: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Dosis', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            color: var(--text-primary);
        }

        /* Layout Container */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-logo img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
        }

        .user-profile {
            text-align: center;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: var(--gradient-4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 600;
            margin: 0 auto 15px;
        }

        .user-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.1);
            padding: 3px 12px;
            border-radius: 12px;
            display: inline-block;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 25px;
        }

        .nav-section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-light);
            padding: 0 20px 10px;
            letter-spacing: 0.5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left: 3px solid var(--accent-color);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-left: 3px solid var(--accent-color);
        }

        .nav-item i {
            font-size: 1.2rem;
            width: 25px;
            margin-right: 12px;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }

        /* TOP NAVBAR */
        .top-navbar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .back-btn {
            background: white;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: var(--light-bg);
            border-color: var(--accent-color);
            transform: translateX(-3px);
        }

        /* FILTER CARD */
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .period-badge {
            background: var(--gradient-1);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .stat-icon {
            font-size: 1.5rem;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* DISTRIBUSI KELAS */
        .distribution-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .kelas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .kelas-item {
            background: var(--light-bg);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .kelas-item:hover {
            background: white;
            border-color: var(--accent-color);
            box-shadow: var(--shadow-sm);
        }

        .kelas-name {
            font-weight: 500;
            color: var(--primary-color);
        }

        .kelas-count {
            background: var(--gradient-4);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* TABLE CARD */
        .table-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        .table-header {
            background: var(--light-bg);
            padding: 18px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-body {
            padding: 0;
        }

        /* TABLE STYLES */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table thead {
            background: var(--light-bg);
        }

        .custom-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background: rgba(49, 130, 206, 0.03);
        }

        .custom-table tfoot {
            background: var(--gradient-4);
            color: white;
        }

        .custom-table tfoot td {
            padding: 15px;
            font-weight: 600;
            font-size: 1rem;
        }

        /* BADGES */
        .badge-kelas {
            background: rgba(49, 130, 206, 0.1);
            color: var(--accent-color);
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-jam {
            background: rgba(247, 151, 30, 0.1);
            color: #f7971e;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        /* EXPORT BUTTONS */
        .export-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .export-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .export-btn {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .export-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--accent-color);
        }

        .export-icon {
            font-size: 1.8rem;
        }

        .export-btn-csv .export-icon {
            color: #17a2b8;
        }

        .export-btn-excel .export-icon {
            color: #28a745;
        }

        .export-btn-rekap .export-icon {
            color: #ffc107;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .empty-title {
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .empty-text {
            color: var(--text-light);
            margin-bottom: 20px;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .top-navbar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .kelas-grid {
                grid-template-columns: 1fr;
            }
            
            .custom-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="/guru/dashboard" class="sidebar-logo">
                    <img src="{{ asset('image-removebg-preview.png') }}" 
                         alt="Logo SMK"
                         id="schoolLogo"
                         onerror="showLogoFallback()">
                    <span>Catatan Mengajar</span>
                </a>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr($guru->nama, 0, 1)) }}
                </div>
                <div class="user-name">{{ $guru->nama }}</div>
                <div class="user-role">{{ session('peran') }}</div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <a href="/guru/dashboard" class="nav-item">
                        <i class="bi bi-speedometer2"></i>
                        <span class="nav-item-text">Dashboard</span>
                    </a>
                    <a href="/guru/kegiatan" class="nav-item">
                        <i class="bi bi-journal-text"></i>
                        <span class="nav-item-text">Kegiatan Mengajar</span>
                    </a>
                    <a href="/guru/laporan-bulanan" class="nav-item active">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span class="nav-item-text">Laporan Bulanan</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Lainnya</div>
                    <a href="/guru/jadwal" class="nav-item">
                        <i class="bi bi-calendar-week"></i>
                        <span class="nav-item-text">Jadwal Saya</span>
                    </a>
                    <a href="/guru/profil" class="nav-item">
                        <i class="bi bi-person"></i>
                        <span class="nav-item-text">Profil Saya</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div>
                    <h1 class="page-title">
                        <i class="bi bi-file-earmark-bar-graph me-2" style="color: var(--accent-color);"></i>
                        Laporan Bulanan
                    </h1>
                    <div class="page-subtitle">Rekap kegiatan mengajar per bulan</div>
                </div>
                
                <a href="{{ route('guru.dashboard') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <div class="filter-header">
                    <div class="filter-title">
                        <i class="bi bi-calendar-month" style="color: var(--accent-color);"></i>
                        Periode Laporan
                    </div>
                    <div class="period-badge">
                        {{ date('F Y', strtotime($tahun . '-' . $bulan . '-01')) }}
                    </div>
                </div>
                
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-muted">Bulan</label>
                        <select name="bulan" class="form-select" style="border-radius: 8px; border: 1px solid var(--border-color);">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label text-muted">Tahun</label>
                        <select name="tahun" class="form-select" style="border-radius: 8px; border: 1px solid var(--border-color);">
                            @for($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100" 
                                style="background: var(--gradient-4); border: none; border-radius: 8px; padding: 10px;">
                            <i class="bi bi-filter me-2"></i> Filter Laporan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Hari Mengajar</div>
                            <div class="stat-value">{{ $statistik['total_hari'] }}</div>
                        </div>
                        <div class="stat-icon" style="background: var(--gradient-1);">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <small class="text-muted">Total hari efektif</small>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Total Jam</div>
                            <div class="stat-value">{{ $statistik['total_jam'] }}</div>
                        </div>
                        <div class="stat-icon" style="background: var(--gradient-2);">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                    <small class="text-muted">Jam mengajar seluruhnya</small>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Rata-rata Jam/Hari</div>
                            <div class="stat-value">{{ $statistik['rata_jam'] }}</div>
                        </div>
                        <div class="stat-icon" style="background: var(--gradient-3);">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                    <small class="text-muted">Perhitungan per hari</small>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Kelas Diajar</div>
                            <div class="stat-value">{{ count($statistik['per_kelas']) }}</div>
                        </div>
                        <div class="stat-icon" style="background: var(--gradient-4);">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <small class="text-muted">Jumlah kelas berbeda</small>
                </div>
            </div>

            <!-- Distribusi per Kelas -->
            @if(count($statistik['per_kelas']) > 0)
            <div class="distribution-card">
                <h5 class="card-title">
                    <i class="bi bi-pie-chart" style="color: var(--accent-color);"></i>
                    Distribusi Kegiatan per Kelas
                </h5>
                
                <div class="kelas-grid">
                    @foreach($statistik['per_kelas'] as $kelas => $jumlah)
                    <div class="kelas-item">
                        <div>
                            <div class="kelas-name">{{ $kelas }}</div>
                            <small class="text-muted">{{ $jumlah }} kegiatan</small>
                        </div>
                        <div class="kelas-count">{{ $jumlah }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Daftar Kegiatan -->
            <div class="table-card">
                <div class="table-header">
                    <div>
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-ul me-2"></i>
                            Daftar Kegiatan
                        </h5>
                        <small class="text-muted">{{ $kegiatan->count() }} kegiatan ditemukan</small>
                    </div>
                    <div class="action-buttons">
                        <button onclick="window.print()" class="btn-icon" title="Cetak Laporan">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>
                </div>
                
                <div class="table-body">
                    @if($kegiatan->count() > 0)
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Jam</th>
                                <th>Materi</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kegiatan as $index => $item)
                            <tr>
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td>
                                    <div>{{ date('d/m/Y', strtotime($item->tanggal)) }}</div>
                                    <small class="text-muted">{{ $item->hari }}</small>
                                </td>
                                <td>
                                    <span class="badge-kelas">{{ $item->nama_kelas }}</span>
                                </td>
                                <td>{{ $item->mata_pelajaran }}</td>
                                <td>
                                    <span class="badge-jam">
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
                                       class="btn-icon" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-end">TOTAL KEGIATAN:</td>
                                <td class="fw-bold">{{ $kegiatan->count() }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-journal-x"></i>
                        </div>
                        <h4 class="empty-title">Tidak ada kegiatan</h4>
                        <p class="empty-text">Belum ada kegiatan mengajar pada periode ini</p>
                        <a href="{{ route('guru.kegiatan.create') }}" class="btn btn-primary" 
                           style="background: var(--gradient-4); border: none; border-radius: 8px; padding: 10px 20px;">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Kegiatan
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Export Options -->
            <div class="export-section">
                <h5 class="card-title mb-3">
                    <i class="bi bi-download me-2"></i>
                    Export Laporan
                </h5>
                
                <div class="export-grid">
                    <a href="{{ route('guru.laporan.export.csv') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" 
                       class="export-btn export-btn-csv">
                        <i class="bi bi-file-earmark-text export-icon"></i>
                        <div>
                            <strong>CSV Format</strong>
                            <small class="text-muted d-block">Data mentah untuk spreadsheet</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('guru.laporan.export.excel') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" 
                       class="export-btn export-btn-excel">
                        <i class="bi bi-file-earmark-excel export-icon"></i>
                        <div>
                            <strong>Laporan Excel</strong>
                            <small class="text-muted d-block">Format rapi dengan header</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('guru.laporan.rekap.kehadiran') }}?bulan={{ $bulan }}&tahun={{ $tahun }}" 
                       class="export-btn export-btn-rekap">
                        <i class="bi bi-person-lines-fill export-icon"></i>
                        <div>
                            <strong>Rekap Kehadiran</strong>
                            <small class="text-muted d-block">Data presensi siswa</small>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Laporan Bulanan loaded');
        
        // Logo fallback function
        window.showLogoFallback = function() {
            const logo = document.getElementById('schoolLogo');
            if (logo) {
                logo.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="%231a202c" rx="10"/><text x="50" y="65" font-family="Arial" font-size="45" fill="white" text-anchor="middle">S</text></svg>';
                logo.alt = 'Logo Default - SMK Muhammadiyah 04';
            }
        };
        
        // Animate stats on load
        document.querySelectorAll('.stat-value').forEach(function(stat) {
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
        
        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('.custom-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
        });
        
        // Export button animations
        const exportButtons = document.querySelectorAll('.export-btn');
        exportButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.export-icon');
                icon.style.transform = 'translateY(-5px)';
            });
            
            button.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.export-icon');
                icon.style.transform = 'translateY(0)';
            });
        });
        
        // Mobile menu toggle
        const menuToggle = document.createElement('button');
        menuToggle.innerHTML = '<i class="bi bi-list"></i>';
        menuToggle.className = 'menu-toggle';
        menuToggle.style.cssText = `
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: var(--accent-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        `;
        document.body.appendChild(menuToggle);
        
        const sidebar = document.querySelector('.sidebar');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Show/hide menu toggle based on screen size
        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                menuToggle.style.display = 'flex';
                sidebar.style.transform = 'translateX(-100%)';
            } else {
                menuToggle.style.display = 'none';
                sidebar.style.transform = 'translateX(0)';
            }
        }
        
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('active') && 
                    !sidebar.contains(event.target) && 
                    !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
        
        // Print styles
        const printStyle = document.createElement('style');
        printStyle.textContent = `
            @media print {
                .sidebar, .menu-toggle, .back-btn, .export-section, .action-buttons {
                    display: none !important;
                }
                
                .main-content {
                    margin-left: 0 !important;
                    padding: 0 !important;
                }
                
                .top-navbar, .filter-card, .distribution-card {
                    border: none !important;
                    box-shadow: none !important;
                    background: white !important;
                }
                
                .stat-card, .table-card {
                    border: 1px solid #000 !important;
                    break-inside: avoid;
                }
                
                .custom-table {
                    border: 1px solid #000;
                }
                
                .custom-table th, .custom-table td {
                    border: 1px solid #000 !important;
                    padding: 8px !important;
                }
                
                .badge-kelas, .badge-jam {
                    border: 1px solid #000 !important;
                    background: white !important;
                    color: #000 !important;
                }
            }
        `;
        document.head.appendChild(printStyle);
    });
    </script>
</body>
</html>
