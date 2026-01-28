<!DOCTYPE html>
<html>
<head>
    <title>Kegiatan Saya - UKK RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
                            @foreach($kegiatan as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ date('d/m/Y', strtotime($k->tanggal)) }}<br>
                                    <small class="text-muted">{{ $k->hari }}</small>
                                </td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->mata_pelajaran }}</td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                        {{ $k->materi }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('guru.kegiatan.detail', $k->id) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
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