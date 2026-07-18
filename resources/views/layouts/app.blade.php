<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AmarMart — Your trusted online shopping destination for electronics, fashion, and more.">
    <title>@yield('title', 'AmarMart — Online Shopping')</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNavbar">
        <div class="container">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <div class="brand-logo-icon">
                    <i class="bi bi-bag-heart-fill"></i>
                </div>
                <span class="brand-name">AmarMart</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarMain" aria-controls="navbarMain"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                {{-- Search Bar --}}
                <form class="d-flex mx-auto search-form" action="{{ route('home') }}" method="GET" role="search">
                    <div class="input-group search-group">
                        <input class="form-control search-input"
                               type="search"
                               name="search"
                               placeholder="Search products..."
                               value="{{ request('search') }}"
                               aria-label="Search products">
                        <button class="btn btn-search" type="submit" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                {{-- Nav Links --}}
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">
                            <i class="bi bi-house-fill me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link {{ request()->routeIs('cart.*') ? 'active' : '' }}"
                           href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 me-1"></i>Cart
                            @php $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity')); @endphp
                            @if($cartCount > 0)
                                <span class="badge bg-danger cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0 rounded-0 flash-alert" role="alert">
            <div class="container">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0 flash-alert" role="alert">
            <div class="container">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-logo-icon brand-logo-sm">
                            <i class="bi bi-bag-heart-fill"></i>
                        </div>
                        <span class="footer-brand-name">AmarMart</span>
                    </div>
                    <p class="footer-desc">Your trusted online shopping destination. Quality products, great prices, fast delivery.</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="footer-heading">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1"></i>Home</a></li>
                        <li><a href="{{ route('cart.index') }}"><i class="bi bi-chevron-right me-1"></i>Shopping Cart</a></li>
                        <li><a href="{{ route('checkout.index') }}"><i class="bi bi-chevron-right me-1"></i>Checkout</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="footer-heading">Contact Us</h6>
                    <ul class="footer-links">
                        <li><i class="bi bi-envelope-fill me-2"></i>support@amarmart.com</li>
                        <li><i class="bi bi-telephone-fill me-2"></i>+880 1700-000000</li>
                        <li><i class="bi bi-geo-alt-fill me-2"></i>Dhaka, Bangladesh</li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="text-center footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} <strong>AmarMart</strong>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
