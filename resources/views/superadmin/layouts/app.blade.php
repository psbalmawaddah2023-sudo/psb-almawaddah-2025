<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
        }
        /* Sidebar */
        .sidebar {
            height: 100vh;
            background: #1e40af;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: all 0.3s ease-in-out;
            overflow-y: auto;
        }
        .sidebar h4 {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
            font-size: 0.95rem;
        }
        .sidebar a:hover {
            background: #2563eb;
        }
        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }
        /* Navbar */
        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-custom .nav-link {
            color: #374151;
        }
        .sidebar-toggle {
            border: none;
            background: transparent;
            font-size: 1.5rem;
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px; /* sembunyi default */
                z-index: 1050;
            }
            .sidebar.show {
                left: 0; /* tampil */
            }
            .content {
                margin-left: 0 !important;
            }
            /* overlay background */
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1049;
                display: none;
            }
            .overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center py-3">Admin</h4>
        <a href="{{ route('superadmin.dashboard') }}">📊 Dashboard</a>
        <a href="{{ route('pendaftaran.index') }}">📝 Pendaftaran</a>
        <a href="{{ route('admin.index') }}">👤 User</a>
        <a href="{{ route('laporan.index') }}">📑 Laporan</a>
        <a href="{{ route('pengaturan.index') }}">⚙️ Pengaturan</a>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom px-3 shadow-sm">
        <button class="sidebar-toggle d-lg-none me-3" onclick="toggleSidebar()">☰</button>
        <a class="navbar-brand fw-bold text-primary" href="#">PSB Mawaddah</a>

        <div class="ms-auto d-flex align-items-center">            
            <!-- User Dropdown -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    👤 {{ Auth::user()->name ?? 'Superadmin' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Content -->
    <div class="content" id="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('overlay').classList.toggle('show');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('overlay').classList.remove('show');
        }
    </script>
</body>
</html>
