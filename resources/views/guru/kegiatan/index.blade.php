@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Kegiatan Saya - UKK RPL</title>
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
            <a class="navbar-brand" href="/guru/dashboard">
                <i class="bi bi-journal-bookmark"></i> Kegiatan Saya
            </a>
            <div class="navbar-nav">
                <span class="nav-link text-white">
                    <i class="bi bi-person-circle"></i> {{ $guru->nama }}
                </span>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3><i class="bi bi-journal-text"></i> Kegiatan Mengajar</h3>
                <p class="text-muted mb-0">Riwayat kegiatan Anda</p>
            </div>
            <div>
                <a href="/guru/kegiatan/create" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Input Baru
                </a>
                <a href="/guru/dashboard" class="btn btn-outline-primary">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                @if($kegiatan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Materi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kegiatan as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ date('d/m/Y', strtotime($k->tanggal)) }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <!-- Tampilkan hari dari tanggal, bukan dari kolom hari -->
                                        @php
                                            $hariInggris = date('l', strtotime($k->tanggal));
                                            $hariIndonesia = [
                                                'Monday' => 'Senin',
                                                'Tuesday' => 'Selasa',
                                                'Wednesday' => 'Rabu',
                                                'Thursday' => 'Kamis',
                                                'Friday' => 'Jumat',
                                                'Saturday' => 'Sabtu',
                                                'Sunday' => 'Minggu'
                                            ];
                                            echo $hariIndonesia[$hariInggris] ?? $hariInggris;
                                        @endphp
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $k->nama_kelas }}</span>
                                </td>
                                <td>{{ $k->mata_pelajaran }}</td>
                                <td>
                                    <div style="max-width: 300px;">
                                        {{ $k->materi }}
                                        @if(!empty($k->catatan))
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-chat-left"></i> 
                                            {{ Illuminate\Support\Str::limit($k->catatan, 40) }}
                                        </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Pastikan route detail ada -->
                                        @if(Route::has('guru.kegiatan.detail'))
                                      <!-- DI index.blade.php, pastikan seperti ini: -->
                                        <a href="{{ route('guru.kegiatan.detail', $k->id) }}" 
                                        class="btn btn-outline-info btn-sm" 
                                        title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @else
                                        <a href="javascript:void(0)" 
                                        class="btn btn-outline-info btn-sm disabled" 
                                        title="Detail tidak tersedia">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Form hapus -->
                                        @if(Route::has('guru.kegiatan.delete'))
                                        <form action="{{ route('guru.kegiatan.delete', $k->id) }}" 
                                            method="POST" 
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus kegiatan {{ addslashes($k->mata_pelajaran) }} tanggal {{ $k->tanggal }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-muted mt-3">
                    <i class="bi bi-info-circle"></i> Total: {{ $kegiatan->count() }} kegiatan mengajar
                </p>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-journal-x display-4 text-muted"></i>
                    <h5 class="text-muted mt-3">Belum ada kegiatan</h5>
                    <p class="text-muted">Mulai catat kegiatan mengajar Anda hari ini</p>
                    <a href="/guru/kegiatan/create" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Input Kegiatan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <div class="mt-3 text-center text-muted">
            <small>UKK RPL 2026 - Aplikasi Catatan Mengajar Guru</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>