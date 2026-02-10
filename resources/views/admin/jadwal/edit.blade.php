@extends('layouts.admin')

@section('title', 'Edit Jadwal Mengajar')

@section('styles')
<style>
    .card-edit {
        border-top: 4px solid #4361ee;
        border-radius: 10px;
    }
    
    .form-header {
        background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
    }
    
    .preview-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .preview-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .guru-preview {
        border-left: 4px solid #0d6efd;
        padding-left: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 pt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.jadwal') }}"><i class="bi bi-calendar-week"></i> Jadwal</a></li>
            <li class="breadcrumb-item active"><i class="bi bi-pencil"></i> Edit Jadwal</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-pencil-square me-2"></i> Edit Jadwal Mengajar
            </h2>
            <p class="text-muted mb-0">Perbarui informasi jadwal mengajar</p>
        </div>
        <div>
            <a href="{{ route('admin.jadwal') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Form Edit -->
            <div class="card card-edit card-hover">
                <div class="form-header">
                    <h4 class="mb-0"><i class="bi bi-calendar-plus"></i> Form Edit Jadwal</h4>
                    <p class="mb-0 opacity-75">ID: #{{ $jadwal->id }}</p>
                </div>
                
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id) }}" id="editJadwalForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3 mb-4">
                            <!-- Guru -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i> Guru Pengajar
                                </label>
                                <select name="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" 
                                            {{ old('guru_id', $jadwal->guru_id) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih guru yang akan mengajar</small>
                            </div>
                            
                            <!-- Kelas -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-building me-1"></i> Kelas
                                </label>
                                <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $kelas_item)
                                    <option value="{{ $kelas_item->id }}" 
                                            {{ old('kelas_id', $jadwal->kelas_id) == $kelas_item->id ? 'selected' : '' }}>
                                        {{ $kelas_item->nama_kelas }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih kelas tujuan</small>
                            </div>
                            
                            <!-- Hari -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-day me-1"></i> Hari
                                </label>
                                <select name="hari" class="form-control @error('hari') is-invalid @enderror" required>
                                    <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                </select>
                                @error('hari')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Jam Pelajaran -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-clock me-1"></i> Jam Pelajaran
                                </label>
                                <select name="jam_ke_id" class="form-control @error('jam_ke_id') is-invalid @enderror" required>
                                    <option value="">Pilih Jam</option>
                                    @foreach($jam_sekolah as $jam)
                                    <option value="{{ $jam->id }}" 
                                            {{ old('jam_ke_id', $jadwal->jam_ke_id) == $jam->id ? 'selected' : '' }}>
                                        Jam ke-{{ $jam->jam_ke }} ({{ date('H:i', strtotime($jam->waktu_mulai)) }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('jam_ke_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih jam pelajaran</small>
                            </div>
                            
                            <!-- Mata Pelajaran -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-book me-1"></i> Mata Pelajaran
                                </label>
                                <input type="text" name="mata_pelajaran" 
                                       class="form-control @error('mata_pelajaran') is-invalid @enderror"
                                       value="{{ old('mata_pelajaran', $jadwal->mata_pelajaran) }}"
                                       placeholder="Contoh: Matematika" required>
                                @error('mata_pelajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Nama mata pelajaran</small>
                            </div>
                        </div>
                        
                        <!-- Preview -->
                        <div class="preview-card">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-eye me-2"></i> Preview Perubahan</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1 text-muted">Guru</p>
                                    <div class="guru-preview">
                                        <strong id="previewGuru">{{ $jadwal->guru->nama ?? 'Belum dipilih' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1 text-muted">Kelas</p>
                                    <span class="preview-badge bg-dark text-white" id="previewKelas">
                                        {{ $jadwal->kelas->nama_kelas ?? 'Belum dipilih' }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1 text-muted">Hari</p>
                                    <span class="preview-badge bg-primary text-white" id="previewHari">
                                        {{ $jadwal->hari }}
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <p class="mb-1 text-muted">Jam</p>
                                    <span class="preview-badge bg-info text-white" id="previewJam">
                                        {{ $jadwal->jamSekolah->jam_ke ?? '?' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('admin.jadwal') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i> Batal
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                    <i class="bi bi-trash me-2"></i> Hapus
                                </button>
                                <button type="submit" class="btn btn-gradient px-4">
                                    <i class="bi bi-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Delete Form (Hidden) -->
                    <form id="deleteForm" action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Jadwal Saat Ini -->
            <div class="card card-hover mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i> Informasi Jadwal Saat Ini</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted mb-1">ID Jadwal</p>
                        <strong>#{{ $jadwal->id }}</strong>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">Guru</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="bi bi-person-fill text-primary"></i>
                            </div>
                            <div>
                                <strong>{{ $jadwal->guru->nama ?? '-' }}</strong>
                                <small class="d-block text-muted">Pengajar</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">Kelas</p>
                        <span class="badge bg-dark py-2 px-3">
                            <i class="bi bi-building me-1"></i> {{ $jadwal->kelas->nama_kelas ?? '-' }}
                        </span>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1">Hari</p>
                            <span class="badge bg-primary py-2">{{ $jadwal->hari }}</span>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1">Jam ke</p>
                            <span class="badge bg-info py-2">{{ $jadwal->jamSekolah->jam_ke ?? '?' }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">Waktu</p>
                        <strong>
                            {{ $jadwal->jamSekolah ? date('H:i', strtotime($jadwal->jamSekolah->waktu_mulai)) : '-' }} 
                            - 
                            {{ $jadwal->jamSekolah ? date('H:i', strtotime($jadwal->jamSekolah->waktu_selesai)) : '-' }}
                        </strong>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-1">Mata Pelajaran</p>
                        <strong>{{ $jadwal->mata_pelajaran }}</strong>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-clock-history me-2"></i>
                        <small>Jadwal ini dibuat pada: {{ $jadwal->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            </div>
            
            <!-- Tips -->
            <div class="card card-hover">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i> Tips Edit Jadwal</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Periksa konflik jadwal sebelum menyimpan</small>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Pastikan guru tersedia di hari dan jam tersebut</small>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Kelas tidak boleh double jadwal di waktu sama</small>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Preview perubahan di bagian bawah form</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview real-time
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const guruSelect = document.querySelector('select[name="guru_id"]');
        const kelasSelect = document.querySelector('select[name="kelas_id"]');
        const hariSelect = document.querySelector('select[name="hari"]');
        const jamSelect = document.querySelector('select[name="jam_ke_id"]');
        const mapelInput = document.querySelector('input[name="mata_pelajaran"]');
        
        // Preview elements
        const previewGuru = document.getElementById('previewGuru');
        const previewKelas = document.getElementById('previewKelas');
        const previewHari = document.getElementById('previewHari');
        const previewJam = document.getElementById('previewJam');
        
        // Update preview for guru
        if (guruSelect) {
            guruSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.text !== 'Pilih Guru') {
                    previewGuru.textContent = selectedOption.text;
                }
            });
        }
        
        // Update preview for kelas
        if (kelasSelect) {
            kelasSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.text !== 'Pilih Kelas') {
                    previewKelas.textContent = selectedOption.text;
                }
            });
        }
        
        // Update preview for hari
        if (hariSelect) {
            hariSelect.addEventListener('change', function() {
                previewHari.textContent = this.value;
            });
        }
        
        // Update preview for jam
        if (jamSelect) {
            jamSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.text !== 'Pilih Jam') {
                    // Extract jam ke from text like "Jam ke-1 (07:30)"
                    const match = selectedOption.text.match(/Jam ke-(\d+)/);
                    if (match) {
                        previewJam.textContent = match[1];
                    }
                }
            });
        }
        
        // Check for konflik jadwal
        function checkKonflik() {
            const hari = hariSelect.value;
            const jamId = jamSelect.value;
            const kelasId = kelasSelect.value;
            const jadwalId = {{ $jadwal->id }};
            
            if (hari && jamId && kelasId) {
                // You can implement AJAX call here to check for conflicts
                // For now, just a placeholder
                console.log('Checking for conflicts...');
            }
        }
        
        // Attach event listeners for conflict checking
        [hariSelect, jamSelect, kelasSelect].forEach(select => {
            if (select) {
                select.addEventListener('change', checkKonflik);
            }
        });
    });
    
    // Confirm delete
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: "Jadwal ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
    
    // Form validation
    document.getElementById('editJadwalForm').addEventListener('submit', function(e) {
        const guru = document.querySelector('select[name="guru_id"]').value;
        const kelas = document.querySelector('select[name="kelas_id"]').value;
        const jam = document.querySelector('select[name="jam_ke_id"]').value;
        const mapel = document.querySelector('input[name="mata_pelajaran"]').value;
        
        if (!guru || !kelas || !jam || !mapel) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form tidak lengkap',
                text: 'Harap isi semua field yang wajib diisi!',
                confirmButtonColor: '#4361ee'
            });
        }
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#4361ee',
        timer: 3000
    }).then(() => {
        window.location.href = '{{ route('admin.jadwal') }}';
    });
</script>
@endif
@endsection