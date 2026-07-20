<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Access Denied | AmarMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container text-center py-5" style="min-height:80vh;display:flex;align-items:center;justify-content:center;">
        <div>
            <i class="bi bi-shield-lock display-1 text-danger"></i>
            <h1 class="display-4 mt-3">403</h1>
            <h2 class="h4 text-muted">Access Denied</h2>
            <p class="text-muted">You do not have permission to access this page. Please log in as admin.</p>
            <a href="{{ route('admin.login') }}" class="btn btn-primary mt-2 me-2">
                <i class="bi bi-person-lock me-1"></i>Admin Login
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary mt-2">
                <i class="bi bi-house me-1"></i>Home
            </a>
        </div>
    </div>
</body>
</html>
