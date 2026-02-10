<!DOCTYPE html>
<html>
<head>
    <title>Detail Kegiatan - UKK RPL</title>
   <!-- Di head semua view -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<!-- Tambahkan ini untuk efek modern -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --warning-color: #f72585;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .navbar {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .btn {
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 500;
    }
    
    .table {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .stat-card {
        border-radius: 12px;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: scale(1.05);
    }
</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-info">
        <div class="container">
            <a class="navbar-brand" href="/guru/kegiatan">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kegiatan
            </a>
            <span class="navbar-text text-white">
                <i class="bi bi-person-circle"></i> Detail Kegiatan
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-journal-text"></i> Detail Kegiatan Mengajar</h4>
            </div>
            <div class="card-body">
                <!-- Info Kegiatan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Kegiatan</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Mata Pelajaran</th>
                                        <td><strong>{{ $kegiatan->mata_pelajaran }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td><span class="badge bg-primary">{{ $kegiatan->nama_kelas }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>{{ date('d/m/Y', strtotime($kegiatan->tanggal)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Input</th>
                                        <td>{{ date('d/m/Y H:i', strtotime($kegiatan->created_at)) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="bi bi-file-text"></i> Konten Pembelajaran</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Materi</th>
                                        <td>{{ $kegiatan->materi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>
                                            @if($kegiatan->catatan)
                                                {{ $kegiatan->catatan }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Kehadiran -->
                <h5 class="mb-3"><i class="bi bi-graph-up"></i> Statistik Kehadiran</h5>
                <div class="row mb-4">
                    <div class="col-3">
                        <div class="card stat-card bg-success text-white text-center">
                            <div class="card-body">
                                <h2 class="mb-0">{{ $statistik['Hadir'] }}</h2>
                                <p class="mb-0">Hadir</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card stat-card bg-warning text-white text-center">
                            <div class="card-body">
                                <h2 class="mb-0">{{ $statistik['Izin'] }}</h2>
                                <p class="mb-0">Izin</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card stat-card bg-info text-white text-center">
                            <div class="card-body">
                                <h2 class="mb-0">{{ $statistik['Sakit'] }}</h2>
                                <p class="mb-0">Sakit</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card stat-card bg-danger text-white text-center">
                            <div class="card-body">
                                <h2 class="mb-0">{{ $statistik['Alpa'] }}</h2>
                                <p class="mb-0">Alpa</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center text-muted">Total: {{ $statistik['total'] }} siswa</p>

                <!-- Daftar Kehadiran -->
                <h5 class="mb-3"><i class="bi bi-people"></i> Data Kehadiran Siswa</h5>
                @if($kehadiran->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th width="120">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kehadiran as $index => $k)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $k->nis }}</td>
                                <td>{{ $k->nama }}</td>
                                <td class="text-center">
                                    @if($k->status == 'Hadir')
                                        <span class="badge badge-status bg-success">Hadir</span>
                                    @elseif($k->status == 'Izin')
                                        <span class="badge badge-status bg-warning">Izin</span>
                                    @elseif($k->status == 'Sakit')
                                        <span class="badge badge-status bg-info">Sakit</span>
                                    @elseif($k->status == 'Alpa')
                                        <span class="badge badge-status bg-danger">Alpa</span>
                                    @else
                                        <span class="badge badge-status bg-secondary">{{ $k->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle display-4"></i>
                    <h5 class="mt-2">Belum ada data kehadiran</h5>
                    <p class="text-muted">Data kehadiran siswa belum direkam untuk kegiatan ini.</p>
                </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="mt-4 text-center">
                    <a href="/guru/kegiatan" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <a href="/guru/kegiatan/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Input Kegiatan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>