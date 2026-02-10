@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="bi bi-person-lines-fill text-success"></i>
            Rekap Kehadiran Siswa
        </h3>
        <a href="/admin" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    
    <!-- Info -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="text-muted mb-1">Informasi</h6>
            <p class="mb-0">
                Halaman rekap kehadiran siswa. Fitur ini sedang dalam pengembangan.
                Untuk saat ini, gunakan laporan kehadiran dari masing-masing guru.
            </p>
        </div>
    </div>
    
    <!-- Daftar Kelas -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <i class="bi bi-people-fill text-primary"></i>
                Daftar Kelas
            </h5>
            
            <div class="row">
                @foreach($kelasList as $kelas)
                <div class="col-md-4 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-building text-success"></i>
                                {{ $kelas->nama_kelas }}
                            </h6>
                            <p class="card-text text-muted small mb-2">
                                Tingkat: {{ $kelas->tingkat }} | 
                                Jurusan: {{ $kelas->jurusan ?? 'Umum' }}
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Lihat Siswa
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($kelasList->count() == 0)
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-building-slash display-1 text-muted"></i>
                </div>
                <h4 class="text-muted">Belum ada kelas</h4>
                <p class="text-muted">Data kelas belum tersedia.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection