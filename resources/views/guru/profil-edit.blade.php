@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<nav class="navbar navbar-glow navbar-expand-lg shadow">
    <!-- Navbar sama seperti profil -->
</nav>

<div class="container-fluid px-4 pt-4">
    <h3><i class="bi bi-pencil"></i> Edit Profil</h3>
    
    @if($guru)
    <div class="card mt-4">
        <div class="card-body">
            <form method="POST" action="/guru/profil/update">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" 
                               value="{{ $guru->nama ?? '' }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" 
                               value="{{ $guru->nip ?? '' }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ $guru->email ?? '' }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $guru->username ?? session('username') }}" readonly>
                        <small class="text-muted">Username tidak dapat diubah</small>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan Perubahan
                    </button>
                    <a href="/guru/profil" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-danger mt-4">
        <i class="bi bi-exclamation-triangle"></i> Data guru tidak ditemukan
    </div>
    @endif
</div>
@endsection