<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example-app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Top Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            background-color: #343454;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
        }

        .navbar .btn,
        .navbar .nav-link,
        .navbar-brand {
            color: #fff;
        }

        .navbar .btn:hover,
        .navbar .nav-link:hover {
            color: #ddd;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 56px;
            /* height of navbar */
            left: 0;
            height: 100%;
            width: 180px;
            /* narrower width */
            background-color: #1e1e2f;
            color: #fff;
            transition: all 0.3s;
            overflow-x: hidden;
            padding-top: 1rem;
        }

        #sidebar.collapsed {
            width: 60px;
            /* collapsed width */
        }

        #sidebar .nav-link {
            color: #cfcfe8;
            font-weight: 500;
            white-space: nowrap;
            padding-left: 1rem;
            transition: all 0.3s;
        }

        #sidebar .nav-link:hover {
            background-color: #343454;
            color: #fff;
        }

        #sidebar.collapsed .nav-link span {
            display: none;
        }

        #sidebar.collapsed .nav-link {
            text-align: center;
            padding-left: 0;
        }

        /* Main content */
        #content {
            margin-top: 56px;
            /* navbar height */
            margin-left: 180px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        #sidebar.collapsed+#content {
            margin-left: 60px;
        }

        /* Optional: smooth card styling */
        .card {
            border-radius: 0.5rem;
        }

        /* User Dropdown outside navbar */
        #userDropdownWrapper {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1060;
            /* Above navbar */
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark d-flex justify-content-between">
        <button class="btn btn-outline-light" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand ms-3" href="#">Example-app</a>
        <div style="width:auto;"></div> <!-- Placeholder to keep toggle button aligned -->
    </nav>

    <!-- User Dropdown (outside navbar) -->
    <div id="userDropdownWrapper">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium text-white" href="#"
                role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap;">
                <img src="{{ asset('images/userLogo.png') }}" alt="User" class="rounded-circle" width="35"
                    height="35">
                <span class="ms-2 ">User</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link py-2" href="/"><i class="fas fa-tachometer-alt me-2"></i>
                <span>Dashboard</span></a>
            <a class="nav-link py-2" href="{{ route('products.show') }}"><i class="fas fa-users me-2"></i>
                <span>Products</span></a>
            <a class="nav-link py-2" href="{{ route('stations.index') }}"><i class="fas fa-boxes me-2"></i>
                <span>Stations</span></a>
            <a class="nav-link py-2" href="{{ route('bills.show') }}"><i class="fas fa-shopping-cart me-2"></i>
                <span>Bills</span></a>

            <!-- Settings Dropdown -->
            <a class="nav-link py-2 d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                href="#settingsMenu" role="button" aria-expanded="false" aria-controls="settingsMenu">
                <span><i class="fas fa-cogs me-2"></i> Settings</span>

            </a>

            <div class="collapse ms-4" id="settingsMenu">
                <a class="nav-link py-1" href="/profile"><i class="fas fa-user-cog me-2"></i>Profile Settings</a>
                <a class="nav-link py-1" href="/user-management"><i class="fas fa-users-cog me-2"></i>User
                    Management</a>
                <a class="nav-link py-1" href="/roles"><i class="fas fa-user-shield me-2"></i>Roles</a>
            </div>
        </nav>
    </div>


    <!-- Main Content -->
    <div id="content">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>

</body>

</html>
