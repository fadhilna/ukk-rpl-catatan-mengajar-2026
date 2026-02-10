@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')

@section('styles')
<!-- Include CSS warna guru -->
<link rel="stylesheet" href="{{ asset('css/admin-guru-colors.css') }}">

<style>
    /* ... (keep existing styles) ... */
    
    /* Tambahan untuk guru colors */
    .guru-color-indicator {
        width: 4px;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        border-radius: 2px 0 0 2px;
    }
    
    .legend-badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        margin: 1px;
        display: inline-flex;
        align-items: center;
    }
    
    .legend-badge i {
        font-size: 0.7rem;
        margin-right: 3px;
    }
</style>
@endsection
 <nav class="navbar navbar-glow navbar-expand-lg shadow">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-white" href="/admin">
            <i class="bi bi-laptop me-2"></i>
            <span class="d-none d-md-inline">UKK RPL Admin</span>
        </a>
        
        <!-- Menu untuk desktop -->
        <div class="d-none d-lg-flex ms-4">
            <div class="navbar-nav">
                <a class="nav-link text-white mx-2 {{ request()->is('admin') ? 'active' : '' }}" 
                   href="/admin">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/guru*') ? 'active' : '' }}" 
                   href="/admin/guru">
                    <i class="bi bi-people me-1"></i> Guru
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/kelas*') ? 'active' : '' }}" 
                   href="/admin/kelas">
                    <i class="bi bi-building me-1"></i> Kelas
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/jadwal*') ? 'active' : '' }}" 
                   href="/admin/jadwal">
                    <i class="bi bi-calendar-week me-1"></i> Jadwal
                </a>
                <!-- MENU DATA SISWA -->
                <a class="nav-link text-white mx-2 {{ request()->is('admin/siswa*') ? 'active' : '' }}" 
                   href="/admin/siswa">
                    <i class="bi bi-people-fill me-1"></i> Siswa
                </a>
            </div>
        </div>
        
        <!-- Search & Profil -->
        <div class="d-flex align-items-center">
            <!-- Profil -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
                   data-bs-toggle="dropdown">
                    <div class="me-2">
                        <div class="profile-img bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill text-primary"></i>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-semibold">{{ session('username') ?? 'Admin' }}</div>
                        <small class="opacity-75">Administrator</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="/admin">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="/logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@section('content')
