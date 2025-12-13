<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 70px;
            border-right: 1px solid #e5e5e5;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        .sidebar.minimized {
            width: 80px;
        }

        .sidebar .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            color: #333;
            border-radius: 8px;
            margin: 4px 12px;
            transition: background 0.2s;
        }

        .sidebar .menu-item:hover {
            background: #f1f1f1;
        }

        .sidebar.minimized .menu-text {
            display: none;
        }

        /* Topbar */
        .topbar {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            z-index: 10;
        }

        /* Main Content */
        .content {
            margin-left: 260px;
            padding: 90px 30px;
            transition: margin-left .3s;
        }

        .content.minimized {
            margin-left: 80px;
        }

        .logo-hamburger-container {
            width: 240px
        }

        #dashboard-logo-container.minimized {
            display: none;
        }
    </style>
</head>

<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-3 logo-hamburger-container">

                <!-- Toggle Sidebar Button -->
                <div id="dashboard-logo-container">
                    <h3>LOGO</h3>
                </div>
                <!-- Toggle Sidebar Button -->
                <button id="toggleSidebar" class="btn btn-light border">
                    <i class="bi bi-list fs-4"></i>
                </button>
            </div>

            <!-- Search -->
            <input type="text" class="form-control" style="width:260px;" placeholder="Search...">
        </div>

        <!-- Right Area -->
        <div class="d-flex align-items-center gap-3">

            <!-- User -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle"
                        width="35" height="35">
                    <span class="ms-2 fw-semibold">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">@csrf
                            <button class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <a href="{{ url('/') }}" class="menu-item">
            <i class="bi bi-house-door fs-5"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="#" class="menu-item">
            <i class="bi bi-people fs-5"></i>
            <span class="menu-text">Users</span>
        </a>

        <a href="#" class="menu-item">
            <i class="bi bi-cart-check fs-5"></i>
            <span class="menu-text">Orders</span>
        </a>

        <a href="#" class="menu-item">
            <i class="bi bi-box-seam fs-5"></i>
            <span class="menu-text">Products</span>
        </a>

        <a href="#" class="menu-item">
            <i class="bi bi-gear fs-5"></i>
            <span class="menu-text">Settings</span>
        </a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="content" id="content">
        <h1>hello man</h1>
        @yield('content')
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const dashboardLogo = document.getElementById('dashboard-logo-container');
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            dashboardLogo.classList.toggle('minimized');
            sidebar.classList.toggle('minimized');
            content.classList.toggle('minimized');
        });
    </script>

</body>

</html>
