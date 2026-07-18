<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AmarMart Admin Login">
    <title>Admin Login — AmarMart</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="admin-login-body">

    <div class="admin-login-wrapper">
        <div class="admin-login-card">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <div class="login-logo-icon">
                    <i class="bi bi-bag-heart-fill"></i>
                </div>
                <h1 class="login-brand-name">AmarMart</h1>
                <p class="login-subtitle">Admin Panel</p>
            </div>

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

            {{-- Login Form --}}
            <form action="{{ route('admin.login.submit') }}" method="POST" id="adminLoginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="login_email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="login_email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="admin@amarmart.com"
                               required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="login_password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="login_password"
                               name="password"
                               placeholder="Enter your password"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg login-btn" id="loginSubmitBtn">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Back to Store
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