<div class="container-fluid px-4 pt-4">
    <!-- Breadcrumb -->
  

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-calendar-week me-2"></i> Manajemen Jadwal
            </h2>
            <p class="text-muted mb-0">Atur jadwal mengajar guru per kelas</p>
        </div>
        <div class="d-flex align-items-center">
           
            <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bi bi-info-circle"></i>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
            <div class="flex-grow-1">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
            <div class="flex-grow-1">
                <strong>Error!</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    

    <!-- Form Tambah Jadwal -->
    <div class="card card-hover mb-4">
        <div class="jadwal-header">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Jadwal Baru</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/admin/jadwal/store-multi-jam') }}">
            @csrf
            
            <div class="row g-3 mb-4">
                <!-- Pilih Guru -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Guru</label>
                    <select name="guru_id" id="selectGuru" class="form-control" required onchange="updateKelasOptions()">
                        <option value="">Pilih Guru</option>
                        @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Pilih Kelas -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select name="kelas_id" id="selectKelas" class="form-control" required 
                            onchange="updateHariOptions()">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $kelas_item)
                        <option value="{{ $kelas_item->id }}">{{ $kelas_item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Pilih Hari -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Hari</label>
                    <select name="hari" id="selectHari" class="form-control" required 
                            onchange="loadJamAvailable()">
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>
                
                <!-- Mata Pelajaran -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran" id="mataPelajaran" 
                        class="form-control" placeholder="Contoh: Matematika" required>
                </div>
            </div>
            
            <!-- KOTAK JAM YANG TERSEDIA -->
            <div class="card card-hover mb-3" id="jamContainer" style="display:none;">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-clock me-2"></i> 
                        Pilih Jam Pelajaran untuk 
                        <span id="infoGuruKelas"></span>
                    </h6>
                    <small class="text-muted">Centang jam yang ingin ditambahkan</small>
                </div>
                <div class="card-body">
                    <div class="row" id="jamList">
                        <!-- Jam akan diisi oleh JavaScript -->
                    </div>
                    
                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-primary" onclick="selectAllJam()">
                            <i class="bi bi-check-square"></i> Centang Semua
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearAllJam()">
                            <i class="bi bi-square"></i> Hapus Centang
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-gradient px-4" id="submitBtn" disabled>
                    <i class="bi bi-save me-2"></i> Simpan Jadwal Terpilih
                </button>
                <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                    <i class="bi bi-x-circle me-2"></i> Reset Form
                </button>
            </div>
        </form>

        <!-- MODAL PREVIEW -->
        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview Jadwal yang akan Disimpan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="previewContent"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit Lagi</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Simpan Semua</button>
                    </div>
                </div>
            </div>
        </div>

  
 <!-- List Jadwal -->
<div class="card card-hover">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold d-flex align-items-center">
                <i class="bi bi-list-task me-2"></i> Daftar Jadwal Mengajar
                <span class="ms-2 badge bg-primary">
                    <i class="bi bi-eye-slash"></i> Mode: Hanya Totok Warsito Berwarna
                </span>
            </h5>
        </div>
        
        <!-- Filter Options -->
        <div class="d-flex align-items-center gap-2">
            <!-- Filter Hari -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary btn-sm filter-btn active" data-hari="all">
                    <i class="bi bi-calendar"></i> Semua
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-hari="Senin">Sen</button>
                <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-hari="Selasa">Sel</button>
                <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-hari="Rabu">Rab</button>
                <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-hari="Kamis">Kam</button>
                <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-hari="Jumat">Jum</button>
            </div>
            
            <!-- Filter Totok Warsito -->
            <button class="btn btn-primary btn-sm" onclick="showOnlyTotok()">
                <i class="bi bi-person-fill"></i> Hanya Totok
            </button>
        </div>
    </div>
    
    <div class="card-body">
        @if($jadwal->count() > 0)
        <div class="table-responsive">
            <table class="table table-jadwal table-hover">
                <thead>
                    <tr>
                        <th width="10%">Hari</th>
                        <th width="15%">Jam Pelajaran</th>
                        <th width="25%">Guru</th>
                        <th width="15%">Kelas</th>
                        <th width="20%">Mata Pelajaran</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="jadwalTableBody">
                    @foreach($jadwal as $j)
                    @php
                        // INISIALISASI VARIABEL DULU
                        $rowColor = '#e9ecef';
                        $rowBg = '#ffffff';
                        $textColor = '#6c757d';
                        $borderColor = '#dee2e6';
                        $is_totok = false;
                        
                        // NORMALISASI NAMA GURU: hapus gelar dan titik
                        $nama_guru_clean = preg_replace('/,?\s*(S\.?\s*Pd\.?|S\.?t\.?|M\.?\s*Pd\.?)$/i', '', $j->nama_guru);
                        $nama_guru_clean = trim($nama_guru_clean);
                        $nama_slug = \Illuminate\Support\Str::slug($nama_guru_clean);
                        
                        // CEK APAKAH INI TOTOK WARSITO
                        if ($nama_slug === 'totok-warsito') {
                            $is_totok = true;
                            // JIKA TOTOK WARSITO, GUNAKAN WARNA BIRU
                            $rowColor = '#0d6efd';
                            $rowBg = 'rgba(13, 110, 253, 0.1)';
                            $textColor = '#0a58ca';
                            $borderColor = '#0d6efd';
                        }
                        // JIKA BUKAN TOTOK WARSITO, VARIABEL SUDAH DIATAS (default)
                    @endphp
                    
                    <tr class="jadwal-row" 
                        data-hari="{{ $j->hari }}"
                        data-guru-name="{{ $nama_slug }}"
                        data-is-totok="{{ $is_totok ? 'yes' : 'no' }}"
                        style="background-color: {{ $rowBg }}; border-left: 4px solid {{ $borderColor }};"
                        title="Guru: {{ $j->nama_guru }}">
                        
                        <!-- Hari -->
                        <td>
                            @if($is_totok)
                            <span class="hari-badge hari-{{ strtolower($j->hari) }} px-3 py-1 rounded-pill fw-medium" 
                                  style="background-color: {{ $rowBg }}; color: {{ $textColor }}; border: 1px solid {{ $borderColor }};">
                                {{ $j->hari }}
                            </span>
                            @else
                            <span class="hari-badge hari-{{ strtolower($j->hari) }} px-3 py-1 rounded-pill fw-medium" 
                                  style="background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6;">
                                {{ $j->hari }}
                            </span>
                            @endif
                        </td>
                        
                        <!-- Jam Pelajaran -->
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="mb-1">{{ date('H:i', strtotime($j->waktu_mulai)) }} - {{ date('H:i', strtotime($j->waktu_selesai)) }}</strong>
                                @if($is_totok)
                                <span class="time-badge" style="background-color: {{ $rowColor }}; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">
                                    Jam ke-{{ $j->jam_ke }}
                                </span>
                                @else
                                <span class="time-badge" style="background-color: #6c757d; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem;">
                                    Jam ke-{{ $j->jam_ke }}
                                </span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Guru -->
                        <td>
                            <div class="d-flex align-items-center">
                                @if($is_totok)
                                <div class="guru-badge d-flex align-items-center p-2 rounded" 
                                     style="background-color: {{ $rowBg }}; color: {{ $textColor }}; border: 1px solid {{ $borderColor }};">
                                    <i class="bi bi-person-fill me-2" style="color: {{ $rowColor }};"></i>
                                    <span class="fw-semibold">{{ $j->nama_guru }}</span>
                                    <small class="ms-2" style="color: {{ $rowColor }};">
                                        ({{ $jadwal->where('nama_guru', $j->nama_guru)->count() }})
                                    </small>
                                </div>
                                @else
                                <div class="d-flex align-items-center p-2 rounded" 
                                     style="background-color: #f8f9fa; color: #6c757d;">
                                    <i class="bi bi-person me-2 text-muted"></i>
                                    <span class="fw-medium">{{ $j->nama_guru }}</span>
                                    <small class="ms-2 text-muted">
                                        ({{ $jadwal->where('nama_guru', $j->nama_guru)->count() }})
                                    </small>
                                </div>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Kelas -->
                        <td>
                            @if($is_totok)
                            <span class="badge py-2 px-3 rounded-pill d-inline-flex align-items-center"
                                  style="background-color: {{ $rowBg }}; color: {{ $textColor }}; border: 1px solid {{ $borderColor }};">
                                <i class="bi bi-building me-1"></i> 
                                <span class="fw-medium">{{ $j->nama_kelas }}</span>
                            </span>
                            @else
                            <span class="badge py-2 px-3 rounded-pill d-inline-flex align-items-center"
                                  style="background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6;">
                                <i class="bi bi-building me-1 text-muted"></i> 
                                <span class="fw-medium">{{ $j->nama_kelas }}</span>
                            </span>
                            @endif
                        </td>
                        
                        <!-- Mata Pelajaran -->
                        <td>
                            @if($is_totok)
                            <span class="fw-medium" style="color: {{ $textColor }};">{{ $j->mata_pelajaran }}</span>
                            @else
                            <span class="fw-medium text-muted">{{ $j->mata_pelajaran }}</span>
                            @endif
                        </td>
                        
                      <!-- Aksi -->
<td>
    <div class="d-flex gap-2">
        <!-- Tombol Edit -->
        <a href="{{ route('admin.jadwal.edit', $j->id) }}" 
           class="btn btn-outline-primary btn-sm btn-action"
           data-bs-toggle="tooltip" 
           title="Edit Jadwal">
            <i class="bi bi-pencil"></i>
        </a>
        
        <!-- Tombol Hapus -->
        <form action="{{ route('admin.jadwal.destroy', $j->id) }}" 
              method="POST" class="d-inline"
              onsubmit="return confirmDelete()">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm btn-action"
                    data-bs-toggle="tooltip" 
                    title="Hapus Jadwal">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Informasi Mode Warna -->
        <div class="mt-4 p-3 rounded" style="background-color: #f8f9fa;">
            <div class="row">
                <div class="col-md-8">
                    <h6 class="mb-2 d-flex align-items-center">
                        <i class="bi bi-info-circle me-2 text-primary"></i> 
                        <span>Mode Single Color Aktif</span>
                    </h6>
                    <p class="mb-0 text-muted">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        Hanya <strong class="text-primary">Totok Warsito</strong> yang memiliki warna (Biru).<br>
                        <i class="bi bi-x-circle-fill text-secondary me-1"></i>
                        Guru lainnya ditampilkan tanpa warna khusus.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-outline-primary btn-sm" onclick="enableAllColors()">
                        <i class="bi bi-palette me-1"></i> Aktifkan Semua Warna
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Statistik -->
        <div class="row mt-4">
            @php
                // Hitung jumlah jadwal Totok Warsito
                $totok_count = 0;
                foreach($jadwal as $j) {
                    $nama_clean = preg_replace('/,?\s*(S\.?\s*Pd\.?|S\.?t\.?|M\.?\s*Pd\.?)$/i', '', $j->nama_guru);
                    $nama_clean = trim($nama_clean);
                    $slug = \Illuminate\Support\Str::slug($nama_clean);
                    if ($slug === 'totok-warsito') {
                        $totok_count++;
                    }
                }
                $other_count = $jadwal->count() - $totok_count;
            @endphp
            
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card card-hover">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Guru Berwarna</p>
                            <h3 class="fw-bold mb-0 text-primary">{{ $totok_count > 0 ? '1' : '0' }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-palette fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card card-hover">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Guru Tanpa Warna</p>
                            <h3 class="fw-bold mb-0 text-secondary">{{ $other_count }}</h3>
                        </div>
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-palette fs-4 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card card-hover">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Jadwal Totok Warsito</p>
                            <h3 class="fw-bold mb-0 text-primary">{{ $totok_count }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-person-fill fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stats-card card-hover">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Jadwal</p>
                            <h3 class="fw-bold mb-0">{{ $jadwal->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-calendar-check fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-calendar-x text-muted"></i>
            <h4 class="text-muted mb-3">Belum Ada Jadwal</h4>
            <p class="mb-4">Tambahkan jadwal mengajar pertama Anda menggunakan form di atas</p>
            <button class="btn btn-gradient" onclick="scrollToForm()">
                <i class="bi bi-plus-circle me-2"></i> Tambah Jadwal Pertama
            </button>
        </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
    // ============================================
    // FUNGSI UNTUK TOGGLE WARNA
    // ============================================
    
    function enableAllColors() {
        // Buat konfirmasi sebelum mengaktifkan semua warna
        if (confirm('Aktifkan warna untuk semua guru? Ini akan mengubah mode tampilan.')) {
            // Reload halaman dengan parameter untuk mengaktifkan semua warna
            window.location.href = window.location.pathname + '?color_mode=all';
        }
    }
    
    function showOnlyTotok() {
        const rows = document.querySelectorAll('.jadwal-row');
        let totokCount = 0;
        let otherCount = 0;
        
        rows.forEach(row => {
            const isTotok = row.dataset.isTotok === 'yes';
            if (isTotok) {
                row.style.display = '';
                totokCount++;
            } else {
                row.style.display = 'none';
                otherCount++;
            }
        });
        
        // Update counter
        const counterElement = document.querySelector('.text-muted strong');
        if (counterElement) {
            counterElement.textContent = totokCount;
        }
        
        showToast(`Menampilkan ${totokCount} jadwal Totok Warsito. ${otherCount} jadwal guru lain disembunyikan.`, 'info');
        
        // Update filter button
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    }
    
    function showAllTeachers() {
        document.querySelectorAll('.jadwal-row').forEach(row => {
            row.style.display = '';
        });
        
        // Update counter
        const counterElement = document.querySelector('.text-muted strong');
        if (counterElement) {
            counterElement.textContent = {{ $jadwal->count() }};
        }
        
        showToast('Menampilkan semua jadwal', 'info');
        
        // Update filter button
        document.querySelector('.filter-btn[data-hari="all"]').classList.add('active');
    }
    
    // ============================================
    // FILTER HARI
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const jadwalRows = document.querySelectorAll('.jadwal-row');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class dari semua button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class ke button yang diklik
                this.classList.add('active');
                
                const selectedHari = this.dataset.hari;
                let visibleCount = 0;
                
                // Filter rows
                jadwalRows.forEach(row => {
                    if (selectedHari === 'all' || row.dataset.hari === selectedHari) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Update counter di footer
                const counterElement = document.querySelector('.row.mt-4 .col-md-3:last-child h3');
                if (counterElement && selectedHari === 'all') {
                    counterElement.textContent = {{ $jadwal->count() }};
                }
            });
        });
    });
    
    // ============================================
    // COLOR MANAGEMENT FUNCTIONS
    // ============================================
    function toggleColorMode() {
        // Cycle through intensities: low -> medium -> high -> low
        if (colorIntensity === 0.03) {
            colorIntensity = 0.08;
            updateRowColors();
            showToast('Mode warna: Medium intensity', 'info');
        } else if (colorIntensity === 0.08) {
            colorIntensity = 0.15;
            updateRowColors();
            showToast('Mode warna: High intensity', 'info');
        } else {
            colorIntensity = 0.03;
            updateRowColors();
            showToast('Mode warna: Low intensity', 'info');
        }
    }
    
    function updateRowColors() {
        const rows = document.querySelectorAll('.jadwal-row');
        
        rows.forEach(row => {
            const guruHash = row.dataset.guruHash;
            if (guruHash) {
                const hue = guruHash % 360;
                
                // Update background color dengan intensity baru
                row.style.backgroundColor = `hsla(${hue}, 70%, 45%, ${colorIntensity})`;
                
                // Update hover effect juga
                const currentRow = row;
                currentRow.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = `hsla(${hue}, 70%, 45%, ${colorIntensity + 0.05})`;
                });
                
                currentRow.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = `hsla(${hue}, 70%, 45%, ${colorIntensity})`;
                });
            }
        });
    }
    
    function highlightGuru(guruSlug) {
        const rows = document.querySelectorAll('.jadwal-row');
        
        rows.forEach(row => {
            if (row.dataset.guruName === guruSlug) {
                row.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    row.classList.remove('animate__animated', 'animate__pulse');
                }, 1500);
            } else {
                row.style.opacity = '0.4';
            }
        });
        
        setTimeout(() => {
            rows.forEach(row => {
                row.style.opacity = '';
            });
        }, 2000);
    }
    
    function showColorGuide() {
        const modal = new bootstrap.Modal(document.getElementById('infoModal'));
        modal.hide();
        
        setTimeout(() => {
            alert('Panduan Warna Guru:\n\n' +
                  '• Totok Warsito: Biru\n' +
                  '• Siti Aminah: Hijau\n' +
                  '• Budi Santoso: Orange\n' +
                  '• Joko Susanto: Cyan\n' +
                  '• Heri Kristianto: Merah\n' +
                  '• Guru Lain: Warna unik otomatis');
        }, 300);
    }
    
    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.');
    }
    
    function scrollToForm() {
        const formCard = document.querySelector('.jadwal-header');
        formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Tambah efek highlight
        formCard.parentElement.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            formCard.parentElement.classList.remove('animate__animated', 'animate__pulse');
        }, 1000);
    }
    
    function searchJadwal() {
        const input = document.getElementById('searchInput');
        if (!input) return;
        
        const filter = input.value.toUpperCase();
        const rows = document.querySelectorAll('.jadwal-row');
        
        rows.forEach(row => {
            const text = row.textContent.toUpperCase();
            row.style.display = text.indexOf(filter) > -1 ? '' : 'none';
        });
    }
    
    // ============================================
    // PRINT & EXPORT FUNCTIONS
    // ============================================
    function printJadwal() {
        const originalContent = document.body.innerHTML;
        
        // Ambil hanya bagian tabel dan statistik
        const tableContent = document.querySelector('.table-responsive').innerHTML;
        const statsElement = document.querySelector('.row.mt-4');
        const statsContent = statsElement ? statsElement.innerHTML : '';
        const gridElement = document.querySelector('.mt-4 .d-flex.flex-wrap');
        const gridContent = gridElement ? gridElement.innerHTML : '';
        
        document.body.innerHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak Jadwal Mengajar - {{ date('d/m/Y') }}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    @media print {
                        body { padding: 15px; font-size: 11px; }
                        .no-print { display: none !important; }
                        .table { border-collapse: collapse; width: 100%; font-size: 10px; }
                        .table th { background-color: #f8f9fa !important; }
                        .guru-badge { 
                            padding: 2px 6px; 
                            border-radius: 3px;
                            display: inline-block;
                            font-size: 10px;
                        }
                        .badge { font-size: 10px; }
                        .print-section { page-break-inside: avoid; }
                    }
                    @media screen {
                        body { padding: 20px; }
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 20px;
                        border-bottom: 2px solid #4361ee;
                        padding-bottom: 10px;
                    }
                    .color-preview {
                        width: 12px;
                        height: 12px;
                        display: inline-block;
                        border-radius: 2px;
                        margin-right: 5px;
                        border: 1px solid #ddd;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="print-header">
                        <h2 style="color: #4361ee;">Jadwal Mengajar</h2>
                        <p><strong>SMA UKK RPL</strong> - Dicetak: ${new Date().toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                    </div>
                    
                    <div class="print-section">
                        ${tableContent}
                    </div>
                    
                    ${statsContent ? `
                    <div class="print-section mt-4">
                        <h5>Statistik Jadwal</h5>
                        ${statsContent}
                    </div>
                    ` : ''}
                    
                    ${gridContent ? `
                    <div class="print-section mt-4">
                        <h5>Visualisasi Guru</h5>
                        <div class="mt-2">
                            ${gridContent}
                        </div>
                    </div>
                    ` : ''}
                    
                    <div class="text-center mt-4 no-print">
                        <button onclick="window.close()" class="btn btn-primary btn-sm">Tutup</button>
                        <button onclick="window.print()" class="btn btn-success btn-sm">Cetak Sekarang</button>
                    </div>
                </div>
                
                <script>
                    // Script untuk print
                    document.addEventListener('DOMContentLoaded', function() {
                        // Highlight row sesuai dengan print
                        const rows = document.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            row.addEventListener('mouseover', function() {
                                this.style.backgroundColor = '#f8f9fa';
                            });
                            row.addEventListener('mouseout', function() {
                                this.style.backgroundColor = '';
                            });
                        });
                    });
                <\/script>
            </body>
            </html>
        `;
        
        // Tunggu sebentar lalu print
        setTimeout(() => {
            window.print();
            document.body.innerHTML = originalContent;
        }, 500);
    }
    
    function exportJadwal() {
        // Simulasi export data
        const rows = document.querySelectorAll('.jadwal-row');
        const exportData = [];
        
        rows.forEach(row => {
            const guruName = row.querySelector('.guru-badge span')?.textContent || '';
            const hari = row.querySelector('.hari-badge')?.textContent || '';
            const waktu = row.querySelector('td:nth-child(2) strong')?.textContent || '';
            const kelas = row.querySelector('.badge.bg-dark')?.textContent.trim() || '';
            const mapel = row.querySelector('td:nth-child(5) span')?.textContent || '';
            
            exportData.push({
                guru: guruName,
                hari: hari,
                waktu: waktu,
                kelas: kelas,
                mapel: mapel
            });
        });
        
        // Convert ke JSON (bisa dikembangkan ke CSV/Excel)
        const jsonData = JSON.stringify(exportData, null, 2);
        const blob = new Blob([jsonData], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `jadwal-mengajar-${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        showToast('Data jadwal berhasil di-export!', 'success');
    }
    
    // ============================================
    // EDIT FUNCTION (PLACEHOLDER)
    // ============================================
    function editJadwal(id) {
        showToast(`Fitur edit jadwal ID: ${id} akan segera tersedia!`, 'info');
    }
    
    // ============================================
    // TOAST NOTIFICATION (from layout)
    // ============================================
    function showToast(message, type = 'success') {
        // Cek jika function sudah ada dari layout
        if (typeof window.showToast === 'function') {
            return window.showToast(message, type);
        }
        
        // Fallback jika tidak ada di layout
        var toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        var bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove after hide
        toast.addEventListener('hidden.bs.toast', function () {
            document.body.removeChild(toast);
        });
    }
    let selectedJamIds = [];
let allJamData = [];

// Fungsi untuk update info guru & kelas
function updateKelasOptions() {
    const guruId = document.getElementById('selectGuru').value;
    const kelasSelect = document.getElementById('selectKelas');
    
    // Reset jam container
    document.getElementById('jamContainer').style.display = 'none';
    document.getElementById('submitBtn').disabled = true;
    
    if (guruId) {
        // Bisa tambahkan filter kelas berdasarkan guru (jika ada relasi khusus)
        // Untuk sekarang, tampilkan semua kelas
    }
}

function updateHariOptions() {
    document.getElementById('jamContainer').style.display = 'none';
    document.getElementById('submitBtn').disabled = true;
}

// Fungsi utama: load jam yang tersedia
async function loadJamAvailable() {
    const guruId = document.getElementById('selectGuru').value;
    const kelasId = document.getElementById('selectKelas').value;
    const hari = document.getElementById('selectHari').value;
    const mapel = document.getElementById('mataPelajaran').value;
    
    if (!guruId || !kelasId || !hari || !mapel) {
        return;
    }
    
    // Update info display
    const guruName = document.getElementById('selectGuru').options[document.getElementById('selectGuru').selectedIndex].text;
    const kelasName = document.getElementById('selectKelas').options[document.getElementById('selectKelas').selectedIndex].text;
    document.getElementById('infoGuruKelas').innerHTML = 
        `<strong>${guruName}</strong> di <strong>${kelasName}</strong> hari <strong>${hari}</strong>`;
    
    // Ambil semua jam sekolah
    const response = await fetch('/api/jam-sekolah');
    const jamData = await response.json();
    allJamData = jamData;
    
    // Ambil jam yang sudah dipakai oleh guru ini di hari tersebut
    const response2 = await fetch(`/api/jadwal-terpakai?guru_id=${guruId}&hari=${hari}`);
    const jamTerpakai = await response2.json();
    
    // Ambil jam yang sudah dipakai oleh kelas ini di hari tersebut
    const response3 = await fetch(`/api/jadwal-kelas?kelas_id=${kelasId}&hari=${hari}`);
    const jamKelasTerpakai = await response3.json();
    
    // Tampilkan jam-jam yang tersedia
    const jamListDiv = document.getElementById('jamList');
    jamListDiv.innerHTML = '';
    
    selectedJamIds = []; // Reset selected
    
    jamData.forEach((jam, index) => {
        const isGuruTerpakai = jamTerpakai.some(j => j.jam_ke_id == jam.id);
        const isKelasTerpakai = jamKelasTerpakai.some(j => j.jam_ke_id == jam.id);
        const isTerpakai = isGuruTerpakai || isKelasTerpakai;
        
        const jamElement = document.createElement('div');
        jamElement.className = 'col-md-3 col-sm-6 mb-3';
        jamElement.innerHTML = `
            <div class="jam-card ${isTerpakai ? 'bg-light text-muted' : 'jam-card-available'} p-3 rounded border">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           id="jam_${jam.id}" 
                           value="${jam.id}"
                           ${isTerpakai ? 'disabled' : 'onchange="toggleJam(' + jam.id + ')"'}
                           data-waktu="${jam.waktu_mulai} - ${jam.waktu_selesai}">
                    <label class="form-check-label w-100" for="jam_${jam.id}">
                        <div class="fw-bold ${isTerpakai ? 'text-muted' : ''}">
                            Jam ke-${jam.jam_ke}
                        </div>
                        <small class="d-block ${isTerpakai ? 'text-muted' : 'text-dark'}">
                            ${jam.waktu_mulai} - ${jam.waktu_selesai}
                        </small>
                        ${isTerpakai ? 
                            '<small class="text-danger"><i class="bi bi-exclamation-circle"></i> Terpakai</small>' : 
                            '<small class="text-success"><i class="bi bi-check-circle"></i> Tersedia</small>'
                        }
                    </label>
                </div>
            </div>
        `;
        
        jamListDiv.appendChild(jamElement);
    });
    
    // Tampilkan container
    document.getElementById('jamContainer').style.display = 'block';
}

// Toggle jam terpilih
function toggleJam(jamId) {
    const checkbox = document.getElementById(`jam_${jamId}`);
    const isChecked = checkbox.checked;
    
    if (isChecked) {
        if (!selectedJamIds.includes(jamId)) {
            selectedJamIds.push(jamId);
        }
    } else {
        const index = selectedJamIds.indexOf(jamId);
        if (index > -1) {
            selectedJamIds.splice(index, 1);
        }
    }
    
    // Update tombol submit
    document.getElementById('submitBtn').disabled = selectedJamIds.length === 0;
    
    // Update preview jika modal terbuka
    updatePreview();
}

function selectAllJam() {
    selectedJamIds = [];
    allJamData.forEach(jam => {
        const checkbox = document.getElementById(`jam_${jam.id}`);
        if (checkbox && !checkbox.disabled) {
            checkbox.checked = true;
            selectedJamIds.push(jam.id);
        }
    });
    document.getElementById('submitBtn').disabled = false;
    updatePreview();
}

function clearAllJam() {
    selectedJamIds = [];
    allJamData.forEach(jam => {
        const checkbox = document.getElementById(`jam_${jam.id}`);
        if (checkbox) checkbox.checked = false;
    });
    document.getElementById('submitBtn').disabled = true;
    updatePreview();
}

function updatePreview() {
    const guruName = document.getElementById('selectGuru').options[document.getElementById('selectGuru').selectedIndex].text;
    const kelasName = document.getElementById('selectKelas').options[document.getElementById('selectKelas').selectedIndex].text;
    const hari = document.getElementById('selectHari').value;
    const mapel = document.getElementById('mataPelajaran').value;
    
    let previewHTML = `
        <p><strong>Guru:</strong> ${guruName}</p>
        <p><strong>Kelas:</strong> ${kelasName}</p>
        <p><strong>Hari:</strong> ${hari}</p>
        <p><strong>Mata Pelajaran:</strong> ${mapel}</p>
        <hr>
        <h6>Jam yang akan ditambahkan (${selectedJamIds.length} jam):</h6>
        <ul class="list-group">
    `;
    
    selectedJamIds.forEach(jamId => {
        const jam = allJamData.find(j => j.id == jamId);
        if (jam) {
            previewHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-clock me-2"></i>
                        Jam ke-${jam.jam_ke} (${jam.waktu_mulai} - ${jam.waktu_selesai})
                    </span>
                    <span class="badge bg-primary">${jam.jam_ke}</span>
                </li>
            `;
        }
    });
    
    previewHTML += `</ul>`;
    document.getElementById('previewContent').innerHTML = previewHTML;
}

function showPreview() {
    updatePreview();
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

async function submitForm() {
    const form = document.querySelector('form');
    const formData = new FormData(form);
    
    // Tambahkan jam terpilih ke FormData
    selectedJamIds.forEach(jamId => {
        formData.append('jam_ke_ids[]', jamId);
    });
    
    // Kirim ke server
    try {
        const response = await fetch('/admin/jadwal/store-multi-jam', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showToast(`${result.count} jadwal berhasil ditambahkan!`, 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showToast(result.message || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'error');
    }
}

function resetForm() {
    selectedJamIds = [];
    document.getElementById('jamContainer').style.display = 'none';
    document.getElementById('submitBtn').disabled = true;
}
    
    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        // Ctrl + P untuk print
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            printJadwal();
        }
        
        // Ctrl + E untuk export
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            exportJadwal();
        }
        
        // Ctrl + F untuk focus search
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Escape untuk reset filter
        if (e.key === 'Escape') {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector('.filter-btn[data-hari="all"]').classList.add('active');
            document.querySelectorAll('.jadwal-row').forEach(row => row.style.display = '');
            updateCounter({{ $jadwal->count() }}, 'all');
        }
    });
</script>
<style>
.jam-card-available {
    background-color: #f8fff8;
    border: 1px solid #d4edda !important;
    cursor: pointer;
    transition: all 0.3s;
}
.jam-card-available:hover {
    background-color: #e8f5e9;
    transform: translateY(-2px);
}
</style>
@endsection