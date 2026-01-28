<!DOCTYPE html>
<html>
<head>
    <title>Edit Guru - UKK RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validasiForm() {
            var password = document.getElementById('password').value;
            var confirm = document.getElementById('password_confirmation').value;
            
            if (password && password !== confirm) {
                alert('Password dan konfirmasi password tidak sama!');
                return false;
            }
            
            if (password && password.length < 6) {
                alert('Password minimal 6 karakter!');
                return false;
            }
            
            return true;
        }
    </script>
    <!-- NAVBAR (COPY SAMA SEPERTI DI ATAS) -->
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
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-person-gear"></i> Edit Data Guru
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Flash Messages -->
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.guru.update', $guru->id) }}" 
                              onsubmit="return validasiForm()">
                            @csrf
                            @method('PUT')
                            
                            <h5 class="mb-3">Data Pribadi</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Guru *</label>
                                    <input type="text" name="nama" class="form-control" 
                                           value="{{ old('nama', $guru->nama) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" name="nip" class="form-control" 
                                           value="{{ old('nip', $guru->nip) }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ old('email', $guru->email) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control bg-light" 
                                           value="{{ $guru->username }}" readonly>
                                    <small class="text-muted">Username tidak dapat diubah</small>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            <h5 class="mb-3">Ubah Password</h5>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                Kosongkan jika tidak ingin mengubah password
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password" id="password" 
                                           class="form-control" minlength="6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" 
                                           id="password_confirmation" class="form-control">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save"></i> Update Data
                                    </button>
                                    <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-primary">
                                        Batalkan
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        <small>
                            ID: {{ $guru->id }} | 
                            Dibuat: {{ date('d/m/Y', strtotime($guru->created_at)) }} |
                            Terakhir diupdate: {{ date('d/m/Y H:i', strtotime($guru->updated_at)) }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>