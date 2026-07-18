<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AmarMart Admin Panel — Manage your store.">
    <title>@yield('title', 'Admin Panel') — AmarMart</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body class="admin-body">

    {{-- ===== ADMIN TOPBAR ===== --}}
    <nav class="navbar admin-topbar navbar-dark" id="adminTopbar">
        <div class="container-fluid px-4">
            {{-- Sidebar Toggle --}}
            <button class="btn btn-link text-white p-0 me-3" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="bi bi-list fs-4"></i>
            </button>

            {{-- Brand --}}
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <div class="brand-logo-icon brand-logo-sm">
                    <i class="bi bi-bag-heart-fill"></i>
                </div>
                <span>AmarMart <small class="admin-tag">Admin</small></span>
            </a>

            {{-- Right side --}}
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i>View Store
                </a>
                <div class="dropdown">
                    <button class="btn btn-link text-white dropdown-toggle d-flex align-items-center gap-2 p-0"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="admin-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="admin-wrapper">
        {{-- ===== SIDEBAR ===== --}}
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-inner">
                <nav class="sidebar-nav">
                    <div class="sidebar-section-title">Main Menu</div>

                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i>
                        <span>Orders</span>
                    </a>

                    <div class="sidebar-divider"></div>
                    <div class="sidebar-section-title">Account</div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link sidebar-link-btn w-100">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="admin-main" id="adminMain">
            <div class="admin-content-area">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('adminSidebar').classList.toggle('collapsed');
            document.getElementById('adminMain').classList.toggle('expanded');
        });
    </script>
    @stack('scripts')
</body>
</html>
