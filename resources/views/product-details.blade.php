@extends('layouts.app')

@section('title', $product->name . ' — AmarMart')

@section('content')
<section class="product-detail-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-md-5">
                <div class="product-detail-img-wrap">
                    @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="product-detail-img img-fluid">
                    @else
                        <div class="product-img-placeholder product-img-placeholder-lg">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-7">
                <div class="product-detail-info">
                    <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
                        <h1 class="product-detail-name mb-0">{{ $product->name }}</h1>
                        @if(!empty($isRecentlyViewed))
                            <span class="badge bg-info text-dark recently-viewed-badge">
                                <i class="bi bi-clock-history me-1"></i>Recently Viewed
                            </span>
                        @endif
                    </div>

                    <div class="product-detail-price mb-3 mt-3">
                        ৳{{ number_format($product->price, 2) }}
                    </div>

                    <div class="mb-3">
                        @if($product->stock > 0 && $product->stock < 5)
                            <span class="badge bg-warning stock-badge">
                                <i class="bi bi-exclamation-triangle me-1"></i>Low Stock ({{ $product->stock }} left)
                            </span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-success stock-badge">
                                <i class="bi bi-check-circle me-1"></i>In Stock ({{ $product->stock }} available)
                            </span>
                        @else
                            <span class="badge bg-danger stock-badge">
                                <i class="bi bi-x-circle me-1"></i>Out of Stock
                            </span>
                        @endif
                    </div>

                    <div class="product-detail-desc mb-4">
                        <h5 class="desc-heading">Description</h5>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="d-flex gap-3 flex-wrap">
                        @if($product->stock > 0)
                            <button type="button"
                                    class="btn btn-primary btn-lg add-to-cart-btn"
                                    data-ajax-add-cart="{{ $product->product_id }}">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary btn-lg" disabled>
                                <i class="bi bi-cart-x me-2"></i>Out of Stock
                            </button>
                        @endif

                        <button type="button"
                                class="btn btn-outline-danger btn-lg {{ !empty($inWishlist) ? 'active' : '' }}"
                                data-wishlist-toggle="{{ $product->product_id }}">
                            <i class="bi bi-heart{{ !empty($inWishlist) ? '-fill' : '' }} me-2"></i>Wishlist
                        </button>

                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                    </div>

                    <div class="delivery-info mt-4">
                        <div class="delivery-item">
                            <i class="bi bi-truck"></i>
                            <span>Fast Delivery Available</span>
                        </div>
                        <div class="delivery-item">
                            <i class="bi bi-shield-check"></i>
                            <span>100% Secure Checkout</span>
                        </div>
                        <div class="delivery-item">
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
