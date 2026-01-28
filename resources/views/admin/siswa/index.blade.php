@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">
                <i class="bi bi-person-badge"></i> Data Siswa
            </h3>
            <p class="text-muted mb-0">Manajemen data siswa per kelas</p>
        </div>
        <div>
            <a href="/admin" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- FORM TAMBAH SISWA -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Tambah Siswa Baru</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/admin/siswa/store') }}">
            @csrf
            <div class="row">
                <!-- NIS -->
                <div class="col-md-3 mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required 
                           placeholder="20240001">
                    <small class="text-muted">Nomor Induk Siswa</small>
                </div>
                
                <!-- NAMA -->
                <div class="col-md-4 mb-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" class="form-control" required 
                           placeholder="Andi Wijaya">
                </div>
                
                <!-- KELAS -->
                <div class="col-md-3 mb-3">
                    <label>Kelas</label>
                    <select name="kelas_id" class="form-control" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- TOMBOL -->
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
    <!-- Daftar Siswa -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i> Daftar Siswa
                <span class="badge bg-primary ms-2">{{ $siswa->count() }} siswa</span>
            </h5>
        </div>
        <div class="card-body">
            @if($siswa->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal Daftar</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $s)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
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

            <!-- Statistik -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Statistik Siswa per Kelas</h6>
                        <div class="row mt-2">
                            @php
                                $siswaPerKelas = [];
                                foreach ($siswa as $s) {
                                    $kelasName = $s->nama_kelas;
                                    if (!isset($siswaPerKelas[$kelasName])) {
                                        $siswaPerKelas[$kelasName] = 0;
                                    }
                                    $siswaPerKelas[$kelasName]++;
                                }
                            @endphp
                            
                            @foreach($siswaPerKelas as $kelasName => $count)
                            <div class="col-md-2 col-4 mb-2">
                                <div class="border rounded p-2 text-center">
                                    <small class="d-block text-muted">{{ $kelasName }}</small>
                                    <strong class="text-primary">{{ $count }} siswa</strong>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-people display-1 text-muted"></i>
                </div>
                <h4 class="text-muted">Belum ada data siswa</h4>
                <p class="text-muted mb-4">Tambahkan siswa pertama Anda menggunakan form di atas</p>
                <div class="alert alert-warning">
                    <i class="bi bi-lightbulb"></i> 
                    <strong>Tips UKK:</strong> Pastikan sudah membuat kelas terlebih dahulu sebelum menambahkan siswa.
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Info Penting -->
    <div class="card mt-4 border-info">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-info-circle"></i> Informasi Penting
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Untuk UKK RPL:</h6>
                    <ul class="mb-0">
                        <li>Data siswa diperlukan untuk fitur kehadiran</li>
                        <li>Siswa dikelompokkan berdasarkan kelas</li>
                        <li>Pastikan kelas sudah dibuat sebelum menambah siswa</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Alur Kerja:</h6>
                    <ol class="mb-0">
                        <li>Buat kelas di menu "Data Kelas"</li>
                        <li>Tambah siswa di sini</li>
                        <li>Buat jadwal mengajar</li>
                        <li>Guru bisa input kegiatan dan kehadiran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
    font-weight: bold;
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
</style>
@endsection