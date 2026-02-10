<!DOCTYPE html>
<html>
<head>
    <title>Input Kegiatan - UKK RPL</title>
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

<div class="card">
<div class="card-header bg-success text-white">
    <h4 class="mb-0">
        <i class="bi bi-journal-plus"></i> Input Kegiatan Mengajar
    </h4>
</div>

<div class="card-body">

<div class="alert alert-info">
    <i class="bi bi-calendar-check"></i>
    <strong>Hari:</strong> {{ $hari_nama }} |
    <strong>Tanggal:</strong> {{ date('d/m/Y') }} |
    <strong>Guru:</strong> {{ $guru->nama }}
</div>

<form method="POST" action="{{ route('guru.kegiatan.store') }}">
@csrf

<!-- ================= JADWAL ================= -->
<div class="mb-4">
    <h5><i class="bi bi-calendar-week"></i> Pilih Jadwal Mengajar</h5>

    @foreach($jadwal as $j)
    <label class="list-group-item">
        <input class="form-check-input me-2 jadwal-radio"
               type="radio"
               name="jadwal_id"
               value="{{ $j->id }}"
               required>
        <strong>{{ $j->nama_kelas }}</strong> - {{ $j->mata_pelajaran }}
        <div class="small text-muted">
            {{ date('H:i', strtotime($j->waktu_mulai)) }} -
            {{ date('H:i', strtotime($j->waktu_selesai)) }}
        </div>
    </label>
    @endforeach
</div>

<!-- ================= MATERI ================= -->
<div class="mb-3">
    <label class="form-label">
        <i class="bi bi-book"></i> Materi Pembelajaran
    </label>
    <input type="text" name="materi" class="form-control" required>
</div>

<!-- ================= CATATAN ================= -->
<div class="mb-3">
    <label class="form-label">
        <i class="bi bi-pencil"></i> Catatan Kegiatan
    </label>
    <textarea name="catatan" class="form-control" rows="5" required></textarea>
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
                Pilih jadwal terlebih dahulu
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
        <i class="bi bi-save"></i> Simpan Kegiatan
    </button>
</div>

</form>
</div>
</div>

</div>
</div>
</div>

<!-- ================= SCRIPT FIXED ================= -->
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
    
    // Tambahkan info statistik
    html += `
    <div class="alert alert-secondary mt-2">
        <small>
            <i class="bi bi-info-circle"></i> 
            Total: ${siswa.length} siswa | Default: Hadir | Ubah jika siswa tidak hadir
        </small>
    </div>`;
    
    return html;
}

// Event listener untuk radio button jadwal
document.querySelectorAll('.jadwal-radio').forEach(radio => {
    radio.addEventListener('change', function () {
        const siswaContainer = document.getElementById('siswa-container');
        const jadwalId = this.value;

        if (!jadwalId) {
            siswaContainer.innerHTML = `
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Pilih jadwal terlebih dahulu
                </div>
            `;
            return;
        }

        // Tampilkan loading
        siswaContainer.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Memuat data siswa...</p>
            </div>
        `;

        // Fetch data siswa
        fetch(`/debug-get-siswa/${jadwalId}`)
            .then(response => {
                console.log('Status:', response.status);
                console.log('URL:', response.url);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data siswa:', data);
                
                if (data.siswa && data.siswa.length > 0) {
                    siswaContainer.innerHTML = renderSiswaTable(data.siswa);
                } else {
                    siswaContainer.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Tidak ada siswa di kelas ini.
                            <br><small>Silakan tambah siswa via admin panel.</small>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                siswaContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i>
                        Gagal memuat data siswa.
                        <br><small>Error: ${error.message}</small>
                        <br><small>Cek koneksi atau refresh halaman.</small>
                    </div>
                `;
            });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
