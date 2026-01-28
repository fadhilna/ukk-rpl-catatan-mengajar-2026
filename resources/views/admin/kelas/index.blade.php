@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<!-- NAVBAR SAMA PERSIS SEPERTI DI DASHBOARD -->
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
                </div>
                <div class="d-none d-lg-block">
                    <button class="btn btn-gradient px-4" data-bs-toggle="modal" data-bs-target="#tambahKelas">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kelas Baru
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="col-md-4">
            <div class="stats-card animate__animated animate__fadeInRight">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Kelas</h6>
                        <h3 class="fw-bold mb-0 text-primary">{{ $kelas->count() }}</h3>
                    </div>
                    <div class="bg-primary rounded-circle p-3">
                        <i class="bi bi-building text-white fs-4"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i> 
                        Kelola data kelas sekolah
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card card-hover shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-table me-2"></i>Daftar Kelas
                        </h5>
                        <div class="d-flex">
                            <!-- Search untuk mobile -->
                            <div class="input-group input-group-sm me-2 d-lg-none" style="width: 150px;">
                                <input type="text" id="searchInputMobile" class="form-control" placeholder="Cari...">
                            </div>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKelas">
                                <i class="bi bi-plus"></i>
                                <span class="d-none d-md-inline">Tambah</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if($kelas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>
                                        <i class="bi bi-building me-1"></i>Nama Kelas
                                    </th>
                                    <th class="text-center">
                                        <i class="bi bi-people me-1"></i>Jumlah Siswa
                                    </th>
                                    <th>
                                        <i class="bi bi-calendar me-1"></i>Dibuat
                                    </th>
                                    <th class="text-center">
                                        <i class="bi bi-gear me-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelas as $k)
                                <tr class="animate__animated animate__fadeIn animate__faster">
                                    <td class="text-center fw-bold text-primary">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-building text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $k->nama_kelas }}</h6>
                                                <small class="text-muted">ID: KLS{{ str_pad($k->id, 3, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info badge-pulse px-3 py-2">
                                            <i class="bi bi-person-fill me-1"></i>
                                            {{ $total_siswa[$k->id] ?? 0 }} siswa
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-clock-history text-muted me-2"></i>
                                            <span class="text-muted">
                                                {{ date('d M Y', strtotime($k->created_at)) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Detail Kelas">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Edit Kelas">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('admin.kelas.destroy', $k->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus Kelas">
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
                    
                    <!-- Footer Table -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <span class="text-muted">
                                Menampilkan {{ $kelas->count() }} dari {{ $kelas->count() }} kelas
                            </span>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-5 my-5 animate__animated animate__pulse">
                        <div class="mb-4">
                            <i class="bi bi-people display-1 text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum ada data kelas</h4>
                        <p class="text-muted mb-4">Mulai dengan menambahkan kelas pertama Anda</p>
                        <button class="btn btn-gradient px-4" data-bs-toggle="modal" data-bs-target="#tambahKelas">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Kelas Pertama
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="/admin" class="btn btn-outline-primary animate__animated animate__fadeInLeft">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
                <a href="/admin/guru" class="btn btn-outline-success animate__animated animate__fadeInRight">
                    <i class="bi bi-people me-2"></i>Lihat Data Guru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate__animated animate__zoomIn">
            <div class="modal-header bg-gradient text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kelas Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.kelas.store') }}" id="formTambahKelas">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-building me-1"></i>Nama Kelas
                        </label>
                        <input type="text" name="nama_kelas" class="form-control form-control-lg" 
                               placeholder="Contoh: X RPL 1, XI TKJ 2" required
                               autofocus>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Format: Tingkat Jurusan Nomor (X RPL 1)
                        </div>
                    </div>
                    
                    <!-- Preview -->
                    <div class="card border-dashed mt-3">
                        <div class="card-body text-center">
                            <i class="bi bi-eye text-primary fs-4 mb-2"></i>
                            <h6 class="card-title">Preview Kelas</h6>
                            <div id="previewKelas" class="text-muted">
                                Akan muncul setelah diisi
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-save me-1"></i>Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Additional Scripts -->
@section('scripts')
<script>
    $(document).ready(function() {
        // Live preview nama kelas
        $('input[name="nama_kelas"]').on('input', function() {
            var nama = $(this).val();
            if (nama) {
                $('#previewKelas').html(`
                    <div class="alert alert-info p-2 mb-0">
                        <i class="bi bi-building me-2"></i>
                        <strong>${nama}</strong>
                    </div>
                `);
            } else {
                $('#previewKelas').html('<span class="text-muted">Akan muncul setelah diisi</span>');
            }
        });
        
        // Validasi form
        $('#formTambahKelas').on('submit', function(e) {
            var nama = $('input[name="nama_kelas"]').val().trim();
            if (!nama) {
                e.preventDefault();
                showToast('Nama kelas harus diisi!', 'danger');
                $('input[name="nama_kelas"]').addClass('is-invalid').focus();
                return false;
            }
            
            // Simulasi loading
            $('button[type="submit"]').html(`
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Menyimpan...
            `).prop('disabled', true);
        });
        
        // Animasi saat modal ditutup
        $('#tambahKelas').on('hidden.bs.modal', function () {
            $('input[name="nama_kelas"]').val('');
            $('#previewKelas').html('<span class="text-muted">Akan muncul setelah diisi</span>');
        });
        
        // Search functionality
        $('#searchInput, #searchInputMobile').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                var text = $(this).text().toLowerCase();
                if (text.indexOf(value) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    
    // Confirmation dengan sweet alert style
    function confirmDelete(form) {
        if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
            form.submit();
        }
        return false;
    }
</script>
@endsection
@endsection