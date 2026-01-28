<!DOCTYPE html>
<html>
<head>
    <title>Input Kegiatan - UKK RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="/guru/dashboard">
                <i class="bi bi-journal-bookmark"></i> Input Kegiatan
            </a>
            <div class="navbar-nav">
                <span class="nav-link text-white">
                    <i class="bi bi-person-circle"></i> {{ $guru->nama }}
                </span>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-journal-plus"></i> Input Kegiatan Mengajar
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Info Hari -->
                        <div class="alert alert-info">
                            <i class="bi bi-calendar-check"></i>
                            <strong>Hari: {{ $hari_nama }}</strong> | 
                            <strong>Tanggal: {{ date('d/m/Y') }}</strong> |
                            <strong>Guru: {{ $guru->nama }}</strong>
                        </div>
                        
                        @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('guru.kegiatan.store') }}">
                            @csrf
                            
                            <!-- Pilih Jadwal -->
                            <div class="mb-4">
                                <h5><i class="bi bi-calendar-week"></i> Pilih Jadwal Mengajar</h5>
                                @if($jadwal->count() > 0)
                                    <div class="list-group">
                                        @foreach($jadwal as $j)
                                        <label class="list-group-item">
                                            <input class="form-check-input me-2" type="radio" 
                                                   name="jadwal_id" value="{{ $j->id }}" required>
                                            <div>
                                                <strong>{{ $j->nama_kelas }}</strong> - {{ $j->mata_pelajaran }}
                                                <div class="text-muted small">
                                                    <i class="bi bi-clock"></i> 
                                                    {{ date('H:i', strtotime($j->waktu_mulai)) }} - {{ date('H:i', strtotime($j->waktu_selesai)) }}
                                                    | Jam ke-{{ $j->jam_ke }}
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Tidak ada jadwal mengajar hari ini ({{ $hari_nama }}).
                                        <a href="/guru/dashboard" class="alert-link">Kembali ke Dashboard</a>
                                    </div>
                                @endif
                            </div>
                            
                            @if($jadwal->count() > 0)
                            <!-- Input Materi -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-book"></i> Materi Pembelajaran *
                                </label>
                                <input type="text" name="materi" class="form-control" 
                                       placeholder="Contoh: Trigonometri Dasar, Puisi Lama, Sistem Operasi" 
                                       required>
                                <div class="form-text">Tulis pokok bahasan yang diajarkan</div>
                            </div>
                            
                            <!-- Input Catatan -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-pencil"></i> Catatan Kegiatan *
                                </label>
                                <textarea name="catatan" class="form-control" rows="6" 
                                          placeholder="Deskripsi kegiatan pembelajaran:
- Tujuan pembelajaran
- Metode yang digunakan  
- Aktivitas siswa
- Hasil yang dicapai
- Kendala dan solusi
- Tindak lanjut" required></textarea>
                                <div class="form-text">Jelaskan kegiatan pembelajaran secara detail</div>
                            </div>
                            
                            <!-- Tanggal (hidden) -->
                            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="/guru/kegiatan" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Simpan Kegiatan
                                </button>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
                
                <!-- Panduan -->
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bi bi-lightbulb"></i> Panduan Pengisian
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="small mb-0">
                            <li><strong>Pilih Jadwal:</strong> Pilih kelas dan mata pelajaran yang diajarkan</li>
                            <li><strong>Materi:</strong> Tulis pokok bahasan/subtema pembelajaran</li>
                            <li><strong>Catatan:</strong> Deskripsikan proses pembelajaran secara lengkap</li>
                            <li>Data akan tersimpan secara permanen dan dapat dilihat kapan saja</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>