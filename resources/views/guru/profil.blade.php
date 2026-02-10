@extends('layouts.admin') {{-- atau layouts.guru jika Anda punya --}}

@section('title', 'Profil Guru')

@section('content')
<nav class="navbar navbar-glow navbar-expand-lg shadow">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold text-white" href="/guru">
            <i class="bi bi-person-badge me-2"></i>
            <span class="d-none d-md-inline">Portal Guru</span>
        </a>
        
        <!-- Menu untuk desktop -->
        <div class="d-none d-lg-flex ms-4">
            <div class="navbar-nav">
                <a class="nav-link text-white mx-2 {{ request()->is('guru') ? 'active' : '' }}" 
                   href="/guru">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('guru/kegiatan*') ? 'active' : '' }}" 
                   href="/guru/kegiatan">
                    <i class="bi bi-journal-check me-1"></i> Kegiatan
                </a>
                <a class="nav-link text-white mx-2 active" 
                   href="/guru/profil">
                    <i class="bi bi-person-circle me-1"></i> Profil
                </a>
            </div>
        </div>
        
        <!-- Profil -->
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
                   data-bs-toggle="dropdown">
                    <div class="me-2">
                        <div class="profile-img bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill text-primary"></i>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-semibold">{{ session('username') ?? 'Guru' }}</div>
                        <small class="opacity-75">Guru</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="/guru">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item active" href="/guru/profil">
                            <i class="bi bi-person-circle me-2"></i>Profil
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

<!-- KONTEN PROFIL -->
<div class="container-fluid px-4 pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">
                <i class="bi bi-person-circle"></i> Profil Guru
            </h3>
            <p class="text-muted mb-0">Informasi akun dan data pribadi</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="profile-img-lg bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h4>{{ $guru->nama ?? session('username') }}</h4>
                    <p class="text-muted mb-2">
                        <i class="bi bi-award me-1"></i> Guru
                    </p>
                    <p class="text-muted">
                        <i class="bi bi-clock-history me-1"></i> 
                        Bergabung: {{ date('d M Y', strtotime($guru->created_at ?? now())) }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-info-circle me-2"></i> Informasi Pribadi
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <div class="form-control bg-light">{{ $guru->nama ?? 'Tidak tersedia' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">NIP</label>
                            <div class="form-control bg-light">{{ $guru->nip ?? 'Tidak tersedia' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Email</label>
                            <div class="form-control bg-light">{{ $guru->email ?? 'Tidak tersedia' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Username</label>
                            <div class="form-control bg-light">{{ $guru->username ?? session('username') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Peran</label>
                            <div class="form-control bg-light">
                                <span class="badge bg-primary">Guru</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Status Akun</label>
                            <div class="form-control bg-light">
                                <span class="badge bg-success">Aktif</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="/guru/profil/edit" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </a>
                        <a href="/guru/profil/ubah-password" class="btn btn-outline-primary ms-2">
                            <i class="bi bi-key"></i> Ubah Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="/guru" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection