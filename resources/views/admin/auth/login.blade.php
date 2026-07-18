<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — AmarMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(160deg, #243b55, #1c2430 55%, #3d4f63);
            color: #1c2430;
        }
        .login-box { background: #fff; border: 1px solid #d7dde5; max-width: 420px; }
        .brand { font-size: 2rem; font-weight: 700; color: #243b55; }
    </style>
</head>
<body>
<div class="container">
    <div class="login-box mx-auto p-4">
        <div class="brand mb-1">AmarMart</div>
        <p class="text-muted mb-4">Administrator sign in</p>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button class="btn w-100 text-white" style="background:#243b55;">Login</button>
        </form>
        <div class="mt-3">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none">← Back to shop</a>
        </div>
    </div>
</div>
</body>
</html>
