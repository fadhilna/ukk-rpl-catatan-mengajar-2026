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


<!-- KONTEN GURU (KONTEN ASLI TANPA PERUBAHAN) -->
<div class="container-fluid px-4 pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      
    
    </div>
     <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-14">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-person-plus"></i> Tambah Data Guru Baru
                        </h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.guru.store') }}" onsubmit="return validasiForm()">
                            @csrf
                            
                            <h5 class="mb-3">Data Pribadi</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Guru *</label>
                                    <input type="text" name="nama" class="form-control" required 
                                           placeholder="Nama lengkap guru">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" name="nip" class="form-control" 
                                           placeholder="Nomor Induk Pegawai">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="email@sekolah.sch.id">
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            <h5 class="mb-3">Data Login</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username *</label>
                                    <input type="text" name="username" class="form-control" required 
                                           placeholder="Username untuk login">
                                    <div class="form-text">Minimal 3 karakter</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password *</label>
                                    <input type="password" name="password" id="password" 
                                           class="form-control" required minlength="6">
                                    <div class="form-text">Minimal 6 karakter</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password *</label>
                                    <input type="password" name="password_confirmation" 
                                           id="password_confirmation" class="form-control" required>
                                    <div class="form-text">Harus sama dengan password</div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Data Guru
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        <small>
                            <i class="bi bi-info-circle"></i> 
                            Data yang bertanda * wajib diisi. Password akan dienkripsi MD5.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

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