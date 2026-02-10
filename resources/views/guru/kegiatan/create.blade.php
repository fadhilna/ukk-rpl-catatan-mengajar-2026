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

<!-- ⭐⭐ TAMBAHKAN KODE INI ⭐⭐ -->
@if(count($kelas_sudah_absen) > 0)
<div class="alert alert-warning animate__animated animate__fadeIn mb-4">
    <h6><i class="bi bi-exclamation-triangle"></i> Peringatan!</h6>
    <p>Beberapa kelas sudah memiliki rekap kehadiran hari ini:</p>
    <ul class="mb-0">
        @foreach($kelas_sudah_absen as $kelas)
        <li>
            <strong>{{ $kelas->nama_kelas }}</strong> 
            ({{ $kelas->jumlah_kegiatan }} kegiatan)
            <span class="badge bg-success ms-2">✓ Sudah Absen</span>
        </li>
        @endforeach
    </ul>
    <small class="d-block mt-2">
        <i class="bi bi-info-circle"></i> 
        Setiap kelas hanya perlu 1x absen per hari, meskipun ada banyak jam pelajaran.
    </small>
</div>
@endif

@if(empty($jadwal))
<div class="alert alert-success animate__animated animate__fadeIn">
    <h6><i class="bi bi-check-circle-fill"></i> Semua Kelas Sudah Diabsen!</h6>
    <p>Anda sudah menginput kehadiran untuk semua kelas yang mengajar hari ini.</p>
    <div class="mt-2">
        <a href="/guru/kegiatan" class="btn btn-outline-success btn-sm">
            <i class="bi bi-eye"></i> Lihat Riwayat Kegiatan
        </a>
        <a href="/guru/dashboard" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-speedometer2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@else

<!-- ⭐⭐ FORM INPUT KEGIATAN (YANG SUDAH ADA) ⭐⭐ -->
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

<form method="POST" action="{{ route('guru.kegiatan.store') }}" id="kegiatanForm">
@csrf

<!-- ================= JADWAL ================= -->
<div class="mb-4">
    <h5><i class="bi bi-calendar-week"></i> Pilih Jadwal Mengajar</h5>
    
    @if(count($jadwal) == 0)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        Tidak ada jadwal yang tersedia untuk diisi hari ini.
    </div>
    @else
        @foreach($jadwal as $j)
        @php
            $kelas_sudah_absen = in_array($j->kelas_id, $kelas_sudah_absen_ids ?? []);
            $disabled = $kelas_sudah_absen;
        @endphp
        
        <label class="list-group-item {{ $disabled ? 'bg-light text-muted' : '' }}">
            <input class="form-check-input me-2 jadwal-radio"
                   type="radio"
                   name="jadwal_id"
                   value="{{ $j->id }}"
                   {{ $disabled ? 'disabled' : 'required' }}
                   data-kelas-id="{{ $j->kelas_id }}">
            
            <div class="d-flex justify-content-between align-items-center w-100">
                <div>
                    <strong>{{ $j->nama_kelas }}</strong> - {{ $j->mata_pelajaran }}
                    <div class="small text-muted">
                        {{ date('H:i', strtotime($j->waktu_mulai)) }} -
                        {{ date('H:i', strtotime($j->waktu_selesai)) }}
                    </div>
                </div>
                
                @if($disabled)
                <span class="badge bg-secondary">
                    <i class="bi bi-lock"></i> Sudah Absen
                </span>
                @endif
            </div>
        </label>
        @endforeach
    @endif
    
    <!-- Info jika semua jadwal disabled -->
    @php
        $semua_disabled = count($jadwal) > 0 && collect($jadwal)->every(function($j) use ($kelas_sudah_absen_ids) {
            return in_array($j->kelas_id, $kelas_sudah_absen_ids ?? []);
        });
    @endphp
    
    @if($semua_disabled)
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle"></i>
        Semua jadwal hari ini sudah memiliki rekap kehadiran.
        <a href="/guru/kegiatan" class="alert-link">Lihat riwayat kegiatan</a>
    </div>
    @endif
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
<!-- ⭐⭐ AKHIR DARI FORM ⭐⭐ -->

