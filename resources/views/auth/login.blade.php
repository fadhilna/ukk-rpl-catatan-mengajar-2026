<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK Muhammadiyah 04</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #0ea5e9;
            --secondary: #1e293b;
            --dark: #0f172a;
            --accent: #f59e0b;
            --light: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', 'Inter', sans-serif;
            overflow-x: hidden;
            position: relative;
            color: var(--light);
        }
        
        /* FULLSCREEN BACKGROUND WITH ANIMATION */
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
            animation: gradientShift 15s ease infinite alternate;
            z-index: -2;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }
        
        /* GLOWING CURSOR EFFECT */
        body {
            cursor: none;
        }
        
        .cursor-glow {
            position: fixed;
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.8) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            filter: blur(15px);
            mix-blend-mode: screen;
            transition: transform 0.1s ease-out, width 0.3s, height 0.3s;
            transform: translate(-50%, -50%);
        }
        
        .cursor-dot {
            position: fixed;
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            pointer-events: none;
            z-index: 10000;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
        }
        
        body:hover .cursor-glow {
            width: 60px;
            height: 60px;
        }
        
        /* MAIN CONTAINER - FULLSCREEN CENTERED */
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        /* LOGIN CARD - DARK GLASS EFFECT */
        .login-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 100px rgba(14, 165, 233, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            animation: cardAppear 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0ea5e9, #f59e0b, #8b5cf6);
            z-index: 2;
        }
        
        /* LOGO SECTION */
        .logo-section {
            padding: 40px 40px 30px;
            text-align: center;
            position: relative;
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, transparent 100%);
        }
        
        .logo-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            position: relative;
            animation: logoFloat 6s ease-in-out infinite;
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(3deg); }
        }
        
        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 20px rgba(14, 165, 233, 0.3));
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.9);
            padding: 10px;
            border: 2px solid rgba(14, 165, 233, 0.3);
        }
        
        .logo-glow {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            animation: logoPulse 4s ease-in-out infinite;
        }
        
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }
        
        .school-name {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0ea5e9, #f59e0b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 8px;
        }
        
        .app-name {
            color: #94a3b8;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        /* FORM SECTION */
        .form-section {
            padding: 0 40px 40px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .form-label {
            display: block;
            color: #cbd5e1;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
            padding-left: 4px;
        }
        
        .input-group {
            position: relative;
            transition: all 0.3s;
        }
        
        .input-group:focus-within {
            transform: translateY(-2px);
        }
        
        .form-control {
            background: rgba(30, 41, 59, 0.8);
            border: 2px solid #334155;
            border-radius: 12px;
            color: #f8fafc;
            padding: 16px 20px;
            font-size: 16px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .form-control:focus {
            background: rgba(30, 41, 59, 1);
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2);
            outline: none;
        }
        
        .form-control::placeholder {
            color: #64748b;
        }
        
        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            transition: color 0.3s;
        }
        
        .form-control:focus + .input-icon {
            color: #0ea5e9;
        }
        
        /* BUTTON STYLING */
        .btn-login {
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            border: none;
            color: white;
            padding: 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14, 165, 233, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            transform: rotate(45deg);
            animation: shine 3s infinite linear;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
        
        /* DEMO ACCOUNTS */
        .demo-section {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .demo-title {
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .demo-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }
        
        .demo-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .demo-card:hover {
            background: rgba(30, 41, 59, 0.9);
            transform: translateY(-2px);
            border-color: #0ea5e9;
        }
        
        .demo-card.admin {
            border-left: 4px solid #0ea5e9;
        }
        
        .demo-card.guru {
            border-left: 4px solid #f59e0b;
        }
        
        .demo-role {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        
        .demo-credentials {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: #f8fafc;
        }
        
        /* FOOTER */
        .login-footer {
            text-align: center;
            padding: 24px 40px;
            background: rgba(15, 23, 42, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .footer-text {
            color: #64748b;
            font-size: 0.8rem;
            line-height: 1.5;
        }
        
        .tech-badge {
            display: inline-block;
            background: rgba(14, 165, 233, 0.1);
            color: #0ea5e9;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            margin-top: 8px;
        }
        
        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }
            
            .login-card {
                max-width: 100%;
                border-radius: 16px;
            }
            
            .logo-section,
            .form-section {
                padding: 30px 20px;
            }
            
            .logo-container {
                width: 100px;
                height: 100px;
            }
            
            .school-name {
                font-size: 1.5rem;
            }
            
            .login-footer {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .demo-cards {
                grid-template-columns: 1fr;
            }
            
            .form-control {
                padding: 14px 16px;
            }
            
            .btn-login {
                padding: 14px;
            }
        }
        
        /* ANIMATED BACKGROUND ELEMENTS */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-element {
            position: absolute;
            background: rgba(14, 165, 233, 0.05);
            border-radius: 50%;
            animation: floatElement 20s infinite linear;
        }
        
        @keyframes floatElement {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* ALERT STYLING */
        .alert {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: #86efac;
        }
    </style>
</head>
<body>
    <!-- Animated Background Elements -->
    <div class="bg-elements" id="bgElements"></div>
    
    <!-- Background Overlay -->
    <div class="bg-overlay"></div>
    
    <!-- Custom Cursor -->
    <div class="cursor-glow" id="cursorGlow"></div>
    <div class="cursor-dot" id="cursorDot"></div>
    
    <!-- Main Container -->
    <div class="main-container">
        <div class="login-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-container">
                    <div class="logo-glow"></div>
                    <img src="{{ asset('image-removebg-preview.png') }}" 
                         alt="Logo SMK Muhammadiyah 04"
                         id="schoolLogo"
                         onerror="showLogoFallback()">
                </div>
                
                <h1 class="school-name">SMK MUHAMMADIYAH 04</h1>
                <p class="app-name">Aplikasi Catatan Mengajar Guru</p>
                <p class="text-sm text-slate-400 mt-2">
                    <i class="bi bi-shield-check me-1"></i>
                    Sistem Terenkripsi - UKK RPL 2026
                </p>
            </div>
            
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert animate__animated animate__shakeX">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
            </div>
            @endif
            
            <!-- Form Section -->
            <div class="form-section">
                <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
                    @csrf
                    
                    <!-- Username Field -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-person me-2"></i> Username
                        </label>
                        <div class="input-group">
                            <input type="text" 
                                   name="username" 
                                   class="form-control" 
                                   placeholder="admin / gurujoko"
                                   value="{{ old('username') }}"
                                   required
                                   autofocus
                                   autocomplete="username">
                            <i class="bi bi-person input-icon"></i>
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-key me-2"></i> Password
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="••••••••"
                                   required
                                   autocomplete="current-password"
                                   id="passwordInput">
                            <i class="bi bi-key input-icon" id="passwordIcon"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-secondary border-0 p-0"
                                    id="togglePassword">
                                <i class="bi bi-eye me-1"></i>
                                <small>Show Password</small>
                            </button>
                            <small class="text-slate-400">
                                <i class="bi bi-info-circle me-1"></i>
                                Password Terenkripsi
                            </small>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn-login" id="loginButton">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span id="loginText">Login ke Sistem</span>
                        <span id="loadingSpinner" class="spinner-border spinner-border-sm ms-2" style="display:none;"></span>
                    </button>
                </form>
                
                <!-- Demo Accounts -->
                <div class="demo-section">
                    <div class="demo-title">
                        <i class="bi bi-key-fill text-amber-400"></i>
                        Akun Demo untuk Testing
                    </div>
                    
                    <div class="demo-cards">
                        <div class="demo-card admin" onclick="fillCredentials('admin', 'admin123')">
                            <div class="demo-role">Administrator</div>
                            <div class="demo-credentials">
                                <div>admin</div>
                                <div>admin123</div>
                            </div>
                            <small class="text-cyan-400">
                                <i class="bi bi-stars"></i> Full Access
                            </small>
                        </div>
                        
                        <div class="demo-card guru" onclick="fillCredentials('gurujoko', 'guru123')">
                            <div class="demo-role">Guru Biologi</div>
                            <div class="demo-credentials">
                                <div>gurujoko</div>
                                <div>guru123</div>
                            </div>
                            <small class="text-amber-400">
                                <i class="bi bi-mortarboard"></i> Guru Access
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="login-footer">
                <div class="footer-text">
                    <i class="bi bi-c-circle me-1"></i> 2026 SMK Muhammadiyah 04
                    <br>
                    Aplikasi Catatan Mengajar Guru - UKK RPL
                    <br>
                    <span class="tech-badge">
                        <i class="bi bi-code-slash me-1"></i>
                        Laravel {{ app()->version() }} • Bootstrap 5 • MySQL
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ======================
        // CUSTOM CURSOR
        // ======================
        const cursorGlow = document.getElementById('cursorGlow');
        const cursorDot = document.getElementById('cursorDot');
        
        document.addEventListener('mousemove', (e) => {
            cursorGlow.style.left = e.clientX + 'px';
            cursorGlow.style.top = e.clientY + 'px';
            cursorDot.style.left = e.clientX + 'px';
            cursorDot.style.top = e.clientY + 'px';
        });
        
        // Cursor hover effects
        document.querySelectorAll('input, button, .demo-card').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursorGlow.style.width = '80px';
                cursorGlow.style.height = '80px';
                cursorGlow.style.filter = 'blur(20px)';
                cursorDot.style.width = '10px';
                cursorDot.style.height = '10px';
            });
            
            el.addEventListener('mouseleave', () => {
                cursorGlow.style.width = '40px';
                cursorGlow.style.height = '40px';
                cursorGlow.style.filter = 'blur(15px)';
                cursorDot.style.width = '6px';
                cursorDot.style.height = '6px';
            });
        });
        
        // ======================
        // ANIMATED BACKGROUND ELEMENTS
        // ======================
        function createBackgroundElements() {
            const container = document.getElementById('bgElements');
            const elementCount = 20;
            
            for (let i = 0; i < elementCount; i++) {
                const element = document.createElement('div');
                element.classList.add('bg-element');
                
                // Random properties
                const size = Math.random() * 100 + 20;
                const left = Math.random() * 100;
                const duration = Math.random() * 20 + 20;
                const delay = Math.random() * 20;
                
                element.style.width = `${size}px`;
                element.style.height = `${size}px`;
                element.style.left = `${left}vw`;
                element.style.animationDuration = `${duration}s`;
                element.style.animationDelay = `${delay}s`;
                element.style.opacity = Math.random() * 0.2 + 0.1;
                
                container.appendChild(element);
            }
        }
        
        // ======================
        // TOGGLE PASSWORD VISIBILITY
        // ======================
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.querySelector('small').textContent = 'Hide Password';
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.querySelector('small').textContent = 'Show Password';
            }
        });
        
        // ======================
        // FILL DEMO CREDENTIALS
        // ======================
        function fillCredentials(username, password) {
            document.querySelector('input[name="username"]').value = username;
            document.querySelector('input[name="password"]').value = password;
            
            // Animation feedback
            const event = new Event('input', { bubbles: true });
            document.querySelector('input[name="username"]').dispatchEvent(event);
            document.querySelector('input[name="password"]').dispatchEvent(event);
            
            // Focus on password field
            document.getElementById('passwordInput').focus();
        }
        
        // ======================
        // LOGIN FORM SUBMISSION
        // ======================
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginButton');
            const text = document.getElementById('loginText');
            const spinner = document.getElementById('loadingSpinner');
            
            // Show loading state
            text.textContent = 'Authenticating...';
            spinner.style.display = 'inline-block';
            button.disabled = true;
        });
        
        // ======================
        // LOGO ERROR HANDLING
        // ======================
        function showLogoFallback() {
            const logo = document.getElementById('schoolLogo');
            if (logo) {
                logo.style.display = 'none';
                // Create fallback logo
                const container = document.querySelector('.logo-container');
                const fallback = document.createElement('div');
                fallback.innerHTML = `
                    <div style="width:100%;height:100%;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#3b82f6);display:flex;align-items:center;justify-content:center;color:white;font-size:2rem;">
                        SMK
                    </div>
                `;
                container.appendChild(fallback);
            }
        }
        
        // ======================
        // AUTO-HIDE ALERTS
        // ======================
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
        
        // ======================
        // INPUT FOCUS EFFECTS
        // ======================
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
        
        // ======================
        // INITIALIZE ON LOAD
        // ======================
        document.addEventListener('DOMContentLoaded', function() {
            createBackgroundElements();
            
            // Check logo loading
            const logo = document.getElementById('schoolLogo');
            if (logo) {
                logo.onload = () => console.log('✅ Logo loaded successfully');
                logo.onerror = showLogoFallback;
            }
            
            // Typing effect for school name (optional)
            const schoolName = document.querySelector('.school-name');
            if (schoolName && !schoolName.hasAttribute('data-typed')) {
                const text = schoolName.textContent;
                schoolName.textContent = '';
                schoolName.setAttribute('data-typed', 'true');
                
                let i = 0;
                function typeWriter() {
                    if (i < text.length) {
                        schoolName.textContent += text.charAt(i);
                        i++;
                        setTimeout(typeWriter, 50);
                    }
                }
                setTimeout(typeWriter, 500);
            }
        });
    </script>
</body>
</html>