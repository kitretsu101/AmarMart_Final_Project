<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found | AmarMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container text-center py-5" style="min-height:80vh;display:flex;align-items:center;justify-content:center;">
        <div>
            <i class="bi bi-emoji-frown display-1 text-primary"></i>
            <h1 class="display-4 mt-3">404</h1>
            <h2 class="h4 text-muted">Page Not Found</h2>
            <p class="text-muted">The page you are looking for does not exist or has been moved.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-2">
                <i class="bi bi-house me-1"></i>Back to Home
            </a>
        </div>
    </div>
</body>
</html>
