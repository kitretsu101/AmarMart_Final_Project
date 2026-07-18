<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — AmarMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: "Times New Roman", Times, serif; background: #f4f6f8; color: #1c2430; }
        h1,h2,h3,h4,h5,h6,.navbar-brand { font-family: "Times New Roman", Times, serif; }
        .sidebar {
            min-height: 100vh;
            background: #243b55;
            color: #fff;
        }
        .sidebar a { color: #dce6f2; text-decoration: none; display: block; padding: .65rem 1rem; border-radius: .25rem; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,.12); color: #fff; }
        .stat-box { background: #fff; border: 1px solid #e3e8ef; padding: 1.25rem; }
        .btn-am { background: #243b55; border-color: #243b55; color: #fff; }
        .btn-am:hover { background: #1a2c40; color: #fff; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <div class="fs-3 fw-bold mb-4">AmarMart</div>
            <nav class="d-grid gap-1">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Products</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Orders</a>
                <a href="{{ route('home') }}" target="_blank"><i class="bi bi-shop"></i> View Shop</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                @csrf
                <button class="btn btn-outline-light btn-sm w-100">Logout</button>
            </form>
        </aside>
        <main class="col-md-9 col-lg-10 p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
