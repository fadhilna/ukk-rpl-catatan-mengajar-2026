<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar - UKK RPL</title>
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
        .hari-card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            transition: transform 0.3s;
        }
        .hari-card:hover {
            transform: translateY(-5px);
        }
        .hari-header {
            border-radius: 10px 10px 0 0;
            color: white;
            padding: 15px;
        }
        .jadwal-item {
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            border-radius: 5px;
        }
        .time-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
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
                </div>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
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
                    <i class="bi bi-calendar-week text-primary"></i> Jadwal Mengajar
                </h3>
                <p class="text-muted mb-0">
                    Jadwal mengajar {{ $guru->nama }} | Total: {{ $jadwal->count() }} jadwal
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="/guru/dashboard" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak
                </button>
            </div>
        </div>
        
        <!-- Kelompokkan Jadwal per Hari -->
        @php
            // Kelompokkan jadwal berdasarkan hari
            $jadwalPerHari = [
                'Senin' => [],
                'Selasa' => [],
                'Rabu' => [],
                'Kamis' => [],
                'Jumat' => []
            ];
            
            foreach ($jadwal as $j) {
                if (isset($jadwalPerHari[$j->hari])) {
                    $jadwalPerHari[$j->hari][] = $j;
                }
            }
            
            // Warna untuk setiap hari
            $hariColors = [
                'Senin' => 'bg-primary',
                'Selasa' => 'bg-success',
                'Rabu' => 'bg-warning',
                'Kamis' => 'bg-info',
                'Jumat' => 'bg-danger'
            ];
        @endphp
        
        <div class="row">
            @foreach($jadwalPerHari as $hari => $jadwalHari)
            <div class="col-md-12 col-lg-6 col-xl-4 mb-4">
                <div class="card hari-card">
                    <div class="card-header {{ $hariColors[$hari] ?? 'bg-secondary' }} text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar3 me-2"></i> {{ $hari }}
                            <span class="badge bg-light text-dark float-end">
                                {{ count($jadwalHari) }} Jadwal
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($jadwalHari) > 0)
                            @foreach($jadwalHari as $j)
                            <div class="jadwal-item mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $j->nama_kelas }}</h6>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-book me-1"></i> {{ $j->mata_pelajaran ?? 'Mata Pelajaran' }}
                                        </p>
                                    </div>
                                    <span class="time-badge">
                                        <i class="bi bi-clock"></i> 
                                        {{ date('H:i', strtotime($j->waktu_mulai)) }} - {{ date('H:i', strtotime($j->waktu_selesai)) }}
                                    </span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-list-ol me-1"></i> Jam ke-{{ $j->jam_ke }}
                                    </small>
                                    <div class="btn-group btn-group-sm">
                                        <a href="/guru/kegiatan/create" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-plus-circle"></i> Catat
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada jadwal</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Summary -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart text-info me-2"></i>
                    Ringkasan Jadwal
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($jadwalPerHari as $hari => $jadwalHari)
                    <div class="col-md-2 col-4 mb-3">
                        <div class="text-center">
                            <div class="display-6 {{ $hariColors[$hari] ?? 'bg-secondary' }} text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                {{ count($jadwalHari) }}
                            </div>
                            <p class="mt-2 mb-0"><strong>{{ $hari }}</strong></p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    <h6>Total Jadwal: <span class="badge bg-primary">{{ $jadwal->count() }}</span></h6>
                    <p class="text-muted small mb-0">
                        Jadwal mengajar aktif untuk semester ini. Untuk perubahan jadwal, hubungi administrasi.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-4 pt-3 border-top text-center text-muted">
            <small>
                <i class="bi bi-c-circle"></i> 2026 Aplikasi Catatan Mengajar Guru - UKK RPL
                | Cetak: {{ date('d/m/Y H:i') }} | User: {{ session('username') }}
            </small>
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
        
        // Print styling
        @media print {
            .navbar, .btn, .d-print-none {
                display: none !important;
            }
            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
        }
    </script>
</body>
</html>