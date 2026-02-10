@extends('layouts.admin')

@section('title', 'Data Guru')

@section('content')
<!-- NAVBAR DENGAN MENU -->
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
                <a class="nav-link text-white mx-2 active" 
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


<div class="container-fluid px-4 pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Header content can be added here -->
    </div>
    
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-hover mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-person-plus me-2"></i> Tambah Data Guru Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.guru.store') }}" onsubmit="return validasiForm()">
                            @csrf
                            
                            <h6 class="mb-3 text-primary fw-semibold border-bottom pb-2">
                                <i class="bi bi-person-vcard me-2"></i> Data Pribadi
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Guru <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" required 
                                           placeholder="Nama lengkap guru">
                                    <small class="text-muted">Masukkan nama lengkap guru</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">NIP</label>
                                    <input type="text" name="nip" class="form-control" 
                                           placeholder="Nomor Induk Pegawai">
                                    <small class="text-muted">Masukkan NIP guru (opsional)</small>
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="email@sekolah.sch.id">
                                    <small class="text-muted">Masukkan email valid guru</small>
                                </div>
                                <div class="col-md-6">
                                    <!-- Additional field can be added here -->
                                </div>
                            </div>
                            
                            <h6 class="mb-3 mt-4 text-primary fw-semibold border-bottom pb-2">
                                <i class="bi bi-key me-2"></i> Data Login
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control" required 
                                           placeholder="Username untuk login">
                                    <small class="text-muted">Minimal 3 karakter</small>
                                </div>
                                <div class="col-md-6">
                                    <!-- Spacer for alignment -->
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" 
                                           class="form-control" required minlength="6">
                                    <small class="text-muted">Minimal 6 karakter</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" 
                                           id="password_confirmation" class="form-control" required>
                                    <small class="text-muted">Harus sama dengan password di atas</small>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-save me-2"></i> Simpan Data Guru
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-2"></i> Reset Form
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-muted bg-light">
                        <small>
                            <i class="bi bi-info-circle me-1"></i> 
                            Data yang bertanda <span class="text-danger">*</span> wajib diisi. Password akan dienkripsi dengan MD5.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>
      <div>
            <h3 class="mb-1">
                <i class="bi bi-people"></i> Data Guru
            </h3>
            <p class="text-muted mb-0">Manajemen data guru sekolah</p>
        </div>

    <!-- Tabel Guru -->
    <div class="card">
        <div class="card-body">
            @if($gurus->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nama Guru</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gurus as $guru)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $guru->nama }}</strong></td>
                            <td>{{ $guru->nip ?: '-' }}</td>
                            <td>{{ $guru->email ?: '-' }}</td>
                            <td>{{ $guru->username }}</td>
                            <td>
                                <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus guru {{ $guru->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-muted">Total: {{ $gurus->count() }} guru</p>
            @else
            <div class="text-center py-5">
                <i class="bi bi-people display-4 text-muted"></i>
                <h5 class="text-muted mt-3">Belum ada data guru</h5>
                <p>Tambahkan guru pertama Anda</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="/admin" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection