<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - UKK RPL</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>">
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Ganti font ke Dosis seperti desain referensi -->
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Color Scheme dari desain referensi */
            --primary-color: #2d3748;
            --secondary-color: #4a5568;
            --accent-color: #3182ce;
            --accent-light: #4299e1;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --sidebar-bg: #1a202c;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --text-light: #a0aec0;
            --border-color: #e2e8f0;
            --border-light: #edf2f7;
            
            /* Gradients untuk cards */
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            --gradient-3: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --gradient-4: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Dosis', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-primary);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 4px;
        }

        /* Layout Container */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        /* ======================== */
/* STATISTIK BULANAN STYLING */
/* ======================== */

.consumption-chart {
    display: flex;
    justify-content: space-around;
    align-items: flex-end;
    height: 200px;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}

.chart-column {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 60px;
}

.chart-bar {
    width: 40px;
    background: linear-gradient(to top, #764ba2, #667eea);
    border-radius: 8px 8px 0 0;
    position: relative;
    transition: height 0.5s ease;
    box-shadow: 0 2px 5px rgba(118, 75, 162, 0.2);
}

.chart-bar:hover {
    background: linear-gradient(to top, #667eea, #764ba2);
    transform: scale(1.05);
}

.chart-value {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #764ba2;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    min-width: 25px;
    text-align: center;
}

.chart-label {
    margin-top: 10px;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.chart-subtitle {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 2px;
}

/* Stat Summary */
.stat-summary {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #764ba2;
}

.stat-summary h6 {
    font-size: 0.9rem;
    color: #495057;
    margin-bottom: 10px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #764ba2;
    line-height: 1;
}

/* Trend Indicator */
.trend-indicator {
    padding: 10px 15px;
    border-radius: 8px;
    background: #f8f9fa;
}

.trend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
}

.trend-item.trend-up {
    color: #28a745;
}

.trend-item.trend-down {
    color: #dc3545;
}

.trend-item i {
    font-size: 1.2rem;
}

/* Card Header dengan Dropdown */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.card-title {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Animation */
.animate-fadeIn {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .consumption-chart {
        height: 150px;
    }
    
    .chart-column {
        width: 50px;
    }
    
    .chart-bar {
        width: 30px;
    }
    
    .chart-value {
        font-size: 0.7rem;
        top: -20px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
        /* ======================== */
/* NAVBAR & SIDEBAR FIXED - TAMBAHAN SAJA */
/* ======================== */

/* Navbar Fixed */
.navbar-glow {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1030 !important;
    width: 100% !important;
}

/* Sidebar Fixed */
.sidebar-menu {
    position: fixed !important;
    top: 60px !important;
    left: 0 !important;
    height: calc(100vh - 60px) !important;
    overflow-y: auto !important;
    z-index: 1020 !important;
}

/* Main Content Offset */
.main-content {
    margin-left: 16.6667% !important;
    padding-top: 80px !important;
    min-height: 100vh !important;
}

/* Untuk tablet */
@media (max-width: 1199.98px) {
    .sidebar-menu {
        width: 25% !important;
    }
    .main-content {
        margin-left: 25% !important;
    }
}

/* Untuk mobile */
@media (max-width: 767.98px) {
    .navbar-glow {
        height: 56px !important;
    }
    
    .sidebar-menu {
        top: 56px !important;
        left: -100% !important;
        width: 250px !important;
        height: calc(100vh - 56px) !important;
        transition: left 0.3s ease !important;
        z-index: 1040 !important;
    }
    
    .sidebar-menu.show {
        left: 0 !important;
    }
    
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
        padding-top: 70px !important;
    }
    
    /* Hamburger menu */
    .navbar-toggler {
        display: block !important;
        border: none !important;
        background: transparent !important;
        color: white !important;
        font-size: 1.5rem !important;
        padding: 5px 10px !important;
    }
}

/* Navbar scroll effect */
.navbar-scrolled {
    background: rgba(67, 97, 238, 0.95) !important;
    backdrop-filter: blur(10px) !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
}

/* Scroll progress */
.scroll-progress {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 0% !important;
    height: 3px !important;
    background: linear-gradient(to right, #4361ee, #4cc9f0) !important;
    z-index: 1031 !important;
    transition: width 0.3s ease !important;
}

/* Sidebar overlay untuk mobile */
.sidebar-overlay {
    display: none !important;
    position: fixed !important;
    top: 60px !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background: rgba(0,0,0,0.5) !important;
    z-index: 1039 !important;
}

.sidebar-overlay.show {
    display: block !important;
}

        /* SIDEBAR - Desain mirip referensi */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-logo img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
        }

        .user-profile {
            text-align: center;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            background: var(--gradient-4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin: 0 auto 15px;
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }

        .user-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-role {
            font-size: 0.85rem;
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.1);
            padding: 3px 12px;
            border-radius: 12px;
            display: inline-block;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 25px;
        }

        .nav-section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-light);
            padding: 0 20px 10px;
            letter-spacing: 0.5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left: 3px solid var(--accent-color);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-left: 3px solid var(--accent-color);
        }

        .nav-item i {
            font-size: 1.2rem;
            width: 25px;
            margin-right: 12px;
        }

        .nav-item-text {
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
            background-color: var(--light-bg);
        }

        /* TOP NAVBAR */
        .top-navbar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .date-info {
            color: var(--text-secondary);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* WELCOME SECTION - Mirip desain referensi */
        .welcome-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .welcome-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* WEATHER WIDGET - dari desain referensi */
        .weather-widget {
            background: var(--gradient-1);
            color: white;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            box-shadow: var(--shadow-md);
        }

        .weather-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .weather-temp {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .weather-info {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* STATS CARDS - Current Percentages */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .stat-icon {
            font-size: 1.5rem;
            color: var(--accent-color);
            background: rgba(49, 130, 206, 0.1);
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-progress {
            height: 6px;
            background: var(--border-light);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 15px;
        }

        .stat-progress-bar {
            height: 100%;
            background: var(--gradient-4);
            border-radius: 3px;
        }

        /* MAIN CONTENT GRID */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        /* SCHEDULE CARD */
        .schedule-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            height: 100%;
        }

        .card-header {
            background: var(--light-bg);
            padding: 18px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 25px;
        }

        /* Schedule Items */
        .schedule-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .schedule-item:last-child {
            border-bottom: none;
        }

        .schedule-info h6 {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .schedule-meta {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .schedule-badge {
            background: rgba(49, 130, 206, 0.1);
            color: var(--accent-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* QUICK ACTIONS */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 15px;
        }

        .action-btn {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px 15px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text-primary);
            display: block;
        }

        .action-btn:hover {
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .action-icon {
            font-size: 1.8rem;
            color: var(--accent-color);
            margin-bottom: 10px;
            display: block;
        }

        .action-text {
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* TEMPERATURE & LIGHTS CONTROL */
        .control-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            height: 100%;
        }

        .control-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .control-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .control-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .slider-container {
            margin: 20px 0;
        }

        .slider-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .custom-slider {
            width: 100%;
            height: 8px;
            -webkit-appearance: none;
            background: var(--border-light);
            border-radius: 4px;
            outline: none;
        }

        .custom-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: var(--accent-color);
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* RECENT ACTIVITIES */
        .activities-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            padding: 15px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: rgba(49, 130, 206, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .activity-meta {
            font-size: 0.85rem;
            color: var(--text-secondary);
            display: flex;
            gap: 15px;
        }

        /* CONSUMPTION CHART */
        .consumption-chart {
            height: 200px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .chart-bar {
            flex: 1;
            background: var(--gradient-4);
            border-radius: 6px 6px 0 0;
            min-height: 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        .chart-bar:hover {
            transform: translateY(-5px);
        }

        .chart-label {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* FOOTER */
        .dashboard-footer {
            background: white;
            border-radius: 12px;
            padding: 20px 25px;
            margin-top: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
            }
            
            .main-content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .top-navbar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .user-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Mobile Menu Button */
        .menu-toggle {
            display: none;
            background: var(--accent-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }
        }
        /* ======================== */
/* NAVBAR SIMPLE - FIXED */
/* ======================== */
.navbar-simple {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    color: white;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.navbar-simple .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 20px;
    max-width: 100%;
}

/* Logo */
.navbar-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
}

.navbar-logo img {
    width: 30px;
    height: 30px;
}

/* Menu */
.navbar-menu {
    display: flex;
    gap: 20px;
}

.navbar-menu a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 5px;
    transition: all 0.3s;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.navbar-menu a:hover,
.navbar-menu a.active {
    color: white;
    background: rgba(255, 255, 255, 0.1);
}

/* Profile */
.navbar-profile {
    position: relative;
}

.profile-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background 0.3s;
}

.profile-dropdown:hover {
    background: rgba(255, 255, 255, 0.1);
}

.avatar-circle {
    width: 35px;
    height: 35px;
    background: white;
    color: #4361ee;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
}

/* Hamburger menu (mobile) */
.menu-toggle {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 5px;
}

/* Mobile Overlay */
.mobile-overlay {
    display: none;
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
}

/* ======================== */
/* SIDEBAR POSITION FIXED */
/* ======================== */
aside.sidebar {
    position: fixed;
    top: 60px; /* Mulai di bawah navbar */
    left: 0;
    width: 250px;
    height: calc(100vh - 60px);
    overflow-y: auto;
    z-index: 998;
    transition: left 0.3s ease;
}

/* ======================== */
/* MAIN CONTENT OFFSET */
/* ======================== */
.dashboard-container {
    margin-left: 250px; /* Sama dengan lebar sidebar */
    padding-top: 70px; /* Navbar height + spacing */
    min-height: 100vh;
}

/* ======================== */
/* RESPONSIVE */
/* ======================== */
@media (max-width: 991px) {
    /* Sembunyikan menu di tablet */
    .navbar-menu {
        display: none;
    }
    
    /* Tampilkan hamburger */
    .menu-toggle {
        display: block;
    }
}

@media (max-width: 768px) {
    /* Navbar lebih kecil di mobile */
    .navbar-simple {
        height: 56px;
    }
    
    /* Sidebar jadi slide-in di mobile */
    aside.sidebar {
        top: 56px;
        left: -250px;
        width: 250px;
        height: calc(100vh - 56px);
    }
    
    aside.sidebar.show {
        left: 0;
    }
    
    /* Main content full width di mobile */
    .dashboard-container {
        margin-left: 0;
        width: 100%;
        padding-top: 66px;
    }
    
    /* Overlay untuk mobile */
    .mobile-overlay.show {
        display: block;
    }
    
    /* Sembunyikan nama di profile di mobile */
    .profile-dropdown span {
        display: none;
    }
}

/* Scroll effect */
.navbar-scrolled {
    background: rgba(67, 97, 238, 0.95) !important;
    backdrop-filter: blur(10px);
}
    </style>
</head>
<body>
    <!-- NAVBAR SIMPLE - TAMBAHKAN INI -->
<nav class="navbar-simple">
    <div class="container">
        <!-- Hamburger untuk mobile -->
        <button class="menu-toggle" id="menuToggle">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Logo -->
        <a href="/guru/dashboard" class="navbar-logo">
            <img src="{{ asset('image-removebg-preview.png') }}" alt="Logo" width="30">
            <span>Dashboard Guru</span>
        </a>
        
        <!-- Menu -->
        <div class="navbar-menu">
            <a href="/guru/dashboard" class="{{ request()->is('guru/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="/guru/kegiatan" class="{{ request()->is('guru/kegiatan*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Kegiatan
            </a>
            <a href="/guru/laporan-bulanan" class="{{ request()->is('guru/laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
            <a href="/guru/jadwal" class="{{ request()->is('guru/jadwal') ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i> Jadwal
            </a>
        </div>
        
        <!-- Profil -->
        <div class="navbar-profile">
            <div class="dropdown">
                <a href="#" class="profile-dropdown" data-bs-toggle="dropdown">
                    <div class="avatar-circle">
                        {{ strtoupper(substr($guru->nama, 0, 1)) }}
                    </div>
                    <span>{{ $guru->nama }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/guru/profil"><i class="bi bi-person"></i> Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- OVERLAY untuk mobile -->
<div class="mobile-overlay" id="mobileOverlay"></div>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="/guru/dashboard" class="sidebar-logo">
                    <img src="{{ asset('image-removebg-preview.png') }}" 
                         alt="Logo SMK"
                         id="schoolLogo"
                         onerror="showLogoFallback()">
                    <span>Catatan Mengajar</span>
                </a>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr($guru->nama, 0, 1)) }}
                </div>
                <div class="user-name">{{ $guru->nama }}</div>
                <div class="user-role">{{ session('peran') }}</div>
                
                <!-- Progress Bar -->
                <div class="stat-progress mt-3">
                    <div class="stat-progress-bar" style="width: {{ min(($total_kegiatan / 100) * 100, 100) }}%"></div>
                </div>
                <small class="text-light mt-2 d-block">Progress Kegiatan</small>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <a href="/guru/dashboard" class="nav-item active">
                        <i class="bi bi-speedometer2"></i>
                        <span class="nav-item-text">Dashboard</span>
                    </a>
                    <a href="/guru/kegiatan" class="nav-item">
                        <i class="bi bi-journal-text"></i>
                        <span class="nav-item-text">Kegiatan Mengajar</span>
                    </a>
                    <a href="/guru/laporan-bulanan" class="nav-item">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span class="nav-item-text">Laporan Bulanan</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Lainnya</div>
                    <a href="/guru/jadwal" class="nav-item">
                        <i class="bi bi-calendar-week"></i>
                        <span class="nav-item-text">Jadwal Saya</span>
                    </a>
                    <a href="/guru/profil" class="nav-item">
                        <i class="bi bi-person"></i>
                        <span class="nav-item-text">Profil Saya</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>

            <!-- Top Navbar -->
            <div class="top-navbar animate-fadeIn">
                <div>
                    <h1 class="page-title">Welcome home, {{ explode(' ', $guru->nama)[0] }}</h1>
                    <div class="date-info">
                        <i class="bi bi-calendar-date"></i>
                        <span>{{ date('d F Y') }}</span>
                        <span class="badge-modern">{{ $hari_nama }}</span>
                    </div>
                </div>
                
                <div class="user-actions">
                    <a href="/guru/kegiatan/create" class="btn btn-primary px-4" style="background: var(--gradient-4); border: none;">
                        <i class="bi bi-plus-circle me-1"></i> Input Kegiatan
                    </a>
                    <a href="{{ route('logout') }}" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <div class="row mb-4">
                <div class="col-12">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Weather and Stats Row -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="weather-widget animate-fadeIn">
                        <div class="weather-title">Hari Ini</div>
                        <div class="weather-temp">{{ $hari_nama }}</div>
                        <div class="weather-info">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ date('d F Y') }}
                        </div>
                    </div>
                </div>
                
                <!-- Stats Grid -->
                <div class="col-md-8">
                    <div class="stats-grid">
                        <div class="stat-card animate-fadeIn" style="animation-delay: 0.1s">
                            <div class="stat-header">
                                <div>
                                    <div class="stat-title">Total Kegiatan</div>
                                    <div class="stat-value">{{ $total_kegiatan }}</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: {{ min(($total_kegiatan / 100) * 100, 100) }}%"></div>
                            </div>
                            <small class="text-muted">Catatan mengajar tersimpan</small>
                        </div>

                        <div class="stat-card animate-fadeIn" style="animation-delay: 0.2s">
                            <div class="stat-header">
                                <div>
                                    <div class="stat-title">Total Jadwal</div>
                                    <div class="stat-value">{{ $total_jadwal }}</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: {{ min(($total_jadwal / 50) * 100, 100) }}%"></div>
                            </div>
                            <small class="text-muted">Jadwal mengajar aktif</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid: Schedule & Quick Actions -->
            <div class="content-grid">
                <!-- Today's Schedule -->
                <div class="schedule-card animate-fadeIn">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-calendar-day" style="color: var(--accent-color);"></i>
                            Jadwal Hari Ini
                        </h3>
                        <span class="schedule-badge">{{ count($jadwal_hari_ini) }} Jadwal</span>
                    </div>
                    <div class="card-body">
                        @if(count($jadwal_hari_ini) > 0)
                            @foreach($jadwal_hari_ini as $jadwal)
                            <div class="schedule-item">
                                <div class="schedule-info">
                                    <h6>{{ $jadwal->mata_pelajaran }}</h6>
                                    <div class="schedule-meta">
                                        <span><i class="bi bi-clock me-1"></i> {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }}</span>
                                        <span><i class="bi bi-house-door me-1"></i> {{ $jadwal->nama_kelas }}</span>
                                    </div>
                                </div>
                                <a href="/guru/kegiatan/create" class="btn btn-sm btn-primary px-3" style="background: var(--gradient-4); border: none;">
                                    <i class="bi bi-plus-circle me-1"></i> Input
                                </a>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x display-4 text-muted mb-3"></i>
                            <h6 class="text-muted mb-2">Tidak ada jadwal hari ini</h6>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="schedule-card animate-fadeIn" style="animation-delay: 0.2s">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-lightning-charge" style="color: #f7971e;"></i>
                            Aksi Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions-grid">
                            <a href="/guru/kegiatan/create" class="action-btn">
                                <i class="bi bi-journal-plus action-icon"></i>
                                <span class="action-text">Input Kegiatan</span>
                            </a>
                            <a href="/guru/jadwal" class="action-btn">
                                <i class="bi bi-calendar2-week action-icon"></i>
                                <span class="action-text">Lihat Jadwal</span>
                            </a>
                            <a href="/guru/kegiatan" class="action-btn">
                                <i class="bi bi-file-earmark-text action-icon"></i>
                                <span class="action-text">Kegiatan Saya</span>
                            </a>
                            <a href="/guru/profil" class="action-btn">
                                <i class="bi bi-person-gear action-icon"></i>
                                <span class="action-text">Profil Saya</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Control Cards & Recent Activities -->
            <div class="content-grid mb-4">
                <!-- Progress Control -->
                <div class="control-card animate-fadeIn">
                    <div class="control-header">
                        <div class="control-title">
                            <i class="bi bi-graph-up"></i>
                            Progress Mengajar
                        </div>
                        <div class="control-value">{{ min(($total_kegiatan / 100) * 100, 100) }}%</div>
                    </div>
                    <div class="slider-container">
                        <input type="range" class="custom-slider" min="0" max="100" 
                               value="{{ min(($total_kegiatan / 100) * 100, 100) }}" disabled>
                        <div class="slider-labels">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>
                    </div>
                </div>

                <!-- Activity Level -->
                <div class="control-card animate-fadeIn" style="animation-delay: 0.1s">
                    <div class="control-header">
                        <div class="control-title">
                            <i class="bi bi-activity"></i>
                            Aktivitas Sistem
                        </div>
                        <div class="control-value">76%</div>
                    </div>
                    <div class="slider-container">
                        <input type="range" class="custom-slider" min="0" max="100" value="76" disabled>
                        <div class="slider-labels">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="schedule-card animate-fadeIn" style="animation-delay: 0.2s">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-clock-history" style="color: #00b09b;"></i>
                            Kegiatan Terbaru
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($kegiatan_terbaru->count() > 0)
                        <ul class="activities-list">
                            @foreach($kegiatan_terbaru->take(3) as $kegiatan)
                            <li class="activity-item">
                                <div class="activity-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $kegiatan->mata_pelajaran }}</div>
                                    <div class="activity-meta">
                                        <span>{{ $kegiatan->tanggal }}</span>
                                        <span>{{ $kegiatan->nama_kelas }}</span>
                                    </div>
                                    <small class="text-muted">{{ Str::limit($kegiatan->materi, 50) }}</small>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="text-center mt-3">
                            <a href="/guru/kegiatan" class="btn btn-sm btn-outline-primary">Lihat Semua Kegiatan</a>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-journal-x display-4 text-muted mb-3"></i>
                            <h6 class="text-muted mb-2">Belum ada kegiatan</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

         <!-- Statistik Bulanan - DATA REAL -->
<div class="schedule-card animate-fadeIn mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-bar-chart-line" style="color: #764ba2;"></i>
            Statistik Kegiatan Bulanan
        </h3>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                {{ date('F Y') }}
            </button>
            <ul class="dropdown-menu">
                @php
                    $months = [];
                    for ($i = 0; $i < 6; $i++) {
                        $months[] = date('F Y', strtotime("-$i months"));
                    }
                @endphp
                @foreach($months as $month)
                <li><a class="dropdown-item" href="#">{{ $month }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-body">
        @php
            // AMBIL DATA REAL dari database
            $currentYear = date('Y');
            $guruId = $guru->id ?? 0;
            
            // Query untuk statistik bulanan
            $monthlyStats = DB::table('kegiatan_mengajar as km')
                ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
                ->select(
                    DB::raw('MONTH(km.tanggal) as bulan'),
                    DB::raw('COUNT(km.id) as total_kegiatan'),
                    DB::raw('YEAR(km.tanggal) as tahun')
                )
                ->where('jm.guru_id', $guruId)
                ->whereYear('km.tanggal', $currentYear)
                ->groupBy('bulan', 'tahun')
                ->orderBy('bulan')
                ->get()
                ->keyBy('bulan');
            
            // Nama bulan
            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            $currentMonth = date('n');
            
            // Siapkan data untuk chart
            $chartData = [];
            $maxKegiatan = 0;
            
            // Ambil 6 bulan terakhir
            for ($i = 5; $i >= 0; $i--) {
                $bulan = $currentMonth - $i;
                $tahun = $currentYear;
                
                if ($bulan <= 0) {
                    $bulan += 12;
                    $tahun -= 1;
                }
                
                $kegiatan = $monthlyStats[$bulan]->total_kegiatan ?? 0;
                $chartData[] = [
                    'bulan' => $bulan,
                    'nama_bulan' => $monthNames[$bulan - 1],
                    'kegiatan' => $kegiatan,
                    'tahun' => $tahun
                ];
                
                if ($kegiatan > $maxKegiatan) {
                    $maxKegiatan = $kegiatan;
                }
            }
            
            // Normalisasi tinggi chart (jika ada data)
            $maxHeight = $maxKegiatan > 0 ? $maxKegiatan : 1;
        @endphp
        
        <div class="consumption-chart">
            @foreach($chartData as $data)
            <div class="chart-column">
                <div class="chart-bar" style="height: {{ ($data['kegiatan'] / $maxHeight) * 100 }}%;">
                    <div class="chart-value">{{ $data['kegiatan'] }}</div>
                </div>
                <div class="chart-label">{{ $data['nama_bulan'] }}</div>
                <div class="chart-subtitle">{{ $data['tahun'] }}</div>
            </div>
            @endforeach
        </div>
        
        <!-- Legenda dan Statistik -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="stat-summary">
                    <h6><i class="bi bi-info-circle text-primary"></i> Total Kegiatan Tahun {{ $currentYear }}</h6>
                    @php
                        $totalYear = DB::table('kegiatan_mengajar as km')
                            ->join('jadwal_mengajar as jm', 'km.jadwal_id', '=', 'jm.id')
                            ->where('jm.guru_id', $guruId)
                            ->whereYear('km.tanggal', $currentYear)
                            ->count();
                    @endphp
                    <div class="stat-number">{{ $totalYear }}</div>
                    <small class="text-muted">kegiatan tercatat</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-summary">
                    <h6><i class="bi bi-graph-up-arrow text-success"></i> Rata-rata per Bulan</h6>
                    <div class="stat-number">{{ $totalYear > 0 ? round($totalYear / ($currentMonth > 0 ? $currentMonth : 1), 1) : 0 }}</div>
                    <small class="text-muted">kegiatan/bulan</small>
                </div>
            </div>
        </div>
        
        <!-- Tren -->
        <div class="trend-indicator mt-3">
            @php
                // Hitung tren bulan ini vs bulan lalu
                $bulanIni = $monthlyStats[$currentMonth]->total_kegiatan ?? 0;
                $bulanLalu = $currentMonth > 1 ? ($monthlyStats[$currentMonth - 1]->total_kegiatan ?? 0) : 0;
                
                if ($bulanLalu > 0) {
                    $persentase = (($bulanIni - $bulanLalu) / $bulanLalu) * 100;
                    $trendClass = $persentase >= 0 ? 'trend-up' : 'trend-down';
                    $trendIcon = $persentase >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
                } else {
                    $persentase = $bulanIni > 0 ? 100 : 0;
                    $trendClass = 'trend-up';
                    $trendIcon = 'bi-arrow-up';
                }
            @endphp
            
            <div class="trend-item {{ $trendClass }}">
                <i class="bi {{ $trendIcon }}"></i>
                <span>Tren Bulan {{ $monthNames[$currentMonth - 1] }}: 
                    <strong>{{ $bulanIni }} kegiatan</strong>
                    @if($bulanLalu > 0)
                    ({{ $persentase >= 0 ? '+' : '' }}{{ round($persentase, 1) }}% dari bulan lalu)
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

            <!-- Footer -->
            <div class="dashboard-footer animate-fadeIn">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start mb-3 mb-md-0">
                        <h6 class="fw-semibold mb-1">Informasi Sistem</h6>
                        <small class="d-block text-muted">
                            <i class="bi bi-calendar-check me-1"></i> Hari aktif: Senin - Jumat
                        </small>
                        <small class="d-block text-muted">
                            <i class="bi bi-clock-history me-1"></i> Login terakhir: {{ date('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-muted">
                            <i class="bi bi-c-circle me-1"></i>
                            2026 Aplikasi Catatan Mengajar Guru - UKK RPL
                        </div>
                        <small class="text-muted">
                            Versi 1.0 | User: {{ session('username') }}
                        </small>
                        <div class="mt-2">
                            <small class="text-muted">
                                SMK Muhammadiyah 04 - Sistem Informasi Manajemen Guru
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard loaded');
        
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }
        
        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Animate stat numbers
        document.querySelectorAll('.stat-value').forEach(function(stat) {
            const originalText = stat.textContent;
            const target = parseInt(originalText);
            
            if (!isNaN(target)) {
                let current = 0;
                const increment = target / 30;
                const timer = setInterval(function() {
                    current += increment;
                    if (current >= target) {
                        stat.textContent = target;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.round(current);
                    }
                }, 30);
            }
        });
        
        // Logo fallback function
        window.showLogoFallback = function() {
            const logo = document.getElementById('schoolLogo');
            if (logo) {
                logo.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="%231a202c" rx="10"/><text x="50" y="65" font-family="Arial" font-size="45" fill="white" text-anchor="middle">S</text></svg>';
                logo.alt = 'Logo Default - SMK Muhammadiyah 04';
            }
        };
        
        // Form loading state
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i>Memproses...';
                    submitBtn.disabled = true;
                }
            });
        });
        
        // Add spin animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .bi-arrow-clockwise.spin {
                animation: spin 1s linear infinite;
                display: inline-block;
            }
            
            /* Smooth transitions */
            .stat-card, .schedule-card, .control-card, .action-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            /* Hover effects for chart bars */
            .chart-bar {
                transition: all 0.3s ease;
            }
        `;
        document.head.appendChild(style);
        
        // Animate chart bars on load
        setTimeout(function() {
            document.querySelectorAll('.chart-bar').forEach(function(bar, index) {
                setTimeout(function() {
                    const currentHeight = bar.style.height;
                    bar.style.height = '0%';
                    
                    setTimeout(function() {
                        bar.style.height = currentHeight;
                    }, 100);
                }, index * 200);
            });
        }, 500);
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('active') && 
                    !sidebar.contains(event.target) && 
                    !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
        
        // Update clock in real-time
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
            
            const dateElement = document.querySelector('.date-info span:not(.badge-modern)');
            if (dateElement) {
                dateElement.textContent = `${now.toLocaleDateString('id-ID', { 
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                })} | ${timeString}`;
            }
        }
        
        // Update clock every minute
        updateClock();
        setInterval(updateClock, 60000);
    });
    $(document).ready(function() {
    // Toggle sidebar di mobile
    $('#menuToggle').click(function() {
        $('aside.sidebar').toggleClass('show');
        $('#mobileOverlay').toggleClass('show');
    });
    
    // Close sidebar ketika klik overlay
    $('#mobileOverlay').click(function() {
        $(this).removeClass('show');
        $('aside.sidebar').removeClass('show');
    });
    
    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(window).scrollTop() > 20) {
            $('.navbar-simple').addClass('navbar-scrolled');
        } else {
            $('.navbar-simple').removeClass('navbar-scrolled');
        }
    });
    
    // Close sidebar ketika klik link di sidebar (mobile)
    $('.sidebar-nav a').click(function() {
        if ($(window).width() <= 768) {
            $('aside.sidebar').removeClass('show');
            $('#mobileOverlay').removeClass('show');
        }
    });
});
    </script>
</body>
</html>
