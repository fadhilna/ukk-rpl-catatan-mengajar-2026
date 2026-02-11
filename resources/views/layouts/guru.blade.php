<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistem Manajemen Sekolah - Guru')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap');
    
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --success-color: #4cc9f0;
        --info-color: #4895ef;
        --warning-color: #f72585;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
        padding-top: 0;
        margin: 0;
    }
    
    /* ======================== */
    /* FIXED NAVBAR */
    /* ======================== */
    .navbar-glow {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        width: 100%;
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
        height: 60px;
    }
    
    /* Navbar scroll effect */
    .navbar-scrolled {
        background: rgba(67, 97, 238, 0.95) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    /* ======================== */
    /* FIXED SIDEBAR */
    /* ======================== */
    .sidebar-menu {
        position: fixed;
        top: 60px;
        left: 0;
        bottom: 0;
        width: 16.6667%;
        overflow-y: auto;
        z-index: 1020;
        background: white;
        border-right: 1px solid #e9ecef;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }
    
    /* ======================== */
    /* MAIN CONTENT OFFSET */
    /* ======================== */
    .main-content {
        margin-left: 16.6667%;
        padding: 20px;
        padding-top: 80px;
        min-height: 100vh;
        background: #f8f9fa;
    }
    
    /* ======================== */
    /* SCROLL PROGRESS */
    /* ======================== */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(to right, #4361ee, #4cc9f0);
        z-index: 1031;
        transition: width 0.3s ease;
    }
    
    /* ======================== */
    /* SIDEBAR OVERLAY MOBILE */
    /* ======================== */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 60px;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1039;
    }
    
    .sidebar-overlay.show {
        display: block;
    }
    
    /* ======================== */
    /* SIDEBAR CONTENT */
    /* ======================== */
    .sidebar-content {
        height: 100%;
        overflow-y: auto;
    }
    
    .user-info {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        color: white;
        margin-bottom: 20px;
    }
    
    .profile-img-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
    }
    
    .sidebar-title {
        color: #6c757d;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .sidebar-nav .nav-link {
        color: #495057;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
        font-family: 'Raleway', sans-serif;
        font-weight: 500;
    }
    
    .sidebar-nav .nav-link:hover {
        background: rgba(67, 97, 238, 0.1);
        color: #4361ee;
        transform: translateX(5px);
    }
    
    .sidebar-nav .nav-link.active {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        color: white;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }
    
    /* ======================== */
    /* PROFILE IMAGES */
    /* ======================== */
    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .profile-img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(255,255,255,0.5);
    }
    
    /* ======================== */
    /* RESPONSIVE */
    /* ======================== */
    @media (max-width: 1199.98px) {
        .sidebar-menu {
            width: 200px;
        }
        .main-content {
            margin-left: 200px;
        }
    }
    
    @media (max-width: 991.98px) {
        .sidebar-menu {
            width: 180px;
        }
        .main-content {
            margin-left: 180px;
        }
    }
    
    @media (max-width: 767.98px) {
        /* Mobile Navbar */
        .navbar-glow {
            height: 56px;
        }
        
        /* Mobile Sidebar Overlay */
        .sidebar-menu {
            position: fixed;
            top: 56px;
            left: -100%;
            width: 250px;
            height: calc(100vh - 56px);
            transition: left 0.3s ease;
            z-index: 1040;
        }
        
        .sidebar-menu.show {
            left: 0;
        }
        
        /* Main Content Mobile */
        .main-content {
            margin-left: 0;
            width: 100%;
            padding-top: 70px;
        }
        
        /* Sidebar Overlay */
        .sidebar-overlay {
            top: 56px;
        }
        
        /* Navbar Toggler */
        .navbar-toggler {
            display: block !important;
            border: none;
            background: transparent;
            color: white;
            font-size: 1.5rem;
            padding: 5px 10px;
        }
    }
    
    /* Hide navbar toggler on desktop */
    .navbar-toggler {
        display: none;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navbar akan dimasukkan di tiap halaman -->
    @yield('navbar')
    
    <!-- Scroll Progress Bar -->
    <div class="scroll-progress"></div>
    
    <!-- Overlay untuk Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Container utama -->
    <div class="container-fluid">
        @yield('content')
    </div>
    
    <!-- JavaScript -->
    <script>
    $(document).ready(function() {
        // ========================
        // NAVBAR SCROLL EFFECT
        // ========================
        $(window).scroll(function() {
            // Navbar scroll effect
            if ($(window).scrollTop() > 50) {
                $('.navbar-glow').addClass('navbar-scrolled');
            } else {
                $('.navbar-glow').removeClass('navbar-scrolled');
            }
            
            // Scroll progress indicator
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();
            const scrollTop = $(window).scrollTop();
            const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;
            
            $('.scroll-progress').width(scrollPercent + '%');
        });
        
        // ========================
        // SIDEBAR TOGGLE MOBILE
        // ========================
        $('#sidebarToggle').click(function(e) {
            e.stopPropagation();
            $('.sidebar-menu').toggleClass('show');
            $('#sidebarOverlay').toggleClass('show');
        });
        
        // Close sidebar when clicking overlay
        $('#sidebarOverlay').click(function() {
            $(this).removeClass('show');
            $('.sidebar-menu').removeClass('show');
        });
        
        // Close sidebar when clicking link (mobile)
        $('.sidebar-nav a').click(function() {
            if ($(window).width() <= 767) {
                $('#sidebarOverlay').removeClass('show');
                $('.sidebar-menu').removeClass('show');
            }
        });
        
        // Close sidebar on window resize (if resized to desktop)
        $(window).on('resize', function() {
            if ($(window).width() > 767) {
                $('.sidebar-menu').removeClass('show');
                $('#sidebarOverlay').removeClass('show');
            }
        });
    });
    </script>
    
    @yield('scripts')
</body>
</html>