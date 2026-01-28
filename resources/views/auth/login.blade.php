<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Catatan Mengajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
        }
        .form-control {
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }
        .logo {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <div class="logo">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <h3 class="mb-1">Aplikasi Catatan Mengajar</h3>
                        <p class="mb-0">UKK RPL 2026 - Sistem Manajemen Guru</p>
                    </div>
                    
                    <div class="login-body">
                        <!-- Flash Messages -->
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person-fill me-1"></i> Username
                                </label>
                                <input type="text" 
                                       name="username" 
                                       class="form-control" 
                                       placeholder="Masukkan username"
                                       value="{{ old('username') }}"
                                       required
                                       autofocus>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-lock-fill me-1"></i> Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       placeholder="Masukkan password"
                                       required>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> 
                                    Default: admin/admin123 atau guru/guru123
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100 mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login
                            </button>
                            
                            <div class="text-center">
                                <small class="text-muted">
                                    Sistem UKK RPL 2026 | 
                                    <a href="#" class="text-decoration-none">Bantuan</a>
                                </small>
                            </div>
                        </form>
                        
                        <!-- Demo Accounts -->
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-center mb-3">
                                <i class="bi bi-key-fill text-warning"></i> 
                                Akun Demo
                            </h6>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="card border-primary mb-2">
                                        <div class="card-body py-2">
                                            <small class="d-block fw-bold">Admin</small>
                                            <small>admin / admin123</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border-success mb-2">
                                        <div class="card-body py-2">
                                            <small class="d-block fw-bold">Guru</small>
                                            <small>gurujoko / guru123</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-4 text-white">
                    <small>
                        <i class="bi bi-c-circle"></i> 2026 Aplikasi Catatan Mengajar Guru - UKK RPL
                        | Versi 1.0 | Laravel {{ app()->version() }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            });
        }, 5000);
    </script>
</body>
</html>