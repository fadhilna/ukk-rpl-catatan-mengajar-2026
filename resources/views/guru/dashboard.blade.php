<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - UKK RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .stat-card {
            border-radius: 10px;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .jadwal-card {
            border-left: 4px solid #3498db;
            transition: all 0.3s;
        }
        .jadwal-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #1a252f 100%);
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: #bdc3c7;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }
        .sidebar a:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: #3498db;
        }
        .sidebar a.active {
            color: white;
            background-color: rgba(52, 152, 219, 0.2);
            border-left-color: #3498db;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/guru/dashboard">
                <i class="bi bi-journal-bookmark-fill"></i> 
                <strong>Catatan Mengajar</strong>
            </a>
            
            <div class="d-flex align-items-center text-white">
                <div class="me-3">
                    <i class="bi bi-person-circle me-1"></i> 
                    <span>{{ $guru->nama }}</span>
                    <small class="d-block ms-2">
                        <span class="badge bg-light text-primary">{{ session('peran') }}</span>
                    </small>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block sidebar p-0">
                <div class="p-4 text-center border-bottom border-secondary">
                    <div class="mb-3">
                        <i class="bi bi-person-badge fs-1 text-primary"></i>
                    </div>
                    <h6 class="mb-1">{{ $guru->nama }}</h6>
                    <small class="text-muted">{{ $guru->nip ?? 'NIP: -' }}</small>
                </div>
                
                <nav class="nav flex-column mt-3">
                    <a href="/guru/dashboard" class="active">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="/guru/kegiatan">
                        <i class="bi bi-journal-text me-2"></i> Kegiatan Mengajar
                    </a>
                    <a href="/guru/jadwal">
                        <i class="bi bi-calendar-week me-2"></i> Jadwal Saya
                    </a>
                    <a href="/guru/profil">
                        <i class="bi bi-person me-2"></i> Profil Saya
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1">
                            <i class="bi bi-speedometer2 text-primary"></i> Dashboard Guru
                        </h3>
                        <p class="text-muted mb-0">
                            <i class="bi bi-calendar-date"></i> 
                            {{ date('d F Y') }} | Hari: {{ $hari_nama }}
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/guru/kegiatan/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Input Kegiatan
                        </a>
                        <a href="/guru/kegiatan" class="btn btn-outline-success">
                            <i class="bi bi-journal-text me-1"></i> Lihat Kegiatan
                        </a>
                    </div>
                </div>
                
                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card bg-primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Total Kegiatan</h6>
                                    <h2 class="mb-0">{{ $total_kegiatan }}</h2>
                                </div>
                                <i class="bi bi-journal-text fs-1 opacity-50"></i>
                            </div>
                            <small>Catatan mengajar tersimpan</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Jadwal</h6>
                                    <h2 class="mb-0">{{ $total_jadwal }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                            </div>
                            <small>Jadwal mengajar aktif</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Hari Ini</h6>
                                    <h2 class="mb-0">{{ count($jadwal_hari_ini) }}</h2>
                                </div>
                                <i class="bi bi-calendar-day fs-1 opacity-50"></i>
                            </div>
                            <small>Jadwal hari ini</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Status</h6>
                                    <h2 class="mb-0">Aktif</h2>
                                </div>
                                <i class="bi bi-check-circle fs-1 opacity-50"></i>
                            </div>
                            <small>Sistem UKK RPL</small>
                        </div>
                    </div>
                </div>
                
                <!-- Jadwal Hari Ini -->
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-check text-primary me-2"></i>
                            Jadwal Mengajar Hari Ini ({{ $hari_nama }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($jadwal_hari_ini) > 0)
                            <div class="row">
                                @foreach($jadwal_hari_ini as $jadwal)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100 jadwal-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="card-title mb-1">{{ $jadwal->nama_kelas }}</h6>
                                                    <p class="text-muted small mb-0">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }}
                                                    </p>
                                                </div>
                                                <span class="badge bg-primary">Jam ke-{{ $jadwal->jam_ke }}</span>
                                            </div>
                                            
                                            <p class="card-text">
                                                <strong>{{ $jadwal->mata_pelajaran ?? 'Mata Pelajaran' }}</strong>
                                            </p>
                                            
                                            @if($jadwal->keterangan)
                                            <p class="card-text small text-muted">
                                                <i class="bi bi-info-circle"></i> {{ $jadwal->keterangan }}
                                            </p>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i> Ruang Kelas
                                                </small>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="/guru/kegiatan/create/{{ $jadwal->id }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-plus-circle"></i> Catat Kegiatan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x display-4 text-muted"></i>
                                <h5 class="text-muted mt-3">Tidak ada jadwal mengajar hari ini</h5>
                                <p class="text-muted mb-4">Anda bisa beristirahat atau menyiapkan materi</p>
                                <a href="/guru/jadwal" class="btn btn-outline-primary">
                                    <i class="bi bi-calendar-week"></i> Lihat Semua Jadwal
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Kegiatan Terbaru -->
                @if($kegiatan_terbaru->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-journal-text text-success me-2"></i>
                            Kegiatan Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kegiatan_terbaru as $kegiatan)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($kegiatan->tanggal)) }}</td>
                                        <td>{{ $kegiatan->nama_kelas }}</td>
                                        <td>{{ $kegiatan->mata_pelajaran }}</td>
                                        <td>
                                            <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                                {{ $kegiatan->catatan }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <a href="/guru/kegiatan" class="btn btn-outline-success btn-sm">
                                Lihat Semua Kegiatan
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-lightning-charge text-warning me-2"></i>
                                    Aksi Cepat
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="/guru/kegiatan/create" class="btn btn-outline-primary w-100 text-start">
                                            <i class="bi bi-journal-plus me-2"></i> Input Kegiatan
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="/guru/jadwal" class="btn btn-outline-success w-100 text-start">
                                            <i class="bi bi-calendar2-week me-2"></i> Lihat Jadwal
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="/guru/kegiatan" class="btn btn-outline-info w-100 text-start">
                                            <i class="bi bi-file-earmark-text me-2"></i> Kegiatan Saya
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="/guru/profil" class="btn btn-outline-secondary w-100 text-start">
                                            <i class="bi bi-person-gear me-2"></i> Profil Saya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-info-circle text-info me-2"></i>
                                    Informasi
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small>Login terakhir: {{ date('d/m/Y H:i') }}</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small>Status: <span class="text-success">Aktif</span></small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        <small>Hari aktif: Senin - Jumat</small>
                                    </li>
                                    <li>
                                        <i class="bi bi-shield-check me-2"></i>
                                        <small>UKK RPL 2026 - Sistem Valid</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="mt-4 pt-3 border-top text-center text-muted">
                    <small>
                        <i class="bi bi-c-circle"></i> 2026 Aplikasi Catatan Mengajar Guru - UKK RPL
                        | Versi 1.0 | User: {{ session('username') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            });
        }, 5000);
    </script>
</body>
</html>