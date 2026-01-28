@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<!-- NAVBAR SAMA SEPERTI DI ATAS -->
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
                <!-- MENU DATA SISWA (AKTIF) -->
                <a class="nav-link text-white mx-2 active" 
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

<!-- KONTEN DATA SISWA -->
<div class="container-fluid px-4 pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-people-fill text-primary me-2"></i>Data Siswa
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item active">Siswa</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSiswa">
            <i class="bi bi-plus-circle"></i> Tambah Siswa
        </button>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <!-- Tabel Siswa -->
    <div class="card card-hover">
        <div class="card-body">
            @if($siswa->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                  <!-- Di bagian tabel, update kolom: -->
<thead class="table-dark">
    <tr>
        <th width="50">#</th>
        <th width="100">NIS</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        <th width="120">Tanggal Daftar</th>
        <th width="100">Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach($siswa as $s)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td>
            <span class="badge bg-dark">{{ $s->nis ?? 'N/A' }}</span>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                     style="width: 32px; height: 32px;">
                    {{ strtoupper(substr($s->nama, 0, 1)) }}
                </div>
                <div>
                    <strong>{{ $s->nama }}</strong>
                </div>
            </div>
        </td>
        <td>
            <span class="badge bg-success">{{ $s->nama_kelas }}</span>
        </td>
        <td>
            <small>{{ date('d/m/Y', strtotime($s->created_at)) }}</small>
        </td>
        <td>
            <form action="{{ url('/admin/siswa/' . $s->id . '/delete') }}" 
                  method="GET" 
                  onsubmit="return confirm('Hapus siswa {{ $s->nama }}?')">
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
            @else
            <div class="text-center py-5">
                <i class="bi bi-people display-4 text-muted"></i>
                <h5 class="text-muted mt-3">Belum ada data siswa</h5>
                <p>Tambahkan siswa pertama Anda</p>
            </div>
            @endif
        </div>
    </div>
    
  <!-- GANTI SEMUA BAGIAN FORM DENGAN INI: -->

<!-- Form Tambah Siswa -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-person-plus"></i> Tambah Siswa Baru
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/admin/siswa/store') }}">
            @csrf
            <div class="row g-3">
                <!-- KOLOM 1: NIS (WAJIB) -->
                <div class="col-md-3">
                    <label class="form-label">
                        <i class="bi bi-123 text-danger"></i> NIS
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nis" class="form-control" required 
                           placeholder="Contoh: 20240001" 
                           maxlength="20"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <div class="form-text">
                        <small>Nomor Induk Siswa (angka saja)</small>
                    </div>
                </div>
                
                <!-- KOLOM 2: NAMA (WAJIB) -->
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="bi bi-person text-danger"></i> Nama Lengkap
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama" class="form-control" required 
                           placeholder="Contoh: Andi Wijaya">
                    <div class="form-text">
                        <small>Masukkan nama lengkap siswa</small>
                    </div>
                </div>
                
                <!-- KOLOM 3: KELAS (WAJIB) -->
                <div class="col-md-3">
                    <label class="form-label">
                        <i class="bi bi-house-door text-danger"></i> Kelas
                        <span class="text-danger">*</span>
                    </label>
                    <select name="kelas_id" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">
                        <small>Pilih kelas tempat siswa belajar</small>
                    </div>
                </div>
                
                <!-- KOLOM 4: TOMBOL SIMPAN -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </div>
            
            <!-- INFO VALIDASI -->
            <div class="mt-3">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> 
                    <strong>Catatan:</strong> Field dengan tanda (<span class="text-danger">*</span>) wajib diisi.
                </small>
            </div>
        </form>
    </div>
</div>
    </div>
</div>
@endsection