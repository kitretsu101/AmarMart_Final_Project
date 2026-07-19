@extends('layouts.app')

@section('title', 'AmarMart — Shop Online')

@section('content')

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title">Welcome to <span class="brand-highlight">AmarMart</span></h1>
                <p class="hero-subtitle">Discover thousands of products at unbeatable prices.</p>
            </div>
        </div>
    </div>
</section>

{{-- Trending Products --}}
@if(isset($trendingProducts) && $trendingProducts->count() > 0 && empty($search))
<section class="products-section pt-4">
    <div class="container">
        <div class="section-header mb-3">
            <h2 class="section-title"><i class="bi bi-fire text-danger me-2"></i>Trending Products</h2>
            <p class="section-subtitle text-muted">Most popular items based on orders</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
            @foreach($trendingProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Latest Products --}}
@if(isset($latestProducts) && $latestProducts->count() > 0 && empty($search))
<section class="products-section pt-0">
    <div class="container">
        <div class="section-header mb-3">
            <h2 class="section-title"><i class="bi bi-stars text-warning me-2"></i>Latest Products</h2>
            <p class="section-subtitle text-muted">Fresh arrivals in our store</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
            @foreach($latestProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- All Products / Search Results --}}
<section class="products-section">
    <div class="container">
        <div class="section-header d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="section-title">
                    @if($search)
                        Search Results for "<em>{{ $search }}</em>"
                    @else
                        Our Products
                    @endif
                </h2>
                <p class="section-subtitle text-muted">{{ $products->total() }} product(s) found</p>
            </div>
            @if($search)
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Clear Search
                </a>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
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