</div> <!-- ⭐⭐ TAMBAHKAN INI: tutup col-md-8 ⭐⭐ -->
</div> <!-- ⭐⭐ TAMBAHKAN INI: tutup row ⭐⭐ -->
</div> <!-- ⭐⭐ TAMBAHKAN INI: tutup container ⭐⭐ -->
</div>
</div>
</div>
@endif

<!-- ================= SCRIPT FIXED ================= -->
<script>
// Function untuk render tabel siswa
function renderSiswaTable(siswa, kelasInfo = null) {
    let html = '';
    
    // ⭐⭐ TAMBAHKAN PERINGATAN JIKA KELAS SUDAH ABSEN ⭐⭐
    if (kelasInfo && kelasInfo.sudah_absen) {
        html += `
        <div class="alert alert-warning mb-3">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>Peringatan!</strong> 
            Kelas <strong>${kelasInfo.nama_kelas}</strong> sudah memiliki 
            ${kelasInfo.jumlah} rekap kehadiran hari ini.
            <br>
            <small>
                <i class="bi bi-info-circle"></i>
                Input kehadiran lagi akan membuat duplikat data.
                Lanjutkan hanya jika memang perlu rekapan tambahan.
            </small>
        </div>
        `;
    }
    
    html += `
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

        // 1. Ambil data siswa
        fetch(`/debug-get-siswa/${jadwalId}`)
            .then(response => response.json())
            .then(siswaData => {
                console.log('Data siswa:', siswaData);
                
                // 2. Cek apakah kelas ini sudah ada kegiatan hari ini
                fetch(`/api/cek-kegiatan-kelas?jadwal_id=${jadwalId}&tanggal={{ date('Y-m-d') }}`)
                    .then(res => res.json())
                    .then(kelasInfo => {
                        console.log('Info kelas:', kelasInfo);
                        
                        if (siswaData.siswa && siswaData.siswa.length > 0) {
                            siswaContainer.innerHTML = renderSiswaTable(siswaData.siswa, kelasInfo);
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
                        console.error('Error cek kegiatan:', error);
                        // Fallback tanpa info kelas
                        if (siswaData.siswa && siswaData.siswa.length > 0) {
                            siswaContainer.innerHTML = renderSiswaTable(siswaData.siswa);
                        }
                    });
            })
            .catch(error => {
                console.error('Fetch error:', error);
                siswaContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i>
                        Gagal memuat data siswa.
                        <br><small>Error: ${error.message}</small>
                    </div>
                `;
            });
    });
});
document.querySelectorAll('.jadwal-radio').forEach(radio => {
    radio.addEventListener('change', function () {
        // Skip jika disabled
        if (this.disabled) {
            return;
        }
        
        const siswaContainer = document.getElementById('siswa-container');
        const jadwalId = this.value;
        const kelasId = this.dataset.kelasId;

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

        // 1. Ambil data siswa
        fetch(`/debug-get-siswa/${jadwalId}`)
            .then(response => response.json())
            .then(siswaData => {
                console.log('Data siswa:', siswaData);
                
                // 2. Cek apakah kelas ini sudah ada kegiatan hari ini
                fetch(`/cek-kegiatan-kelas?jadwal_id=${jadwalId}&tanggal={{ date('Y-m-d') }}`)
                    .then(res => res.json())
                    .then(kelasInfo => {
                        console.log('Info kelas:', kelasInfo);
                        
                        if (siswaData.siswa && siswaData.siswa.length > 0) {
                            siswaContainer.innerHTML = renderSiswaTable(siswaData.siswa, kelasInfo);
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
                        console.error('Error cek kegiatan:', error);
                        if (siswaData.siswa && siswaData.siswa.length > 0) {
                            siswaContainer.innerHTML = renderSiswaTable(siswaData.siswa);
                        }
                    });
            })
            .catch(error => {
                console.error('Fetch error:', error);
                siswaContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i>
                        Gagal memuat data siswa.
                        <br><small>Error: ${error.message}</small>
                    </div>
                `;
            });
    });
});

// Confirmation pada submit
document.getElementById('kegiatanForm').addEventListener('submit', function(e) {
    const jadwalRadio = document.querySelector('input[name="jadwal_id"]:checked');
    
    if (!jadwalRadio) {
        e.preventDefault();
        alert('Pilih jadwal terlebih dahulu!');
        return;
    }
    
    // Cek apakah jadwal disabled
    if (jadwalRadio.disabled) {
        e.preventDefault();
        alert('Jadwal ini sudah diabsen hari ini!');
        return;
    }
    
    const jadwalId = jadwalRadio.value;
    
    fetch(`/cek-kegiatan-kelas?jadwal_id=${jadwalId}&tanggal={{ date('Y-m-d') }}`)
        .then(res => res.json())
        .then(data => {
            if (data.sudah_absen) {
                e.preventDefault();
                
                const modalHtml = `
                    <div class="modal fade" id="confirmModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-warning">
                                        <i class="bi bi-exclamation-triangle"></i> PERINGATAN
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <p>Kelas <strong>${data.nama_kelas}</strong> sudah memiliki 
                                    <strong>${data.jumlah}</strong> rekap kehadiran hari ini.</p>
                                    <p class="text-danger">Apakah Anda yakin ingin membuat rekap kehadiran tambahan?</p>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle"></i> 
                                        Rekomendasi: Tidak, kecuali untuk sesi khusus atau remedial.
                                    </small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="button" class="btn btn-warning" id="forceSubmit">
                                        Ya, Buat Rekap Tambahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Tambahkan modal ke body
                const modalDiv = document.createElement('div');
                modalDiv.innerHTML = modalHtml;
                document.body.appendChild(modalDiv);
                
                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                modal.show();
                
                // Handle force submit
                document.getElementById('forceSubmit').addEventListener('click', function() {
                    modal.hide();
                    document.getElementById('kegiatanForm').submit();
                });
                
                // Hapus modal setelah ditutup
                document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
                    modalDiv.remove();
                });
            }
        });
});

