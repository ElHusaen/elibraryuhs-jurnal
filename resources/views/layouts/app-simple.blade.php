<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Library | @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('mega/assets/images/logo-uhs.jpeg') }}" type="image/x-icon">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mega/assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mega/assets/icon/font-awesome/css/font-awesome.min.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mega/assets/css/style.css') }}">

    {{-- Chart.js untuk Dashboard --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ===== GLOBAL STYLE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #1a3c6e;
            color: #fff;
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            text-align: center;
            padding: 20px 0 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand img {
            max-height: 50px;
        }

        .sidebar-brand h4 {
            color: #fff;
            margin-top: 10px;
            font-weight: 500;
            font-size: 18px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            padding: 0 20px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .sidebar-menu li a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        .sidebar-menu li a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu .menu-label {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            text-transform: uppercase;
            padding: 20px 16px 8px;
            letter-spacing: 1px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            padding: 20px 30px;
            min-height: 100vh;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }

        .topbar .page-title {
            font-size: 18px;
            font-weight: 500;
            color: #1a3c6e;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar .user-info .user-name {
            font-size: 14px;
            color: #333;
        }

        .topbar .user-info .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1a3c6e;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: 16px;
        }

        .topbar .user-info .logout-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
        }

        .topbar .user-info .logout-btn:hover {
            color: #a71d2a;
        }

        /* ===== CARD ===== */
        .card-custom {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-custom .card-header-custom {
            font-size: 16px;
            font-weight: 500;
            color: #1a3c6e;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* ===== TABLE ===== */
        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom thead th {
            background: #f8f9fa;
            padding: 12px 16px;
            text-align: left;
            font-weight: 500;
            font-size: 13px;
            color: #555;
            border-bottom: 2px solid #eee;
        }

        .table-custom tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        .table-custom tbody tr:hover {
            background: #f8f9fa;
        }

        /* ===== BUTTON ===== */
        .btn-primary-custom {
            background: #1a3c6e;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom:hover {
            background: #0f2a4a;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 60, 110, 0.3);
        }

        .btn-success-custom {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success-custom:hover {
            background: #1e7e34;
            color: #fff;
        }

        .btn-warning-custom {
            background: #ffc107;
            color: #333;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-warning-custom:hover {
            background: #e0a800;
            color: #333;
        }

        .btn-danger-custom {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-danger-custom:hover {
            background: #bd2130;
            color: #fff;
        }

        .btn-info-custom {
            background: #17a2b8;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-info-custom:hover {
            background: #138496;
            color: #fff;
        }

        .btn-secondary-custom {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary-custom:hover {
            background: #5a6268;
            color: #fff;
        }

        /* ===== BADGE ===== */
        .badge-custom {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .badge-success-custom {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning-custom {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger-custom {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info-custom {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-secondary-custom {
            background: #e9ecef;
            color: #495057;
        }

        .badge-primary-custom {
            background: #1a3c6e;
            color: #fff;
        }

        /* ===== ALERT ===== */
        .alert-custom {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-success-custom {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger-custom {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info-custom {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .alert-warning-custom {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .form-group .form-control {
            height: 46px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0 15px;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
        }

        .form-group .form-control:focus {
            border-color: #1a3c6e;
            box-shadow: 0 0 0 3px rgba(26, 60, 110, 0.1);
            outline: none;
        }

        .form-group textarea.form-control {
            height: auto;
            padding: 12px 15px;
            resize: vertical;
        }

        .form-group .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-group .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            .topbar {
                flex-wrap: wrap;
                gap: 12px;
            }
            .row {
                flex-direction: column;
            }
            .row .col-md-3,
            .row .col-md-2 {
                width: 100%;
                margin-bottom: 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ===== SIDEBAR ===== --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('mega/assets/images/logo-bg-uhs.png') }}" alt="Logo" style="max-height:50px;">
            <h4>E-Library</h4>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-label">Menu Utama</li>
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('jurnal.index') }}" class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
                    <i class="fa fa-book"></i> Data Jurnal
                </a>
            </li>

            @if(auth()->user() && auth()->user()->isAdmin())
                <li class="menu-label">Administrasi</li>
                <li>
                    <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i> Kelola User
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="fa fa-tags"></i> Kelola Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('mahasiswa.index') }}" class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                        <i class="fa fa-graduation-cap"></i> Data Mahasiswa
                    </a>
                </li>
            @endif

            @if(auth()->user() && auth()->user()->isMahasiswa())
                <li class="menu-label">Jurnal</li>
                <li>
                    <a href="{{ route('jurnal.create') }}">
                        <i class="fa fa-plus-circle"></i> Tambah Jurnal
                    </a>
                </li>
            @endif

            <li class="menu-label">Akun</li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline; width:100%;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:rgba(255,255,255,0.7);padding:12px 16px;width:100%;text-align:left;display:flex;align-items:center;gap:12px;border-radius:8px;cursor:pointer;font-size:14px;">
                        <i class="fa fa-sign-out"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="main-content">

        {{-- ===== TOPBAR ===== --}}
        <div class="topbar">
            <div class="page-title">
                @yield('title', 'Dashboard')
            </div>
            <div class="user-info">
                <span class="user-name">
                    <i class="fa fa-user"></i> {{ auth()->user()->nama ?? 'User' }}
                </span>
                <span class="badge-custom {{ auth()->user() && auth()->user()->isAdmin() ? 'badge-success-custom' : 'badge-info-custom' }}">
                    {{ auth()->user()->role ?? 'mahasiswa' }}
                </span>
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'U', 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="fa fa-sign-out"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- ===== CONTENT ===== --}}
        @yield('content')

    </div>

    {{-- ===== SCRIPTS ===== --}}
    <script src="{{ asset('mega/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('mega/assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Auto-hide alert setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-custom');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')

</body>

</html>