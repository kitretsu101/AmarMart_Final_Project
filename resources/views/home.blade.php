@extends('layouts.app')

@section('title', 'AmarMart — Shop Online')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Welcome to <span class="brand-highlight">AmarMart</span></h1>
                <p class="hero-subtitle">Discover thousands of products at unbeatable prices.</p>
                <form action="{{ route('home') }}" method="GET" class="hero-search-form" role="search">
                    <div class="input-group hero-search-group">
                        <input type="search"
                               class="form-control form-control-lg hero-search-input"
                               name="search"
                               placeholder="Search for products..."
                               value="{{ $search ?? '' }}"
                               aria-label="Search products">
                        <button class="btn btn-primary btn-lg hero-search-btn" type="submit">
                            <i class="bi bi-search me-1"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ===== PRODUCT LISTING ===== --}}
<section class="products-section">
    <div class="container">

        {{-- Section Header --}}
        <div class="section-header d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="section-title">
                    @if($search)
                        Search Results for "<em>{{ $search }}</em>"
                    @else
                        Our Products
                    @endif
                </h2>
                <p class="section-subtitle text-muted">
                    {{ $products->total() }} product(s) found
                </p>
            </div>
            @if($search)
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Clear Search
                </a>
            @endif
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
                @foreach($products as $product)
                    <div class="col">
                        <div class="card product-card h-100">
                            {{-- Product Image --}}
                            <div class="product-card-img-wrap">
                                @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="product-card-img">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                @if($product->stock < 5 && $product->stock > 0)
                                    <span class="badge bg-warning product-badge">Low Stock</span>
                                @elseif($product->stock == 0)
                                    <span class="badge bg-danger product-badge">Out of Stock</span>
                                @endif
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <p class="product-desc text-muted">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                                <div class="mt-auto">
                                    <div class="product-price">৳{{ number_format($product->price, 2) }}</div>
                                    <a href="{{ route('product.show', $product->product_id) }}"
                                       class="btn btn-primary btn-sm w-100 mt-2 view-details-btn">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            @endif

        @else
            {{-- No Products Found --}}
            <div class="empty-state text-center py-5">
                <i class="bi bi-search display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">No Products Found</h3>
                <p class="text-muted">We couldn't find any products matching "{{ $search }}".</p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-house me-1"></i>Back to Home
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
