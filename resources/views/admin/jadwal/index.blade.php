@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')

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
                <a class="nav-link text-white mx-2 {{ request()->is('admin/guru*') ? 'active' : '' }}" 
                   href="/admin/guru">
                    <i class="bi bi-people me-1"></i> Guru
                </a>
                <a class="nav-link text-white mx-2 {{ request()->is('admin/kelas*') ? 'active' : '' }}" 
                   href="/admin/kelas">
                    <i class="bi bi-building me-1"></i> Kelas
                </a>
                <a class="nav-link text-white mx-2 active" 
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

<!-- KONTEN JADWAL (KONTEN ASLI TANPA PERUBAHAN) -->
<div class="container-fluid px-4 pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">
                <i class="bi bi-calendar-week"></i> Manajemen Jadwal
            </h3>
            <p class="text-muted mb-0">Atur jadwal mengajar guru</p>
        </div>
        <a href="/admin" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Form Tambah Jadwal -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Tambah Jadwal Baru</h5>
        </div>
        <div class="card-body">
            <!-- ⭐ PERBAIKAN: action pakai url langsung -->
            <form method="POST" action="{{ url('/admin/jadwal/store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Guru</label>
                        <select name="guru_id" class="form-control" required>
                            <option value="">Pilih Guru</option>
                            @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $kelas_item)
                            <option value="{{ $kelas_item->id }}">{{ $kelas_item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Hari</label>
                        <select name="hari" class="form-control" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Jam Pelajaran</label>
                        <select name="jam_ke_id" class="form-control" required>
                            <option value="">Pilih Jam</option>
                            @foreach($jam_sekolah as $jam)
                            <option value="{{ $jam->id }}">
                                Jam ke-{{ $jam->jam_ke }} ({{ date('H:i', strtotime($jam->waktu_mulai)) }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Jadwal
                </button>
            </form>
        </div>
    </div>

    <!-- List Jadwal -->
    <div class="card">
        <div class="card-body">
            <h5>Daftar Jadwal Mengajar</h5>
            @if($jadwal->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Guru</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwal as $j)
                        <tr>
                            <td>{{ $j->hari }}</td>
                            <td>
                                {{ date('H:i', strtotime($j->waktu_mulai)) }}-{{ date('H:i', strtotime($j->waktu_selesai)) }}
                                <br><small>Jam ke-{{ $j->jam_ke }}</small>
                            </td>
                            <td>{{ $j->nama_guru }}</td>
                            <td>{{ $j->nama_kelas }}</td>
                            <td>{{ $j->mata_pelajaran }}</td>
                            <td>
                                <!-- ⭐ PERBAIKAN: pakai url langsung -->
                                <form action="{{ url('/admin/jadwal/' . $j->id . '/delete') }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf
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
            <p class="text-muted">Total: {{ $jadwal->count() }} jadwal</p>
            @else
            <div class="text-center py-4">
                <p class="text-muted">Belum ada jadwal mengajar</p>
                <p>Tambahkan jadwal menggunakan form di atas</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection