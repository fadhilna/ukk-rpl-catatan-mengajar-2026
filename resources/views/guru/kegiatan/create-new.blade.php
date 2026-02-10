<!DOCTYPE html>
<html>
<head>
    <title>Input Kegiatan - UKK RPL</title>
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

<nav class="navbar navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="/guru/dashboard">
            <i class="bi bi-journal-bookmark"></i> Input Kegiatan
        </a>
        <span class="navbar-text text-white">
            <i class="bi bi-person-circle"></i> {{ $guru->nama }}
        </span>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(count($kelas_sudah_absen) > 0)
            <div class="alert alert-info mb-4">
                <h6><i class="bi bi-info-circle"></i> Informasi</h6>
                <p>Kelas yang sudah diabsen hari ini:</p>
                <ul class="mb-0">
                    @foreach($kelas_sudah_absen as $kelas)
                    <li>
                        <strong>{{ $kelas->nama_kelas }}</strong>
                        <span class="badge bg-success ms-2">✓ Sudah Absen</span>
                    </li>
                    @endforeach
                </ul>
                <small class="d-block mt-2">
                    <i class="bi bi-lightbulb"></i> 
                    <strong>Sistem Baru:</strong> 1 kelas hanya perlu 1x absen per hari, 
                    meskipun ada banyak jam pelajaran.
                </small>
            </div>
            @endif

            @if(empty($kelas_tersedia))
            <div class="alert alert-success">
                <h6><i class="bi bi-check-circle-fill"></i> Semua Kelas Sudah Diabsen!</h6>
                <p>Tidak ada kelas yang perlu diabsen hari ini.</p>
                <div class="mt-2">
                    <a href="/guru/kegiatan" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-eye"></i> Lihat Riwayat
                    </a>
                </div>
            </div>
            @else

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-journal-plus"></i> Input Absen Kelas (Sistem Baru)
                    </h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-calendar-check"></i>
                        <strong>Hari:</strong> {{ $hari_nama }} |
                        <strong>Tanggal:</strong> {{ date('d/m/Y') }} |
                        <strong>Guru:</strong> {{ $guru->nama }}
                    </div>

                    <form method="POST" action="{{ route('guru.kegiatan.store-new') }}" id="kegiatanForm">
                        @csrf

                        <!-- ================= PILIH KELAS ================= -->
                        <div class="mb-4">
                            <h5><i class="bi bi-building"></i> Pilih Kelas</h5>
                            
                            @foreach($kelas_tersedia as $kelas)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input kelas-radio" 
                                               type="radio" 
                                               name="kelas_id" 
                                               value="{{ $kelas->id }}"
                                               id="kelas_{{ $kelas->id }}"
                                               required
                                               onchange="loadSiswaByKelas({{ $kelas->id }})">
                                        <label class="form-check-label w-100" for="kelas_{{ $kelas->id }}">
                                            <h5 class="mb-1">{{ $kelas->nama_kelas }}</h5>
                                            
                                            <!-- Tampilkan mata pelajaran untuk kelas ini -->
                                            <div class="ms-4">
                                                <small class="text-muted">Mata Pelajaran:</small>
                                                <select name="jadwal_id[{{ $kelas->id }}]" 
                                                        class="form-select form-select-sm mt-1" 
                                                        id="mapel_{{ $kelas->id }}">
                                                    @if(isset($mapel_per_kelas[$kelas->id]))
                                                        @foreach($mapel_per_kelas[$kelas->id] as $mapel)
                                                        <option value="{{ $mapel->id }}">
                                                            {{ $mapel->mata_pelajaran }}
                                                        </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- ================= MATERI & CATATAN ================= -->
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bi bi-book"></i> Materi Pembelajaran
                                </label>
                                <input type="text" name="materi" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bi bi-pencil"></i> Catatan
                                </label>
                                <textarea name="catatan" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

                        <!-- ================= KEHADIRAN SISWA ================= -->
                        <div class="card mt-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-people-fill"></i> Data Kehadiran Siswa
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="siswa-container">
                                    <div class="alert alert-info">
                                        Pilih kelas terlebih dahulu
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ================= TOMBOL ================= -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="/guru/kegiatan" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Absen Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            @endif

        </div>
    </div>
</div>

<script>
// Function untuk render tabel siswa
function renderSiswaTable(siswa) {
    let html = `
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th width="50">No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
    `;

    siswa.forEach((s, i) => {
        html += `
        <tr>
            <td class="text-center">${i + 1}</td>
            <td><code>${s.nis}</code></td>
            <td>${s.nama}</td>
            <td>
                <select name="kehadiran[${s.id}]" class="form-select form-select-sm" required>
                    <option value="Hadir" selected>Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpha">Alpha</option>
                </select>
            </td>
        </tr>`;
    });

    html += `</tbody></table>`;
    
    html += `
    <div class="alert alert-secondary mt-2">
        <small>
            <i class="bi bi-info-circle"></i> 
            Total: ${siswa.length} siswa | Default: Hadir | Ubah jika siswa tidak hadir
        </small>
    </div>`;
    
    return html;
}

// Load siswa berdasarkan kelas
function loadSiswaByKelas(kelasId) {
    const siswaContainer = document.getElementById('siswa-container');
    
    siswaContainer.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat data siswa...</p>
        </div>
    `;

    fetch(`/api/get-siswa-by-kelas/${kelasId}`)
        .then(response => response.json())
        .then(data => {
            if (data.siswa && data.siswa.length > 0) {
                siswaContainer.innerHTML = renderSiswaTable(data.siswa);
            } else {
                siswaContainer.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        Tidak ada siswa di kelas ini.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            siswaContainer.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle"></i>
                    Gagal memuat data siswa.
                </div>
            `;
        });
}
</script>

<!-- Tambah route API untuk get siswa by kelas -->
@push('scripts')
<script>
// Route ini perlu ditambahkan di web.php
</script>
@endpush

</body>
</html>