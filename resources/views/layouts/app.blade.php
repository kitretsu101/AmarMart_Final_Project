<!DOCTYPE html>
<html lang="en" data-theme="{{ request()->cookie('theme_preference', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AmarMart — Your trusted online shopping destination for electronics, fashion, and more.">
    <title>@yield('title', 'AmarMart — Online Shopping')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body class="theme-{{ request()->cookie('theme_preference', 'light') }}">

    {{-- Loading Spinner Overlay --}}
    <div id="globalSpinner" class="global-spinner d-none" aria-hidden="true">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    {{-- Toast container for AJAX messages --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;" id="toastContainer"></div>

    {{-- ===== STICKY NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNavbar">
        <div class="container">
            {{-- 1. Logo --}}
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
                {{-- Centered Search Bar --}}
                <div class="d-flex mx-auto search-form position-relative" role="search">
                    <div class="input-group search-group">
                        <input class="form-control search-input"
                               type="search"
                               id="liveSearchInput"
                               name="search"
                               placeholder="Search products..."
                               value="{{ request('search', request()->cookie('last_search')) }}"
                               autocomplete="off"
                               aria-label="Search products">
                        <button class="btn btn-search" type="button" id="liveSearchBtn" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div id="searchSuggestions" class="search-suggestions d-none"></div>
                </div>

                {{-- Menu order: Home → Products → Wishlist → Cart → Contact → Location → Login/Dashboard --}}
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    {{-- 2. Home (product list + search) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-fill me-1"></i>Home
                        </a>
                    </li>

                    {{-- 3. Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart me-1"></i>Wishlist
                            @php $wishCount = count(session()->get('wishlist', [])); @endphp
                            <span class="badge bg-warning text-dark {{ $wishCount > 0 ? '' : 'd-none' }}" id="wishlistBadge">{{ $wishCount }}</span>
                        </a>
                    </li>

                    {{-- 5. Cart --}}
                    <li class="nav-item">
                        <a class="nav-link cart-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 me-1"></i>Cart
                            @php $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity')); @endphp
                            <span class="badge bg-danger cart-badge {{ $cartCount > 0 ? '' : 'd-none' }}" id="cartBadge">{{ $cartCount }}</span>
                        </a>
                    </li>

                    {{-- 6. Contact --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="bi bi-envelope me-1"></i>Contact
                        </a>
                    </li>

                    {{-- 7. Current Location (HTML5 Geolocation + Nominatim) --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-location-link dropdown-toggle"
                           href="#"
                           id="navLocationToggle"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                           title="Your current location">
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            <span id="navLocationText">
                                <span class="spinner-border spinner-border-sm me-1" id="navLocationSpinner" role="status" aria-hidden="true"></span>
                                Loading...
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-2 nav-location-dropdown" aria-labelledby="navLocationToggle">
                            <div id="navLocationAlert" class="alert alert-warning py-2 px-3 small mb-2 d-none" role="alert"></div>
                            <div id="navMapWrap" class="nav-map-wrap d-none">
                                <iframe id="navMapFrame"
                                        class="nav-map-frame"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Your current location on Google Maps"></iframe>
                            </div>
                            <div id="navMapHiddenMsg" class="text-muted small px-1">
                                Map appears after location is detected.
                            </div>
                        </div>
                    </li>

                    {{-- Theme toggle (utility) --}}
                    <li class="nav-item">
                        <button type="button" class="btn btn-link nav-link theme-toggle" id="themeToggle" title="Toggle theme" aria-label="Toggle light/dark theme">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </button>
                    </li>

                    {{-- 8. Login / Dashboard (depends on authentication) --}}
                    <li class="nav-item">
                        @auth
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        @else
                            <a class="nav-link {{ request()->routeIs('admin.login') ? 'active' : '' }}"
                               href="{{ route('admin.login') }}">
                                <i class="bi bi-person-lock me-1"></i>Login
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

    <main class="main-content">
        @yield('content')
    </main>

    {{-- Quick View Modal --}}
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickViewTitle">Product Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="quickViewBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <li><a href="{{ route('wishlist.index') }}"><i class="bi bi-chevron-right me-1"></i>Wishlist</a></li>
                        <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right me-1"></i>Contact</a></li>
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

    <script>
        window.AmarMart = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            routes: {
                searchSuggestions: @json(route('search.suggestions')),
                home: @json(route('home')),
                cartAdd: @json(url('/cart/add')),
                cartUpdate: @json(route('cart.update')),
                cartIncrease: @json(url('/cart/increase')),
                cartDecrease: @json(url('/cart/decrease')),
                cartRemove: @json(url('/cart/remove')),
                cartCount: @json(route('cart.count')),
                wishlistToggle: @json(url('/wishlist/toggle')),
                quickView: @json(url('/api/products')),
                themeSet: @json(route('theme.set')),
                locationReverse: @json(route('location.reverse')),
                locationStore: @json(route('location.store')),
                locationCurrent: @json(route('location.current')),
            },
            // Server-side session location (if already detected earlier)
            sessionLocation: @json(session('user_location')),
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/location.js') }}"></script>
    @stack('scripts')
</body>
</html>