// ⭐⭐ TAMBAHKAN CONFIRMATION PADA SUBMIT ⭐⭐
document.querySelector('form').addEventListener('submit', function(e) {
    const jadwalId = document.querySelector('input[name="jadwal_id"]:checked')?.value;
    
    if (!jadwalId) return;
    
    // Cek apakah kelas sudah ada absen
    fetch(`/api/cek-kegiatan-kelas?jadwal_id=${jadwalId}&tanggal={{ date('Y-m-d') }}`)
        .then(res => res.json())
        .then(data => {
            if (data.sudah_absen) {
                e.preventDefault(); // Hentikan submit
                
                // Tampilkan modal konfirmasi
                const modalHtml = `
                    <div class="modal fade" id="confirmModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-warning">
                                        <i class="bi bi-exclamation-triangle"></i> PERINGATAN
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <p>Kelas <strong>${data.nama_kelas}</strong> sudah memiliki 
                                    <strong>${data.jumlah}</strong> rekap kehadiran hari ini.</p>
                                    <p class="text-danger">Apakah Anda yakin ingin membuat rekap kehadiran tambahan?</p>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle"></i> 
                                        Rekomendasi: Tidak, kecuali untuk sesi khusus atau remedial.
                                    </small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="button" class="btn btn-warning" id="forceSubmit">
                                        Ya, Buat Rekap Tambahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Tambahkan modal ke body
                const modalDiv = document.createElement('div');
                modalDiv.innerHTML = modalHtml;
                document.body.appendChild(modalDiv);
                
                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                modal.show();
                
                // Handle force submit
                document.getElementById('forceSubmit').addEventListener('click', function() {
                    modal.hide();
                    document.querySelector('form').submit();
                });
                
                // Hapus modal setelah ditutup
                document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
                    modalDiv.remove();
                });
            }
        });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>