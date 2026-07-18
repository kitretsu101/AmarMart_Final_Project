<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Invoice') — AmarMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: "Times New Roman", Times, serif; color: #111; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body class="bg-white">
<div class="container py-4">
    <div class="no-print mb-3 d-flex gap-2">
        <button onclick="window.print()" class="btn btn-dark">Print Invoice</button>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Shop</a>
    </div>
    @yield('content')
</div>
</body>
</html>
